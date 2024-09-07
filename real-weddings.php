<?php include 'admin/include/init.php'; ?>

<?php 
    $blogEvent = EventWedding::getEventBlogs();
 ?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inspiration Couples</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datepicker.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: #fff;
            margin-top:6%;
        }
    </style>
</head>
<body>
<?php
include "include/nav.php";
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="h2 text-center mb-0">НАЙ-НОВОТО ВДЪХНОВЕНИЕ</h4>
            <p class="text-muted text-center">Открийте най-добрите идеи, съвети и статии които да вдъхновяват
                вашата мечтана сватба.</p>
        </div>
           <div class="card-columns">
            <?php foreach($blogEvent as $blog_item) : ?>
               <div class="card">
                <img class="card-img-top" src="admin/<?= $blog_item->preview_image_picture(); ?>" alt="Card image cap">
                <div class="card-body">
                    <a href="wedding_details.php?id=<?= $blog_item->id; ?>" class="btn-stamp">
                        <h6 class="card-title mt-0 mb-0 text-center font-weight-bold font-custom text-uppercase"><?= $blog_item->title; ?></h6>
                        <p class="card-text mt-0 mb-0 text-center color_gray"><?= $blog_item->wedding_type; ?> Wedding</p>
                        <p class="card-text mt-0 mb-0 text-center color_light text-capitalize"><i class="mdi mdi-map-marker"></i>
                            <?= $blog_item->location; ?></p>
                    </a>
                </div>
            </div> 
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php include "include/fot.php"; ?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.2.1.slim.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>