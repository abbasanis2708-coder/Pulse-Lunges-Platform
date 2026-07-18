<?php

function is_admin($type){
    return $type === "admin" ? 1 : 0;
}

function is_professeur($type){
    return $type === "professeur" ? 1 : 0;
}

function is_etudiant($type){
    return $type === "etudiant" ? 1 : 0;
}

function TypeUser($type){
    $type = strtolower($type);
    return $type === "admin" ? 1 : ($type === "professeur" ? 0 : ($type === "etudiant" ? -1 : null));
}

function capterConnexion($code){
    if (!isset($code)) {
        header("Location: index.php");  
        exit();
    }
    return 1;
}

function lastpage($array){
    $url = (string)($_SERVER['HTTP_REFERER'] ?? '');
    $tab = explode("/", $url);
    $last = end($tab);
    if (in_array($last, $array)) {
        echo "<script> alert('You cannot see this page if you are not logged in');</script>";
    }
}

function connecte(){
    try {
        $db = new PDO('mysql:host=db;port=3306;dbname=school;charset=utf8', 'root', 'root_password');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->query("SET NAMES utf8mb4");
        return $db;
    } catch (PDOException $e) {   
        die("Database connection error: " . $e->getMessage());
    }
}

function PDO($query, $array = []) {
    $db = connecte();
    $stm = $db->prepare($query);

    // Count placeholders in query
    $placeholdersCount = substr_count($query, '?');

    // Only bind values if placeholders exist
    if ($placeholdersCount > 0) {
        if ($placeholdersCount !== count($array)) {
            throw new PDOException("Error: Mismatch between placeholders and bound values.");
        }
        foreach ($array as $index => $value) {
            $stm->bindValue($index + 1, $value);
        }
    } else {
        // Ignore extra values instead of throwing an error
        $array = []; 
    }

    $stm->execute();
    return $stm;
}

function display_message($values){
    $query = "SELECT * FROM message WHERE recepteur_id = ? AND recepteur_type = ? ORDER BY id_msg DESC";
    $stm = PDO($query, $values);
    return $stm->rowCount() ? $stm : null;
}

function search_image($path, $code){
    foreach (scandir($path) as $file) {
        if ($file !== "." && $file !== ".." && pathinfo($file, PATHINFO_FILENAME) === $code) {
            return 1;
        }
    }
    return 0;
}

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

function test_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? 1 : 0;
}

function check_existe_email_student($email){
    $queries = [
        "SELECT email FROM student WHERE email=?",
        "SELECT email FROM demande_student WHERE email=?"
    ];
    foreach ($queries as $query) {
        if (PDO($query, [$email])->rowCount() != 0) return 0;
    }
    return 1;
}

function check_existe_email_teacher($email){
    $queries = [
        "SELECT email FROM teacher WHERE email=?",
        "SELECT email FROM demande_teacher WHERE email=?"
    ];
    foreach ($queries as $query) {
        if (PDO($query, [$email])->rowCount() != 0) return 0;
    }
    return 1;
}

function check_existe_filiere_id($filiere_id){
    return PDO("SELECT filiere_id FROM user WHERE filiere_id=?", [$filiere_id])->rowCount() ? 0 : 1;
}

function check_existe_filiere_nom($filiere){
    return PDO("SELECT filiere FROM user WHERE filiere=?", [$filiere])->rowCount() ? 0 : 1;
}
?>
