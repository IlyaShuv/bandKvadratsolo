<?php
	header('Content-Type: text/html; charset=utf-8');
  mb_internal_encoding("UTF-8");

  if( isset($_POST['comment']) ) {
    $db = mysql_connect("localhost", "i40232_ksoloband", "2018ksoloband");
    mysql_select_db("i40232_ksoloband", $db);
    $comm = $_POST['comment'];
    $id = $_POST['inputid'];

    mysql_query("UPDATE people SET `comment` = '$comm' WHERE `identity` = '$id'");

    header("Location: adminpage.php");
  }
?>