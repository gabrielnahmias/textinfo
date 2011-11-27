<?php

define("APP","textInfo");
define("FILE", basename( $_SERVER['PHP_SELF'] ) );
define("ERROR_NOTEXT", "Please enter some text.");
define("VER","1.0");

include "./browser.php";
include "./vs.php";
//include "funcs.php";

/***************
add duplicate word count
*******************/


$br = new Browser;

if ( isset( $_POST['text'] ) ) {
	
	$strText = trim( $_POST['text'] );
	
	if ( !empty($strText) ) {
		
		$strUnfTxt = $_POST['text'];	// to show actual character count
		
		$intWords = count( explode(" ", $strText) );
		$intLines = count( explode("\n", $strText) );
		$intChars = strlen($strUnfTxt);
		$arrChars = count_chars($strUnfTxt, 1);
		$strChars = "";
		
		foreach ($arrChars as $ka => $va) {
   			
			if ($ka==32)
				$ka = "Space";
			elseif ($ka==10)
				$ka = "Newline";
			else
				$ka = chr($ka);
			
			$strChars .= "<tr>\r\n<td class=\"info\">$ka</td>\r\n<td class=\"info\">$va</td>\r\n</tr>\r\n";
			
		}
		
		print "<b>$intWords</b> <i>word".( ($intWords==1) ? "" : "s" )."</i><br />
		      <b>$intLines</b> <i>line".( ($intLines==1) ? "" : "s" )."</i><br />
		      <b>$intChars</b> <i>character".( ($intChars==1) ? "" : "s" )."</i><br /><br />
		      <table align=\"center\" cellspacing=0 class=\"info\">
			  <tr>
			  <th class=\"info\">Character</td>
			  <th class=\"info\">Frequency</td>
			  </tr>
			  $strChars</table>";
		
	} else
		print ERROR_NOTEXT;
	
//	sleep(1);
	 
	exit;
	
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= APP.( ($br->Platform=="iPhone") ? "" : " v".VER )	// for the purpose of when a person adds it to their home screen ?></title>

<link rel="apple-touch-icon-precomposed" href="img/touchfav.png" />
<link rel="apple-touch-startup-image" href="img/splash.png" />
<link rel="shortcut icon" href="img/favy.ico" />
<link rel="stylesheet" href="css/styles.css" />
<?php css_add(); ?>

<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">

<script language="javascript" src="js/jquery-1.4.4.min.js"></script>
<script language="javascript" src="js/placeholder.js"></script>

<script language="javascript">

$(document).ready( function() {
	
	$("#load").ajaxStart( function() {
		$(this).css("visibility","visible");
	} ).ajaxStop( function() {
		$(this).css("visibility","hidden");
	} );
	
	$("#btnCount").click( function() {
		
		$.post("<?=FILE?>", { text: $("#txtText").val() }, function(data) {
			
			if (data != "<?=ERROR_NOTEXT?>") {
				$("#err").slideUp();
				$("#msg").slideDown().html(data);
			} else {
				$("#msg").slideUp();
				$("#err").slideDown().html("<b>"+data+"</b>");
			}
			
		} );
		
	} );
	
	$("#copy").click( function() {
		
		$text = $("#msg").html();
		
		copy2cb($text);
		
	} );
	
	// ***********************************
	// copy output functionality
	// make goto sense .last(".ln")'s value to alert there is no line number
	// ***********************************
	
	function copy2cb(text) {
	
		var flashId = 'flashId-HKxmj5';
		
		var clipboardSWF = 'http://appengine.bravo9.com/copy-into-clipboard/clipboard.swf';
		
		if (!document.getElementById(flashId) ) {
			var div = document.createElement('div');
			div.id = flashId;
			document.body.appendChild(div);
		}
		
		document.getElementById(flashId).innerHTML = '';
		
		var content = '<embed src="' + clipboardSWF +
					  '" FlashVars="clipboard=' + encodeURIComponent(text) +
					  '" width="0" height="0" type="application/x-shockwave-flash"></embed>';
		
		document.getElementById(flashId).innerHTML = content;
		
	}
	
} );

</script>

</head>

<body onorientationchange="updateOrientation();">

<?php if ($br->Platform == "iPhone"):  ?>
<br />
<br />
<?php endif; ?>

<?php

if ($br->Platform != "iPhone"):
?><table class="main">
	
    <tr>
    	
        <td align="center" height="100%" valign="middle">
            
			<?php
			
			endif;
			
			if ($br->Platform != "iPhone"):
			
			?><h1><?=APP." v".VER?>
            <hr /></h1>
            <?php endif; ?>
            
            <center>
            <div id="msg"></div>
            <div id="err"></div>
            </center>
            
            <textarea id="txtText">Enter words here</textarea>
            
            <br /><input id="btnCount" type="button" value="Show Info" /> <img id="load" src="img/load.gif" style="visibility:hidden;" />
            
			<hr class="footer" /><?=vs()?>
<?php
if ($br->Platform != "iPhone"):
?>
        </td>
    	
    </tr>

</table>

<?php
endif;
?>

</body>

</html>