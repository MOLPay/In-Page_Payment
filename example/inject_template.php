<?php
//Load the library file
require_once '../MOLPay/distribution/InpageMolpay.php';

//Instantiate the library
$molpay = new MOLPay\distribution\InpageMolpay();

//Important - checking if the page should redirect to the real return URL
$molpay->checkReturn();

//Define the parameters by using attribute initialize
$molpay->merchantID = 'molpaytech';
$molpay->orderID = 'DEMO1045';
$molpay->amount = 1.10;
$molpay->bill_name = 'MOLPay demo';
$molpay->bill_email = 'demo@molpay.com';
$molpay->bill_mobile = '0355218438';
$molpay->bill_description = 'testing by MOLPay';
$molpay->country = 'MY';
$molpay->returnURL = 'processing.php';
$molpay->vcode = '0d72ceec9ee3848f4721697f5dca166e';
$molpay->currency = 'MYR';
$molpay->langcode = 'en';
$molpay->payment_type = 'fpx.php';

//Generate the inpage code and save it into the variables
$molpay_inpage = $molpay->trigger();

//Assuming the HTML markup below is template that you already develop
?>
<!DOCTYPE html>
<html>
    <head>
        <title>MOLPay In-page Inject Template</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <div class="topic-header">
            <h2>MOLPay in-page Payment</h2>
        </div>
        <h3>Examples</h3>
        <a href="javascript.html">Javascript version</a><br />
        <a href="full_template.php">PHP classes full template</a><br />
        <a href="inject_template.php">PHP classes inject template</a><br />
        <h3>Documentation</h3>
        <a href="../docs/javascript.html">Javascript version</a><br />
        <a href="../docs/full_template.php">PHP classes full template</a><br />
        <a href="../docs/inject_template.php">PHP classes inject template</a><br />
        <?php //Display the molpay inpage in a segment. ?>
        <?= $molpay_inpage ?>
    </body>
</html>