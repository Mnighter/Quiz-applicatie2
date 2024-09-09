<!DOCTYPE html>
<html lang="en">
    <?php 
        require_once('../head.php'); 
        require_once('../backend/conn.php');
        
        // Haal alle vragen op uit de database
        $query = $conn->query("SELECT * FROM questions");
        $questions = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <body>
        <div class="delete-question-container">
            <h1>Verwijder een vraag</h1>

            <form method="post" action="../backend/questionController.php">
                <label for="question_id">Selecteer de vraag die je wilt verwijderen:</label>
                <select id="question_id" name="question_id" required>
                    <?php foreach ($questions as $question) : ?>
                        <option value="<?php echo $question['id']; ?>"><?php echo $question['question']; ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <input type="hidden" name="delete_question" value="1">
                <input type="submit" value="Verwijder Vraag">
            </form>
        </div>
    </body>
</html>
