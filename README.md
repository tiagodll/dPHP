dPHP
====

A simple php framework to simulate asp.net code behind and components


To use this framework is very easy, you just have to add it to the folder of your project.

Include in the frontend files:
require_once("./dPHP/dPage.php");
$dp = new dPage();

name your code behind files with _ in the end and include the code behind to them
require_once("./dPHP/dPage_.php");
$dp_ = new dPage_();
