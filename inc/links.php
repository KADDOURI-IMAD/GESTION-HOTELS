<link href="assets/css/bootstrap-icons.css" rel="stylesheet"  crossorigin="anonymous">

<link href="assets/css/icons-main/" rel="stylesheet"  crossorigin="anonymous">

<link href="assets/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">

<link href="assets/css/Style.css" rel="stylesheet"  crossorigin="anonymous">

<link href="assets/css/swiper-bundle.min.css" rel="stylesheet"  crossorigin="anonymous">

<link href="assets/js/+esm.js" rel="stylesheet"  crossorigin="anonymous">

<link href="assets/js/bootstrap.bundle.min.js" rel="stylesheet"  crossorigin="anonymous">

<link href="assets/js/swiper-bundle.esm.browser.min.js" rel="stylesheet"  crossorigin="anonymous">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
 <?php
  session_start();

  date_default_timezone_set("Africa/Casablanca");
  require('admin/inc/db_config.php');
  require('admin/inc/essentials.php');

$settings_q ="SELECT * FROM settings WHERE sr_no =?";
$values = [1];
$settings_r = mysqli_fetch_assoc(select($settings_q,$values,'i'));

if($settings_r['shutdown']){
  echo<<<alertbar
     <div class='bg-danger text-center p-2 fw-bold'>
        <i class="bi bi-exclamation-triangle-fill"></i>
        Booking are temporarily closed!
     </div>
  alertbar;
}


?>