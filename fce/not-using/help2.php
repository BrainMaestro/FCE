<?php
	$result1 = $mysqli->query("SELECT * FROM accesskeys WHERE key_crn='$crn' AND key_eval_type='$eval_type'");
	$keyArray1 = [];
	
	echo "<div class='slider_bg'>";
	echo "<div class='container'>";
	echo "<div id='da-slider' class='da-slider text-center'>";
	
	for($i = 0; $i < $result1->num_rows; $i++) {
		$row = $result1->fetch_assoc();
		$sn = $i + 1;
		
		echo "<div class='da-slide'>";
		echo "<p>$sn</p>";
		echo "<h2>$row[key_value]</h2>";
		//echo "<span><h3 class='da-link'><a  class='fa-btn btn-1 btn-1e'>Previous Key</a></h3></span>
		//<span><h3 class='da-link'><a  class='fa-btn btn-1 btn-1e'>Next Key</a></h3></span>";
		//echo "<input class='black-btn' name='previous_key' value='Previous Key'>
		//<input class='black-btn' name='next_key' value='Next Key'>";
		echo "</div>";
	}

	echo "</div></div></div>";
	
	echo "<div class='text-center'>";
	echo "<input class='black-btn' name='previous_key' type='button' value='Previous Key'>
	<input class='black-btn' name='next_key' type='button' value='Next Key'>";
	echo "</div>";
?>

<script type="text/javascript">
	document.write("<div class='slider_bg'>");
	document.write("<div class='container'>");
	document.write("<div id='da-slider' class='da-slider'>");
	
	displayKeys();
	
	function getnum() {
		var num = 1;
		return num
	}
	
	function increaseKey() {
		var num = getnum();
		var keyvalues = document.getElementsByName('items[]');
		
		if (num > keyvalues.length) {
			num = 0;
		}
		else {
			num++;
		}
		
		return num;
	}
	
	function decreaseKey() {
		var num = getnum();
		num--
		return num;
	}
	
	function displayKeys() {
		
		var keyvalues = document.getElementsByName('items[]');
		var keys_array = [];
		num = 2;
		
		/*var num = getnum();
		if (num > keyvalues.length) {
			num = 0;
		}
		if (num < 0) {
			num = keyvalues.length;
		}*/
		
		for (var i = 0; i < keyvalues.length; i++) {
			keys_array.push(keyvalues[i].value);
		}
		
		document.write("<div class='da-slide'>");
		document.write("<p>" + num + "</p>");
		document.write("<h2>" + keys_array[num] + "</h2>");
		document.write("</div>");
	}
	
	document.write("</div></div></div>");
	
	
	document.write("<div class='text-center'>");
	document.write("<input class='black-btn' name='previous_key' type='button' value='Previous Key' onClick=' return decreaseKey(this)'>"); 
	document.write("<input class='black-btn' name='next_key' type='button' value='Next Key' onClick=' return increaseKey(this)'>"); 
	document.write("</div>");

</script>