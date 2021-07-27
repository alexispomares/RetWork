<?php
require("page.inc.php");
$page = new Page("Search results");
$page->content = "\n\n";


// Read jobs file
// 0 Title
// 1 Job description
// 2 Time schedule (Mon, Tue, Wed, Thu, Fri, Sat, Sun) - 2400 hour format
// 3 Pay (in $/h)
// 4 Keywords
// 5 Possible limitations
// 6 Address: Street/Postcode
// 7 Contact number
// 8 Company: Name/CompanyORPrivate

$file = fopen("joboffers.txt","r");
$jobList = [];
while(!feof($file)){
	$line = fgets($file);
	$lineArr = explode(">", trim($line));
	$searchTerm = $_GET['cat'];
	if(count($lineArr) > 4 && preg_match("/$searchTerm/", $lineArr[4])){
		$jobList[] = $lineArr;
	}
}
fclose($file);

$page->content .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
//window.alert("hello");
var jArray= "<?php echo json_encode($jobList); ?>";
//window.alert(jArray);
$(document).ready(function(){
    $("input").each(function(){
		//window.alert($(this).attr("value"));
		//window.alert(getCookie($(this).attr("value")));
		//window.alert($(this).attr("name") + ", " + getCookie($(this).attr("name")));
		if(getCookie($(this).attr("name")) == $(this).attr("value")){
			
			$(this).prop("checked", true);
		}
	});
});
</script>';

// Filter
$page->content .= "<div class='results'>\n\n";
$page->content .= "<div class='filter' style='float:left'>\n";
$page->content .= "<b>Pay range:</b><br>
<input c='filter' onclick='setCookie(\"cat3\",\"flex\");location.reload();' type='checkbox' name='cat3' value='flex'>Flexible<br>\n
<input id='filter' onclick='setCookie(\"cat3\",\"0-10\");location.reload();' type='checkbox' name='cat3' value='0-10'>$0-10<br>\n
<input id='filter' onclick='setCookie(\"cat3\",\"11-20\");location.reload();' type='checkbox' name='cat3' value='11-20'>$11-20<br>\n
<input id='filter' onclick='setCookie(\"cat3\",\"21-\");location.reload();' type='checkbox' name='cat3' value='21-'>$21<br>";

$page->content .= "<br><b>I can't:</b><br>
<input id='filter' onclick='setCookie(\"cat5\",\"walk\");location.reload();' type='checkbox' name='cat5' value='walk'>Walk<br>\n
<input id='filter' onclick='setCookie(\"cat5\",\"hear\");location.reload();' type='checkbox' name='cat5' value='hear'>Hear<br>\n
<input id='filter' onclick='setCookie(\"cat5\",\"listen\");location.reload();' type='checkbox' name='cat5' value='listen'>Listen<br>\n
<input id='filter' onclick='setCookie(\"cat5\",\"talk\");location.reload();' type='checkbox' name='cat5' value='talk'>Talk<br>\n
<input id='filter' onclick='setCookie(\"cat5\",\"see\");location.reload();' type='checkbox' name='cat5' value='see'>See<br>\n";

$page->content .= "<button onclick='deleteAllCookies();location.reload();'>Reset</button>";
$page->content .= "</div>";

// Display job information based on searchTerm
if(count($jobList) > 0){
	for($i = 0; $i < count($jobList); $i++){
		// Check if cookies say job should be skipped
		// Category 5 - Physical limitations
		if(isset($_COOKIE["cat5"]) && $_COOKIE["cat5"] != "") {
			$v = $_COOKIE["cat5"];
			if (strpos($jobList[$i][5], $v) !== false){
				continue;
			}
		}
		// Category 3 - Pay
		/* if(isset($_COOKIE["cat3"]) && $_COOKIE["cat3"] != "") {
			$v = $_COOKIE["cat3"];
			echo $v;
			if($v == "flex") continue;
			$numArr = explode("-",$_COOKIE["cat3"]);
			echo "Length = " + sizeof($numArr); */
			
			
		//}
		
		
		// Main information
		$page->content .= "<div class='job' id='job$i'>\n";
		$page->content .= "<p><b>".$jobList[$i][0]."</b><br><i>Description: </i>".$jobList[$i][1]."</p>\n";
		$page->content .= "<p onclick='displayDiv(\"job".$i."b\")'>--more--</p><p onclick='hideDiv(\"job".$i."b\")'>--less--</p>";
		$page->content .= "</div>";
		
		// Additional information (shown with onclick)
		$page->content .= "<div class='job' style='display:none;' id='job".$i."b'>\n";
		if($jobList[$i][3] != "0"){
			$page->content .= "<i>Pay: </i>$".$jobList[$i][3]." per hour<br>\n";
		}
		else{ $page->content .= "<i>Pay: </i> Flexible pay<br>"; }
		if($jobList[$i][2] != "0"){
			$s = explode(";", $jobList[$i][2]);
			$page->content .= "<i>Schedule:</i><br>Mon : $s[0]<br>Tues: $s[1]<br>Wed : $s[2]<br>Thurs: $s[3]<br>Fri : $s[4]<br>Sat : $s[5]<br>Sun : $s[6]<br>\n";
		}
		else{ $page->content .= "<i>Schedule: </i> Flexible hours<br>"; }
		$page->content .= "<i>Job requirements: </i>".$jobList[$i][5]."<br>\n";
		$s = explode("/", $jobList[$i][6]);
		$page->content .= "<i>Address: </i><br>$s[0]<br>$s[1]<br>\n";
		$page->content .= "<i>Phone number: </i>".$jobList[$i][7]."<br>\n";
		$page->content .= "<i>Employer: </i>".$jobList[$i][8]."<br>\n";
		$page->content .= "</div>\n\n";
	}
}
else $page->content .= "<p>No job offers of that type currently.</p>\n";
$page->content .= "</div>\n";



$page->display();
?>