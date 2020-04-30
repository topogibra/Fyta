<body>
    <div id="page-container">
        <div id="content-wrap">
                @include('layouts.navbar')
                <form class="input-group w-auto mt-1 rounded-pill border border-dark navbar-search" action ="/search" method="GET">
                    <span class="input-group-append">
                        <button type="submit" class="btn border border-right-0" >
                            <i aria-hidden="true" class="fas fa-search form-control-feedback"></i>
                            Submit the search
                        </button>
                    </span>
                    <label for="query">Search for a product...</label>
                    <input class="form-control border-left-0" type="text" id="query" name="query" placeholder="Search for a product...">
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