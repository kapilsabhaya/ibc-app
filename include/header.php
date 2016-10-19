<?php session_start();
function common_rediect($message,$error){
    if(!empty($message) && !$error) {
        $_SESSION['message']=$message;
        echo "<script type='text/javascript'>window.location.href = '".$_SERVER["PHP_SELF"]."';</script>";
        exit;
    }
}
function common_response($message){
    if (!empty($message) || isset($_SESSION['message'])) { ?>
        <div class="alert alert-<?php echo isset($_SESSION['message']) ? 'success' : 'danger' ?>" id="trans-response" style="position: relative">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong><?php echo isset($_SESSION['message']) ? '<i class="fa fa-check-circle"></i> Success' : 'Error' ?><br></strong>
            <?php if(isset($_SESSION['message'])){
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }else{
                echo $message;
            } ?>
        </div>
<?php }
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>
        Events
    </title>



    <link rel="stylesheet" href="   assets/css/bootstrap.css?v=4545">
    <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="assets/css/main.css?v=21545245445">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="   assets/css/bootstrap-social.css">
    <link rel="stylesheet" href="assets/css/bootstrap-datepicker.css?v=1">


<style>
    body {
        font-family: Arial, Helvetica,sans-serif!important;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
    }
</style>
</head>

<body>

<div class="loader" style="width: 100%; height: 100%; position: fixed; z-index: 100000;display:none; background-image: url('./assets/images/loader.gif'); background-position: 50% 45%; background-repeat: no-repeat;">
</div>
<?php require_once('include/db_connection.php'); ?>
<div class="container container1">
    <div class="jumbotron" style="padding-top: 40px;padding-bottom: 10px">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <?php
                $event='';
                $image='';
                $main_image='';
                $blog='';
                $youtube='';
                $noti='';
                $verse='';
                $base_url='/projects/kapil/ibc/';

                if($_SERVER['REQUEST_URI']==$base_url.'event.php'){
                    $event='active';
                }else if($_SERVER['REQUEST_URI']==$base_url.'image.php'){
                    $image='active';
                }
                else if($_SERVER['REQUEST_URI']==$base_url.'main_image.php'){
                    $main_image='active';
                }
                else if($_SERVER['REQUEST_URI']==$base_url.'blog.php'){
                    $blog='active';
                }
                else if($_SERVER['REQUEST_URI']==$base_url.'services.php'){
                    $services='active';
                }
                else if($_SERVER['REQUEST_URI']==$base_url.'youtube.php'){
                    $youtube='active';
                }else if($_SERVER['REQUEST_URI']==$base_url.'notification.php'){
                    $noti='active';
                }else if($_SERVER['REQUEST_URI']==$base_url.'verse.php'){
                    $verse='active';
                }
                ?>
<style>
    .ph3
    {
        padding-left:1px!important;
        padding-right:1px!important;
    }
    @media screen and (max-width: 400px) {
        .header-icon{
            width: 30px!important;
        }
    }

</style>
                <!--<div class="small-display" style="display: none;padding-top: 8px;width: 100%;text-align: center">

                    <span class="ph3 <?php /*echo $job_add*/?>"><a href="index.php"><img src="./assets/img/add-expenses.png" class="header-icon" ></a></span>
                    <span class="ph3 <?php /*echo $state_city_list*/?>"><a href="state_city_list.php"><img src="./assets/img/add-income.png" class="header-icon"></a></span>
                </div>-->

                <ul  class="nav navbar-nav ">

                </ul>
                <nav class="navbar navbar-default navbar-fixed-top">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">Events </a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="<?php echo $event?>"><a href="event.php"><i class="fa fa-list"></i> Events</a></li>
                                <li class="<?php echo $image?>"><a href="image.php"><i class="fa fa-image"></i> Gallery</a></li>
                                <li class="<?php echo $main_image?>"><a href="main_image.php"><i class="fa fa-file-photo-o"></i> Announcement</a></li>
                                <li class="<?php echo $blog?>"><a href="blog.php"><i class="fa fa-th-list"></i> Blog</a></li>
                                <li class="<?php echo $services?>"><a href="services.php"><i class="fa fa-th-list"></i> Services</a></li>
                                <li class="<?php echo $youtube?>"><a href="youtube.php"><i class="fa fa-youtube"></i> Youtube</a></li>
                                <li class="<?php echo $noti?>"><a href="notification.php"><i class="fa fa-youtube"></i> Notification</a></li>
                                <li class="<?php echo $verse?>"><a href="verse.php"><i class="fa fa-list"></i> Verse</a></li>

                               <!-- <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li class="dropdown-header">Nav header</li>
                                        <li><a href="#">Separated link</a></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li>-->
                            </ul>

                        </div><!--/.nav-collapse -->
                    </div>
                </nav>
            </div>
        </nav>
       <!-- <div style="width: 100%;text-align: right"><a href="report_old.php" >Edit Expense</a></div>-->
    </div>
    <div class="jumbotron" style="min-height: 400px;padding-top: 4px;border-radius: 10px 10px 10px 10px;background: transparent">