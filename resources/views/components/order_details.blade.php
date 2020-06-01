<div class="order-summary ">
    <div class="row summary-header">
        <h3 class="col title text-nowrap">Order Summary</h3>
    </div>
    <div class="container summary">
        <div class="row header justify-space-around">
            <div class="col-md-7 col-sm-6 order-ref text-left">
                <p class="order-id font-weight-bold text-nowrap">Order #{{ $information->shipping_id }}</p>
                <div class="order-placed row">
                    <p class="text-nowrap">Placed on:</p>
                    <p class="order-date font-weight-bold text-nowrap">{{ $information->date }}</p>
                </div>
                <div class="order-status row">
                <p class="font-weight-bold text-nowrap">Order Status:</p>
                    <p class="status font-weight-normal text-nowrap">{{$status->status}}</p>
                </div>
            </div>
            <div class="col-md-5 col-sm-6 payment-method">
                @if($information->payment === 'Bank_Transfer')
                    <p class="bank-entity text-nowrap"><span class="font-weight-bold"> Entity: </span> 11496 </p>
                    <p class="bank-reference text-nowrap"> <span class="font-weight-bold"> Bank Reference: </span> {{ intdiv(intval($information->shipping_id,26),pow(10,9)) }}</p>
                @endif
            </div>
            <div class="row order-info">
                <div class="col">
                    <p class="order-recipient"><span class="font-weight-bold "> Deliver to:</span> {{ $information->name }}</p>
                    <p class="order-address"> <span class="font-weight-bold ">Delivery Address: </span> {{ $information->address }}</p>
                    <p class="order-location "> <span class="font-weight-bold "> Billing Address: </span> {{ $information->billing }}</p>
                </div>
            </div>
        </div>
        <div class="products-list">
        @each('components.order_item', $items, 'item')
        </div>
        <div class="delivery-fee row justify-content-end">
            <p class="text-right">Delivery:</p>
            <p class="fee text-right">{{$delivery}}</p>
        </div>
        <div class="order-total row justify-content-end ">
            <p class="total text-right">Total Value:</p>
            <p class="total-value text-right">{{ $sum }} €</p>
        </div>
    @if($buttons)
        <div class="row buttons sm-space-around justify-content-end" id="next-btn-row">
            <a href="/home" id="back-btn" class="btn rounded-0 btn-lg shadow-none">Back to Home</a>
        </div>
    @endif
</div>
</div>