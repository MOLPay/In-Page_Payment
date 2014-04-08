<!--
    Display the return result. 
    This page should be where the real return url to process the transaction result at merchant side
-->
<html>
    <head>
        <title>Example site : Return value</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>
        <div class="topic-header">
            <h2>This is the return value from MOLPay</h2>
        </div>
        <pre>
            <?= print_r($_REQUEST, true); ?>
        </pre>        
    </body>
</html>