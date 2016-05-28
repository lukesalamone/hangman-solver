<?php
	
	/*	lookup.php
	 *
	 *	Created by Luke Salamone on May 26, 2016
	 *
	 *	Looks up words given filter parameters and returns possible results
	 *	in the form 
	 *		{	"letters":{"a":0.1, "b":0.2, "c":0.3}, 
	 *			"words":["word1", "word2", "word3"]
	 *		}
	*/

	$length = $_POST['length'];
	$proto = $_POST['proto'];
	$dead = $_POST['dead'];

	// check that $length is number

	// load appropriate dictionary into $dict
	$dict = file("dicts/" . $length . "_letters.txt", FILE_IGNORE_NEW_LINES);
	$words = array();

	// loop through each word in dictionary
	foreach($dict as $word){
		$flag = true;
		// check that word matches proto
		for($i=0; $i<strlen($proto); $i++){
			if($proto[$i] == "*"){			// wildcard, go to next letter
				//error_log("wildcard at pos " . $i);
				continue;
			}
			if($proto[$i] == $word[$i]){	// correct, go to next letter
				//error_log($proto[$i] . " = " . $word[$i]);
				continue;
			} else{							// incorrect
				//error_log($proto[$i] . " != " . $word[$i]);
				$flag = false;
				continue 2;
			}
		}
		
		if($flag){
			array_push($words, $word);
		}

	}// end foreach loop
	unset($word);

	$deadWords = array();

	//remove words with dead letters
	foreach ($words as $word){
		for ($i=0; $i < strlen($dead); $i++) { 
			if(strpos($word, $dead[$i]) !== false){
				error_log("adding " . $word . " to deadWords");
				array_push($deadWords, $word);
				continue 2;
			}
		}
		
	}
	unset($word);

	$words = array_values(array_diff($words, $deadWords));

	// probably limit returned words to 500 or so

	$letters = array(	"a" => 0,
						"b" => 0,
						"c" => 0,
						"d" => 0,
						"e" => 0,
						"f" => 0,
						"g" => 0,
						"h" => 0,
						"i" => 0,
						"j" => 0,
						"k" => 0,
						"l" => 0,
						"m" => 0,
						"n" => 0,
						"o" => 0,
						"p" => 0,
						"q" => 0,
						"r" => 0,
						"s" => 0,
						"t" => 0,
						"u" => 0,
						"v" => 0,
						"w" => 0,
						"x" => 0,
						"y" => 0,
						"z" => 0);

	$alphabet = "abcdefghijklmnopqrstuvwxyz";

	// count occurrances of each letter by word
	foreach($words as $word){
		// check for each letter in each word
		for($i=0; $i<26; $i++){
			if(strpos($word,$alphabet[$i]) !== false){
				$letters[ $alphabet[$i] ]++;
			}
		}
	}// end foreach loop
	unset($word);

	arsort($letters, SORT_NUMERIC);

	// normalize numbers to size of words
	$num_words = count($words);
	foreach($letters as $l => $v){
		$letters[$l] = $letters[$l] / $num_words;
	}


	//remove letters with zero frequency
	foreach($letters as $l=>$v){
		if($v == 0 || $v == 1){
			$letters = array_diff($letters, array($l=>$v));
		}
	}
	unset($l);

	$ret = array("words"=>$words, "letters"=>$letters);
	echo json_encode($ret);
?>