<?php
require_once("../../functions/helpers.php");
require_once("../../functions/pdo_connection.php");
require_once ('../../functions/check_session.php');
global $pdo;
if(isset($_GET["post_id"])&& !empty($_GET["post_id"])){
    //check for exists post id
    $query = 'SELECT * FROM php_project.posts WHERE id = ?';
    $statement = $pdo->prepare($query);
    $statement->execute([$_GET['post_id']]);
    $post = $statement->fetch();
    $basePath=dirname(dirname(__DIR__));
    if(file_exists($basePath.$post->image)){
        unlink($basePath.$post->image);
    }


    $sql="DELETE FROM php_project.posts WHERE id = ?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$_GET["post_id"]]);


}
redirect('panel/post');
?>