<?php
require_once 'backend/conn.php'; // Verbind met de database

// Haal alle quizvragen uit de database
$query = $conn->query("SELECT * FROM questions");
$questions = $query->fetchAll(PDO::FETCH_ASSOC);

// Controleer of de vragen zijn geladen
if (!$questions) {
    die('Error loading quiz data');
}

$title = "Simpele Quiz applicatie";
$description = "Test jouw knowledge met deze simpele quiz!";
?>

<!DOCTYPE html>
<html lang="en">
<!-- vragenlijst.php -->
<!DOCTYPE html>
<html lang="en">
<?php 
    require_once('head.php');
?>
<?php 
    require_once('header.php');
?>
<body>
    <div class="container vragenlijst-container">
        <h1>Vragenlijst</h1>
		<h1><?php echo $title; ?></h1>
		<p><?php echo $description; ?></p>

		<form method="post" action="resultaat.php">
			<?php foreach ($questions as $index => $question) : ?>
				<div class="question">
					<h2><?php echo ($index + 1) . '. ' . $question['question']; ?></h2>
					<ul class="choices">
						<?php if ($question['type'] == 'multiple-choice') : 
							$choices = json_decode($question['choices'], true);
							foreach ($choices as $choice) : ?>
								<li>
									<label>
										<input type="radio" name="question-<?php echo $index; ?>" value="<?php echo $choice; ?>" required>
										<?php echo $choice; ?>
									</label>
								</li>
							<?php endforeach; ?>

						<?php elseif ($question['type'] == 'open') : ?>
								<li>
									<label>
										<textarea name="question-<?php echo $index; ?>" placeholder="Schrijf je antwoord hier..." required></textarea>
									</label>
								</li>
						<?php endif ?>
					</ul>
				</div>
			<?php endforeach; ?>
			<input type="submit" value="Verzend Quiz">
		</form>
	</div>
</body>
</html>
