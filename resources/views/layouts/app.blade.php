<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fytá - Feel the Flower Power</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
    <script src="https://kit.fontawesome.com/ac3e82986f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link href={{ asset('css/styles.css') }} rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src= {{ asset('js/jquery-3.4.1.slim.min.js') }} type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src= {{ asset('js/bootstrap.min.js') }} type="module"></script>
    <script src= {{ asset('js/navbar.js') }} type="module"></script>
    @foreach ($scripts as $script)
     <script src={{ asset($script) }} type="module"></script>   
    @endforeach
    @foreach ($styles as $style)
     <link href={{ asset($style) }} rel="stylesheet">   
    @endforeach
</head>
@include('layouts.app_body')
</html>
