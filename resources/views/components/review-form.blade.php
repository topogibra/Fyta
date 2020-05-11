@if(User::checkUser() == User::$CUSTOMER)
  @foreach(Auth::user()->getProcessedOrders($id) as $key=>$order)
    @if($key == 0)
      <div class="row" id="review-form-row">
        <div class="col-12" id="review-title-form">
          <h3> Enter your review </h3>
        </div>
        <form action="/review" id="review-form" class="col" method="post">
          <input type="hidden" name="id_product" id="id_product" value={{ $id }}>
          <div class="review-stars">
            <p>Rating:</p>
            <div class="stars" id="review-form-stars">
              <i class="fas fa-star star clicked"></i>
              @for($i = 0; $i < 4; $i++)
                <i class="far fa-star star"></i>
              @endfor
            </div>
          </div>
          <select class="custom-select custom-select-sm" name="id_order" id="select-order-Id" required>
            <option selected value="" class="text-muted optionplaceholder" hidden>Select Order</option>
    @endif
    <option value={{ $order->id }}> {{ $order->shipping_id }} at {{ $order->order_date }} </option>
    @if($key == 0)
      </select>
      <div class="form-group">
        <textarea class="review-input-text form-control" name="review-form-text" id="reviewDescription" rows="5"
          cols="1000" placeholder="Enter your review..." required></textarea>
      </div>
      @include('components.errors')
      <div id="submit-button">
        <input type="submit" class="btn btn-success pr-3" id="submit-review" value="Submit Review">
      </div>
      @csrf
      </form>
      </div>
    @endif
  @endforeach
@endif