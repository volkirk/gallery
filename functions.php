<?php
function addFiletoDB(){
    $link=mysqli_connect("localhost", "root", "", "gallery"); 
    $fileName=$_FILES['files']['name'][0];
    print_r($fileName);
    $userId=$_COOKIE['id'];
    ECHO $userId;
    mysqli_query($link,"INSERT INTO pictures SET id='".$userId."', pic_name='".$fileName."'");
}
// function getFileFromDB(){
//     $link=mysqli_connect("localhost", "root", "", "gallery"); 
//     // $query = mysqli_query($link, "SELECT * FROM `pictures`");
//     $query = mysqli_query($link, "SELECT pic_name FROM `pictures`");
//     // return mysqli_fetch_all($query);
//     return $query;
// }
function getFileFromDBPRO(){
    $link=mysqli_connect("localhost", "root", "", "gallery"); 
    // $query = mysqli_query($link, "SELECT * FROM `pictures`");
    $query = mysqli_query($link, "select * from users join pictures on users.user_id = pictures.id");
    // return mysqli_fetch_all($query);
    return $query;
}
// function getUserIdFromDB(){
//     $link=mysqli_connect("localhost", "root", "", "gallery"); 
//     $query = mysqli_query($link, "SELECT id FROM `pictures`");
// }