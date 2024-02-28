<?php
require('admin/inc/db_config.php');
require('admin/inc/essentials.php');
require('admin/inc/links.php');

require('inc/paytm/config_paytm.php');
require('inc/paytm/encdec_paytm.php');

date_default_timezone_set("Africa/Casablanca");

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}

if (isset($_POST['pay_now']) && isset($_POST['action']) && $_POST['action'] !== 'https://securegw-stage.paytm.in/theia/processTransaction') {
    header("Pragma: no-cache");
    header("Cache-Control: no-cache");
    header("Expires: 0");

    $checkSum = "";

    $ORDER_ID = 'ORD_' . $_SESSION['uId'] . random_int(11111, 9999999);
    $CUST_ID = $_SESSION['uId'];
    $INDUSTRY_TYPE_ID = INDUSTRY_TYPE_ID;
    $CHANNEL_ID = CHANNEL_ID;

    // Check if 'payment' key is set in $_SESSION['room'] array
    $TXN_AMOUNT = isset($_SESSION['room']['payment']) ? $_SESSION['room']['payment'] : 0;

    $paramList = array();

    $paramList["ORDER_ID"] = $ORDER_ID;
    $paramList["CUST_ID"] = $CUST_ID;
    $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
    $paramList["CHANNEL_ID"] = $CHANNEL_ID;
    $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
    $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;

    $paramList["CALLBACK_URL"] = CALLBACK_URL;

    $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);

    // Insert payment data into database
    $frm_data = filteration($_POST);

    $query = "INSERT INTO booking_order(user_id, room_id, check_in, check_out, order_id) VALUES (?,?,?,?,?)";
    insert($query, [$CUST_ID, $_SESSION['room']['id'], $frm_data['checkin'], $frm_data['checkout'], $ORDER_ID], 'issss');

    $booking_id = mysqli_insert_id($con);

    $query2 = "INSERT INTO booking_details(booking_id, room_name, price, total_pay, user_name, phonenum, address) VALUES (?,?,?,?,?,?,?)";
    $fname = isset($frm_data['fname']) ? $frm_data['fname'] : '';
    $lname = isset($frm_data['lname']) ? $frm_data['lname'] : '';
    insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $fname . ' ' . $lname, $frm_data['phonenum'], $frm_data['address']], 'issssss');

    // Update 'payed' status in database
    $updateQuery = "UPDATE booking_details SET payed = 'statut_booking' WHERE booking_id = ?";
    update($updateQuery, [$booking_id], 'i');
}
?>

<html>
<head>
    <title>Processing</title>
</head>
<body>
    <h1>Please do not refresh this page...</h1>
    <form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
        <?php
        foreach ($paramList as $name => $value) {
            echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
        }
        ?>
        <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
        <button class="btn btn-danger" type="submit">Make Payment</button>
    </form>

    <script type="text/javascript">
        document.f1.submit();
    </script>

    <h2>Payment Status:</h2>
    <?php
    // Check if payment is successful
    if (isset($_POST['pay_now']) && isset($_POST['action']) && $_POST['action'] !== 'https://securegw-stage.paytm.in/theia/processTransaction') {
        echo "<p>Processing payment...</p>";
    } else {
        echo "<p>No payment has been initiated.</p>";
    }
    ?>
</body>
</html>
