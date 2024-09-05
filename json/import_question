<?php
// Import-script: Importeert de gegevens uit quiz.json naar de database.

require_once 'backend/conn.php'; // Verbind met de database via PDO

// Laad de JSON-file
$jsonFile = 'quiz.json'; // Pad naar JSON-bestand in de map json
$jsonData = file_get_contents($jsonFile);
$quiz = json_decode($jsonData, true);

// Controleer of de JSON correct is geladen
if (!$quiz) {
    die("Error bij het laden van quiz.json");
}

// Prepareer de SQL-query voor het invoegen van vragen
$stmt = $conn->prepare("INSERT INTO questions (question, choices, answer, type) VALUES (:question, :choices, :answer, :type)");

// Loop door elke vraag en voer de invoegopdracht uit
foreach ($quiz['questions'] as $question) {
    $type = isset($question['choices']) ? 'multiple-choice' : 'open';
    $choices = isset($question['choices']) ? json_encode($question['choices']) : json_encode([]);

    $stmt->bindParam(':question', $question['question']);
    $stmt->bindParam(':choices', $choices);
    $stmt->bindParam(':answer', $question['answer']);
    $stmt->bindParam(':type', $type);
    
    $stmt->execute();
}

echo "Vragen succesvol geïmporteerd naar de database!";
?>
