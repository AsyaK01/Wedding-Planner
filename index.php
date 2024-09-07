<?php include 'admin/include/init.php'; ?>
<?php
    $count = 0;
    $error = '';
    $user_firstname = $user_lastname = $user_password = $user_email = $wedding_date = '';

    $account_details = new Account_Details();
    $accounts = new Accounts();
    $booking = new Booking();
    $category = Category::find_all();
    $blogEvent = EventWedding::getEventBlogs();

    if (isset($_POST['register'])) {

        $user_firstname = clean($_POST['user_firstname']);
        $user_lastname = clean($_POST['user_lastname']);
        $user_email = clean($_POST['user_email']);
        $user_phone = clean($_POST['user_phone']);
        $wedding_date = clean($_POST['wedding_date']);

        $checkdate = $booking->check_wedding_date($wedding_date);

        if ($checkdate) {
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  Посочената дата от вас вече е резервирана. Моля, опитайте с друга дата!
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        if (empty($user_firstname) ||
            empty($user_phone) ||
            empty($user_email) ||
            empty($user_lastname) ||
            empty($wedding_date)) {
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  Please Fill up all the fields.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  Неправилен формат на имейла.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();

        }

        $check_email = $accounts->email_exists($user_email);

        if ($check_email) {
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  Имейлът вече съществува.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        } else {
            if ($error == '') {
                $count = $count + 1;
                $account_details->firstname = $user_firstname;
                $account_details->lastname = $user_lastname;
                $account_details->status = 'pending';
                $account_details->datetime_created  = date("y-m-d h:m:i");
                $account_details->phone= $user_phone;
                if ($account_details->save()) {
                    $account_details->user_id = mysqli_insert_id($db->connection);

                    if($account_details->update()) {
                        $accounts->user_id = $account_details->user_id;
                        $accounts->user_email= $user_email;


                         if($accounts->save()) {
                             $booking->user_id = $accounts->user_id;
                             $booking->user_email = $user_email;
                             $booking->wedding_date =  $wedding_date;
                             $booking->save();
                             redirect_to("thank_you.php");
                         }
                    }
                }
            }
        }
    }
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wedding Planner</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap&subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .alert {
            font-size: 12px;
        }
        .error {
            background-color: #F2DEDE;
        }
        .alert.alert-danger.text-center {
            font-size: 16px;
        }
        .mdi.mdi-alert-circle.mr-3 {
            font-size: 16px;
        }

        .bgact{
                background: rgb(14 14 14 / 49%);
                padding: 15px;
        }


.testimonials {
    margin-top: 20px;
}

.testimonial {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.testimonial-content {
    position: relative;
}

blockquote {
    font-style: italic;
    margin: 0;
}

.client-name {
    font-weight: bold;
    margin-top: 5px;
}

.rating {
    margin-top: 10px;
}

.fa-star {
    color: #ddd;
    font-size: 20px;
}

.checked {
    color: #f39c12;
}

.video-testimonial iframe {
    width: 100%;
    height: 315px;
    border: none;
}


.about-us-container {
        max-width: 1550px;
        margin: 0 auto;
        text-align: center;
        padding: 50px 50px;
        background: #fcf9e8;
    }
        .about-us-container h1 {
            font-size: 36px;
            margin-bottom: 10px;
            color: #7f6a56;
            letter-spacing: 2px;
        }

        .about-us-container .divider {
            width: 80px;
            height: 2px;
            background-color: #d4c6b3;
            margin: 10px auto;
        }

        .about-us-container .subtitle {
            font-size: 18px;
            color: #b7a395;
            margin-bottom: 40px;
            font-style: italic;
        }

        .about-us-container p {
            font-size: 16px;
            line-height: 1.6;
            color: #3a2920;
        }

        .about-us-container .quote {
            font-style: italic;
            margin-top: 30px;
            color: #b7a395;
        }


    </style>
</head>
<body>
<?php include 'include/nav.php'; ?>

<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="hero">
            <div class="row justify-content-md-center">
                <div class="col col-lg-3">
                </div>
                <div class="col col-lg-5" style="margin-top: 10%;">
                    
                    <?php
                        if ($session->message()) {
                            echo $session->message();
                        }
                    ?>
                    <form class="bgact" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <h2 class="text-center hero-lead">Вълнуващото Ви Сватбено Пътешествие Започва От Тук</h2>
                    <p class="lead text-center" style="color:white;">Направете първата стъпка към вашия перфектен ден – започнете с попълване на формуляра.</p>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="user_firstname" placeholder="Име" id="user_firstname">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" id="user_lastname" class="form-control" name="user_lastname" placeholder="Фамилия">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="user_email" id="user_email" placeholder="youremailaddress@mail.com">
                        </div>
                        <div class="form-group">
                            <input type="text" aria-describedby="phoneHelpBlock" class="form-control" name="user_phone" id="user_phone" placeholder="Телефон за връзка">
                        </div>
                        <div class="form-row">
                            <div class="input-group col-md-5">
                                <input type="text" class="form-control" name="wedding_date" data-provide="datepicker" id="wedding_date"
                                       placeholder="Дата за сватба">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background: white;"><i
                                                style="font-size: 20px;color:#19b5bc;" class="mdi mdi-calendar-check"
                                                id="review" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <p style="font-size: 11px;color:white;">Като щракнете върху „Започнете сега“, вие се съгласявате с TiedWithLove <a
                                        href="" title="" style="color: #b81717;font-weight: bold;">Условия за ползване</a></p>
                            <button type="submit" name="register" class="btn btn-danger btn-sm text-uppercase fb"
                                    style="margin-top: -5px;">Започнете Сега
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col col-lg-3">
                </div>
            </div>
        </div>
    </div> 
</div>

<div class="about-us-container">
        <h1>ЗА НАС</h1>
        <div class="divider"></div>
        <p class="subtitle">Безупречна организация и незабравимо празненство.</p>
        <p>
            Ние в нашата агенция вярваме, че всяка любовна история е уникална и ние сме тук, за да превърнем вашите мечти в 
            красива реалност. Със страст към елегантността и ангажимент за съвършенство, ние сме специализирани в 
            създаване на незабравими сватби, които улавят същността на вашата любов и стил.
        </p>
        <p>
            Нашата мисия е проста - да направим вашия сватбен ден необикновен. Ние се фокусираме върху разбирането на вашата визия и предпочитания,
            детайлно планиране на всеки малък детайл и изпълнение на всеки елемент с безупречна прецизност. От малки семейни събирания до 
            грандиозни тържества, ние внасяме креативност, организация и нотка магия на всяко събитие, което създаваме.
            Нашият талантлив екип от сватбени организатори, дизайнери и координатори носи богат опит и ентусиазъм на 
            всяко събитие. Ние сме посветени на това да сбъднем вашите мечти и да гарантираме, че вашият сватбен ден ще бъде магичен и впечатляващ.
        </p>
        <p class="quote">Споделете вашите желания и ни оставете да организираме вашето събитие!</p>
    </div>

<div class="container-fluid custom-container">
    <div class="row">
        <div class="col-lg-12">
            <hr>
            <h2 class="h2 text-uppercase text-center mb-4">Нашите Сватбени Пакети</h2>
            <h6 class="h6 text-uppercase text-center text-muted mb-3">Разгледайте нашите персонализирани сватбени пакети, предназначени да подхождат на всяко тържество. 
                От декор и кетъринг до фотография, всеки пакет предлага всичко необходимо за един безупречен и незабравим сватбен ден. 
                Нека вдъхнем живот на вашата мечтана сватба.</h6>

            <?php foreach ($category as $category_row) : ?>
                <div class="pricing">
                    <ul class="list-group list-unstyled">
                        <li class="list-group-item text-center text-uppercase"><?= $category_row->wedding_type; ?></li>
                        <li><img src="admin/<?= $category_row->preview_image_picture(); ?>" class="img-fluid" alt=""></li>
                        <li class="list-group-item text-center"><b>ТОЗИ ПАКЕТ ВКЛЮЧВА:</b></li>
                        <?php $feature = Features::find_by_feature_all($category_row->id); ?>
                            <?php foreach ($feature as $feature_item) : ?>
                                <li class="list-group-item"><?= $feature_item->title; ?></li>
                            <?php endforeach; ?>
                        <li class="list-group-item font-weight-bold">Price: $ <?= number_format($category_row->price); ?>
                         </li>
                        <li class="list-group-item font-weight-bold">
                            <a href="package_detail.php?id=<?= $category_row->id; ?>" class="btn btn-custom">Виж подробности</a>
                        </li>
                    </ul>
                </div>
             <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="h2 text-uppercase text-center mb-3">НАЙ-НОВОТО ВДЪХНОВЕНИЕ</h2>
            <h6 class="h6 text-uppercase text-center text-muted mb-3">Открийте най-добрите идеи, съвети и статии които да вдъхновяват
                вашата мечтана сватба.</h6>

            <div class="card-columns">

                <?php foreach($blogEvent as $blog_item) : ?>
                   <div class="card">
                    <img class="card-img-top" src="admin/<?= $blog_item->preview_image_picture(); ?>" alt="Card image cap">
                        <div class="card-body">
                            <a href="wedding_details.php?id=<?= $blog_item->id; ?>" class="btn-stamp">
                                <h6 class="card-title mt-0 mb-0 text-center font-weight-bold font-custom text-uppercase"><?= $blog_item->title; ?></h6>
                                <p class="card-text mt-0 mb-0 text-center color_gray"><?= $blog_item->wedding_type; ?> Сватба</p>
                                <p class="card-text mt-0 mb-0 text-center color_light text-capitalize"><i class="mdi mdi-map-marker"></i>
                                    <?= $blog_item->location; ?></p>
                            </a>
                        </div>
                    </div> 
                <?php endforeach; ?>

                <a href="real-weddings.php" class="btn btn-lg btn-block btn-explore">ПРЕГЛЕД НА ОЩЕ ИДЕИ</a>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid" style="width: 100%;background:#d9eefa; margin-top: 50px;padding-bottom: 20px;">
    <div class="row">
        <div class="col-lg-6">
            <div class="row img-control">
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <img src="DESIGN/checklist-ea253352239433deb24f2ed8ae110aac1840ff8fa5df43967027e880b5f5385b.svg"
                         alt="">
                    <div class="font-custom">Контролен списък</div>
                </div>
                <div class="col-md-2">
                    <img src="DESIGN/seating-chart-084bbdaabe84a638edf344224d7a92b1bc792db53c5fcf7ab16fcd5a6109ff79.svg"
                         alt="">
                    <div class="font-custom">Схема за разпределение на гостите</div>
                </div>
                <div class="col-md-2">
                    <img src="DESIGN/guest-list-eaaf9277c60be7449e41e2f72f358ae3c94c1b31726b894e064498a9536cac9a.svg"
                         alt="">
                    <div class="font-custom">Списък за гости</div>
                </div>
                <div class="col-md-2">
                    <img src="DESIGN/budget-6eca6d3898f15dd5682ce3664d8d9ff9bdd271db03857ba8a99e90b9181db46c.svg"
                         alt="">
                    <div class="font-custom">Бюджет</div>
                </div>
                <div class="col-md-2">
                    <img src="DESIGN/vendor-manager-102fbe8fdbab3e176a6d29bd05c6f26dcd35cfa0f55ff50b1bfd9e70c8fdcdda.svg"
                         alt="">
                    <div class="font-custom">Мениджър доставчик</div>
                </div>

            </div>
                <h1 class="h1 text-center mt-4">Опростете процеса и се насладете на планиране без стрес</h1>
                <p class="lead text-muted text-center ml-5" style="font-size: 14px;">Отбележете всеки детайл от вашия персонализиран контролен списък, докато се подготвяте за вашия специален ден!</p>
        </div>
        <div class="col-lg-6">
            <div class="feature">
                <ul class="list-group rounded-0">
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center ">Обявете годежа си
                        <span class="badge badge-pill" style="font-size: 12px;font-weight: bold;color:#888;">Просрочен <i class="mdi mdi-checkbox-blank-outline ml-3" ></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Планирайте годежното си парти
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">Днес <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Насрочете годежна фотосесия
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">Утре <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Следете целия процес
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">15 Май <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Управлявайте своя списък с гости
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">По всяко време <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Вземете решение за вашата сватба
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">10 Юни <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Изберете датата на вашата сватба
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">20 Юни <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="h2 text-uppercase text-center mb-3">Какво казват нашите клиенти</h2>
            <h6 class="h6 text-uppercase text-center text-muted mb-4">Отзиви от двойки, които са сбъднали мечтите си с нас.</h6>
            
            <div class="testimonials">
                <!-- Testimonial 1 -->
                <div class="testimonial">
                    <div class="testimonial-content">
                        <blockquote>"Екипът направи сватбения ни ден вълшебен. Всеки детайл беше перфектен!"</blockquote>
                        <p class="client-name">- Ива & Иван</p>
                        <div class="rating">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 2 -->
                <div class="testimonial">
                    <div class="testimonial-content">
                        <blockquote>"Незабравимо изживяване от началото до края. Горещо препоръчвам на всеки!"</blockquote>
                        <p class="client-name">- Ема & Борис</p>
                        <div class="rating">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 3 (Video) -->
                <div class="testimonial">
                    <div class="testimonial-content">
                        <div class="video-testimonial">
                            <iframe src="https://www.youtube.com/embed/PEIgbYXgKQk?si=PwP46fuo4-0i5jhv" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <p class="client-name">- Тереза & Димитър</p>
                    </div>
                </div>
            </div>
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
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/savy.js"></script>
<script>

    $(document).ready(function () {
        $('#wedding_date').datepicker();
    <?php
        if($count == 0) {
    ?>
        $('#user_firstname').savy('load');
        $('#user_lastname').savy('load');
        $('#user_email').savy('load');
        $('#user_phone').savy('load');
        $('#wedding_date').savy('load');
    <?php } else { ?>
        $('#user_firstname').savy('destroy');
        $('#user_email').savy('destroy');
        $('#user_lastname').savy('destroy');
        $('#user_phone').savy('destroy');
        $('#wedding_date').savy('destroy');
    <?php } ?>
    });
</script>
</body>
</html>