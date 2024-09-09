<?php
session_start();
require_once 'backend/conn.php'; // Verbind met de database

// Haal alle vragen opnieuw op uit de database
$query = $conn->query("SELECT * FROM questions");
$questions = $query->fetchAll(PDO::FETCH_ASSOC);

// Verwerk de antwoorden
$score = 0;
$totalQuestions = count($questions);

foreach ($questions as $index => $question) {
    if (isset($_SESSION['user_answers'][$index])) {
        // Controleer meerkeuzevragen
        if ($question['type'] == 'multiple-choice' && $_SESSION['user_answers'][$index] == $question['answer']) {
            $score++;
        }
        // Controleer open vragen
        elseif ($question['type'] == 'open') {
            $userAnswer = trim(strtolower($_SESSION['user_answers'][$index]));
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
<?php require_once('head.php'); ?>
<title>Quiz resultaat</title>
<body>
    <h1>Quiz resultaat</h1>
    <p>Jouw score: <?php echo $score; ?> van de <?php echo $totalQuestions; ?> (<?php echo round($percentage); ?>%)</p>
    
    <h2>Overzicht van je antwoorden:</h2>
    <ul>
        <?php foreach ($questions as $index => $question) : ?>
            <li>
                <strong><?php echo htmlspecialchars($question['question'], ENT_QUOTES, 'UTF-8'); ?></strong><br>
                Jouw antwoord: 
                <?php
                $userAnswer = $_SESSION['user_answers'][$index] ?? 'Geen antwoord';
                $correctAnswer = $question['answer'];
                if ($question['type'] == 'multiple-choice') {
                    if ($userAnswer == $correctAnswer) {
                        echo '<span style="color: green;">' . htmlspecialchars($userAnswer, ENT_QUOTES, 'UTF-8') . '</span>';
                    } else {
                        echo '<span style="color: red;">' . htmlspecialchars($userAnswer, ENT_QUOTES, 'UTF-8') . '</span>';
                    }
                } else {
                    if (strtolower(trim($userAnswer)) == strtolower(trim($correctAnswer))) {
                        echo '<span style="color: green;">' . htmlspecialchars($userAnswer, ENT_QUOTES, 'UTF-8') . '</span>';
                    } else {
                        echo '<span style="color: red;">' . htmlspecialchars($userAnswer, ENT_QUOTES, 'UTF-8') . '</span>';
                    }
                }
                ?>
                <br>Correct antwoord: <?php echo htmlspecialchars($correctAnswer, ENT_QUOTES, 'UTF-8'); ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="index.php" onclick="resetQuiz()">Doe de Quiz nogmaals</a>

    <script>
    function resetQuiz() {
        <?php
        // Start een nieuwe sessie en vernietig de oude gegevens
        session_start();
        session_unset();
        session_destroy();
        ?>
    }
    </script>
</body>
</html>
