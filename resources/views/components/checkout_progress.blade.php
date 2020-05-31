
<div class="row justify-content-center" id="checkout-breadcrumb">
    <div class="col">
        <div class="row">
            <span class="bread-number 
            {{ $number == 1 ? 'bread-active' : '' }}
            ">1</span>
            <span class="bread-title">Order Details</span>
        </div>
    </div>
    <div class="col-1">
        <div class="row">
            <hr class="bread-separator">
        </div>
    </div>
    <div class="col">
        <div class="row">
            <span class="bread-number
            {{ $number == 2 ? 'bread-active' : '' }}
            ">2</span>
            <span class="bread-title">Payment</span>
        </div>
    </div>
    <div class="col-1">
        <div class="row">
            <hr class="bread-separator">
    </div>
    </div>
    <div class="col">
        <div class="row">
        <span class="bread-number 
            {{ $number == 3 ? 'bread-active' : '' }}
            ">3</span>
            <span class="bread-title">Confirm Order</span>
        </div>
    </div>
    <div class="col-1">
        <div class="row">
            <hr class="bread-separator">
        </div>
    </div>
    <div class="col">
        <div class="row">
            <span class="bread-number 
            {{ $number == 4 ? 'bread-active' : '' }}
            ">4</span>
            <span class="bread-title">Resume</span>
        </div>
    </div>
</div>