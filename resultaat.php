<?php
// Laad de quizgegevens opnieuw in
$jsonData = file_get_contents('quiz.json');
$quiz = json_decode($jsonData, true);

// Variabelen voor de vragen
$questions = $quiz['questions'];

// Verwerk de antwoorden
$score = 0;
$totalQuestions = count($questions);

foreach ($questions as $index => $question) {
    if (isset($_POST["question-$index"]) && $_POST["question-$index"] == $question['answer']) {
        $score++;
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
