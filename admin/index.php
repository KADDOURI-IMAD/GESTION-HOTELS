<?php require('inc/db_config.php');
      require('inc/essentials.php');


        session_start();
        session_regenerate_id(true);
        if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
           redirect('dashboard.php');
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/Style.css">
    <?php require('inc/links.php') ?>
    <title>Admin Login Panel</title>

    <style>
        div.login-form{
           position: absolute;
           top: 50%;
           left: 50%;
           transform: translate(-50%, -50%);
           width: 400px;
        }

        .custom-alert{
        position: fixed;
        top: 25px;
        right: 25px;

        }


    </style>
</head>
<body class="bg-light">
    
<div  class="login-form text-center rounded bg-white shadow overflow-hidden ">
    <form method="post">
        <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
        <div>
            <div class="mb-3">  
                <input name="admin_name" required type="text" class="form-control shadow-none text-center" placeholder="Admin Name">          
            </div>
            <div class="mb-3">  
                <input name="admin_password" required type="password" class="form-control shadow-none text-center" placeholder="Password">          
            </div>   
            <button name="login" type="submit" class="btn text-white custom-bg shadow-none">LOGIN</button>          
        </div>
    </form>
</div>

<?php 

if(isset($_POST['login']))
{
  $frm_data = filteration($_POST);
  $query = "SELECT * FROM admin_cred WHERE admin_name=? AND admin_password=?";
  $values = [$frm_data['admin_name'],$frm_data['admin_password']];
  $res = select($query,$values,"ss");
  
  if($res->num_rows > 0){
    $row = mysqli_fetch_assoc($res);

    $_SESSION['adminlogin'] = true;
    $_SESSION['adminId'] = $row['so_no'];
    redirect("dashboard.php");

  }else{
    alert('error','Login failed - Invalid Credentials!');
  }
}


?>




<?php require('inc/scripts.php');   ?>
</body> 
</html>