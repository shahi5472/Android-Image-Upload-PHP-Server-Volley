<?php

require 'init.php';

$db = new DB_Connect();

$response = array();

if ($db->connect()) {
    if (isset($_POST["image"]) && isset($_POST["number"])) {

        $image = $_POST['image'];
        $number = $_POST["number"];

        $upload_image = rand(1000, 1000000) . ".jpeg";;
        $target_dir = "images/" . $upload_image;

        $serverUrl = "http://192.168.0.103:8080/image_upload_android/images/" . $upload_image;

        $sql = "INSERT INTO `posts` (`url`, `number`) VALUES ('$serverUrl', '$number');";
        $result = mysqli_query($db->connect(), $sql);

        if ($result) {
            file_put_contents($target_dir, base64_decode($image));

            //move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $upload_image);
            $response["message"] = "Upload successful";
            $response["status"] = 200;
        } else {
            $response["message"] = "Upload failed";
            $response["status"] = 404;
        }

    } else {
        $response["message"] = "Invalid request";
        $response["status"] = 400;
    }
} else {
    $response["message"] = "Server connection failed";
    $response["status"] = 500;
}

echo json_encode($response);

?>
