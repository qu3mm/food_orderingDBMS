<?php
    require 'connection.php';


var_dump($_POST);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $menu_id = $_POST['menu_id'];
    $sqlquery = "DELETE FROM tbl_menu WHERE menu_id = ? ";
    $stmt = $conn->prepare($sqlquery);
    $stmt->bind_param("i",$menu_id);
    if($stmt->execute()){
        header("Location: index.php");
        exit();
    }
}



?>