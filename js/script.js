var classes = ["skull", "noose", "pencil", "star", "calculator",
			 "tile-a", "tile-b", "tile-c"];

var length;
var response;
var blocking = false;

$(document).ready(function(){
	setProto();
	var height = Math.ceil($(window).height() / 40);
	var width = Math.ceil($(window).width() / 40);

	document.getElementById("length").oninput = function(){
		if( !isNaN(parseInt( $("#length").val() )) ){
			length = parseInt($("#length").val());
		}
		setProto();
		evaluate();
	}
	document.getElementById("proto").oninput = evaluate;
	document.getElementById("dead").oninput = evaluate;

	$(".headings h2").click(function(e){
		dataSelect(e.target);
	});
});

var evaluate = function(){
	if(blocking) return;
	if( $("#length").val() == "") return;
	if( !checkProto() ) return;

	$(".bottom-row").removeClass("hidden");
	$("#loading").removeClass("hidden");
	for(var i=0; i<4; i++){
		$(".column" + i).html("");
	}

	blocking = true;

	// send ajax request
	$.ajax({
		url: 'lookup.php',
		type: 'post',
		data: {	'length':length, 
				'proto':getProto(),
				'dead':$("#dead").val()},
		success: function(data, status) {
			data = JSON.parse(data);
			response = data;

			var j=0;
			var norm;
			for(var key in response.letters){
				if(norm == null){
					norm = 0.95 / response.letters[key];
				}
				var percent = (response.letters[key] * 100).toFixed(2);
				var str = key + " : " + percent + "%";
				var entry = document.createElement("div");
				var label = document.createElement("span");
				var bar = document.createElement("div");
				$(entry).addClass("letter-entry");
				$(label).html(str);
				$(bar).attr("style", "width:" + percent*norm + "%");
				$(entry).append( $(label) );
				$(entry).append( $(bar) );
				$(".column" + j%2).append( $(entry) );
				j++;
			}

			for(var i=0; i<data.words.length; i++){
				var word = document.createElement("a");
				var lbrk = document.createElement("br");
				$(word).html(data.words[i]);
				$(word).attr("href", "http://dictionary.com/browse/" + data.words[i]);
				$(word).attr("target", "_blank");
				$(".column" + (i%2 + 2) ).append( $(word) );
				$(".column" + (i%2 + 2) ).append( $(lbrk) );
			}
			$("#possible").html(data.words.length + " Possible Words");
		}, error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + "\nError:" + err);
		}, complete: function(){
			$("#loading").addClass("hidden");
			blocking = false;	
		}
	}); // end ajax call
};

function setProto(){
	if(length == 0) length = 4;
	for(var i=0; i<8; i++){
		if(i<length){
			$($("#proto").children()[i]).css("display", "block");
		}else{
			$($("#proto").children()[i]).css("display", "none");
		}
	}
}

function getProto(){
	var ret = "";
	for(var i=0; i<length; i++){
		if($($("#proto").children()[i]).val() == ""){
			ret += "*";
		} else{
			ret += $($("#proto").children()[i]).val();
		}
	}
	return ret.toLowerCase();
}

// return true if proto is not all asterisks
function checkProto(){
	var proto = getProto();
	for(var i=0; i<proto.length; i++){
		if(proto.charAt(i) != "*"){
			return true;
		}
	}
	return false;
}

function getRandomClass(){
	return classes[Math.floor(Math.random() * classes.length)];
}

function dataSelect(target){
	if($(target).hasClass("selected")) return;

	$("#likely").toggleClass("selected");
	$("#possible").toggleClass("selected");

	if(target.id == "likely"){
		$("#lettergraph").removeClass("hidden");
		$("#wordlist").addClass("hidden");
	}else{
		$("#lettergraph").addClass("hidden");
		$("#wordlist").removeClass("hidden");
	}
}