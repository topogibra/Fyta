<section class="container">
    <form action="/manager/sale" id="sales-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method($method)
        @yield('sales-page-content')
    </form>
</section>