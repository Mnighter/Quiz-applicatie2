<?php


require_once 'backend/conn.php'; 

$jsonFile = 'quiz.json'; 
$jsonData = file_get_contents($jsonFile);
$quiz = json_decode($jsonData, true);


if (!$quiz) {
    die("Error bij het laden van quiz.json");
}


$quizSQL = $conn->prepare("INSERT INTO questions (question, choices, answer, type) VALUES (:question, :choices, :answer, :type)");


foreach ($quiz['questions'] as $question) {
    $type = isset($question['choices']) ? 'multiple-choice' : 'open';
    $choices = isset($question['choices']) ? json_encode($question['choices']) : json_encode([]);

    $quizSQL->bindParam(':question', $question['question']);
    $quizSQL->bindParam(':choices', $choices);
    $quizSQL->bindParam(':answer', $question['answer']);
    $quizSQL->bindParam(':type', $type);
    
    $quizSQL->execute();
}

echo "Vragen succesvol geïmporteerd naar de database!";
?>
