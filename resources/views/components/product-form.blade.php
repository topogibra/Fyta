<form action="/product" id="product-form" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method)
    @include('components.product-page')
</form>
