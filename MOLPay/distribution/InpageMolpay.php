<?php

/**
 * MOLPay Inpage-Payment library.
 * This library is used to construct inpage payment for MOLPay merchant only.
 * It cannot be used for other than payment page.
 * 
 * @author MOLPay Technical <technical@molpay.com>
 * @copyright (c) 2013, MOLPay Technical
 * @example example/full_template.php Example how to implement this library
 * @license http://MOLPay.com (c)
 * @version 1.0.0
 * @todo Convert to PSR standard
 * 
 */

namespace MOLPay\distribution;

class InpageMolpay {
    
    public  $merchantID,
            $orderID,
            $amount,
            $bill_name,
            $bill_email,
            $bill_mobile,
            $bill_description,
            $country,
            $vcode,
            $currency,
            $langcode,
            $page_title,
            $debugging,
            $fullHTML,
            $returnURL,
            $payment_type;
    
    private $_minAmount,
            $_molpayURL,
            $_virtualURL;
    
    /**
     * Construct MOLPay inpage class
     * 
     * @return \MOLPay\distribution\InpageMolpay
     */
    function __construct() {
        $this->_minAmount = 1.10;
        $this->_molpayURL = 'https://www.onlinepayment.com.my/MOLPay/pay/';
        $this->page_title = 'MOLPay Malaysia Online Payment Gateway';
        $this->debugging = false;
        $this->fullHTML = false; 
        $this->page_title = 'MOLPay Malaysia Online Payment Page';
        $this->_virtualURL = $this->defaultReturn();
        $this->country = 'MY';
        $this->currency = 'MYR';
        $this->langcode = 'en';
        $this->payment_type = '';
        return $this;
    }
    
    /**
     * Set the Merchant ID
     * 
     * @param string $merchantID Merchant Identity name
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setMerchantID( $merchantID ) {
        $this->merchantID = $merchantID;
        return $this;
    }
    
    /**
     * Set the Order Number/Indentifier for the transaction
     * 
     * @param string $orderID Order identifier for the transaction
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setOrderID( $orderID ) {
        $this->orderID = $orderID;
        return $this;
    }
    
    /**
     * Define total amount of the transaction
     * 
     * @param double $amount Full amount of the transaction
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setAmount( $amount ) {
        $this->amount = $amount;
        return $this;
    }
    
    /**
     * Define the buyer details of the transaction
     * 
     * @param array $buyer Buyer details in array bill_name, bill_email, bill_mobile, bill_description
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setBuyerDetails( $buyer ) {
        $this->bill_name = (isset($buyer['bill_name']))? $buyer['bill_name'] : null;
        $this->bill_email = (isset($buyer['bill_email']))? $buyer['bill_email'] : null;
        $this->bill_mobile = (isset($buyer['bill_mobile']))? $buyer['bill_mobile'] : null;
        $this->bill_description = (isset($buyer['bill_description']))? $buyer['bill_description'] : null;
        return $this;
    }
    
    /**
     * Define the country where the transaction were made
     * 
     * @param string $country country format name. Please refer MOLPay API
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setCountry( $country ) {
        $this->country = $country;
        return $this;
    }
    
    /**
     * Define the return URL after the transaction have been done in MOLPay
     * 
     * @param string $returnURL Return URL after the payment successfully done
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setReturnURL( $returnURL ) {
        $this->returnURL = $returnURL;
        return $this;
    }
    
    /**
     * Define the generated Verification Code (vCode) for better security.
     * 
     * @param string $vcode Verification code to prevent eavesdropping and security issues
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setVcode( $vcode ) {
        $this->vcode = $vcode;
        return $this;
    }
    
    /**
     * Define the currency format in the transaction
     * 
     * @param string $currency Currency format that shall be use in the transaction
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setCurrency( $currency ) {
        $this->currency = $currency;
        return $this;
    }
    
    /**
     * Define the standard language code |en|cn
     * 
     * @param string $langcode Language code that shall be used
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setLanguageCode( $langcode ) {
        $this->langcode = $langcode;
        return $this;
    }
    
    /**
     * Set the page title in the Inpage payment. Only if full template is enabled
     * 
     * @param string $page_title The page title
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setPageTitle( $page_title ) {
        $this->page_title = $page_title;
        return $this;
    }
    
    /**
     * Set if debugging is needed
     * 
     * @param boolean $debug If debugging purpose is needed
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setDebug( $debug ) {
        if(is_bool( $debug ))
            $this->debugging = $debug;
        return $this;
    }
    
    /**
     * Set if output need a full HTML template
     * 
     * @param boolean $full_HTML If need a full HTML template output
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setTemplate( $full_HTML ) {
        if(is_bool( $full_HTML ))
            $this->fullHTML = $full_HTML;
        return $this;
    }
    
    /**
     * Define the payment method gateway
     * 
     * @param string $payment_method
     * @return \MOLPay\distribution\InpageMolpay
     */
    function setPaymentMethod( $payment_method ) {
        $this->payment_type = $payment_method;
        return $this;
    }
    
    /**
     * Generate the HTML markup/template for MOLPay In-page payment. Act as terminal method
     * 
     * @return string
     */
    function trigger() {
        return $this->validate()? $this->masterTemplate() : $this->errorTemplate();
    }
    
    /**
     * Check if the page was loaded after returning from MOLPay domain.
     * Bind the reponse param to the parent form and submit it to the real return URL
     * 
     */
    function checkReturn() {
        if(isset($_REQUEST['tranID']) && isset($_REQUEST['domain']) && isset($_REQUEST['skey'])) {
            $error_code = (isset($_REQUEST['error_code']))? $_REQUEST['error_code'] : '';
            $error_desc = (isset($_REQUEST['error_desc']))? $_REQUEST['error_desc'] : '';
            echo '<html><body>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    window.top.document.getElementById("amount").value="' . $_REQUEST['amount'] . '";
                    window.top.document.getElementById("orderid").value="' . $_REQUEST['orderid'] . '";
                    window.top.document.getElementById("appcode").value="' . $_REQUEST['appcode'] . '";
                    window.top.document.getElementById("tranID").value="' . $_REQUEST['tranID'] . '";
                    window.top.document.getElementById("domain").value="' . $_REQUEST['domain'] . '";
                    window.top.document.getElementById("status").value="' . $_REQUEST['status'] . '";
                    window.top.document.getElementById("error_code").value="' . $error_code . '";
                    window.top.document.getElementById("error_desc").value="' . $error_desc . '";
                    window.top.document.getElementById("currency").value="' . $_REQUEST['currency'] . '";
                    window.top.document.getElementById("paydate").value="' . $_REQUEST['paydate'] . '";
                    window.top.document.getElementById("channel").value="' . $_REQUEST['channel'] . '";
                    window.top.document.getElementById("skey").value="' . $_REQUEST['skey'] . '";
                    parent.molpayCloseFrames();
                });
            </script></body></html>';
            exit();
        }
    }
    
    /**
     * Validate the attribute before going further
     * 
     * @access private
     * @return boolean Validation status
     */
    private function validate() {
        if( is_null($this->merchantID) ||
            is_null($this->orderID) || 
            is_null($this->amount) || 
            is_null($this->bill_name) || 
            is_null($this->bill_email) || 
            is_null($this->bill_mobile) || 
            is_null($this->returnURL) || 
            is_null($this->vcode) || 
            is_null($this->country) || 
            is_null($this->currency) || 
            is_null($this->langcode) || 
            $this->amount < $this->_minAmount ||
            !is_double($this->amount))
            return false;
        else
            return true;
    }
    
    /**
     * Define the hidden HTML form to grab the reponse parameter after redirect from MOLPay domain
     * 
     * @return string The HTML markup for hidden fields
     */
    private function hiddenForm() {
        return '
            <form id="molpayresubmitform" action="' . $this->returnURL . '" method="POST">
                <input type="hidden" name="amount" id="amount" />
                <input type="hidden" name="orderid" id="orderid" />
                <input type="hidden" name="appcode" id="appcode" />
                <input type="hidden" name="tranID" id="tranID" />
                <input type="hidden" name="domain" id="domain" />
                <input type="hidden" name="status" id="status" />
                <input type="hidden" name="error_code" id="error_code" />
                <input type="hidden" name="error_desc" id="error_desc" />
                <input type="hidden" name="currency" id="currency" />
                <input type="hidden" name="paydate" id="paydate" />
                <input type="hidden" name="channel" id="channel" />
                <input type="hidden" name="skey" id="skey" />
            </form>
        ';
    }
    
    /**
     * Define the master HTML template
     * 
     * @return string Main HTML markup template
     */
    private function masterTemplate() {
        $css = '<style>' . $this->cssCode() . '</style>';
        $iframes = '<div id="molpay-dialog-overlay"></div>
                    <div id="molpay-dialog-box">
                        <div>
                            <iframe id="molpayframe" frameborder="0" seemless src="' . $this->iframeURL() . '"></iframe>
                        </div>
                        ' .  $this->hiddenForm() . '
                    </div>
                    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
                    <script>
                        function molpayCloseFrames(){
                            jQuery( "#molpayframe" ).remove();
                            jQuery( "#molpayresubmitform" ).submit();
                       }
                    </script>';
        // For full HTML markup template
        if($this->fullHTML) {
            return '<!DOCTYPE html>
            <html>
                <head>
                    <title>' . $this->page_title . '</title>
                    ' . $css . '
                </head>
                <body>
                    This shall display at the back of the dialog. In lower opacity
                    ' . $iframes . '
                </body>
            </html>';
        }
        // For injection HTML markup template
        else {
            return $css . $iframes;
        }
    }
    
    /**
     * Define the error HTML markup template
     * 
     * @return string HTML markup for error display template
     */
    private function errorTemplate() {
        return '<!DOCTYPE html>
            <html>
                <head>
                    <title>Error during processing your payment</title>
                    <style>' . $this->cssCodeFail() . '</style>
                </head>
                <body>
                    <div class="error">
                        Opppsss.. There was an error occur during processing your payment.<br />Hope you can notify the administrator about this error.
                    </div>
                </body>
            </html>';
    }
    
    /**
     * Generate the iFrame URL base on given attribute
     * 
     * @return string The URL to online payment page with params
     */
    protected function iframeURL() {
        $url = array(
            'amount' => $this->amount,
            'orderid' => $this->orderID,
            'bill_desc' => $this->bill_description,
            'bill_name' => $this->bill_name,
            'bill_email' => $this->bill_email,
            'bill_mobile' => $this->bill_mobile,
            'vcode' => $this->vcode,
            'cur' => $this->currency,
            'langcode' => $this->langcode,
            'returnurl' => $this->_virtualURL
        );
        $payment_methods = (strlen($this->payment_type) > 0)? '/' . $this->payment_type : '/';
        return $this->_molpayURL . $this->merchantID . $payment_methods . '?' . http_build_query($url);
    }
    
    /**
     * The define minify CSS code for master template
     * 
     * @return string The minify CSS code
     */
    protected function cssCode() {
        return 'body{overflow: hidden;}#molpay-dialog-overlay{width:100%;height:100%;filter:alpha(opacity=70);-moz-opacity:.7;-khtml-opacity:.7;opacity:.7;background:#000;position:fixed;top:0;left:0;z-index:3000}#molpay-dialog-box{width:90%;height:99%;position:absolute;left:0;right:0;top:0;margin:5px auto;z-index:5000}#molpay-dialog-box div{height:100%;margin:0 auto;max-width:765px;background:#fff}iframe{border-radius:5px;-webkit-border-radius:5px;border:0;width:100%;height:100%}::-webkit-scrollbar{width:11px;height:11px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-track-piece{background:transparent}::-webkit-scrollbar-thumb{background:#ccc;border-radius:5px;-webkit-border-radius:5px}::-webkit-scrollbar-thumb:hover{background:#aaa;border-radius:5px;-webkit-border-radius:5px}';
    }
    
    protected function cssCodeFail() {
        return 'body{background:#efebeb;font-family:Optima,Segoe,“Segoe UI”,Candara,Calibri,Arial,sans-serif;font-size:14px}.error{margin:20px auto;max-width:430px;border:4px solid #ccc;padding:15px;background-color:#fff;-webkit-border-radius:10px;border-radius:10px;text-align:center}';
    }
    
    /**
     * Define the path to this scripting for MOLPay to return properly to this page
     * 
     * @return null | string The generated URL to this page
     */
    protected function defaultReturn() {
        $return = (isset($_SERVER['REQUEST_SCHEME']))? $_SERVER['REQUEST_SCHEME'] . '://' : 'http://';
        if(isset($_SERVER['SERVER_NAME']))
            $return .= $_SERVER['SERVER_NAME'];
        else
            return null;
        if(isset($_SERVER['REQUEST_URI']))
            $return .= $_SERVER['REQUEST_URI'];
        
        return $return;
    }
}
