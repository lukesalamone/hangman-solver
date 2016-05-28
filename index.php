<?php
	function getRandomClass(){
		$classes = array("skull", "noose", "pencil", "star", "calculator",
 					"tile-a", "tile-b", "tile-c");
		return $classes[ rand(0, count($classes) - 1) ];
	}
?>

<html>
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="title" content="Hangman Solver">
	    <meta name="description" content="Solve difficult hangman words!">
	    <meta name="author" content="Luke Salamone">
		<meta name="keywords" content="Hanging with Friends cheat, Hangman solver, Hangman solver tool, Hangman help, Hanging with Friends, Hangman solver online, Hangman help free" />

		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="icon" type="img/ico" href="favicon.ico">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="js/script.js"></script>

		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:site" content="@LukeASalamone">
		<meta name="twitter:creator" content="@LukeASalamone">
		<meta name="twitter:title" content="Hangman Solver">
		<meta name="twitter:description" content="This web app can be used to, um, cheat at hangman :) Built using the Zynga dictionary, this can **optimize** your play in Hanging With Friends">
		<meta name="twitter:image" content="http://solver.lukesalamone.com/img/twitter-img.png">
	</head>

	<body>
		<div id="bg">
			<?php 
				
				for($i=0; $i<300; $i++){
					echo "<div class=" . getRandomClass() . "></div>";
				}
			?>
		</div>
		<div class="content">
			<div class="top-row">
				<div class="word-length">
					<label>Word Length</label>
					<input id="length" size="1" maxlength="1" value="4" />
				</div>
				<div class="proto-word">
					<label>Proto Word</label>
					<div id="proto">
						<input size='1' maxlength='1'>
						<input size='1' maxlength='1'>
						<input size='1' maxlength='1'>
						<input size='1' maxlength='1'>
						<input size='1' maxlength='1'>
						<input size='1' maxlength='1'>
						<input size='1' maxlength='1'>
						<input size='1' maxlength='1'>
					</div>
				</div>
			</div>
			<br>
			<div class="second-row">
				<label>Dead Letters</label>
				<input id="dead" size="15" maxlength="25"/>
			</div>
			<div class="bottom-row hidden">
				<div class="headings">
					<h2 id="likely" class="selected">Likely Letters</h2>
					<h2 id="possible">Possible Words</h2>
				</div>
				<div id="loading" class="hidden"></div>
				<div id="lettergraph">
					<div class="column0"></div>
					<div class="column1"></div>
				</div>
				<div id="wordlist" class="hidden">
					<div class="column2"></div>
					<div class="column3"></div>
				</div>
			</div>
		</div>
	</body>
</html>