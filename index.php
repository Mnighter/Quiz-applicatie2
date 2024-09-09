<!DOCTYPE html>
<html lang="en">
<?php require_once('head.php'); ?>
<?php require_once('header.php'); ?>
<body>
    <div class="container welcome-container">
        <h1>Welkom bij mijn super duper Quiz App!</h1>
        <p>Ben je er klaar voor om jouw kennis te testen? Klik dan op de knop hieronder.</p>
        
        <div class="arrow-container">
            <div class="arrow-up"></div>
        </div>  
        <!-- Voeg start_quiz=1 toe aan de URL om de quiz te starten -->
        <a href="vragenlijst.php?start_quiz=1" class="start-button">Start Quiz</a>
    </div>
</body>
</html>
