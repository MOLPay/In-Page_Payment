MOLPay in-page payment PHP library
===============================

MOLPay in-page payment PHP library is a library that allowing developer to implement MOLPay in-page with easy and faster to deploy.

It will generate the MOLPay in-page together with the corresponding API to MOLPay payment page by using PHP chain method for more readability and easy to maintenance.

Installation
-------------

Just include the InpageMolpay.php in the distribution folder into your shopping cart. Please ensure your shopping cart payment gateway can communicate with MOLPay in-page library.

```php
require_once 'MOLPay/distribution/InpageMolpay.php';
```

Implementation
-------------

To generate the in-page payment. First, you need to initialize the library.

```php
$molpay = new MOLPay\distribution\InpageMolpay();
```
or
```php
use MOLPay\distribution\InpageMolpay;

$molpay = new InpageMolpay();
```

Then, after initialize the library, <strong>You MUST declare return checking above the property declaration</strong>
```php
$molpay->checkReturn();
```

Start fill-in the property with cart related information. You can read the MOLPay API docs for more details.
```php
//In this example, We going to used PHP method chaining.
//Refer example/full_template.php

$html_code = $molpay->setMerchantID('test5620')         //Set the Merchant ID
        ->setOrderID('DEMO1045')                        //Set the Order ID
        ->setAmount(1.10)                               //Set the Transaction Amount
        ->setBuyerDetails(array(
            'bill_name' => 'MOLPay demo',
            'bill_email' => 'demo@molpay.com',
            'bill_mobile' => '0355218438',
            'bill_description' => 'testing by MOLPay',
        ))                                              //Define the buyer information
        ->setCountry('MY')                              //Set the country code
        ->setReturnURL('processing.php')                //Define the URL where shall we proceed after returning from MOLPay
        ->setVcode('0d72ceec9ee3848f4721697f5dca166e')  //Define the verification code
        ->setCurrency('MYR')                            //Set the currency used
        ->setLanguageCode('en')                         //Set the language code
        ->setTemplate(true)                             //Set to true for Full Template Output
        ->trigger();                                    //Trigger the in-page payment
        
echo $html_code;
```
That the only method you need if you want to implements MOLPay in-page full template.

If you going to implement inject style templating. Just remove the method <code>setTemplate()</code>, then echo the output at desired position.

```php
<?php
//In this example, We going to used PHP method chaining.
//Refer example/inject_template.php

$html_code = $molpay->setMerchantID('test5620')         //Set the Merchant ID
        ->setOrderID('DEMO1045')                        //Set the Order ID
        ->setAmount(1.10)                               //Set the Transaction Amount
        ->setBuyerDetails(array(
            'bill_name' => 'MOLPay demo',
            'bill_email' => 'demo@molpay.com',
            'bill_mobile' => '0355218438',
            'bill_description' => 'testing by MOLPay',
        ))                                              //Define the buyer information
        ->setCountry('MY')                              //Set the country code
        ->setReturnURL('processing.php')                //Define the URL where shall we proceed after returning from MOLPay
        ->setVcode('0d72ceec9ee3848f4721697f5dca166e')  //Define the verification code
        ->setCurrency('MYR')                            //Set the currency used
        ->setLanguageCode('en')                         //Set the language code
        ->trigger();                                    //Trigger the in-page payment
?>
```

Output the generated HTML markup to your selected page.

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Your page title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <!-- Your page content -->
        <!-- Output the generated code in your template. -->
        <?= $html_code; ?>
    </body>
</html>
```

Notes
-----
You can refer to the example code

Library API
------------

[Library API documentation](https://github.com/MOLPay/MOLPay_in-page_docs/blob/master/API.md)
