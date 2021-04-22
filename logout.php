<?php
// Страница разавторизации 
// Удаляем куки
session_start();
setcookie("id", "", time() - 3600*24*30*12, "/");
setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true); // httponly !!! 
$_SESSION['auth']=0;
session_destroy();


// Переадресовываем браузер на страницу проверки нашего скрипта
header("Location: index.php"); 

exit();
?>
