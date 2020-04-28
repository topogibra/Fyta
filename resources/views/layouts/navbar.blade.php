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
                <a class="nav-link" href="/search?section=Indoor">Indoor</a>
            </li>
            <li class="nav-item  divider">
                <a class="nav-link" href="/search?section=Outdoor">Outdoor</a>
            </li>
            <li class="nav-item  divider">
                <a class="nav-link" href="/search?section=Vases">Vases</a>
            </li>
            <li class="nav-item  divider">
                <a class="nav-link" href="/search?section=Tools">Tools</a>
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