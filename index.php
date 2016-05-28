<?php
	function getRandomClass(){
		$classes = array("skull", "noose", "pencil", "star", "calculator",
 					"tile-a", "tile-b", "tile-c");
		return $classes[ rand(0, count($classes) - 1) ];
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="icon" type="img/ico" href="favicon.ico">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="js/script.js"></script>
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
			<div class="bottom-row">
				<label>Possible Words</label>
				<div id="loading" class="hidden"></div>
				<div class="column0"></div>
				<div class="column1"></div>
			</div>
		</div>
	</body>
</html>