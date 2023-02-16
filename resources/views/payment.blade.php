<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="SB-Mid-client-DafhZZgwaUKeiMzG"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
</head>

<body>
<button id="pay-button">Pay!</button>

<form action="/payment" id="submit_form" method="post">
    @csrf
    <input type="hidden" name="json" id="json_callback">
</form>

<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{$snap_token}}', {
            onSuccess: function(result){
                /* You may add your own implementation here */
                alert("payment success!"); console.log(result);
            },
            onPending: function(result){
                /* You may add your own implementation here */
                alert("wating your payment!"); console.log(result);
            },
            onError: function(result){
                /* You may add your own implementation here */
                alert("payment failed!"); console.log(result);
            },
            onClose: function(){
                /* You may add your own implementation here */
                alert('you closed the popup without finishing the payment');
            }
        })
    });
</script>
</body>
</html>

