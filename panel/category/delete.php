<?php
require_once("../../functions/helpers.php");
require_once("../../functions/pdo_connection.php");
require_once ('../../functions/check_session.php');
if(isset($_GET["cat_id"])&& !empty($_GET["cat_id"])){
    global $pdo;
    $sql="DELETE FROM php_project.categorizes WHERE id = ?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$_GET["cat_id"]]);


}
redirect('panel/category');
?>