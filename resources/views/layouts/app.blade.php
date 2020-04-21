<!DOCTYPE html>
<html>
<head>
    <title>Fytá - Feel the Flower Power</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/ac3e82986f.js" crossorigin="anonymous"></script>
    <link href={{ asset('css/styles.css') }} rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src= {{ asset('js/navbar.js') }} type="module"></script>
    @foreach ($scripts as $script)
     <script src={{ asset($script) }} type="module"></script>   
    @endforeach
    @foreach ($styles as $style)
     <link href={{ asset($style) }} rel="stylesheet">   
    @endforeach
</head>

<body>
    <div id="page-container">
        <div id="content-wrap">
            <nav class="navbar-wrapper navbar navbar-expand-md">
                <a class="navbar-brand" href="/home">
                    <img src={{ asset("img/logo.png") }} alt="Company Logo">
                </a>
                
                <nav class="navbar navbar-expand-lg navbar-light navbar-icons">
                @auth  
                    @if (User::checkUser() === User::$CUSTOMER)
                        <a href="/profile" class="user">
                            <i class="far fa-user"></i>
                        </a>
                        <a href="/cart" class="cart">
                            <i class="fas fa-shopping-basket"></i>
                        </a>
                    
                    @else
                        <a href="/manager" class="user">
                            <i class="far fa-user"></i>
                        </a>
                        <a href="/product/add" class="star">
                            <i class="far fa-plus-square"></i>
                        </a>
                    @endif      
                @endauth
                @guest
                    <a href="/login" class="login">
                        <i class="fas fa-user"></i>
                    </a>
                @endguest
                </nav>
                <nav class="navbar navbar-expand-md navbar-light navbar-categories">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categoriesNavbar" aria-controls="categoriesNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon fas"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="categoriesNavbar">
                        <ul class="navbar-nav mt-2 mt-lg-0 mr-lg-4">
                            <li class="nav-item">
                                <a class="nav-link" href="/search">Indoor</a>
                            </li>
                            <li class="nav-item  divider">
                                <a class="nav-link" href="/search">Outdoor</a>
                            </li>
                            <li class="nav-item  divider">
                                <a class="nav-link" href="/search">Vases</a>
                            </li>
                            <li class="nav-item  divider">
                                <a class="nav-link" href="/search">Tools</a>
                            </li>
                            <li class="nav-item  divider">
                                <a class="nav-link" href="/search">Deals</a>
                            </li>
                        </ul>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col user">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="col star">
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                </nav>
                <form class="input-group w-auto mt-1 rounded-pill border border-dark navbar-search" action ="/search" method="GET">
                    <span class="input-group-append">
                        <button type="submit" class="btn border border-right-0" >
                            <i class="fas fa-search form-control-feedback"></i>
                        </button>
                    </span>
                    <input class="form-control border-left-0" type="text" name="query">
                </form>
            </nav>
            @yield('content')
            </div>
            <footer class="row ">
                <span id="copyright" class="align-self-center col-3 text-nowrap">Copyright &copy; Fytá</span>
                <div class="nav align-self-center col-3 offset-lg-2 ">
                    <a class="nav-item text-nowrap" href="/about" id="aboutus">About Us</a>
                    <a class="nav-item text-nowrap" href="#faqs" id="faqs">FAQs</a>
                    <a class="nav-item text-nowrap" href="#contactus" id="contacts">Contact Us</a>
                </div>
            </footer>
        </div>
    </body>
</html>
