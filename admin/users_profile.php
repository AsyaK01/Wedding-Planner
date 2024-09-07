<?php include 'include/init.php'; ?>
<?php
     if (!isset($_SESSION['id'])) {
         redirect_to("../");
     }
?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
<?php 
    if (isset($_POST['submit'])) {
            $firstname   = clean($_POST['firstname']);
            $lastname    = clean($_POST['lastname']);
            $address     = clean($_POST['address']);
            $email       = clean($_POST['email']);
            $username    = clean($_POST['username']);
            $gender      = clean($_POST['gender']);
            $designation = clean($_POST['designation']);

             if (empty($firstname) || empty($lastname) || empty($address) || empty($email) || empty($username)) {
                redirect_to("users_add.php");
                $session->message("
                <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                  <strong><i class='mdi mdi-account-alert'></i></strong> Моля, попълнете цялата информация.
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>");
                die();
            }

            if ($users_profile) {
                $users_profile->firstname = $firstname;
                $users_profile->lastname = $lastname;
                $users_profile->address = $address;
                $users_profile->email = $email;
                $users_profile->username = $username;
                $users_profile->gender = $gender;
                $users_profile->designation = $designation;

                if(empty($_FILES['profile_picture'])) {
                  $users_profile->save();
                   redirect_to("users_profile.php");
                  $session->message("
                    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                      <strong><i class='mdi mdi-check'></i></strong>The {$users_profile->firstname} {$users_profile->lastname} е успешно актуализиран.
                      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                      </button>
                    </div>");
                } else {
                  $users_profile->set_file($_FILES['profile_picture']);
                  $users_profile->save_image();
                  $users_profile->save();
                  redirect_to("users_profile.php");
                  $session->message("
                    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                      <strong><i class='mdi mdi-check'></i></strong>The {$users_profile->firstname} {$users_profile->lastname} е успешно актуализиран.
                      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                      </button>
                    </div>");
                }
            }
        }
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Редактиране на детайли на профила</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!--    <link href="css/bootstrap.css" rel="stylesheet">-->
    <link rel="stylesheet" type="text/css"
          href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap&subset=cyrillic" rel="stylesheet">
    <style>
        table.table.table-striped.table-bordered.table-sm {
            font-size:12px;
        }
        .tooltip {
            font-size: 12px;
        }

        td.special {
            padding: 0;
            padding-top: 8px;
            padding-left:6px;
            padding-bottom:6px;
            margin-top:5px;
            text-transform: capitalize;
        }
        .datepicker {
            font-size: 12px;
        }
        div.dataTables_wrapper div.dataTables_paginate {
            font-size: 11px;
        }
         .form-control {
            font-size: 12px;
        }
        .datepicker {
            font-size: 12px;
        }
        .custom-file-label {
            color: #212529;
        }

         .box-shadow {
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.3);
            font-size: 12px;
        }

    </style>
</head>

<body>

<?php include_once 'include/sidebar.php'; ?>

<div class="row">
    <div class="col-lg-8 offset-2 pl-3 pb-3 box-shadow mt-4">
            <form method="post" action="" enctype="multipart/form-data">
            
                <h6 class="h6 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">Детайли на профила
                   
                </h6>

                <?php
                    if ($session->message()) {
                        echo ' <div class="form-group col-md-12">' . $session->message() . '</div>';
                    }
                ?>


                <div class="text-center mb-3 mt-3">
                    <img src="<?= $users_profile->profile_picture_picture(); ?>" style="border-radius: 50%; width: 200px;height: 200px;diplay:block;" alt="">
                       
                </div>
                <div class="custom-file mb-3" style="font-size: 13px;">
                  <input type="file" class="custom-file-input" id="customFile" name="profile_picture">
                  <label class="custom-file-label" for="customFile">Редактиране на профилната снимка</label>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputFirstname">Име:</label>
                        <input type="text" name="firstname" class="form-control" value="<?= $users_profile->firstname; ?>" id="inputFirstname"  placeholder="Въведете име">
                    </div>
                   <div class="form-group col-md-6">
                        <label for="inputLastname">Фамилия:</label>
                        <input type="text" name="lastname" class="form-control" value="<?= $users_profile->lastname; ?>" id="inputLastname"  placeholder="Въведете фамилия">
                    </div>
                   
                </div>
                
                <div class="form-group">
                    <label for="inputEmail">Имейл адрес:</label>
                    <input type="text" name="email" class="form-control"  value="<?= $users_profile->email; ?>" id="inputEmail" placeholder="Въведете имейл адрес">
                </div>

                <div class="form-group">
                    <label for="inputUsername">Потребителско име:</label>
                    <input type="text" name="username" class="form-control"  value="<?= $users_profile->username; ?>" id="inputUsername" placeholder="Въведете потребителско име">
                </div>

                 <div class="form-group">
                        <label for="gender">Пол:</label>
                        <select name="gender" class="custom-select" id="gender">
                            <?php if($users_profile->gender == 'm') : ?>
                                <option value="m" selected>Мъж</option>
                                <option value="f">Жена</option>
                            <?php else: ?>
                                <option value="m">Мъж</option>
                                <option value="f" selected>Жена</option>
                            <?php endif; ?>
                        </select>
                    </div>

                <div class="form-group">
                    <label for="inputAddress">Адрес</label>
                    <textarea rows="5" name="address" class="form-control" id="inputAddress"  placeholder="Въведете адрес"><?= $users_profile->address;  ?></textarea>
                </div>

                 <div class="form-group">
                    <label for="designation">Длъжност</label>
                    <select name="designation" id="designation" class="custom-select">
                        <?php if($users_profile->designation == 0) : ?>
                            <option value="0" selected>Администратор</option>
                            <option value="1">Модератор</option>
                            <option value="2">Мениджър</option>
                            <option value="3">Организатор</option>
                            <option value="4">Доставчик</option>
                        <?php else: ?>
                            <option value="0">Администратор</option>
                            <option value="1" selected>Модератор</option>
                            <option value="2">Мениджър</option>
                            <option value="3">Организатор</option>
                            <option value="4">Доставчик</option>
                        <?php endif; ?>
                    </select>
                </div>
                 <a href="users.php" class="btn btn-sm btn-danger float-right" style="font-size: 12px;">
                    <i class="mdi mdi-close-circle mr-2"></i> Затвори
                </a>

                <button type="submit" name="submit" class="btn btn-sm btn-success float-right mr-2" style="font-size: 12px;">
                    <i class="mdi mdi-account-plus mr-2"></i> Редактирай
                </button>
            </form>
    </div>
</div>

<?php include_once 'include/footer.php';?>