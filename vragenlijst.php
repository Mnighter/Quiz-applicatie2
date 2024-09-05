<?php
// Laad de quizgegevens vanuit het JSON-bestand
$jsonData = file_get_contents('quiz.json');
$quiz = json_decode($jsonData, true);

// Controleer of de gegevens correct zijn geladen
if (!$quiz) {
    die('Error loading quiz data');
}

// Variabelen voor de titel en beschrijving van de quiz
$title = $quiz['title'];
$description = $quiz['description'];
$questions = $quiz['questions'];
?>

<!DOCTYPE html>
<html lang="en">
<?php 
    require_once('head.php');
?>
<body>
	<div class="vragenlijst-container">
		<h1><?php echo $title; ?></h1>
		<p><?php echo $description; ?></p>

		<form method="post" action="resultaat.php">
			<?php foreach ($questions as $index => $question) : ?>
				<div class="question">
					<h2><?php echo ($index + 1) . '. ' . $question['question']; ?></h2>
					<ul class="choices">
						<?php if (isset($question['choices'])) : ?>		
							<?php foreach ($question['choices'] as $choice) : ?>
								<li>
									<label>
										<input type="radio" name="question-<?php echo $index; ?>" value="<?php echo $choice; ?>" required>
										<?php echo $choice; ?>
									</label>
								</li>
							<?php endforeach; ?>

						<?php elseif (isset($question['placeholder'])) : ?>
								<li>
									<label>
										<textarea
											name="question-<?php echo $index; ?>"
											value="<?php echo $question['placeholder']; ?>" required>
										</textarea>
									</label>
								</li>
						<?php endif ?>
					</ul>
				</div>
			<?php endforeach; ?>
			<input type="submit" value="verzend Quiz">
		</form>
	</div>
</body>
</html>
