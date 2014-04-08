<?php
//Load the library file
require_once '../MOLPay/distribution/InpageMolpay.php';

use MOLPay\distribution\InpageMolpay;

//Instantiate the library
$molpay = new InpageMolpay();

//Important - checking if the page should redirect to the real return URL
$molpay->checkReturn();

//Define the parameters using PHP method chaining
echo $molpay->setMerchantID('molpaytech')
            ->setOrderID('DEMO1045')
            ->setAmount(1.10)
            ->setBuyerDetails(array(
                'bill_name' => 'MOLPay demo',
                'bill_email' => 'demo@molpay.com',
                'bill_mobile' => '0355218438',
                'bill_description' => 'testing by MOLPay',
            ))
            ->setCountry('MY')
            ->setReturnURL('processing.php')
            ->setVcode('0d72ceec9ee3848f4721697f5dca166e')
            ->setCurrency('MYR')
            ->setLanguageCode('en')
            ->setPaymentMethod('maybank2u.php')
            ->setTemplate(true)
            ->trigger();
?>