<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StockMaster React</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/react/main.jsx'])
</head>

<body class="antialiased">
    <div id="react-app"></div>
</body>

</html>