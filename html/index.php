<?php

$uri = $_SERVER['REQUEST_URI'];
$request_url_split = preg_split("@[?]@",$uri);
if(sizeof($request_url_split)==2)
{
	$param="?".$request_url_split[1];
}
else
{
	$param = "";
}
$request = $request_url_split[0].$param;

print_r($request);


if(strpos($_SERVER['HTTP_HOST'],"localhost") !== false)
{
	$docBasePath="/demo/html/";
	$_SESSION["DocRoot"]="http://localhost/demo/";
}
else
{
	$docBasePath="/";
    print_r("this is a hosting path");
}

switch ($request) {

    case '':
		
    case $docBasePath:
        case $docBasePath . 'Home': 
        require __DIR__. '/myHome.php';
        break;

    case $docBasePath:
        case $docBasePath . 'myDashboard': 
        require __DIR__. '/myDashboard.php';
        break;

     default:
        echo "<h1>404 - Page Not Found</h1>";
        break;
	
}	
?>