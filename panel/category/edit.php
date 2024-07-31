<?php
require_once("../../functions/helpers.php");
require_once("../../functions/pdo_connection.php");
require_once ('../../functions/check_session.php');
if(!isset($_GET["cat_id"]) ){
    redirect('panel/category');
}
      global $pdo;
     $sql ="SELECT * FROM php_project.categorizes WHERE  id = :id";
     $stmt=$pdo->prepare($sql);
     $stmt->bindParam(":id",$_GET["cat_id"],PDO::PARAM_INT);
     $stmt->execute();
     $category=$stmt->fetch();

     if(!$category){

         redirect('panel/category');
     }


if (isset($_POST["name"]) && !empty($_POST["name"])) {
    global $pdo;
    $sql='UPDATE php_project.categorizes SET  name_cat=:name ,update_at= NOW() WHERE id=:id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':name',$_POST["name"]);
    $stmt->bindParam(':id',$_GET["cat_id"]);
    $stmt->execute();
    redirect('panel/category');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP panel</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" type="text/css">
</head>

<body>
<section id="app">
    <?php
    require_once("../layouts/top-nav.php");
    ?>
    <section class="container-fluid">
        <section class="row">
            <section class="col-md-2 p-0">
                <?php
                require_once("../layouts/sidebar.php");
                ?>
            </section>
            <section class="col-md-10 pt-3">

                <form action="<?= url('panel/category/edit.php?cat_id=').$_GET['cat_id']  ?>" method="post">
                    <section class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="name ..." value="<?= $category->name_cat ?>">
                    </section>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </section>

                </form>

            </section>
        </section>
    </section>

</section>

<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>