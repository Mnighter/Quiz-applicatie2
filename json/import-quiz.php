<?php
// Stap 1: Verbind met de database
require_once 'backend/conn.php'; // Verbind met de database via PDO

// Stap 2: Lees de JSON-file
$jsonData = file_get_contents('quiz.json');
$quiz = json_decode($jsonData, true);

// Controleer of de JSON correct is geladen
if (!$quiz) {
    die("Error bij het laden van quiz.json");
}

// Stap 3: Prepareer de SQL-query voor het invoegen van vragen
$stmt = $conn->prepare("INSERT INTO questions (question, choices, answer, type) VALUES (:question, :choices, :answer, :type)");

// Stap 4: Loop door elke vraag en voer de invoegopdracht uit
foreach ($quiz['questions'] as $question) {
    // Bepaal het type vraag (meerkeuze of open vraag)
    $type = isset($question['choices']) ? 'multiple-choice' : 'open';

    // Zet de keuzes om naar JSON als het een meerkeuzevraag is, anders null
    $choices = isset($question['choices']) ? json_encode($question['choices']) : null;

    // Bind parameters en voer de query uit
    $stmt->bindParam(':question', $question['question']);
    $stmt->bindParam(':choices', $choices);
    $stmt->bindParam(':answer', $question['answer']);
    $stmt->bindParam(':type', $type);
    
    $stmt->execute();
}

// Bevestiging
echo "Vragen succesvol geïmporteerd naar de database!";
?>
