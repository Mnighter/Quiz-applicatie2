<?php
require_once 'backend/conn.php'; // Verbind met de database

// Haal alle vragen opnieuw op uit de database
$query = $conn->query("SELECT * FROM questions");
$questions = $query->fetchAll(PDO::FETCH_ASSOC);

// Verwerk de antwoorden
$score = 0;
$totalQuestions = count($questions);

foreach ($questions as $index => $question) {
    if (isset($_POST["question-$index"])) {
        // Controleer meerkeuzevragen
        if ($question['type'] == 'multiple-choice' && $_POST["question-$index"] == $question['answer']) {
            $score++;
        }
        // Controleer open vragen
        elseif ($question['type'] == 'open') {
            $userAnswer = trim(strtolower($_POST["question-$index"]));
            $correctAnswer = trim(strtolower($question['answer']));
            
            if ($userAnswer == $correctAnswer) {
                $score++;
            }
        }
    }
}

$percentage = ($score / $totalQuestions) * 100;
?>

<!DOCTYPE html>
<html lang="en">
<?php 
    require_once('head.php');
?>
<title>Quiz resultaat</title>
<body>
    <h1>Quiz resultaat</h1>
    <p>jouw score: <?php echo $score; ?> van de <?php echo $totalQuestions; ?> (<?php echo round($percentage); ?>%)</p>
    <a href="index.php">Doe de Quiz nogmaals</a>
</body>
</html>
