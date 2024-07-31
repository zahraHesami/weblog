<?php
require_once("../../functions/helpers.php");
require_once("../../functions/pdo_connection.php");
require_once ('../../functions/check_session.php');
if (
        isset($_POST["title"]) && !empty($_POST["title"]) &&
        isset($_FILES["image"]) && !empty($_FILES["image"]['name']) &&
        isset($_POST["cat_id"]) && !empty($_POST["cat_id"])&&
        isset($_POST["body"]) && !empty($_POST["body"])

   )
{

    global $pdo;
    $sql ="SELECT * FROM php_project.categorizes WHERE  id = :id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":id",$_POST["cat_id"],PDO::PARAM_INT);
    $stmt->execute();
    $category=$stmt->fetch();
    $allowdFileTypes=array("jpeg","png","jpg","gif");
    $imageMime=pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    if(!in_array($imageMime,$allowdFileTypes))
    {
        redirect('panel/post');
    }
    $basePath=dirname(dirname(__DIR__));
    $imagePath='/assets/images/posts/' . date("Y_M_D_H_I_S").'.'.$imageMime;
    $image_uploade=move_uploaded_file($_FILES["image"]["tmp_name"],$basePath.$imagePath);

    if($image_uploade !==false  && $category!==false)
    {
               global $pdo;
              $query='INSERT INTO php_project.posts SET title=? , body=?, cat_id=?, image=?, create_at=NOW()';

              $stmt = $pdo->prepare($query);

              $stmt->execute([$_POST["title"],$_POST["body"],$_POST['cat_id'],$imagePath]);




    }

    redirect('panel/post');

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

                <form action="<?= url('panel/post/create.php') ?>" method="post" enctype="multipart/form-data">
                    <section class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="title ...">
                    </section>
                    <section class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </section>
                    <section class="form-group">
                        <label for="cat_id">Category</label>
                        <select class="form-control" name="cat_id" id="cat_id">
                            <?php
                            global $pdo;
                            $sql = "SELECT * FROM  php_project.categorizes ";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $categories = $stmt->fetchAll();
                            foreach ($categories as $category) {

                                ?>
                                <option value="<?= $category->id ?>"><?= $category->name_cat ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </section>
                    <section class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body" id="body" rows="5" placeholder="body ..."></textarea>
                    </section>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary">Create</button>
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