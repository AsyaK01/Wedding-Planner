<?php include 'include/init.php'; ?>
<?php

    if (!isset($_SESSION['id'])) { redirect_to("../"); }

    $users = new Users();

    if (isset($_POST['submit'])) {
        $firstname   = clean($_POST['firstname']);
        $lastname    = clean($_POST['lastname']);
        $address     = clean($_POST['address']);
        $email       = clean($_POST['email']);
        $username    = clean($_POST['username']);
        $password    = clean($_POST['password']);
        $password2   = clean($_POST['password2']);
        $gender      = clean($_POST['gender']);
        $designation = clean($_POST['designation']);

         if (empty($firstname) || empty($lastname) || empty($address) || empty($email) || empty($username)) {
            redirect_to("users_add.php");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> Please Fill up all the information.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        if ($password != $password2) {

            redirect_to("users_add.php");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> Password input mismatched.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();

        } else {

            $users->firstname = $firstname;
            $users->lastname = $lastname;
            $users->address = $address;
            $users->email = $email;
            $users->username = $username;
            $users->password = md5($password);
            $users->gender = $gender;
            $users->designation = $designation;
            $users->set_file($_FILES['profile_picture']);
            $users->date_created = date("F j, Y, g:i a"); 
            $users->save();
            redirect_to("users.php");
            $session->message("
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-check'></i></strong> {$users->firstname} {$users->lastname}  is successfully added.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
        }
    }
?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add New User - Administrator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap&subset=cyrillic" rel="stylesheet">
    <style>
        body {
            margin-bottom: 2%;
        }
        .box-shadow {
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.3);
            font-size: 12px;
        }
        .form-control {
            font-size: 12px;
        }
        .datepicker {
            font-size: 12px;
        }
    </style>
</head>

<body>

<?php include_once 'include/sidebar.php'; ?>

<div class="container">

    <div class="row">

        <div class="col-lg-8 offset-2 pl-3 pb-3 box-shadow mt-4">
        
            <form method="post" action="" enctype="multipart/form-data">

                <h4 class="h4 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">Информация за нов потребител
                    <a href="users.php" class="btn btn-sm btn-danger float-right" style="font-size: 12px;"><i class="mdi mdi-close-circle mr-2"></i> Затвори</a>

                    <button type="submit" name="submit" class="btn btn-sm btn-success float-right mr-2" style="font-size: 12px;"><i class="mdi mdi-account-plus mr-2"></i> Запази</button>
                </h4>

                <?php
                    if ($session->message()) {
                        echo $session->message();
                    }
                ?>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputFirstname">Име:</label>
                        <input type="text" name="firstname" class="form-control" id="inputFirstname"  placeholder="Въведете текст">
                    </div>
                   <div class="form-group col-md-6">
                        <label for="inputLastname">Фамилия</label>
                        <input type="text" name="lastname" class="form-control" id="inputLastname"  placeholder="Въведете текст">
                    </div>
                   
                </div>
                
                <div class="form-group">
                    <label for="inputEmail">Имейл:</label>
                    <input type="text" name="email" class="form-control" id="inputEmail" placeholder="Въведете имейл адрес">
                </div>

                <div class="form-group">
                    <label for="inputUsername">Потребителско име:</label>
                    <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Въведете текст">
                </div>

                <div class="form-group">
                    <label for="inputpassword">Парола:</label>
                    <input type="password" name="password" class="form-control" id="inputpassword" placeholder="Въведете парора">
                </div>

                <div class="form-group">
                    <label for="inputpasswordConfirm">Потвърдете паролата:</label>
                    <input type="password" name="password2" class="form-control" id="inputpasswordConfirm" placeholder="Потвърдете паролата">
                </div>


                 <div class="form-group">
                        <label for="gender">Пол:</label>
                        <select name="gender" class="custom-select" id="gender">
                            <option value="m">Мъж</option>
                            <option value="f">Жена</option>
                        </select>
                    </div>

                <div class="form-group">
                    <label for="inputAddress">Адрес</label>
                    <textarea rows="5" name="address" class="form-control" id="inputAddress"  placeholder="Въведете текст"></textarea>
                </div>

                <div class="form-group">
                     <label for="designation">Designation:</label>
                     <select name="designation" id="designation" class="custom-select">
                         <option value="0" <?= isset($users) && $users->designation == 0 ? 'selected' : ''; ?>>Администратор</option>
                         <option value="1" <?= isset($users) && $users->designation == 1 ? 'selected' : ''; ?>>Модератор</option>
                         <option value="2" <?= isset($users) && $users->designation == 2 ? 'selected' : ''; ?>>Мениджър</option>
                         <option value="3" <?= isset($users) && $users->designation == 3 ? 'selected' : ''; ?>>Организатор</option>
                         <option value="4" <?= isset($users) && $users->designation == 4 ? 'selected' : ''; ?>>Доставчик</option>

                     </select>
                </div>

                  <div class="form-group">
                    <label for="inputProfilePicture">Изображение за профилна снимка</label>
                    <input type="file" name="profile_picture" class="form-control-file" id="inputProfilePicture">
                  </div>
            </form>
        </div>
    </div>
</div>


</main>
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-3.2.1.slim.min.js"></script>
<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="js/popper.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>

</body>
</html>
