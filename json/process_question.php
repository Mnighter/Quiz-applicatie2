<?php
// Verbind met de database
require_once '../backend/conn.php'; 

// Verkrijg de POST-gegevens
$question = $_POST['question'];
$choices = isset($_POST['choices']) ? explode(',', $_POST['choices']) : [];
$answer = $_POST['answer'];
$type = $_POST['type'];

// Laad de bestaande JSON-gegevens
$jsonFile = 'quiz.json'; // Geen pad nodig als alles in dezelfde map staat
if (file_exists($jsonFile)) {
    $jsonData = file_get_contents($jsonFile);
    $quiz = json_decode($jsonData, true);
} else {
    $quiz = ['title' => 'Simpele Quiz applicatie', 'description' => 'Test jouw knowledge met deze simpele quiz!', 'questions' => []];
}

// Voeg de nieuwe vraag toe
$quiz['questions'][] = [
    'question' => $question,
    'choices' => $type == 'multiple-choice' ? $choices : null,
    'answer' => $answer,
    'placeholder' => $type == 'open' ? 'Schrijf je antwoord hier...' : null
];

// Schrijf de bijgewerkte JSON terug naar het bestand
file_put_contents($jsonFile, json_encode($quiz, JSON_PRETTY_PRINT));

// Optioneel: Voeg de vraag direct toe aan de database
$stmt = $conn->prepare("INSERT INTO questions (question, choices, answer, type) VALUES (:question, :choices, :answer, :type)");
$stmt->bindValue(':question', $question);
$stmt->bindValue(':choices', $type == 'multiple-choice' ? json_encode($choices) : json_encode([]));
$stmt->bindValue(':answer', $answer);
$stmt->bindValue(':type', $type);
$stmt->execute();

// Bevestiging
echo "Vraag succesvol toegevoegd!";
?>
