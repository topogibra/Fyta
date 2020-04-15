<form action="/product" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method)
    @include('components.product-page')
</form>