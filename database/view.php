<?php

 $server = "localhost";
 $dbuser = "root";
 $pass = "root";
 $db = "model";
 // Database connection (server,username,password,database)
 $conn = new mysqli($server,$dbuser,$pass,$db);
 // Check connection
 if($conn === false){
     die("COULD NOT CONNECT. ".$conn->connect_error);
 }
 
?>

<!doctype html>
<html>

<head>
	<title>3D Model AR</title>
	<meta charset="UTF-8" />

<!-- Import the component -->
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.js"></script>

<script nomodule src="https://unpkg.com/@google/model-viewer/dist/model-viewer-legacy.js"></script>

<link rel="stylesheet" href="https://unpkg.com/tachyons@4.10.0/css/tachyons.min.css"/>

</head>

<body class="w-100 sans-serif bg-white"> 
    <?php
    session_start();
    if (isset($_GET['id'])){
        $_SESSION['id'] = $_GET['id'];
    }

    $id = $_SESSION['id'];
    $sql = "SELECT * FROM output_images WHERE imageId = '$id'";
    $result = mysqli_query($conn, $sql);
    
    while ($row =  mysqli_fetch_array($result)) { 
        echo "<model-viewer ar ar-modes='webxr scene-viewer quick-look' camera-controls src='data:".$row["imageType"].";base64,".base64_encode($row['imageData'])."' >
                <button slot='ar-button' id='ar-button'>
                View in your space
                </button>
            ";
    }	
    ?>
<style>
body{
	  overflow:hidden;
    font-family: -apple-system,BlinkMacSystemFont,avenir next,avenir,helvetica neue,helvetica,ubuntu,roboto,noto,segoe ui,arial,sans-serif;
}

article.pa3.pa5-ns {
    position: absolute;
}

model-viewer{
	position: absolute;
	width:100vw;
	height:100vh;
	margin: 0 auto;
}
</style>

</body>

</html>