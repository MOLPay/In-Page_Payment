<?php
//Above here is where you server side client is functioning.
//We going to detect if the page come from MOLPay return page
//You can use what ever server side language to detect if the page comming from MOLPay
if(isset($_REQUEST['tranID']) && isset($_REQUEST['domain']) && isset($_REQUEST['skey'])):
    $error_code = (isset($_REQUEST['error_code']))? $_REQUEST['error_code'] : 'null';
    $error_desc = (isset($_REQUEST['error_desc']))? $_REQUEST['error_desc'] : 'null';
?>
<!-- link to jQuery CDN -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- script source to MOLPay library -->
<script src="../source/MOLPay_inpage.js"></script>
<script>
    molpay_is_return(   '<?= $_REQUEST['amount'] ?>',
                        '<?= $_REQUEST['orderid'] ?>',
                        '<?= $_REQUEST['appcode'] ?>',
                        '<?= $_REQUEST['tranID'] ?>',
                        '<?= $_REQUEST['domain'] ?>',
                        '<?= $_REQUEST['status'] ?>',
                        '<?= $error_code ?>',
                        '<?= $error_desc ?>',
                        '<?= $_REQUEST['currency'] ?>',
                        '<?= $_REQUEST['paydate'] ?>',
                        '<?= $_REQUEST['channel'] ?>',
                        '<?= $_REQUEST['skey'] ?>' );
</script>
<?php endif; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>MOLPay In-page Javascript Demo</title>
        <!-- Stylesheet for this page -->
        <link rel="stylesheet" href="style.css" type="text/css" />
        <!-- The in-pay payment page stylesheet. Important -->
        <link rel="stylesheet" href="../source/MOLPay_inpage.css" type="text/css" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <a href="#">Click here to pay with MOLPay</a>
        <!-- jQuery scripting using google CDN -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <!-- MOLPay in-page jQuery plugin -->
        <script src="../source/MOLPay_inpage.js"></script>
        <script>
            jQuery(document).ready(function() {
                $('a').click(function( event ) {
                    $('body').molpay({
                        merchantID : 'molpaytech',
                        orderID : 'DEMO1045',
                        amount : 1.10,
                        bill_name : 'MOLPay demo',
                        bill_email : 'demo@molpay.com',
                        bill_mobile : '0355218438',
                        bill_desc : 'testing by MOLPay',
                        country : 'MY',
                        returnURL : 'processing.php',
                        vcode: '0d72ceec9ee3848f4721697f5dca166e',
                        cur: 'MYR',
                        langcode: 'en'
                    });
                    event.preventDefault();
                });
            });
        </script>
    </body>
</html>
