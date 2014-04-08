(function($) {
    $.fn.molpay = function( options ) {
                        
        //Define the default value
        var settings = $.extend({
            merchantID : null,
            orderID : null,
            amount : null,
            bill_name : null,
            bill_email : null,
            bill_mobile : null,
            bill_desc : null,
            country : null,
            returnURL : null,
            vcode: null,
            cur: null,
            langcode: null,
            debug: false,           
        }, options);
        
        //Master configuration 'Cannot be done by user'
        var conf = {
            min_amount: 1.10,
            molpay_url: 'https://www.onlinepayment.com.my/MOLPay/pay/',
            returnURL: location.href
        };
        
        //If debug is needed
        if(settings.debug) {
            settings.merchantID = 'molpaytech';
            settings.orderID = 'DEMO1536';
            settings.amount = 1.10;
            settings.country = 'MY';
            settings.vcode = '0d72ceec9ee3848f4721697f5dca166e';
            settings.cur = 'MYR';
            settings.langcode = 'en';
            console.info('Setting object : \n', settings);
        }
        
        //Avaliable method inside this function
        $.methods = {
            isDebug: function( message, type ) {
                type = typeof type !== 'undefined' ? type : 'log';
                if(settings.debug) {
                    if(type == 'log')
                        console.log(message);
                    else if(type == 'time')
                        console.time(message);
                    else
                        console.timeEnd(message);
                }
            },
            validates: function( data, message ) {
                if(data == null || data.length < 1) {
                    console.error(message);
                    return false;
                }
                return true;
            },
            validate: function() {
                var checking = true;
                checking = checking && $.methods.validates( settings.merchantID, 'The merchant ID is required!' );
                checking = checking && $.methods.validates( settings.orderID, 'The order ID is required!' );
                checking = checking && $.methods.validates( settings.amount, 'The amount is required!' );        
                checking = checking && $.methods.validates( settings.bill_name, 'The bill name is required!' );
                checking = checking && $.methods.validates( settings.bill_email, 'The bill email is required!' );
                checking = checking && $.methods.validates( settings.bill_desc, 'The bill description is required!' );
                checking = checking && $.methods.validates( settings.vcode, 'The Verfication code is required!' );
                checking = checking && $.methods.validates( settings.cur, 'The currency is required!' );
                checking = checking && $.methods.validates( settings.returnURL, 'The return URL is required!' );
                if(settings.cur === 'MYR')
                    checking = checking && $.methods.amountvalidate( settings.amount, 'The amount must greater than ' + settings.cur + conf.min_amount + '!' );
                return checking;
            },
            amountvalidate: function( amount, message ) {
                amount = parseFloat(amount);
                if(amount < conf.min_amount) {
                    console.error(message);
                    return false;
                }
                return true;
            },
            makedialog: function( element ) {
                $.methods.isDebug('Create dialog element', 'time');
                var dialog = '<div id="molpay-dialog-overlay"></div>';
                dialog += '<div id="molpay-dialog-box"><div>';
                dialog += $.methods.generateiframe();
                dialog += '</div></div>';
                dialog += $.methods.generatehiddenfields();
                element.append( dialog );
                element.css('overflow-y', 'hidden');
                $('#molpay-dialog-overlay,#molpay-dialog-box').css('display', 'inline');
                $.methods.isDebug('Create dialog element', 'end');
            },
            generateiframe: function() {
                var src = conf.molpay_url + settings.merchantID + '/?';
                src += 'amount=' + settings.amount + '&';
                src += 'orderid=' + settings.orderID + '&';
                src += 'bill_desc=' + settings.bill_desc + '&';
                src += 'bill_name=' + settings.bill_name + '&';
                src += 'bill_email=' + settings.bill_email+ '&';
                src += 'bill_mobile=' + settings.bill_mobile + '&';
                src += 'vcode=' + settings.vcode + '&';
                src += 'cur=' + settings.cur + '&';
                src += 'langcode=' + settings.langcode + '&';
                src += 'returnurl=' + conf.returnURL + '&';
                return '<iframe id="molpayframe" frameborder="0" seemless src="' + src + '"></iframe>';
            },
            generatehiddenfields: function() {
                var fields = '<form id="molpayresubmitform" action="' + settings.returnURL + '" method="POST">';
                fields += '<input type="hidden" name="amount" id="amount" />';
                fields += '<input type="hidden" name="orderid" id="orderid" />';
                fields += '<input type="hidden" name="appcode" id="appcode" />';
                fields += '<input type="hidden" name="tranID" id="tranID" />';
                fields += '<input type="hidden" name="domain" id="domain" />';
                fields += '<input type="hidden" name="status" id="status" />';
                fields += '<input type="hidden" name="error_code" id="error_code" />';
                fields += '<input type="hidden" name="error_desc" id="error_desc" />';
                fields += '<input type="hidden" name="currency" id="currency" />';
                fields += '<input type="hidden" name="paydate" id="paydate" />';
                fields += '<input type="hidden" name="channel" id="channel" />';
                fields += '<input type="hidden" name="skey" id="skey" />';
                fields += '</form>';                
                return fields;
            }
        }
        
        var value = $.methods.validate();
        
        if(value)
            $.methods.makedialog(this);
        
    }
}(jQuery));

molpay_is_return = function( amount, orderid, appcode, tranID, domain, status, err_code, err_desc, currency, paydate, channel, skey ) {
    $(document).ready(function() {
        window.top.document.getElementById("amount").value = amount;
        window.top.document.getElementById("orderid").value = orderid;
        window.top.document.getElementById("appcode").value = appcode;
        window.top.document.getElementById("tranID").value = tranID;
        window.top.document.getElementById("domain").value = domain;
        window.top.document.getElementById("status").value = status;
        window.top.document.getElementById("error_code").value = err_code;
        window.top.document.getElementById("error_desc").value = err_desc;
        window.top.document.getElementById("currency").value = currency;
        window.top.document.getElementById("paydate").value = paydate;
        window.top.document.getElementById("channel").value = channel;
        window.top.document.getElementById("skey").value = skey;
        parent.molpayCloseFrames();
    });
};
molpayCloseFrames = function() {
    jQuery( "#molpayframe" ).remove();
    jQuery( "#molpayresubmitform" ).submit();
}