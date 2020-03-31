-- Insert New Image
INSERT INTO  "image" (img, "description")
    VALUES($img, $img_description);

-- Insert New Product
INSERT INTO product ("name", "description", price, stock, views)
    VALUES($product_name, $product_description, $price, $stock, $views);

-- Update a Product's Stock
UPDATE product
    SET stock = $stock
    WHERE id = $id;

-- Update a Product Price
UPDATE product
    SET price = $price
    WHERE id = $id;

-- Add New Image to product
INSERT INTO product_image (id_image, id_product)
    VALUES ($id_image, $id_product);

-- Add a New Order
INSERT INTO "order" (shipping_id, billing_address, delivery_address, order_date, payment_method, id_user)
    VALUES ($shipping_id, $billing_address, $delivery_address, $order_date, $payment_method, $id_user);

-- Associate a Product to an Order
INSERT INTO product_order (id_order, id_product, quantity)
    VALUES ($id_order, $id_product, $quantity);

-- Update Order Status
INSERT INTO order_history(date_begin, id_order, order_status)
    VALUES ($date_begin, $id_order, $order_status); 

-- Add a Review
INSERT INTO review (id_product, id_order, "description", rating, review_date)
    VALUES ($id_product, $id_order, $review_description, $rating, $review_date);

-- Update Review Description
UPDATE review
    SET "description" = $review_description
    WHERE id = $id;

-- Add a new Product to a Wishlist
INSERT INTO wishlist_product (id_product, id_wishlist)
    VALUES ($id_product, $id_wishlist);

-- Add a new product to the Shopping Cart 
INSERT INTO customer_product (id_customer, id_product, quantity)
    VALUES ($id_customer, $id_product, $quantity);

-- Modify a product's quantity in the Shopping Cart 
UPDATE customer_product 
    SET quantity = $quantity
    WHERE id_customer = $id_customer AND id_product = $id_product;

-- Create a discount
INSERT INTO discount ("value", date_begin, date_end)
    VALUES ($discount_value, $date_begin, $date_end);

-- Update a discount value
UPDATE discount
    SET "value" = $discount_value
    WHERE $id = id;

-- Apply discount to a product
INSERT INTO apply_discount (id_product, id_discount)
    VALUES($id_product, $id_discount);

-- Create a new tag
INSERT INTO tag ("name") VALUES ($tag_name);

-- Associate a product to a tag
INSERT INTO product_tag (id_tag, id_product) 
    VALUES ($id_tag, $id_product);

-- Delete a product
DELETE FROM product
    WHERE id = $id;

-- Deassociate a product to a discount
DELETE FROM product_tag
    WHERE id_discount = $id_discount AND id_product = $id_product;

-- Deassociate a product to a tag
DELETE FROM product_tag
    WHERE id_tag = $id_tag AND id_product = $id_product;