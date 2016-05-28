var classes = ["skull", "noose", "pencil", "star", "calculator",
			 "tile-a", "tile-b", "tile-c"];

var length;
var response;

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
});

var evaluate = function(){
	if( $("#length").val() == "") return;
	if( getProto() == "") return;

	$("#loading").removeClass("hidden");
	$(".column0").html("");
	$(".column1").html("");
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
			console.log(data);
			for(var i=0; i<data.words.length; i++){
				$(".column" + i%2).append("<span>" + data.words[i] + "</span>");
			}
		}, error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + "\nError:" + err);
		}, complete: function(){
			$("#loading").addClass("hidden");
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
	return ret;
}

function getRandomClass(){
	return classes[Math.floor(Math.random() * classes.length)];
}