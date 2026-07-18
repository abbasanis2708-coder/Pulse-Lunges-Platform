from flask import Flask, request, jsonify
from transformers import AutoTokenizer, AutoModelForSequenceClassification, pipeline
import os
import json
import csv
import re
import unicodedata


app = Flask(__name__)

# Chargement du modèle une seule fois au démarrage
print("Chargement du modèle...")
model_path = os.path.abspath(os.path.join(os.path.dirname(__file__), "model"))
print(f"Chemin du modèle : {model_path}")

try:
    tokenizer = AutoTokenizer.from_pretrained(model_path, local_files_only=True)
    model = AutoModelForSequenceClassification.from_pretrained(model_path, local_files_only=True)
    classifier = pipeline("text-classification", model=model, tokenizer=tokenizer)

    print("Modèle chargé avec succès!")
except Exception as e:
    print(f"Erreur lors du chargement du modèle : {str(e)}")
    raise

# Chargement des mots-clés depuis le CSV 
keywords = {}
try:
    with open("keywords.csv", "r", encoding="utf-8") as f:
        csv_reader = csv.reader(f)
        next(csv_reader)  # Ignorer l'en-tête si présent
        for row in csv_reader:
            if len(row) >= 2:
                label = row[0]
                keyword = row[1]
                if label not in keywords:
                    keywords[label] = []
                keywords[label].append(keyword)
    print("Mots-clés chargés avec succès!")
    print(f"Thèmes avec mots-clés : {list(keywords.keys())}")
except Exception as e:
    print(f"Erreur lors du chargement des mots-clés : {str(e)}")
    keywords = {}

# Nouveau mapping des labels basé sur la configuration du modèle
label_map = {
    "antécédents cardiovasculaires": "antécédents cardiovasculaires",
    "douleur thoracique": "douleur thoracique",
    "durée": "durée",
    "facteurs calmants": "facteurs calmants",
    "facteurs déclenchants": "facteurs déclenchants",
    "irradiation": "irradiation",
    "résultats d'examen": "résultats d'examen",
    "traitements en cours": "traitements en cours"
}

# Score pour le fallback pondéré
FALLBACK_SCORE = 0.8

def apply_weighted_fallback(outputs, question):
    """Applique le système de fallback pondéré aux sorties du modèle"""
    # Conversion des sorties en dictionnaire
    scores = {pred['label']: pred['score'] for pred in outputs}
    
    # Application du fallback pondéré
    text_lower = question.lower()
    for label, kw_list in keywords.items():
        for kw in kw_list:
            if kw.lower() in text_lower:
                # Si un mot-clé est trouvé, on met le score à FALLBACK_SCORE
                # sauf si le score existant est déjà plus élevé
                scores[label] = max(scores.get(label, 0), FALLBACK_SCORE)
                break
    
    # Conversion en liste triée et au format attendu
    sorted_scores = sorted(scores.items(), key=lambda x: x[1], reverse=True)
    return [{"label": label, "score": score} for label, score in sorted_scores]

def preprocess_text(text):
    # 1. Minuscules
    text = text.lower()
    # 2. Suppression des accents
    text = ''.join(c for c in unicodedata.normalize('NFD', text) if unicodedata.category(c) != 'Mn')
    # 3. Suppression de la ponctuation (garde lettres, chiffres et espaces)
    text = re.sub(r'[^a-z0-9\s]', '', text)
    # 4. Suppression des espaces superflus
    return text.strip()

@app.route('/classify', methods=['POST'])
def classify_question():
    try:
        data = request.get_json()
        #print("\n=== NOUVELLE REQUÊTE ===")
        
        if not data or 'question' not in data:
            return jsonify({
                "theme_detecte": "inconnu",
                "label_brut": None,
                "confidence": 0.0,
                "message_feedback": "Pardon ? Je ne comprends pas.",
                "cas": "cas_4"
            })

        question_brute = data['question'].strip()
        if not question_brute:
            return jsonify({
                "theme_detecte": "inconnu",
                "label_brut": None,
                "confidence": 0.0,
                "message_feedback": "Pardon ? Je ne comprends pas.",
                "cas": "cas_4"
            })

        themes_attendus = data.get('themes_attendus', [])
        
        # 1. Nettoyage pour le modèle (plus agressif)
        question_propre = preprocess_text(question_brute)
        
        # 2. Classification (on envoie le texte propre au modèle BERT)
        outputs = classifier(question_propre, top_k=None)
        
        # 3. Application du fallback (on garde la question brute pour les mots-clés)
        outputs = apply_weighted_fallback(outputs, question_brute)
        print(f"REQ | '{question_brute}' -> '{question_propre}' | Score: {outputs[0]['score']:.2f} | Label: {outputs[0]['label']}")
        
        print(f"Question brute : '{question_brute}'")
        print(f"Question nettoyée : '{question_propre}'")
        print(f"Top prédiction : {outputs[0]['label']} avec score {outputs[0]['score']:.4f}")

        first_output = outputs[0]
        predicted = first_output["label"]
        confidence = first_output["score"]

        # Normalisation du label
        label_normalise = predicted.strip().lower()
        label_map_normalise = {k.strip().lower(): v for k, v in label_map.items()}

        theme = label_map_normalise.get(label_normalise, "inconnu")

        # Cas 3 : Score de confiance faible
        if confidence < 0.5:
            return jsonify({
                "theme_detecte": theme,
                "label_brut": predicted,
                "confidence": confidence,
                "message_feedback": "Je ne suis pas sûr de ce que vous demandez.",
                "cas": "cas_3"
            })

        # Cas 2 : Thème non attendu
        if themes_attendus and theme not in themes_attendus:
            return jsonify({
                "theme_detecte": theme,
                "label_brut": predicted,
                "confidence": confidence,
                "message_feedback": "Je ne vois pas le rapport avec ce qu'on cherche à savoir.",
                "cas": "cas_2"
            })

        # Cas 1 : Succès
        return jsonify({
            "theme_detecte": theme,
            "label_brut": predicted,
            "confidence": confidence,
            "message_feedback": "OK",
            "cas": "cas_1"
        })

    except Exception as e:
        print(f"\n❌ Erreur lors de la classification : {str(e)}")
        return jsonify({
            "theme_detecte": "inconnu",
            "label_brut": None,
            "confidence": 0.0,
            "message_feedback": "Une erreur est survenue.",
            "cas": "cas_4"
        })

if __name__ == '__main__':
    print("\n=== DÉMARRAGE DU SERVEUR FLASK ===")
    print("Labels disponibles :", list(label_map.keys()))
    print("Thèmes disponibles :", list(label_map.values()))
    print("Mots-clés chargés pour les thèmes :", list(keywords.keys()))
    app.run(host='0.0.0.0', port=5000) 
    #app.run(host='127.0.0.1', port=5000, debug=False)