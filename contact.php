<!DOCTYPE html>
<html lang="an">
  <head>

    <?php require('inc/links.php'); ?>
    <title>Star Hotel-CONTACT</title>

<style>
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
  <h2 class="fw-bold h-font text-center">CONTACT US</h2>
  <div class="h-line bg-dark"></div>
  <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit.
    Laudantium est aliquam quae dolor voluptas,<br>animi nobis aliquid tempora
    distinctio veniam.
  </p>
</div>

<?php 
$contact_q = "SELECT *FROM contact_details WHERE sr_no =?";
$values =[1];
$contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));
?>


<div class="container">
  <div class="row">
    <div class="col-lg-6 col-md-6 mb-5 px-4">

      <div class="bg-white rounded shadow p-4">
        <iframe class="w-100 rounded mb-4" src="<?php echo $contact_r['iframe']?>" 
                height="320px" loading="lazy">
        </iframe>

        <h5>Address:</h5>
        <a href="<?php echo $contact_r['gmap']?>" target="_blank" class="d-inline-block text-decoration-none text-dark">
        <i class="bi bi-geo-alt-fill"></i><?php echo $contact_r['address']?>
        </a>

        <h5 class="mt-4">Call us:</h5>
        <a href="tel: +<?php echo $contact_r['pn1']?>" class="d-inline-block mb-2 text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i><?php echo $contact_r['pn1']?></a>
        <br>
        <?php 
        if($contact_r['pn2']!=''){
          echo<<<data
          <a href="tel: +$contact_r[pn2]" class="d-inline-block text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i>+$contact_r[pn2]</a>
          data;
        }
        ?>
         

        <h5 class="mt-4">Email:</h5>
        <a href="mailto: <?php echo $contact_r['email']?>" class = "d-inline-block text-decoration-none text-dark">
        <i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email']?>

        <h5 class="mt-4">Follow us</h5>
        <?php
        if($contact_r['twit']!=''){
          echo<<<data
          <a href="$contact_r[twit]" class="d-inline-block  text-dark fs-5 me-2">
          <i class="bi bi-twitter "></i>
          </a>
          data;
        }
        ?>
       
      
        <a href="<?php echo $contact_r['insta']?>" class="d-inline-block  text-dark fs-5 me-2">
        <i class="bi bi-instagram "></i>
        </a>
      
        <a href="<?php echo $contact_r['fb']?>" class="d-inline-block  text-dark fs-5 ">
        <i class="bi bi-facebook "></i>
        </a>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 mb-5 px-4">
      <div class="bg-white rounded shadow p-4 ">
        <form method="post">
          <h5>Send a message</h5>
          <div class="mt-3">
            <label class="form-label" style="font-weight: 500;">Name</label>
            <input name="name" required type="text" class="form-control shadow-none">
          </div>
          <div class="mt-3">
            <label class="form-label" style="font-weight: 500;">Email</label>
            <input type="email" name="email" required class="form-control shadow-none">
          </div>
          <div class="mt-3">
            <label class="form-label" style="font-weight: 500;">Subject</label>
            <input type="text" name="subject" required class="form-control shadow-none">
          </div>
          <div class="mt-3">
            <label class="form-label" style="font-weight: 500;">Message</label>
            <textarea class="form-control shadow-none" name="message" required rows="5" style="resize: none;"></textarea>
          </div>
            <button type="submit" name="send" class="btn text-white custom-bg mt-3">SEND</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php 
  if(isset($_POST['send'])){
    $frm_data = filteration($_POST);
    $q = "INSERT INTO user_queries (name, email, subject, message) VALUES (?,?,?,?)";
    $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $frm_data['message']];
    $res = insert($q,$values,'ssss');
    if($res == 1){
      alert('success','Mail Sent!');
    }else{
      alert('error','Server Down! Try again leter');
    }
  }
?>




<!-- Footer -->
   <?php require('inc/footer.php'); ?>
<!--End Footer -->

</body>
</html>