Notes for Inpage-payment
=========================

- In-page payment is using iframe to display the payment page. Any scripting at Online Payment Page that using javascript window.top or same function as that 
will not function properly and will cause error.

- It also make some redirection that using javascript not functioning properly due to it's on child window (iframe).

- Whenever buyer make a payment using FPX channel. The buyer need to click "check status" button due to multiple child window (Popup).

- It also will cause an "Unfriendly" UI at sandbox page due to poor scripting in sandbox page.

`more will be updated later`