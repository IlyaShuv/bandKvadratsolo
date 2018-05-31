<?php 
	header('Content-Type: text/html; charset=utf-8');
	mb_internal_encoding("UTF-8");
	mysql_set_charset('utf8');
	
	session_start();         
  $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
  $user = json_decode($s, true);
  //$user['network'] - соц. сеть, через которую авторизовался пользователь
  //$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
  //$user['first_name'] - имя пользователя
  //$user['last_name'] - фамилия пользователя

  $network = $user['network'];
  $identity = $user['identity'];
  $first_name = $user['first_name'];
  $last_name = $user['last_name'];
  $defaultComment = "Подбираем музыкальную группу для Вас...";

  $d = getdate();
  $min = $d[minutes];
  if ( strlen ($min) < 2 ) {
    $min = "0$d[minutes]";
  }
  $login_date = "$d[year].$d[mon].$d[mday] $d[hours]:$min";

  $isexist = false;

  if (isset($user))
  {
  	#Соединение с БД
  	$db = mysql_connect("localhost", "i40232_ksoloband", "2018ksoloband");
  	mysql_select_db("i40232_ksoloband", $db);

    $queryExist = "SELECT identity FROM people ";
    $result = mysql_query($queryExist) or die(mysql_error());

    while ( $row = mysql_fetch_assoc($result) ) {
      if ($identity == $row['identity']) { 
        $isexist = true;
      }
    }

    if (!$isexist) {
      mysql_query("INSERT INTO people (first_name, last_name, network, identity, login_date, comment) VALUES ('$first_name','$last_name','$network','$identity', '$login_date', '$defaultComment')");
    }
    else {
      $queryComm = "SELECT `comment` FROM `people` WHERE `identity` = '$identity'";
      $resultComm = mysql_query($queryComm) or die(mysql_error());
      $commRow = mysql_fetch_assoc($resultComm);
      $comment = $commRow['comment'];
    }
    


    $_SESSION['user'] = $user;
  	$_SESSION['comment'] = $comment;
    $_SESSION['isexist'] = $isexist;
  	header("Location: reg_page.php");
  	exit;
  }
?>                