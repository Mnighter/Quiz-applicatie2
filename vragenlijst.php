<?php
session_start();
require_once 'backend/conn.php'; // Verbind met de database

// Als de sessie niet is ingesteld, laad de vragen uit de database en zet ze in de sessie
if (!isset($_SESSION['questions'])) {
    $_SESSION['questions'] = $conn->query("SELECT * FROM questions")->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['user_answers'] = []; // Initialiseer een lege array voor antwoorden
}

// Controleer of er een vraag is verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_question_index = $_POST['question_index'];
    $user_answer = $_POST['answer'];

    // Sla het antwoord op in de sessie
    $_SESSION['user_answers'][$current_question_index] = $user_answer;

    // Ga naar de volgende vraag
    $current_question_index++;
    if ($current_question_index >= count($_SESSION['questions'])) {
        // Alle vragen zijn beantwoord, stuur door naar de resultatenpagina
        header('Location: resultaat.php');
        exit();
    }

    // Update de vraagindex in de sessie
    $_SESSION['current_question_index'] = $current_question_index;
}

// Verkrijg de huidige vraagindex uit de sessie, of start bij 0 als deze niet is ingesteld
if (!isset($_SESSION['current_question_index'])) {
    $_SESSION['current_question_index'] = 0;
}
$current_question_index = $_SESSION['current_question_index'];

// Verkrijg de huidige vraag op basis van de index
if ($current_question_index >= count($_SESSION['questions'])) {
    // Geen vragen meer beschikbaar, stuur door naar de resultatenpagina
    header('Location: resultaat.php');
    exit();
}

$current_question = $_SESSION['questions'][$current_question_index];

// Definieer titel en beschrijving
$title = "Simpele Quiz applicatie";
$description = "Test jouw knowledge met deze simpele quiz!";
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('head.php'); ?>
<?php require_once('header.php'); ?>
<body>
    <div class="container vragenlijst-container">
        <h1>Vragenlijst</h1>
        <h1><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
        <p><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></p>

        <form method="post">
            <input type="hidden" name="question_index" value="<?php echo htmlspecialchars($current_question_index, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="question">
                <h2><?php echo htmlspecialchars(($current_question_index + 1) . '. ' . $current_question['question'], ENT_QUOTES, 'UTF-8'); ?></h2>
                <ul class="choices">
                    <?php if ($current_question['type'] == 'multiple-choice') : 
                        $choices = json_decode($current_question['choices'], true);
                        foreach ($choices as $choice) : ?>
                            <li>
                                <label>
                                    <input type="radio" name="answer" value="<?php echo htmlspecialchars($choice, ENT_QUOTES, 'UTF-8'); ?>" required>
                                    <?php echo htmlspecialchars($choice, ENT_QUOTES, 'UTF-8'); ?>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    <?php elseif ($current_question['type'] == 'open') : ?>
                        <li>
                            <label>
                                <textarea name="answer" placeholder="Schrijf je antwoord hier..." required></textarea>
                            </label>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
            <button type="submit">Volgende</button>
        </form>
    </div>
</body>
</html>
