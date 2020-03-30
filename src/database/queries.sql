-- Product query  of class bASed on Tag (Homepage)
--SELECT01
--nome,imagem,preco
SELECT product."name", price
FROM product, tag, product_tag
WHERE tag."name" = $tag_name 
    AND product.id = product_tag.id_product 
    AND tag.id = product_tag.id_tag 
ORDER BY views DESC LIMIT 4;

-- Get all images from a product (General)
--SELECT02
SELECT "path" AS product_image_path, "image"."description" AS image_alt
FROM product, product_image, "image"
WHERE product.id = $id
    AND product_image.id_product = product.id
    AND product_image.id_image = "image".id;

-- Product query based on id (Product page)
--SELECT03
SELECT "name", product."description" AS details, price
FROM product
WHERE product.id = $product_id;

-- Reviews retrival query based on product id (Product page)
--SELECT04
SELECT review."description" AS contents, rating, review_date, username, 
    "path" AS image_path, "image"."description" AS image_alt 
FROM review,product_order,"order","user","image"
WHERE review.id_product = $product_id 
    AND review.id_order = product_order.id_order
    AND product_order.id_product = $product_id 
    AND product_order.id_order = "order".id
    AND "order".id_user = "user".id 
    AND "user".id_image = "image".id
ORDER BY review_date DESC;

-- Tags retrieve query (Search page)
--SELECT05
SELECT "name" AS tag
FROM tag

-- Products retrive query based on tag (Search page)
--SELECT06
SELECT product."name" AS product_name, price
FROM product, tag, product_tag
WHERE tag.id = $tag_id 
    AND product_tag.id_tag = $tag_id
    AND product_tag.id_product = product.id 
ORDER BY views DESC;

-- Customer information retrieval query (Profile page)
--SELECT07
SELECT username, email, "date", 
    "path" AS image_path, "description" AS image_alt
FROM "user","image"
WHERE email = $email 
    AND "user".user_role = 'Customer' 
    AND "user".id_image = "image".id;

-- Order History collection bASed on user id (Order History page)
--SELECT08
SELECT shipping_id, order_status, order_date
FROM "order",order_history
WHERE "order".id_user = $user_id 
    AND order_history.id_order = "order".id
ORDER BY order_date DESC;

-- Wishilist and size retrieval bASed on user id(Wishlist page)
--SELECT09
SELECT wishlist."name", COUNT(id_product) AS size
FROM wishlist, wishlist_product
WHERE wishlist.id_user = $user_id 
    AND wishlist_product.id_wishlist = wishlist.id
GROUP BY wishlist."name"

--Shopping cart based information based on user id(shopping cart page)
--SELECT10
SELECT product.name AS product_name, product.price AS product_price, quantity
FROM shopping_cart, product
WHERE shopping_cart.id_user = $id AND 
      product.id = shopping_cart.id_product;

-- Product query for order summary
--SELECT11
SELECT "name",price, quantity
FROM product, product_order
WHERE product.id = product_order.id_product 
      AND product_order.id_order = $id;

-- Product query for order summary
--SELECT12
SELECT "order".delivery_address AS address, "order".order_date AS placed_at, username, order_status
FROM "user", "order", order_history
WHERE "order".id = $id
	  AND "user".id = "order".id_user 
      AND order_history.id_order = $id

--Retrieve information for manager 
--SELECT13
SELECT username,email
FROM "user"
WHERE "user".user_role = 'Manager' AND "user".id = $id ;


--Retrieve stock information about products
--SELECT14
SELECT "name" AS product_name, price, stock
FROM product
LIMIT 10 OFFSET 10*$i;

--Retrieve pending orders
--SELECT15
SELECT shipping_id,order_date,order_status
FROM "order", order_history
WHERE "order".id = order_history.id_order
	  AND (order_status = 'Ready_for_Shipping' OR order_status = 'Awaiting_Payment');

--Retrieve information FROM all the managers
--SELECT16
SELECT "image"."path" AS image_path, username, "date" AS created_at
FROM "image", "user"
WHERE "image".id = "user".id_image AND "user".user_role = 'Manager'

--Retrieve discounts valid in a given date
--SELECT17
SELECT "percentage", "name" AS product_name
FROM discount , product, "apply"
WHERE 
      discount.date_begin <= $"date"
      AND discount.date_end >= $"date"
      AND discount.id = apply.id_discount
      AND product.id = apply.id_product;

--Retrieve products based on a price range
--SELECT18
SELECT "name", product."description" AS details, price
FROM product
WHERE product.price > $price_min AND product.price < $price_max
LIMIT 10 OFFSET 10*$i;