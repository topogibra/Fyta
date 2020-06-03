<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Fytá - 
        @isset($title)
            {{$title}}
        @else
            Feel the Flower Power
        @endisset
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="57x57" href={{asset("img/apple-icon-57x57.png")}}>
    <link rel="apple-touch-icon" sizes="60x60" href={{asset("img/apple-icon-60x60.png")}}>
    <link rel="apple-touch-icon" sizes="72x72" href={{asset("img/apple-icon-72x72.png")}}>
    <link rel="apple-touch-icon" sizes="76x76" href={{asset("img/apple-icon-76x76.png")}}>
    <link rel="apple-touch-icon" sizes="114x114" href={{asset("img/apple-icon-114x114.png")}}>
    <link rel="apple-touch-icon" sizes="120x120" href={{asset("img/apple-icon-120x120.png")}}>
    <link rel="apple-touch-icon" sizes="144x144" href={{asset("img/apple-icon-144x144.png")}}>
    <link rel="apple-touch-icon" sizes="152x152" href={{asset("img/apple-icon-152x152.png")}}>
    <link rel="apple-touch-icon" sizes="180x180" href={{asset("img/apple-icon-180x180.png")}}>
    <link rel="icon" type="image/png" sizes="192x192"  href={{asset("img/android-icon-192x192.png")}}>
    <link rel="icon" type="image/png" sizes="32x32" href={{asset("img/favicon-32x32.png")}}>
    <link rel="icon" type="image/png" sizes="96x96" href={{asset("img/favicon-96x96.png")}}>    
    <link rel="icon" type="image/png" sizes="16x16" href={{asset("img/favicon-16x16.png")}}>
    <link rel="manifest" href={{asset("img/manifest.json")}}>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content={{asset("/ms-icon-144x144.png")}}>
    <meta name="theme-color" content="#ffffff">
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
