<?php
require_once 'conn.php'; // Verbind met de database via PDO

// Functie voor het toevoegen van een vraag
function addQuestion($question, $choices, $answer, $type) {
    global $conn;

    // Laad de bestaande JSON-gegevens
    $jsonFile = '../json/quiz.json'; // Pad naar JSON-bestand
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

    // Voeg de vraag direct toe aan de database
    $stmt = $conn->prepare("INSERT INTO questions (question, choices, answer, type) VALUES (:question, :choices, :answer, :type)");
    $stmt->bindValue(':question', $question);
    $stmt->bindValue(':choices', $type == 'multiple-choice' ? json_encode($choices) : json_encode([]));
    $stmt->bindValue(':answer', $answer);
    $stmt->bindValue(':type', $type);
    $stmt->execute();

    $msg =  "Vraag succesvol toegevoegd";
    header("location: ../index.php?msg=$msg");
}

// Functie voor het verwijderen van een vraag
function deleteQuestion($questionId) {
    global $conn;

    // Verwijder de vraag uit de database
    $stmt = $conn->prepare("DELETE FROM questions WHERE id = :id");
    $stmt->bindValue(':id', $questionId);
    $stmt->execute();

    // Laad de bestaande JSON-gegevens
    $jsonFile = '../json/quiz.json'; // Pad naar JSON-bestand
    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        $quiz = json_decode($jsonData, true);

        // Zoek en verwijder de vraag uit de JSON
        foreach ($quiz['questions'] as $index => $question) {
            if ($question['question'] === $questionId) {
                unset($quiz['questions'][$index]);
                break;
            }
        }

        // Herindexeer de array en sla de bijgewerkte JSON op
        $quiz['questions'] = array_values($quiz['questions']);
        file_put_contents($jsonFile, json_encode($quiz, JSON_PRETTY_PRINT));
    }

    $msg = "Vraag succesvol verwijderd";
    header("location: ../index.php?msg=$msg");
}

// Verkrijg de POST-gegevens en roep de juiste functie aan
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
