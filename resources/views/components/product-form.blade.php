<form action="/product" method="POST" enctype="multipart/form-data" id="productForm">
    @csrf
    @method($method)
    @include('components.product-page')
</form>
