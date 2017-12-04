<?php

function generatePage($body, $head=" ", $script=" ") {
    
    $page = <<<EOPAGE
	<!doctype html>
	<html>
    	<head> 
       	    $head
    	</head>
            
    	<body>
       	    $body
           	$script
    	</body>
	</html>
EOPAGE;

    return $page;
}

?>
