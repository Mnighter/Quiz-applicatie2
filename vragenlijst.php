<!DOCTYPE html>
<html lang="nl" class="vragenlijst-bg">
	<?php
		require_once('head.php');
	?>
<body>
	<?php
		require_once('header.php');
	?>
	<main>
		<div class="wrapper">
			
			<h2>vragenlijst</h2> 
						
				<form action="backend/opdrachtController.php" method="post">
					
					<input type="hidden" name="action" value="send">
								
								<div class="questions">
									<label for="question1">Q1.Hoe vond je het eerste blok gaan?</label><br>
									<input type="radio" name="question1" id="question1" value="slecht">slecht<br>
									<input type="radio" name="question1" id="question1" value="redelijk slecht">redelijk slecht<br>	
									<input type="radio" name="question1" id="question1" value="neutraal">neutraal<br>
									<input type="radio" name="question1" id="question1" value="redelijk goed">redelijk goed<br>	
									<input type="radio" name="question1" id="question1" value="goed">goed<br>	
								</div>

								<div class="questions">
									<div class="text">
										<label for="question2">Q2.Wat zijn verbeterpunten voor jezelf voor blok 2?</label><br>
										<textarea type="text" name="question2" id="question2"></textarea><br>
									</div>
								</div>

								<div class="questions">
									Q3. Van 1 tot 10, hoe tevreden ben je dat je deze opleiding heb gekozen?<br>
									<label for="question3"></label>
									<input type="number" id="question3" name="question3" min="1" max="10">
								</div>

								<div class="questions">
									<label for="question4">Q4. Vink de vakken waar je nog moeite mee hebt.</label><br>
									<input type="checkbox" name="moeite1" value="Nederlands">Nederlands<br>
									<input type="checkbox" name="moeite2" value="Rekenen">Rekenen<br>	
									<input type="checkbox" name="moeite3" value="Engels">Engels<br>
									<input type="checkbox" name="moeite4" value="Web">Web<br>
									<input type="checkbox" name="moeite5" value="Pra">Pra<br>
									<input type="checkbox" name="moeite6" value="Pro">Pro<br>	
									<input type="checkbox" name="moeite7" value="Native">Native<br>
									<input type="checkbox" name="moeite8" value="DIV">DIV<br>	
								</div>

								<div class="questions">
									<label for="question5">Q5. Hoe is de band met je klasgenoten</label><br>
									<label for="question5">slecht</label>
				 					<input type="range" id="question5" name="question5" min="0" max="50">goed
								</div>

								<div class="questions">
									<label for="question6">Q6. hoellaat word je ongeveer het vaakst wakker voor school?</label><br>
									<label for="question6">Select a time:</label>
				  					<input type="time" id="question6" name="question6">
								</div>

								<div class="questions">	
									<label for="question7">Q7. Als je een kleur kon kiezen voor je klas,welke kleur zou je dan kiezen?</label><br>
									<label for="question7"></label>
				 					<input type="color" id="question7" name="question7" ><br>
								</div>

								<div class="questions">
									<label for="question8">Q8. wat is je favoriete vak?</label><br>
									<input type="radio" name="question8" id="question8" value="Nederlands">Nederlands<br>
									<input type="radio" name="question8" id="question8" value="Rekenen">Rekenen<br>	
									<input type="radio" name="question8" id="question8" value="Engels">Engels<br>
									<input type="radio" name="question8" id="question8" value="Web">Web<br>
									<input type="radio" name="question8" id="question8" value="Pra">Pra<br>
									<input type="radio" name="question8" id="question8" value="Pro">Pro<br>	
									<input type="radio" name="question8" id="question8" value="Native">Native<br>
									<input type="radio" name="question8" id="question8" value="DIV">DIV<br>	
								</div>

								<div class="questions">
									<div class="text">
										<label for="question9">Q9.Heb je hiervoor nog een ander opleiding gedaan? Zo ja, welke?</label><br>
										<textarea type="text" name="question9"> </textarea><br>
									</div>
								</div>

								<div class="questions">
									Q10. Welke klas is beter<br>
									<input type="radio" name="question10" id="question10" value="klas a">klas a<br>
									<input type="radio" name="question10" id="question10" value="klas b">klas b<br>	
									<input type="radio" name="question10" id="question10" value="klas c">klas c<br>
									<input type="radio" name="question10" id="question10" value="klas d">klas d<br>
									<input type="radio" name="question10" id="question10" value="klas e">klas e<br>	
									<input type="radio" name="question10" id="question10" value="klas f">klas f<br>		
								</div>

								<div class="questions">
									<input type="reset" value="Reset">
				  					<input type="submit" value="Submit">	
								</div>
				</form>
		</div>
	</main>
	<?php
		require_once('footer.php');
	?>
</body>
</html>
