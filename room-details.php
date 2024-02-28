<!DOCTYPE html>
<html lang="an">
  <head>

    <?php require('inc/links.php'); ?>
    <title>Star Hotel-ROOM DETAILS</title>

  </head>

<body class="bg-light">
<!-- navbar -->
    <?php require('inc/navbar.php'); ?>
<!--End navbar -->
<?php
  if(!isset($_GET['id'])){
    redirect('rooms.php');
  }

  $data = filteration($_GET);
  $room_res = select("SELECT * FROM rooms WHERE id=? AND status=? AND removed=?",[$data['id'],1,0],'iii');

  if(mysqli_num_rows($room_res)==0){
    redirect('rooms.php');
  }

  $room_data = mysqli_fetch_assoc($room_res);
?>  


<div class="container">
  <div class="row">


  <div class="col-12 my-5 mb-4 px-4">
    <h2 class="fw-bold"><?php echo $room_data['name'] ?></h2>
    <div style="font-size: 14px;">
      <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
      <span class="text-secondary"> > </span>
      <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
    </div>
  </div>


    <div class="col-lg-7 col-md-12 px-4">
      <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <?php 
          // GET IMAGES OF ROOM
          $room_img = ROOMS_IMG_PATH . "thumbnail.jpg";
          $img_q = mysqli_query($con, "SELECT * FROM room_images WHERE room_id='$room_data[id]'");

          if (mysqli_num_rows($img_q) > 0) {
            $active_class = 'active';
            while ($img_res = mysqli_fetch_assoc($img_q)) {
              echo "<div class='carousel-item $active_class'>
                <img src='" . ROOMS_IMG_PATH . $img_res['image'] . "' class='d-block w-100 rounded'>
              </div>";
              $active_class = '';
            }
          } else {
            echo "<div class='carousel-item active'>
              <img src='$room_img' class='d-block w-100'>
            </div>";
          }
          ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>

    <div class="col-lg-5 col-md-12 px-4">
          <div class="card mb-4 border-0 shadow-sm rounded-3">
            <div class="card-body">
              <?php 
                echo<<<price
                  <h4>$room_data[price] Per night</h4>
                price;

                echo<<<rating
                  <div class="mb-3">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                  </div>
                rating;


               // GET FEATURES OF ROOM
                    $fea_q = mysqli_query($con,"SELECT f.name FROM features f 
                    INNER JOIN room_features rfea ON f.id = rfea.features_id 
                    WHERE rfea.room_id = '$room_data[id]'");
                    
                    $features_data = "";
                    while($fea_row = mysqli_fetch_assoc($fea_q)){
                      $features_data .="<span class='badge rounded-pill text-bg-light text-wrap me-1 mb-1'>
                      $fea_row[name]
                     </span>";
                    }

                echo<<<features
                  <div class="mb-3"><h6 class="mb-1">Features</h6>$features_data</div>
                features;
              

              // GET FACILITIES OF ROOM
                    $fac_q = mysqli_query($con,"SELECT f.name FROM facilities f 
                    INNER JOIN room_facilities rfac ON f.id = rfac.facilities_id 
                    WHERE rfac.room_id ='$room_data[id]'");

                    $facilities_data = "";
                    while($fac_row = mysqli_fetch_assoc($fac_q)){
                      $facilities_data .="<span class='badge rounded-pill text-bg-light text-wrap me-1 mb-1'>
                      $fac_row[name]
                    </span>";
                    }

                echo<<<facilities
                    <div class="mb-3"><h6 class="mb-1">Facilities</h6>$facilities_data</div>
                facilities;
                
                echo<<<guests
                    <div class="mb-3">
                      <h6 class="mb-1">Guests</h6>
                      <span class="badge rounded-pill text-bg-light text-wrap">$room_data[adult] Adults</span>
                      <span class="badge rounded-pill text-bg-light text-wrap">$room_data[children] Children</span>
                    </div>
                guests;

                echo<<<area
                    <div class="mb-3"><h6 class="mb-1">Area</h6><span class='badge rounded-pill text-bg-light text-wrap me-1 mb-1'>
                    $room_data[area] sq. ft.
                  </span></div>
                area;
                
                // booking settings
              
                if(!$settings_r['shutdown']){
                  
                  $login = 0;
                  if(isset($_SESSION['login']) && $_SESSION['login']==true){
                    $login = 1;
                  }
                  
                  echo<<<book
                    <button onclick='checkLoginToBook($login,$room_data[id])' class="btn w-100 text-white custom-bg shadow-none mb-1">Book Now</button>
                  book;
                }

                
                
                

              ?>
            </div>
          </div>
    </div>




     <div class="col-12 mt-4 px-4">
      <div class="mb-5">
        <h5>Description</h5>
        <?php echo $room_data['description'] ?>
      </div>
      <div>
        <h5 class="mb-3">Reviews & Ratings</h5>
        <div>
        <div class="d-flex align-items-center mb-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
              </svg>
              <h6 class="m-1 ms-2">Random User1</h6>
            </div>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
               Necessitatibus quo ipsum dolores perspiciatis est nemo molestias maxime, 
               explicabo quis temporibus.
            </p>
            <div class="rating">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
        </div>
      </div>
     </div>
  
  </div>
</div>
<!-- Footer -->
   <?php require('inc/footer.php'); ?>
<!--End Footer -->

</body>
</html>