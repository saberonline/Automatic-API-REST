<html lang="es">

<head>

<meta charset="utf-8">   
<title>Show Table</title>   
<meta name="description" content="Creating a Zebra table with Twitter Bootstrap. Learn with example of a Zebra Table with Twitter Bootstrap.">  
<link href="style/bootstrap.css" rel="stylesheet"> 
</head>
<body>
    
    
<?php
require_once 'inc/functions.php';
$objectTools = new Tools();
if(isset($_GET["c"])){
    if(isset($_GET["l"])){
        $sql = "SELECT ".$_GET["c"]." FROM ".$_GET["t"]." LIMIT ".$_GET["l"].";";
    }else{
        $sql = "SELECT ".$_GET["c"]." FROM ".$_GET["t"].";";
    }
}else{
    if(isset($_GET["l"])){
        $sql = "SELECT * FROM ".$_GET["t"]." LIMIT ".$_GET["l"].";";
    }else{
        $sql = "SELECT * FROM ".$_GET["t"].";";
    }
}

$objectTools->displayTable($sql);
?>
    
    
</body>
</html>