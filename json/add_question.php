<!DOCTYPE html>
<html lang="en">
<?php 
    require_once('../head.php'); // Zorg ervoor dat het pad correct is
?>
<body>
    <h1>Voeg een Vraag Toe</h1>
    <form method="post" action="../backend/questionAddController.php">
        <label for="question">Vraag:</label>
        <input type="text" id="question" name="question" required><br><br>

        <label for="choices">Keuzes (komma-gescheiden, leeg voor open vraag):</label>
        <input type="text" id="choices" name="choices"><br><br>

        <label for="answer">Antwoord:</label>
        <input type="text" id="answer" name="answer" required><br><br>

        <label for="type">Type vraag:</label>
        <select id="type" name="type" required>
            <option value="multiple-choice">Meerkeuze</option>
            <option value="open">Open</option>
        </select><br><br>

        <input type="submit" value="Voeg Vraag Toe">
    </form>
</body>
</html>
