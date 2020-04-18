<section class="container">
    <div class="row product-section">
        <div class="col-md product-img ">
            @yield('img')
        </div>
        @hasSection ('header')
            <div class="col-md">          
                <div class="container title">
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