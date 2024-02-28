<!DOCTYPE html>
<html lang="an">
  <head>

    <?php require('inc/links.php'); ?>
    <title>Star Hotel-HOME</title>

      <style>
       
          .availability-form{
            margin-top: -50PX ;
            z-index: 2;
            position: relative;
          }
          @media screen and (max-with: 575px) {
            .availability-form{
            margin-top: 0px ;
            padding: 0 35px ;
          }
          }

      </style>
  </head>

    <body class="bg-light">
      <!-- navbar -->

<?php  require('inc/navbar.php'); ?>
      <!--End navbar -->
<!-- Swiper-->
  <div class="container-fluid px-lg-4 mt-4">
    <div class="swiper swiper-container">
        <div class="swiper-wrapper">
          <?php 
          $res = selectAll('carousel');
          while($row = mysqli_fetch_assoc($res)){
            $path = CAROUSEL_IMG_PATH;
            echo <<<data
              <div class="swiper-slide">
              <img src="{$path}{$row['image']}" class="w-100d-block" width="100%" height="500"/>
              </div>
            data;
        }
          ?>
          
        </div>
      
      </div>
  </div>
<!-- End Swiper-->

<!-- check availability form -->
  <div class="container availability-form">
        <div class="row">
          <div class="col-lg-12 bg-white shadow-lg p-3 mb-4 bg-body-tertiary rounded">
            <h5 class="mb-4">Check Booking Availability</h5>
            <form>
              <div class="row align-items-end">
              <div class="col-lg-3 mb-3">
                <label class="form-label" style="font-weight: 500;">Check-in</label>
                <input type="date" class="form-control shadow-none">
              </div>
              <div class="col-lg-3 mb-3">
                <label class="form-label" style="font-weight: 500;">Check-out</label>
                <input type="date" class="form-control shadow-none">
              </div>
              <div class="col-lg-2 mb-3">
                <label class="form-label" style="font-weight: 500;">Adult</label>
                <select class="form-control shadow-none">
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
              </div>
              <div class="col-lg-2 mb-3">
                <label class="form-label" style="font-weight: 500;">Children</label>
                <select class="form-control shadow-none">
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
              </div>
              <div class="col-lg-1 mb-lg-3 mt-2">
                <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
              </div>
            </div>
            </form>       
          </div>
        </div>
  </div>
<!-- End check availability form -->

<!-- Our Rooms -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font ">OUR ROOMS</h2>
  <div class="container">
    <div class="row">

    <?php 
        $room_res = select("SELECT * FROM rooms WHERE status=? AND removed=? ORDER BY id DESC LIMIT 3",[1,0],'ii');

        while($room_data = mysqli_fetch_assoc($room_res)){
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

          // GET THUMBNAIL OF ROOM
          $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
          $thumb_q = mysqli_query($con,"SELECT * FROM room_images 
          WHERE room_id='$room_data[id]' AND thump='1'");

          if(mysqli_num_rows($thumb_q)>0){
            $thumb_res = mysqli_fetch_assoc($thumb_q);
            $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
          } 

          // booking settings
            $book_btn = "";
            if (!$settings_r['shutdown']) {
              $login = 0;
              if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                $login = 1;
              }
              $book_btn = "<button onclick='checkLoginToBook($login, $room_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Book Now</button>";
            }

          // PRINT ROOM CARD
           echo <<<data

              <div class="col-lg-4 col-md-6 my-3">
                  <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                  <img src="$room_thumb" class="card-img-top">
                    <div class="card-body">
                    <h5>$room_data[name]</h5>
                    <h6 class="mb-4"> $room_data[price] MAD for night</h6>
                    <div class="features mb-4">
                      <h6 class="mb-1">Features</h6>
                      $features_data
                    </div>
                    <div class="facilities mb-4">
                      <h6 class="mb-1">Facilities</h6>
                      $facilities_data
                    </div>
                    <div class="guests mb-4">
                      <h6 class="mb-1">Guests</h6>
                      <span class="badge rounded-pill text-bg-light text-wrap">
                           $room_data[adult] Adults
                      </span>
                      <span class="badge rounded-pill text-bg-light text-wrap">
                           $room_data[children] Children
                      </span>
                    </div>
                    <div class="reting mb-3">
                      <h6 class="mb-1">Reting</h6>
                        <span class="badge rounded-pill bg-light ">
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        $book_btn
                        <a href="room-details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark shadow-none">More details</a>
                    </div> 
                    </div>
                  </div>
              </div>
          data;

          


        }
     ?>
      <div class="col-lg-12 text-center mt-5">
        <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms</a>
      </div>
    </div>
  </div>
<!-- End Our Rooms -->

<!--Our Facilities -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font ">OUR FACILITIES</h2>
  <div class="container">
    <div class="row justify-content-between px-lg-0 px-md-0 px-5">

    <?php
    $res = mysqli_query($con,"SELECT * FROM facilities  ORDER BY id DESC LIMIT 5");
    $path =FEATURES_IMG_PATH;

    while($row = mysqli_fetch_assoc($res)){
      echo<<<data
          <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3 ">
            <img src="$path$row[icon]" width="60"/>
            </img>
            <h5 class="mt-3">$row[name]</h5>
          </div>
      data;
    }
    ?>
    <div class="col-lg-12 text-center mt-5">
        <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities</a>
      </div>
    </div>
  </div>
<!-- End Our Facilities -->

 
<!-- Testimonials-->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font ">TESTIMONIALS</h2>
  <div class="container mt-5">
      <div class="swiper swiper-testimonials">
          <div class="swiper-wrapper mb-5">
            <div class="swiper-slide bg-white p-4">
              <div class="profile d-flex align-items-center mb-3">
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
            <div class="swiper-slide bg-white p-4">
              <div class="profile d-flex align-items-center mb-3">
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
            <div class="swiper-slide bg-white p-4">
              <div class="profile d-flex align-items-center mb-3">
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
            <div class="swiper-slide bg-white p-4">
              <div class="profile d-flex align-items-center mb-3">
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
            <div class="swiper-slide bg-white p-4">
              <div class="profile d-flex align-items-center mb-3">
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
            <div class="swiper-slide bg-white p-4">
              <div class="profile d-flex align-items-center mb-3">
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
          <div class="swiper-pagination"></div>
        </div>
    <div class="col-lg-12 text-center mt-5">
        <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know More</a>
      </div>

  </div>
<!-- End Our testerfsq -->

<!-- Reach us-->

  <?php 
  $contact_q = "SELECT *FROM contact_details WHERE sr_no =?";
  $values =[1];
  $contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));
  ?>





  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font ">REACH US</h2>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
      <iframe class="w-100 rounded" src="<?php echo $contact_r['iframe']?>" 
      height="320px" loading="lazy"></iframe>
    
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="bg-white p-4 rounded mb-4">
          <h5>Call us</h5>
          <a href="tel: +<?php echo $contact_r['pn1']?>" class="d-inline-block mb-2 text-decoration-none text-dark">
            <i class="bi bi-telephone-fill"></i> <?php echo $contact_r['pn1']?> </a>
          <br>
          <?php 
          if($contact_r['pn2'] != ''){
            echo<<<data
            
            <a href="tel: + $contact_r[pn2]" class="d-inline-block text-decoration-none text-dark">
            <i class="bi bi-telephone-fill"></i>$contact_r[pn2]</a>

            data;
          }
          ?>
        </div>
        <div class="bg-white p-4 rounded mb-4">
          <h5>Follow us</h5>
          <?php 
          if($contact_r['twit']!=''){
            echo<<<data

            <a href="$contact_r[twit]" class="d-inline mb-3">
            <span class="badge bg-light text-dark fs-6 p-2">
            <i class="bi bi-twitter"></i>Twitter
            </span>
            </a>
            <br>
            data;
          }
          ?>
          <a href="<?php echo $contact_r['insta'] ?>" class="d-inline mb-3">
          <span class="badge bg-light text-dark fs-6 p-2">
          <i class="bi bi-instagram "></i>Instagram
          </span>
          </a>
          <br>
          <a href="<?php echo $contact_r['fb'] ?>" class="d-inline mb-3">
          <span class="badge bg-light text-dark fs-6 p-2">
          <i class="bi bi-facebook"></i>Facebook
          </span>
          </a>
        
        
        </div>
        

      </div>

    </div>

  </div>
<!-- End Reach us-->

<!-- Password reset modal and code-->
  <div class="modal fade" id="recoveryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="recovery-form">
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items center" >
            <i class="bi bi-shield-lock fs-3 me-2"></i>Set up New Password
          </h5>
        </div>
        <div class="modal-body">
          <div class="mb-4">
          <label class="form-label">New Password</label>
          <input type="password" name="pass" required class="form-control shadow-none">
          <input type="hidden" name="email">
          <input type="hidden" name="token">
        </div>
        <div class="mb-2 text-end">
          <button type="button" class="btn shadow-none p-0 me-2" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-dark shadow-none">Submit</button>
        </div>
        </div>
        </form>
      </div>
    </div>
  </div>
<!-- End Password reset modal and code-->





   <!-- Footer -->
   <?php  require('inc/footer.php'); ?>
  <!--End Footer -->


  <?php 
  if (isset($_GET['account_recovery'])) {
    $data = filteration($_GET);

    $t_date = date("Y-m-d");

    $query = select("SELECT * FROM user_cred WHERE email=? AND token=? AND t_expire=? LIMIT 1", [$data['email'], $data['token'], $t_date], 'sss');

    if (mysqli_num_rows($query) == 1) {
        echo <<<showModal
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              var myModal = document.getElementById('recoveryModal');

              myModal.querySelector("input[name='email']").value = '{$data['email']}';
              myModal.querySelector("input[name='token']").value = '{$data['token']}';

              var modal = new bootstrap.Modal(myModal);
              modal.show();
            });
          </script>
        showModal;
    } else {
        echo alert("error","Invalid or Expired Link!");
    }
}


  ?>




<!-- Open JavaScript Bundle with Popper -->
<script src="assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>  
<script src="assets/js/swiper-bundle.min.js"></script>  
<script src="assets/js/swiper-bundle.min.js1.js"></script>
<!--swiper leading page script -->

<script>
  // swiper leading script
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay :{
        delay: 3500,
        disableOnInteraction: false,
      }
     
    });

   // swiper testimonials script
var swiper = new Swiper(".swiper-testimonials", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      slidesPerView: 3,
      loop: true,
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: false,
        
      },
      pagination: {
        el: ".swiper-pagination",
      },

      breakpoints: {
        640: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
      }, }     
});





// Recover account
let recovery_form = document.getElementById('recovery-form');
    
recovery_form.addEventListener('submit', (e) => {
     e.preventDefault();

        let data = new FormData();

        data.append('email', recovery_form.elements['email'].value);
        data.append('token', recovery_form.elements['token'].value);
        data.append('pass', recovery_form.elements['pass'].value);

        data.append('recover_user', '');

        var myModal = document.getElementById('recoveryModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);
        
        

        xhr.onload = function () {
            if (this.responseText == 'failed') {
                alert('error','Account Reset failed!');
            } else {
                alert('success','Account Reset Successful!');
                recovery_form.reset();
            }
     };
    
      xhr.send(data);
    });
    

  </script>
  

   

</body>
</html>