<section class="container">
    <div class="row product-section">
        <div class="col-lg-5 col-md-6  product-img ">
            @yield('img')
        </div>
        @hasSection ('header')
            <div class="col-lg-7 col-md-6 ">          
                <div class="title">
                    <div class="row justify-content-between ">
                        @yield('header')
                    </div>
                    @yield('price')
                    <div id="description" class="row">
                        @yield('description')
                    </div>
                    @hasSection ('product-content')
                        @yield('product-content')
                    @endif
                </div>
            </div>
        @endif
    </div>
    @hasSection ('product-page-content')
        @yield('product-page-content')
    @endif
</section>