MOLPay in-page payment Javascript library
===============================

MOLPay in-page payment Javascript library is a library that allowing developer to implement MOLPay in-page with easy and faster to deploy.

Instruction to deploy
---------------------

Just include the <strong>jQuery (version 1.10.2)</strong> and <strong>MOLPay_inpage.min.js</strong> files into your shopping cart page. Please ensure your shopping cart payment gateway can communicate with MOLPay in-page library.

```
<!-- jQuery scripting using google CDN -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <!-- MOLPay in-page jQuery plugin -->
        <script src="../source/MOLPay_inpage.min.js"></script>
```

And provide the constructor below with the required value and it will automaticly generate an iframe inside the current page where the library is called. Like example below, the constructor is call when link has been clicked.

```
//Wrap the method inside the jQuery ready method to ensure the DOM were loaded before the method were call
jQuery(document).ready(function() {
	$('a').click(function( event ) {
	    //MOLPay jQuery plugin method call
	    $('body').molpay({
	        //The merchant ID *
	        merchantID : 'molpaytech',
	        //The order ID *
	        orderID : 'DEMO1045',
	        //Amount required *
	        amount : '1.10',
	        //Buyer name *
	        bill_name : 'MOLPay demo',
	        //Buyer email *
	        bill_email : 'demo@molpay.com',
	        //Buyer mobile number
	        bill_mobile : '0355218438',
	        //Bill description or notes *
	        bill_desc : 'testing by MOLPay',
	        //Country where the buyer pay
	        country : 'MY',
	        //The VCODE (please check API Docs how to generate this) *
	        vcode: '628eaff7da99b8e7d7339d55579f57fd',
	        //Currency
	        cur: 'MYR',
	        //Language
	        langcode: 'en'
	    });
	    event.preventDefault();
	});
});
```

Please also called the Javascript function <code>molpay_is_return()</code> in the page to handle return parameters from inpage payment form. Below is the example when the parameters has been returned (PHP) and process by <code>molpay_is_return()</code> javascript function.

```
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
```


Notes
-----
You can refer to the example code


