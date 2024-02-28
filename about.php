<!DOCTYPE html>
<html lang="an">
  <head>

    <?php require('inc/links.php'); ?>
    <title>Star Hotel-ABOUT</title>
  <style>
    .box:hover{
        border-top-color: var(--teal) !important;
        transform: scale(1.03);
        transition: all 0.3s;
      }
      :root{
  --teal: #2ec1ac;
  --teal_hover: #279e8c;

}


*{
    font-family: 'Poppins', sans-serif;
   }
  
   .h-font{
    font-family: 'Merienda', cursive;
   }

   /* Chrome, Safari, Edge, Opera */
     input::-webkit-outer-spin-button,
     input::-webkit-inner-spin-button {
     -webkit-appearance: none;
     margin: 0;
      }

      .custom-bg{
        background-color: var(--teal);
        border: 1px solid var(--teal);
      }

      .custom-bg:hover{
        background-color: var(--teal_hover);
        border-color: var(--teal_hover);
      }

      .h-line{
        width: 150px ;
        margin: 0 auto;
        height: 1.7px;
      }

      .custom-alert{
        position: fixed;
        top: 80px;
        right: 25px;

        }
      

      
  </style>
  
  </head>

<body class="bg-light">
<!-- navbar -->
    <?php require('inc/navbar.php'); ?>
<!--End navbar -->
<div class="my-5 px-4">
  <h2 class="fw-bold h-font text-center">ABOUT US</h2>
  <div class="h-line bg-dark"></div>
  <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit.
    Laudantium est aliquam quae dolor voluptas,<br>animi nobis aliquid tempora
    distinctio veniam.
  </p>
</div>

<div class="container">
   <div class="row justify-content-between align-items-center">
     <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
        <h3 class="mb-3">Lorem ipsum dolor sit.</h3>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit.
          Harum, blanditiis, hic quis, nihil culpa magnam numquam
          cumque eum sunt deleniti accusantium ratione. Ipsam,
          repudiandae quis Lorem ipsum dolor sit amet.
        </p>
     </div>
     <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
      <img src="assets/img/persn.jpg" class="w-100">
     </div>
   </div>
</div>

<div class="container mt-5">
  <div class="row">
     <div class="col-lg-3 col-md-6 mb-4 px-4">
       <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="assets/img/hotel.svg" width="70px">
          <h5 class="mt-3">100+ ROOMS</h5>
       </div>
     </div>
     <div class="col-lg-3 col-md-6 mb-4 px-4">
       <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="assets/img/custm.png" width="70px">
          <h5 class="mt-3">200+ CUSTOMERS</h5>
       </div>
     </div>
     <div class="col-lg-3 col-md-6 mb-4 px-4">
       <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="assets/img/rating.png" width="70px">
          <h5 class="mt-3">150+ REVIEWS</h5>
       </div>
     </div>
     <div class="col-lg-3 col-md-6 mb-4 px-4">
       <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="assets/img/staff.svg" width="70px">
          <h5 class="mt-3">200+ STAFFS</h5>
       </div>
     </div>
  </div>
</div>


<h3 class="fw-bold h-font text-center">MANAGEMENT TEAM</h3>
<div class="h-line bg-dark"></div>
  <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit.
    Laudantium est aliquam quae dolor voluptas.
  </p>

<div class="container px-4">
    <!-- Swiper -->
  <div class="swiper mySwiper">
    <div class="swiper-wrapper mb-5">

    <?php
      $about_r = selectAll('team_details');
      $path = ABOUT_IMG_PATH;
      while($row = mysqli_fetch_assoc($about_r)){
        echo<<<data
        <div class="swiper-slide bg-white overflow-hidden rounded">
        <img src="$path$row[picture]" class="w-100">
        <h5 class="mt-2 text-center">$row[name]</h5>
        </div> 
        data;
      }
    ?> 
    </div>
  </div>
</div>
<!-- Footer -->
   <?php require('inc/footer.php'); ?>
<!--End Footer -->


<!-- Swiper JS -->
<script src="assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>  
<script src="assets/js/swiper-bundle.min.js"></script>  
<script src="assets/js/swiper-bundle.min.js1.js"></script>

<!-- Initialize Swiper -->
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesdPerView: 3,
    spaceBetween: 48,
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
</script>

</body>
</html>