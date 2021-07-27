<?php
require("page.inc.php");
$page = new Page("Search results");


// Open file
if($_GET["hours"] == "flexible") $_GET["hours"] = "0";

$file = fopen("joboffers.txt","a");
$arr = [$_GET["jobTitle"], $_GET["description"], $_GET["hours"], $_GET["pay"], $_GET["keywords"], $_GET["physicalReqs"], $_GET["streetAddress"]."/".$_GET["zipcode"], $_GET["number"], $_GET["name"]."/".$_GET["type"]];
$txt = implode(">", $arr);
fwrite($file, $txt."\r\n");
fclose($file);
$page->display();

echo 'window.alert("Thank you for posting a job offer!")';
header("Location: index.html");
die();
?>