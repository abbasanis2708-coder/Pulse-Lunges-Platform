import pandas as pd
import torch
from transformers import AutoTokenizer, AutoModelForSequenceClassification, Trainer, TrainingArguments
from sklearn.preprocessing import LabelEncoder
from datasets import Dataset
import os

# Chargement des données
df = pd.read_csv("dataset.csv")

# Nettoyage des doublons dans les labels (très important)
df["theme"] = df["theme"].str.strip()
df["theme"] = df["theme"].str.replace(r"\s+", " ", regex=True)
df.drop_duplicates(subset=["question", "theme"], inplace=True)

# Encoder les labels
label_encoder = LabelEncoder()
df["label"] = label_encoder.fit_transform(df["theme"])

# Vérification du mapping
print("Mapping des labels :", dict(enumerate(label_encoder.classes_)))

# Sauvegarde du mapping (utile pour serveur Flask)
with open("label_mapping.txt", "w", encoding="utf-8") as f:
    for label, theme in enumerate(label_encoder.classes_):
        f.write(f"{label}\t{theme}\n")

# Dataset HuggingFace
dataset = Dataset.from_pandas(df[["question", "label"]])

# Tokenizer et modèle
model_name = "Dr-BERT/DrBERT-4GB"
tokenizer = AutoTokenizer.from_pretrained(model_name)

def tokenize(batch):
    return tokenizer(batch["question"], padding=True, truncation=True)

dataset = dataset.map(tokenize, batched=True)
dataset = dataset.train_test_split(test_size=0.2)

# Créer le mapping label2id et id2label propre
id2label = {i: label for i, label in enumerate(label_encoder.classes_)}
label2id = {label: i for i, label in id2label.items()}

# Charger le modèle avec le mapping correct
model = AutoModelForSequenceClassification.from_pretrained(
    model_name,
    num_labels=len(label_encoder.classes_),
    id2label=id2label,
    label2id=label2id
)

# Entraînement
training_args = TrainingArguments(
    output_dir="./model",
    evaluation_strategy="epoch",
    save_strategy="epoch",
    num_train_epochs=4,
    per_device_train_batch_size=4,
    per_device_eval_batch_size=4,
    logging_dir="./logs",
    load_best_model_at_end=True,
    metric_for_best_model="eval_loss"
)

trainer = Trainer(
    model=model,
    args=training_args,
    train_dataset=dataset["train"],
    eval_dataset=dataset["test"],
    tokenizer=tokenizer
)

trainer.train()

# Sauvegarde finale
trainer.save_model("model")
tokenizer.save_pretrained("model")
