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
	$live = str_replace("*", "", $proto);

	// check that $length is number

	// load appropriate dictionary into $dict
	$dict = file("dicts/" . $length . "_letters.txt", FILE_IGNORE_NEW_LINES);
	$words = array();

	// loop through each word in dictionary
	foreach($dict as $word){
		$flag = true;
		// check that word matches proto
		for($i=0; $i<strlen($proto); $i++){
			if($proto[$i] == "*"){			// wildcard
				for($j=0; $j<strlen($live); $j++){
					if($word[$i] == $live[$j]){		// disallow a*** matching abba
						$flag = false;
						continue 3;
					}
				}
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

	$alphabet = "abcdefghijklmnopqrstuvwxyz";
	$letters = array_fill_keys(str_split($alphabet), 0);

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