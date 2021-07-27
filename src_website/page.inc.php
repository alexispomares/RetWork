<?php
class Page
{
  // class Page's attributes
  public $content;
  private $title = 'RetWork';
  private $keywords = 'Hackathon, old people';
	
  

  //constructor 
  public function __construct($title){
	$this->__set("title", $title);
  }
  
	//set private attributes
  	public function __set($varName, $varValue)
	{	
		$varValue = trim($varValue);
		$varValue = strip_tags($varValue);
		if (!get_magic_quotes_gpc()){
			$varValue = addslashes($varValue);
		}
		$this->$varName = $varValue;
	}
	
	//get function - nothing special for now
	public function __get($varName)
	{
		return $this->$varName;
	}
  
  
  
  //output the page
  public function display()
  {
?>
	<!DOCTYPE html>
	<html>
	<head>
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<script>
		function displayDiv(id){
			document.getElementById(id).style.display = "block";
		}
		function hideDiv(id){
			document.getElementById(id).style.display = "none";
		}
		function createArray(len, itm) {
			var arr1 = [itm],
				arr2 = [];
			while (len > 0) {
				if (len & 1) arr2 = arr2.concat(arr1);
				arr1 = arr1.concat(arr1);
				len >>>= 1;
			}
			return arr2;
		}
		function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+ d.toUTCString();
			document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		}
		function getCookie(cname) {
			var name = cname + "=";
			var decodedCookie = decodeURIComponent(document.cookie);
			var ca = decodedCookie.split(';');
			for(var i = 0; i <ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) == 0) {
					return c.substring(name.length, c.length);
				}
			}
			return "";
		}
		function deleteAllCookies() {
			var cookieArr = document.cookie.split(";");
			for(var i = 0; i < cookieArr.length; i++){
				var x = cookieArr[i].split("=")[0];
				setCookie(x,"");
			}
		}
		function deleteCookie(name) {
			document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
			alert('Cookie deleted');
		}
	</script>
<?php
	$this -> displayTitle();
    $this -> displayKeywords();
    $this -> displayStyles();
    echo "</head>\n<body>\n";
    $this -> displayContentHeader();
    echo $this->content;
    $this -> displayContentFooter();
	?>
    </body>
	</html>
<?php	
  }

  //output the title 
  public function displayTitle()
  {
    echo '<title> '.$this->title.' </title>';
  }

  public function displayKeywords()
  {
    echo "<meta name=\"keywords\" content=\"$this->keywords\" />";
  }

  //display the embedded stylesheet
  public function displayStyles()
  { 
?>   
  <style>
	p {font-size:12pt; text-align:justify; 
       font-family:arial,sans-serif}
    p.footer {color:yellow; background-color: blue; font-size:9pt; 		
			text-align:center; 
            font-family:arial,sans-serif; font-weight:bold}
			
	div.results {	width:100%;
					
					overflow:hidden;
	}
	div.job		{	width:79%;
					float:right;
					
	}
	div.filter 	{
					
					width:20%;
					
	}

	

	div.header		{
					width:100%;
					background-color:#11FFFF;
					display: inline-block;
					height:60px;
					
	
	}
	
	div.headerIcons	{
					width:50%;
					height:100%;
					float:left;
					display:inline-block;
					
					
	}
    
	div.menu		{
					vertical-align: middle;
					height:40px;
					float:left;
					background-color: white;
					color: blue;
					margin-top:9px;
					margin-left:3px;
					width:90px;
					text-align:center;
					padding-top:0px;
	}

	img			{
					margin:9px 5px;
					width:auto;
					height:40px;
					float:left;
	}
  </style>
<?php
  }

  //display the header part of the visible page
  public function displayContentHeader()
  { 
?>   

    <div class = "header"><img id="logo" src="retwork_artwork.png" alt="RetWork Logo">
	
		<div class="menu"><a href="index.html">New Search</a></div>
		<div class="menu"><a href="addJobForm.html">Post Job</a></div>
	</div>
<?php
  }

  //display the footer part of the visible page
  public function displayContentFooter()
  {
  }
}
?>
