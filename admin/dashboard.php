<?php
require('inc/essentials.php');
adminLogin();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/Style.css" rel="stylesheet"  crossorigin="anonymous">
    <title>Admin panel - Dashboard</title>
    <?php
require('inc/links.php');
     ?>

<style>
       #dashboard-menu{
        position: fixed;
        height: 100%;
      } 

      @media screen and (max-width: 992px){
        #dashboard-menu{
        height: auto;
        width: 100%;
      } 
      }

      #main-content{
        margin-top: 60px;
      }

</style>
</head>
<body>
    
<?php
require('inc/header.php');
?>


<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">

        </div>
    </div>
</div>




<?php
require('inc/scripts.php');
     ?>
</body>
</html>