<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  /*
  |--------------------------------------------------------------------------
  | Author : Sukan Sittibamrungsuk
  | Modified :-
  |
  | import Templat footer from application/assets
  |
  |--------------------------------------------------------------------------
  */

?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- favicon
		============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <!-- font awesome CSS
		============================================ -->
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.theme.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.transitions.css">
    <!-- meanmenu CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/meanmenu/meanmenu.min.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/normalize.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- Notika icon CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/notika-custom-icon.css">
    <!-- bootstrap select CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-select/bootstrap-select.css">

    <!-- wave CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/wave/waves.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/wave/button.css">
     <!-- dialog CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dialog/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dialog/dialog.css">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
    <!-- Data Table JS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css">
    <!-- datapicker CSS
   ============================================ -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datapicker/datepicker3.css">
      <!-- dropzone CSS
   ============================================ -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dropzone/dropzone.css">


   <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">
    <!-- modernizr JS
		============================================ -->
    <script src="<?php echo base_url(); ?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- jquery
		============================================ -->
    <script src="<?php echo base_url(); ?>assets/js/vendor/jquery-1.12.4.min.js"></script>
</head>
<body>
<div class="header-top-area">
    <div class="container">
        <div class="row">
          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
            <?php
              if($user_session['type'] == 'A'){
            ?>
              <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                <li id="menu_lessons"><a href="<?php echo base_url()."index.php/ManageLessons/index" ;?>"><img src="<?php echo base_url('assets/icon/icon_lessons.png');?>" alt="lesson icon" style="width:22.5px;height:22.5px;">บทเรียน</a></li>
                <li id="menu_score"><a data-toggle="tab" href="#Score"><img src="<?php echo base_url('assets/icon/icon_score.png');?>" alt="score icon" style="width:30.5px;height:22.5px;">คะแนน</a></li>
                <li id="menu_user"><a data-toggle="tab" href="#ManageUser"><img src="<?php echo base_url('assets/icon/icon_user.png');?>" alt="user icon" style="width:22.5px;height:22.5px;">จัดการผู้ใช้งาน</a></li>
              </ul>
            <?php
              } else if ($user_session['type'] == 'C'){ 
            ?>
                <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                  <li id="menu_user_lessons"><a href="<?php echo base_url()."index.php/UserProblems/index" ;?>"><img src="<?php echo base_url('assets/icon/icon_lessons.png');?>" alt="lesson icon" style="width:22.5px;height:22.5px;">บทเรียน</a></li>
                </ul>
              <?php } ?>
          </div>
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5"> 
            <div class="pull-right" style="padding-bottom:0px;padding-top:10px;">
              <div class="dropdown-trig-sgn">
                <button  class="btn triger-bounceIn" data-toggle="dropdown" style="color:#ffff; box-shadow:none;">
                  <?php if($user_session['type'] == 'A'){ ?>
                    <img src="<?php echo base_url('assets/icon/icon_admin.png');?>" alt="admin icon" style="width:22.5px;height:22.5px;">
                  <?php
                  }else{
                  ?>
                    <img src="<?php echo base_url('assets/icon/icon_nisit.png');?>" alt="nisit icon" style="width:22.5px;height:22.5px;">
                  <?php } ?>
                    <?php echo $user_session['name'];?>
                    <i class="fa fa-chevron-circle-down"></i>
                </button>
                  <ul class="dropdown-menu triger-bounceIn-dp">
                      <li><a href="<?php echo base_url('index.php/ResetPassword/index');?>">เปลี่ยนรหัสผ่าน</a></li>
                      <li class="divider"></li>
                      <li><a href="<?php echo base_url('index.php/Main/logout/');?>">ออกจากระบบ</a></li>
                  </ul>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div class="main-menu-area">
      <div class="container">
          <div class="row">
              <div class="tab-content custom-menu-content">
                  <div id="Lessons" class="tab-pane notika-tab-menu-bg animated flipInX">
                      <ul class="notika-main-menu-dropdown">
                      </ul>
                  </div>
                  <div id="Score" class="tab-pane notika-tab-menu-bg animated flipInX">
                      <ul class="notika-main-menu-dropdown">
                          <li><a href="<?php echo base_url()."index.php/Score/score_total" ;?>">ทั้งหมด</a>
                          </li>
                          <li><a href="<?php echo base_url()."index.php/Score/score_problems" ;?>">โจทย์ปัญหา</a>
                          </li>
                      </ul>
                  </div>
                  <div id="ManageUser" class="tab-pane notika-tab-menu-bg animated flipInX">
                      <ul class="notika-main-menu-dropdown">
                          <li><a href="<?php echo base_url()."index.php/ManageUser/show_user" ; ?>">แสดงรายชื่อผู้ใช้งาน</a>
                          </li>
                          <li><a href="<?php echo base_url()."index.php/ManageUser/upload_user" ; ?>">อัปโหลดรายชื่อผู้ใช้งาน</a>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
<script>
$(document).ready(function(){
  var active = "<?php echo $active ;?>"
    if(active == 'Lessons'){
      $('#menu_lessons').addClass('active')
    }else if(active == 'Score'){
      $('#menu_score').addClass('active')
      $('#Score').addClass('active')
    }else if(active == 'User'){
      $('#menu_user').addClass('active')
      $('#ManageUser').addClass('active')
    }
});
</script>