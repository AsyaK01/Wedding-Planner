<?php include 'include/init.php'; ?>
<?php


    if (!isset($_SESSION['id'])) { redirect_to("../"); }

    $users = Users::find_by_id($_GET['id']);

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

        if ($users) {
            $users->firstname = $firstname;
            $users->lastname = $lastname;
            $users->address = $address;
            $users->email = $email;
            $users->username = $username;
            $users->gender = $gender;
            $users->designation = $designation;

            if(empty($_FILES['profile_picture'])) {
              $users->save();
               redirect_to("users.php");
              $session->message("The photo has been updated");
            } else {
              $users->set_file($_FILES['profile_picture']);
              $users->save_image();
              $users->save();
              redirect_to("users.php");
              $session->message("
                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                  <strong><i class='mdi mdi-check'></i></strong>The {$users->firstname} {$users->lastname} е успешно актуализиран.
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>");
            }
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
    <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
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
        .custom-file-label {
            color: #212529;
        }
    </style>
</head>

<body>

<?php include_once 'include/sidebar.php'; ?>

<div class="container">

    <div class="row">

        <div class="col-lg-8 offset-2 pl-3 pb-3 box-shadow mt-4">
        
            <form method="post" action="" enctype="multipart/form-data">
            
                <h6 class="h6 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">Редактиране на информация
                    <a href="users.php" class="btn btn-sm btn-danger float-right" style="font-size: 12px;"><i class="mdi mdi-close-circle mr-2"></i> Затвори</a>

                    <button type="submit" name="submit" class="btn btn-sm btn-success float-right mr-2" style="font-size: 12px;"><i class="mdi mdi-account-plus mr-2"></i> Редактирай</button>
                </h6>

                <?php
                    if ($session->message()) {
                        echo ' <div class="form-group col-md-12">' . $session->message() . '</div>';
                    }
                ?>

                <div class="text-center mb-3 mt-3">
                    <img src="<?= $users->profile_picture_picture(); ?>" style="border-radius: 50%; width: 300px;height: 300px;diplay:block;" alt="">
                       
                </div>

                <div class="custom-file mb-3" style="font-size: 13px;">
                  <input type="file" class="custom-file-input" id="customFile" name="profile_picture">
                  <label class="custom-file-label" for="customFile">Редактиране на профилната снимка</label>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputFirstname">Име:</label>
                        <input type="text" name="firstname" class="form-control" value="<?= $users->firstname; ?>" id="inputFirstname"  placeholder="Въведете име">
                    </div>
                   <div class="form-group col-md-6">
                        <label for="inputLastname">Фамилия:</label>
                        <input type="text" name="lastname" class="form-control" value="<?= $users->lastname; ?>" id="inputLastname"  placeholder="Въведете фамилия">
                    </div>
                   
                </div>
                
                <div class="form-group">
                    <label for="inputEmail">Имейл:</label>
                    <input type="text" name="email" class="form-control"  value="<?= $users->email; ?>" id="inputEmail" placeholder="Въведете имейл адрес">
                </div>

                <div class="form-group">
                    <label for="inputUsername">Потребителско име:</label>
                    <input type="text" name="username" class="form-control"  value="<?= $users->username; ?>" id="inputUsername" placeholder="Въведете потребителско име">
                </div>

                 <div class="form-group">
                        <label for="gender">Пол:</label>
                        <select name="gender" class="custom-select" id="gender">
                            <?php if($users->gender == 'm') : ?>
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
                    <textarea rows="5" name="address" class="form-control" id="inputAddress"  placeholder="Въведете адрес"><?= $users->address;  ?></textarea>
                </div>

                <div class="form-group">
                    <label for="designation">Длъжност:</label>
                    <select name="designation" id="designation" class="custom-select">
                    <option value="0" <?= $users->designation == 0 ? 'selected' : ''; ?>>Администратор</option>
                    <option value="1" <?= $users->designation == 1 ? 'selected' : ''; ?>>Модератор</option>
                    <option value="2" <?= $users->designation == 2 ? 'selected' : ''; ?>>Мениджър</option>
                    <option value="3" <?= $users->designation == 3 ? 'selected' : ''; ?>>Организатор</option>
                    <option value="4" <?= $users->designation == 4 ? 'selected' : ''; ?>>Доставчик</option>
                    </select>
                </div>
                  
            </form>
        </div>
    </div>
</div>

<?php include_once 'include/footer.php';?>
