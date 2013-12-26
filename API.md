MOLPay In-page PHP library API
==============================

Basic informations
------------------
1. MOLPay In-page PHP library API is fully support to used method chain. Some old PHP version won't support these method chain, Please consider to upgrade PHP version.
2. For upcomming version. We will implement ability to customize the CSS and some markup.

API
---
`setMerchantID( params )`
- `params` | string | Your merchant ID  *Required


`setOrderID( params )`
- `params` | string | The transaction order ID *Required


`setAmount( params )`
- `params` | double | The transaction total amount *Required  

```php
$class->setAmount(1.10);
```


`setBuyerDetails( params )`
- `params` | array | Buyer details in array with key `bill_name`, `bill_email`, `bill_mobile`, `bill_description` *Required  

```php
$user_details = array(
  'bill_name' => '',
  'bill_email' => '',
  'bill_mobile' => '',
  'bill_description' => ''
);
```


`setCountry( params )`
- `params` | string | Country where the transaction were made *Default : `MY`


`setReturnURL( params )`
- `params` | string | Set the return URL together with `http://` or `https://` *Required


`setVcode( params )`
- `params` | string | The generated verification code *Required


`setCurrency( params )`
- `params` | string | The currency code that used in the transactions *Default : `MYR`


`setLanguageCode( params )`
- `params` | string | The language code *Default : `en`


`setPaymentMethod( params )`
- `params` | string | Assign default payment channel *Default : `null`


`setPageTitle( params )`
- `params` | string | Page title, ONLY if you enable full HTML template *Default : `MOLPay Malaysia Online Payment Gateway`



`setDebug( params )`
- `params` | boolean | Debug the library. ONLY enable when in development *Default : `false`



`setTemplate( params )`
- `params` | boolean | Send params true to enable full HTML template. *Default : `false`



`trigger()`
- Validate the property and generate the HTML markup. This method cannot be chain. (Terminal) | return string



`checkReturn()`
- Check if the page come from MOLPay return URL. if page was return from MOLPay return URL. The response data will be redirect to the Return URL define at `setReturnURL( params )` method. This method cannot be chain. | return void

