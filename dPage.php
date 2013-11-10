<?php
require_once("dPage_.php");
class dPage extends dPage_
{
	function dPage()
	{
		parent::dPage_();
		
		$tmp = explode("/", $_SERVER["PHP_SELF"]);
		$tmp = explode(".", $tmp[count($tmp)-1]);
		$tmp[count($tmp)-2] .= "_";
		require_once("./" . implode(".", $tmp));
	}
	
	function Head()
	{
		require_once("Inc/Head.php");
		echo "<input type='hidden' id='hdnQueryString' value='" . $this->GetQueryString() . "' />";
	}
	function Foot()
	{
		require_once("Inc/Foot.php");
	}
}
?>