<div class="order-summary ">
    <div class="row summary-header">
        <h3 class="col-6 text-nowrap">Order Summary</h3>
        <div class="order-status col-6 row justify-content-center ">
            <p class="font-weight-bold text-nowrap">Order Status:</p>
            <p class="status font-weight-normal">{{$status->status}}</p>
        </div>
    </div>
    <div class="container summary">
        <div class="row header justify-space-around">
            <div class="col-md-5 col-sm-6 order-ref text-left">
                <p class="order-id font-weight-bold text-nowrap">Order #{{$information->shipping_id}}</p>
                <div class="order-placed row">
                    <p class="text-nowrap">Placed on:</p>
                    <p class="order-date font-weight-bold text-nowrap">{{$information->date}}</p>

                </div>
            </div>
            <div class="col-md-6 col-sm-6 deliver-address">
                <p class="font-weight-bold ">Deliver to:</p>
                <p class="order-recipient">{{$information->name}}</p>
                <p class="order-address">{{$information->address}}</p>
                <p class="order-location ">{{$location}}</p>
            </div>
        </div>
        @each('components.order_item', $items, 'item')
        <div class="delivery-fee row justify-content-end">
            <p class="text-right">Delivery:</p>
            <p class="fee text-right">{{$delivery}}</p>
        </div>
        <div class="order-total row justify-content-end ">
            <p class="total text-right">Total Value:</p>
            <p class="total-value text-right">{{$sum}} €</p>
        </div>
    </div>
    @if ($buttons)
        <div class="row buttons lg-content-between sm-space-around">
        <a href="/payment-details" type="button" id="back-btn" class="btn rounded-0 btn-lg shadow-none">Back</a>
        <a href="/home" type="button" id="next-btn" class="btn rounded-0 btn-lg shadow-none">Finish</a>
    </div>
    @endif
</div>