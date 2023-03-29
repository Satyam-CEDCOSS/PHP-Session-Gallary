<?php
// Session start 
session_start();
if (!isset($_SESSION["path"])){
    $_SESSION["path"] = array();
}
?>
<!-- HTML Template -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./CSS/style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- HTML FORM  -->
    <h1>Image Gallary</h1>
    <p>This page Display the list of uploaded images.</p>
    <form action="#" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" accept="image/*"/><br>
        <!-- USE BUTTON TO INITIALISE CONDITION  -->
        <input type="submit" value="Submit" name="submit">
    </form>
    
    <!-- PHP FILE UPLOAD  -->

    <?php
    $target_dir = "./image/";
    $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // CHECK FILE CONDITION
    if(isset($_GET["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
      } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
      }
    }
    // file already exists CONDITION 
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // SIZE LESS THAN 5 MB CONDITION
    if ($_FILES["fileToUpload"]["size"] > 5097152) {
      echo "Sorry, your file is too large.<br>";
      $uploadOk = 0;
    }
    // FILE SHOULD BE IMAGE CONDITION 
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
      $uploadOk = 0;
    }
    // FILE UPLOAD CONDITION
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.<br>";
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file has been uploaded.<br>";
        array_push($_SESSION["path"],$_FILES["fileToUpload"]["name"]);
      } else {
        echo "Sorry, there was an error uploading your file.<br>";
      }
    }echo "<div class = 'main_box'>";
    foreach ($_SESSION["path"] as $key => $value) {
        echo "<div class='image_box'><img src=./image/".$value." height=300 width=300 />";
        echo "<p>";echo $value;echo "</p></div>";
    }echo "</div>";
    ?>
</body>
</html>