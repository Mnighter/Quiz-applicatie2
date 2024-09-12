<?php
require_once 'conn.php';


function addQuestion($question, $choices, $answer, $type) {
    global $conn;

    $jsonFile = '../json/quiz.json';
    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        $quiz = json_decode($jsonData, true);
    } else {
        $quiz = ['title' => 'Simpele Quiz applicatie', 'description' => 'Test jouw knowledge met deze simpele quiz!', 'questions' => []];
    }


    $quiz['questions'][] = [
        'question' => $question,
        'choices' => $type == 'multiple-choice' ? $choices : null,
        'answer' => $answer,
        'placeholder' => $type == 'open' ? 'Schrijf je antwoord hier...' : null
    ];

    file_put_contents($jsonFile, json_encode($quiz, JSON_PRETTY_PRINT));

    $quizSQL = $conn->prepare("INSERT INTO questions (question, choices, answer, type) VALUES (:question, :choices, :answer, :type)");
    $quizSQL->bindValue(':question', $question);
    $quizSQL->bindValue(':choices', $type == 'multiple-choice' ? json_encode($choices) : json_encode([]));
    $quizSQL->bindValue(':answer', $answer);
    $quizSQL->bindValue(':type', $type);
    $quizSQL->execute();

    $msg =  "Vraag succesvol toegevoegd";
    header("location: ../index.php?msg=$msg");
}


function deleteQuestion($questionId) {
    global $conn;

    $quizSQL = $conn->prepare("DELETE FROM questions WHERE id = :id");
    $quizSQL->bindValue(':id', $questionId);
    $quizSQL->execute();

  
    $jsonFile = '../json/quiz.json'; 
    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        $quiz = json_decode($jsonData, true);

        foreach ($quiz['questions'] as $index => $question) {
            if ($question['question'] === $questionId) {
                unset($quiz['questions'][$index]);
                break;
            }
        }

        $quiz['questions'] = array_values($quiz['questions']);
        file_put_contents($jsonFile, json_encode($quiz, JSON_PRETTY_PRINT));
    }

    $msg = "Vraag succesvol verwijderd";
    header("location: ../index.php?msg=$msg");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_question'])) {
        $questionId = $_POST['question_id'];
        deleteQuestion($questionId);
    } else {
        $question = $_POST['question'];
        $choices = isset($_POST['choices']) ? explode(',', $_POST['choices']) : [];
        $answer = $_POST['answer'];
        $type = $_POST['type'];

        addQuestion($question, $choices, $answer, $type);
    }
}
?>
