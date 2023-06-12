<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<form action="/payment" method="GET">
    <div class="wrap">
        <input type="text" placeholder="id_user" name="id_user" required>
        <div class="bar">
            <i></i>
        </div>
        <input type="text" placeholder="game_id" name="game_id" required>
        <div class="bar">
            <i></i>
        </div>
        <input type="text" placeholder="item_id" name="item_id" required>
        <div class="bar">
            <i></i>
        </div>
        <input type="text" placeholder="harga" name="harga" required>
        <div class="bar">
            <i></i>
        </div>

        <button type="submit">next</button>
    </div>
</form>
@if(session('alert-success'))
    <script>alert("{{session('alert-success')}}")</script>
@elseif(session('alert-failed'))
    <script>alert("{{session('alert-failed')}}")</script>
@endif
</body>
</html>
