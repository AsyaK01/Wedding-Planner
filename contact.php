<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wedding Planner</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datepicker.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/carousel.css">
    <style>
        body {
            font-family: 'Open Sans', 'Roboto', sans-serif;
            line-height: 1.5em;
            margin-bottom: 2%;
            margin-top: 3%;
            width: 100%;
            overflow-x: hidden;
            background: #f1f1f1;
        }

        .navbar-light .navbar-brand {
            color: #1a1a1a;
            font-weight: bold;
            line-height: 22px;
        }

        .navbar {
            font-weight: 700;
            padding: 12px;
            font-style: normal;
            font-size: 14px;
            text-transform: uppercase;
            color: black;
            border-bottom: 1px solid #ddd;
        }

        li.nav-item > a.nav-link {
            color: black !important;
            font-weight: bold !important;
        }

        #review {
            font-size: 16px;
            font-weight: bold;
            margin-right: 5px;
        }

        .form-inline > a.mr-2, .btn.btn-sm.my-2.my-sm-0 {
            color: black;
            font-size: 14px;
            font-weight: 700;
            margin-left: 10px;
        }

        .form-inline > a.mr-2:hover, .btn.btn-sm.my-2.my-sm-0:hover {
            color: #17b4bc;
            text-decoration: none;
        }

        a.btn.btn-sm.my-2.my-sm-0.mr-2.loginbtn {
            background: #dc3545;
            font-size: 14px;
            color: white;
            padding: 5px;
            border: 2px solid transparent;
            width: 85px;
        }

        a.btn.btn-sm.my-2.my-sm-0.mr-2.loginbtn:hover {
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .navbar-expand-lg .navbar-nav .nav-link {
            padding-right: .9rem;
        }

        .navbar-brand {
            margin-left: 20px;
            width: 200px;
        }

        .form-control {
            font-size: 12px;
            border-radius: 0;
            margin-top: 0;
        }



    </style>
</head>
<body>
<?php include "include/nav.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="text-center mb-3">НАШИТЕ КОНТАКТИ</h3>
            <div class="bg-white p-4">
                <div class="contact-information">
                    <h5>ИНФОРМАЦИЯ</h5>
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-sm" style="font-size: 12px;">
                                <tr>
                                    <td>Агенция Tied With Love България</td>
                                    <td><i class="mdi mdi-deskphone mr-3"></i> +358 888 9874</td>
                                </tr>
                                <tr>
                                    <td>ЕТАЖ 2, град София</td>
                                    <td><i class="mdi mdi-phone mr-3"></i> +359 899 6597</td>
                                </tr>
                                <tr>
                                    <td>бул. „Александър Малинов“ 31</td>
                                    <td><i class="mdi mdi-email mr-3"></i> info@tiedwithlove.com</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mt-3">
                                <i class="mdi mdi-map-marker" style="font-size: 110px;color: #22ADB5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white mt-3 pt-1 pl-4 pb-3">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <form action="" method="post" style="font-size: 12px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="form-group col-md-12 mb-1">
                                            <label for="contact_person">Име</label>
                                            <input type="email" class="form-control" id="contact_person" placeholder="Въведете вашето име">
                                        </div>
                                        <div class="form-group col-md-12 mb-1">
                                            <label for="contact_email">Имейл</label>
                                            <input type="password" class="form-control" id="contact_email" placeholder="Въведете имейл адрес">
                                        </div>
                                        <div class="form-group col-md-12 mb-1">
                                            <label for="contact_phone">Телефон</label>
                                            <input type="text" class="form-control" id="contact_phone" placeholder="Въведете мобилен номер">
                                        </div>
                                        <div class="form-group col-md-12 mb-1">
                                            <label for="contact_message">Съобщение</label>
                                            <textarea type="text" class="form-control"
                                                      style="resize: none;" rows="8"
                                                      id="contact_message" placeholder="Въведете съобщение"></textarea>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 pr-2">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2934.48992422403!2d23.379420599999996!3d42.6509723!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40aa8763c5332b89%3A0x5d902a2ae2fad5a7!2sCampus%20X!5e0!3m2!1sbg!2sbg!4v1724148446724!5m2!1sbg!2sbg"  width="95%" height="395" frameborder="0" style="border:0" allowfullscreen></iframe> 
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm rounded-0" style="font-size: 12px;margin-top: 10px;background: #22adb5;border: 0;">Изпратете запитване</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include "include/fot.php"; ?>
<!-- MODAL LOGIN SECTION-->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModal"><img src="images/logo/MOMMYAMBOL.png" alt=""></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="register.php" method="post">
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail" name="email"
                                   placeholder="Enter email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword" placeholder="Enter password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="login" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-primary mr-2 custom-btn" style="font-size: 14px;">
                                Login
                            </button>
                            <a href="" style="color: #22adb5;">Forgot your password?</a>
                            <br/>
                            <div class="mt-2">Not a member yet? <a href="" style="color: #22adb5;">Join Now</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.2.1.slim.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>