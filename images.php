<?php
require_once 'components/connect.php';
$db = connect(dbhost, dbname, dbusername, dbpassword);
if (isset($_GET['image_id'])) {
    $sql = "SELECT imageType,imagebinary FROM image WHERE id=?";
    $statement = $db->prepare($sql);
    $statement->bind_param("i", $_GET['image_id']);
    $statement->execute() or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_connect_error());
    $result = $statement->get_result();

    $row = $result->fetch_assoc();
    header("Content-type: " . $row["imageType"]);
    echo $row["imagebinary"];
} else if (isset($_GET['pimageid'])) {
    $sql = "SELECT filecontent FROM attachements WHERE id=?";
    $statement = $db->prepare($sql);
    $statement->bind_param("i", $_GET['pimageid']);
    $statement->execute() or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_connect_error());
    $result = $statement->get_result();

    $row = $result->fetch_assoc();
    header("Content-type: image/jpeg");
    echo $row["filecontent"];
}
