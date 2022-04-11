@@ -0,0 +1,90 @@
<?php 
include 'dbConfig.php';
$statusMsg = '';

session_start();

	if(!isset($_SESSION['email'])){
		header("Location: Login.php");
	}

	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION);
		header("Location: index.php");
	}
     
        // Database connection (server,username,password,database)
        $conn = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

        // Check connection
        if($conn === false){
            die("COULD NOT CONNECT. ".$conn->connect_error);
        }

        //check if post request is active
        if ($_SERVER["REQUEST_METHOD"] == "POST"){

            //check size of file
            if(is_uploaded_file($_FILES['file']['tmp_name']) && $_FILES['file']['size'] < 4000000) {
                
                //Upload file to server
                $targetDir = "uploads/";
                $fileName = basename($_FILES["file"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                    $statusMsg = 'The file ".$fileName. " has been uploaded successfully.';
                }else{
                    $statusMsg = 'File upload failed, please try again.';
                }
                
                //match email from session to database creator_id
                $sql = "SELECT creator_id FROM Creators WHERE  email = ?";
                $stmtselect  = $db->prepare($sql);
                $userid = $stmtselect->execute([$email]);

                $username = $_SESSION['email']; 
                
                //insert file info into database
                $sql = "INSERT INTO Creator_Models(filetype, creator_id, file_name) VALUES('$fileType', '$userid', '$fileName')";
                $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b> Cannot insert file to the database<br/>" . mysqli_error($conn));
                if(isset($current_id)) {
                  
                    echo "Successfully upload";
                    header("Location: display.php?username=".$username);
                    //
                    
                }
            }
            else{
                echo "Please try again. Your AR file is over 4MB.";
                echo "";
            }
        }
        
    
    ?>
<!doctype html>
<html>
<head lang="en">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<meta charset="utf-8">
<title>Upload Project</title>
</head>
<body>
    <form name="frmImage" enctype="multipart/form-data" action="upload.php" method="post" class="frmImageUpload">
        <label>Please upload your glb file here to see your work:</label><br/>
        <input name="file" type="file" />
        <input type="submit" value="Submit"/>
    </form>
    
    <?php
    session_start();
    if (isset($_GET['username'])){
        $_SESSION['username'] = $_GET['username'];
    }
    ?>    
</body>
</html>