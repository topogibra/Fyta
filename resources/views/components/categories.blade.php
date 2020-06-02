
  <h5>Categories</h5>
  <ul id="categories" class="list-group list-group-flush">
    @each('components.search_categories', $categories, 'category')
  </ul>
  <h5>Size</h5>
  <ul id="sizes" class="list-group list-group-flush">
      @each('components.search_sizes', $sizes, 'size')
  </ul>
  <div class="price">
    <h5>Price Range</h5>
    <div class="row price-values">
      <div class="col-5 min">
        <p>1€</p>
      </div>
      <div class="col-5 max">
        <p>100€</p>
      </div>
    </div>
    <div class="row price-inputs">
      <div class="col-5 min-input">
        <label for="min">Minimum Price:</label>
        <input type="number" class="form-control" id="min" placeholder="1" min="1" max="99">
      </div>
      <div class="col-5 max-input">
        <label for="max">Maximum Price:</label>
        <input type="number" class="form-control" id="max" placeholder="100" min="2" max="100">
      </div>
    </div>
  </div>
