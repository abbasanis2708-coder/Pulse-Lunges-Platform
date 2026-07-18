<?php
define('DB_DSN', 'mysql:host=db;port=3306;dbname=school');
define('DB_USER', 'root');
define('DB_PASS', 'root_password'); // Mets ici le mot de passe défini dans docker-compose

// Configuration de Flask
define('FLASK_API_URL', 'http://ia:5000/classify');
define('FLASK_TIMEOUT', 5);
define('FLASK_CONNECT_TIMEOUT', 2);

// Configuration du script Python
//define('PYTHON_SCRIPT_PATH', 'moteur_web_drbert.py');

// Configuration des messages d'erreur
define('ERROR_MESSAGES', [
    'flask_error' => 'Erreur de communication avec le service de classification.',
    'python_error' => 'Erreur lors de l\'exécution du script Python.',
    'db_error' => 'Erreur lors de la sauvegarde des données.',
    'auth_error' => 'Vous devez être connecté pour accéder à cette page.'
]); 