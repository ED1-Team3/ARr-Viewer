
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Completed Projects</h2>
  <p></p>            
  <table class="table table-condensed">
    <thead>
      <tr>
        <th>imageId</th>
        <th>Username</th>
        <th>View QR</th>
      </tr>
    </thead>
    <tbody>
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
        
        
        $sql = "SELECT * FROM output_images";
        $result = mysqli_query($conn, $sql);
        
        while ($row =  mysqli_fetch_array($result)) { 
            $project = $row["imageId"].$row["username"];
            ?>
            <tr>
                <td><?=$row["imageId"];?></td>
                <td><?=$row["username"];?></td>
                <td><a class="btn btn-success" tabindex="0" title="QR Code" role="button" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-url="<?php echo "localhost:8888/QR_code_generator/view.php?id=".$row['imageId'];?>">View QR Code</a>
                <div id="qrcode" style="display: none; width: auto; height: auto; padding: 15px;"></div> </td>
            </tr>
          <?php
        }
          ?>
    </tbody>
  </table>
</div>

</body>
</html>
<script src="qrcode.min.js"></script>
<script>
// Create QR code
var qrcode = new QRCode(document.getElementById("qrcode"), {
    width : 120,
    height : 120
});
// Get data
function makeQrcode(e) {
    qrcode.makeCode(e.attr("data-url"));
}


jQuery(document).ready(function(){
    jQuery("[data-toggle='popover']").popover(
        options = {
                    content: jQuery("#qrcode"),
                    html: true 
        }
    );
    //Show QR code
    jQuery("[data-toggle='popover']").on("show.bs.popover", function(e) {
        makeQrcode(jQuery(this));
        jQuery("#qrcode").show();
    });
});

</script>