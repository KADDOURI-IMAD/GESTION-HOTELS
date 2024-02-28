<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/Style.css" rel="stylesheet"  crossorigin="anonymous">
    <title>Admin panel - Users</title>
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

      .custom-alert{
        position: fixed;
        top: 80px;
        right: 25px;

        }
        ::-webkit-scrollbar{
        width: 10px;
      }

      ::-webkit-scrollbar-track{
        background: #f1f1f1;
      }

      ::-webkit-scrollbar-thumb{
        background: rgb(36, 36, 36);
      }

      ::-webkit-scrollbar-thumb:hover{
        background: #555;
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
           <h3 class="mb-4">USERS</h3>


          <!-- Add room section -->
           <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

              <div class="text-end mb-4">
                 <input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search...">
                
              <div class="table-responsive">
                  <table class="table table-hover border text-center" style="min-width: 1300px;" >
                    <thead>
                      <tr class="bg-dark text-light">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Location</th>
                        <th scope="col">Date Of Birthday</th>
                        <th scope="col">Verified</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>

                      </tr>
                    </thead>
                    <tbody id="users-data">
              
                    </tbody>
                  </table>
              </div>

            </div>
           </div>
          <!-- END Add room section -->
          


          
        </div>
    </div>
</div>

<?php require('inc/scripts.php'); ?>
<script src="scripts/users.js"></script>


</body>
</html>