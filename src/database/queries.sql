-- Product query  of clASs bASed on Tag (Homepage)
--SELECT01
--nome,imagem,preco
SELECT "name",price,"path" AS image_path, "image"."description" AS image_alt
FROM product,tag,product_tag,product_image,"image"
WHERE tag = $tag AND product.id = product_tag.id_product AND
    tag.id = product_tag.id_tag AND product_image.id_product = product.id
    AND product_image.id_image = "image".id
ORDER BY "name";

-- Product query bASed on id (Product page)
--SELECT02
SELECT "name",product."description" AS details,price,"path" AS image_path,"image"."description" AS image_alt
FROM product, "image", product_image
WHERE product.id = $id AND product_image.id_product = product.id 
    AND product_image.id_image = "image".id;

-- Reviews retrival query bASed on product id (Product page)
--SELECT03
SELECT review."description" AS contents, rating, review_date, username, "path" AS image_path, "image"."description" AS image_alt 
FROM review,product_order,order,user,"image"
WHERE review.id_product = $id AND review.id_order = product_order.id_order
    AND product_order.id_product = $id AND product_order.id_order = order.id
    AND order.id_user = user.id AND user.id_image = "image".id
ORDER BY review_date DESC;

-- Tags retrieve query (Search page)
--SELECT04
SELECT "name" AS tag
FROM Tags

-- Products retrive query bASed on tag (Search page)
--SELECT05
SELECT product."name" AS product_name , price, "path" AS image_path, "image".description AS image_alt
FROM product,tag,product_tag,product_image,"image"
WHERE tag.id = $id AND product_tag.id_tag = $id
    AND product_tag.id_product = product.id AND product_image.id_product = product.id
    AND product_image.id_image = image.id
ORDER BY product_name;

-- Customer information retrieval query (Profile page)
--SELECT06
SELECT username, email, "date", "path" AS image_path, "description" AS image_alt
FROM user,"image"
WHERE user.id = $id AND user.user_role = 'Customer'
    user.id_image = "image".id;

-- Order History collection bASed on user id (Order History page)
--SELECT07
SELECT shipping_id, order_status, order_date
FROM order,order_history
WHERE order.id_user = $id AND order_history.id_order = order.id
ORDER BY order_date DESC;

-- Wishilist AND size retrieval bASed on user id(Wishlist page)
--SELECT08
SELECT "name", COUNT(id_product) AS size
FROM wishlist, wishlist_product
WHERE wishlist.id_user = $id 
AND wishlist_product.id_wishlist = wishlist.id

--Shopping cart bASed information bASed on user id(shopping cart page)
--SELECT09
SELECT product.name AS product_name, "image"."path" AS image_path, product.price AS product_price, quantity
FROM shopping_cart, product, "image", product_image
WHERE shopping_cart.id_user = $id AND 
      product_image.id_product = product.id AND
      "image".id = product_image.id_image AND
      product.id = shopping_cart.id_product;


-- Product query for order summary
--SELECT10.1
SELECT "name",price,"path" AS image_path, "image"."description" AS image_alt
FROM product,order,product_image,"image",product_order
WHERE product.id = product_order.id_product 
      AND product_order.id_order = order.id 
      AND product_image.id_product = product.id
      AND product_image.id_image = "image".id
ORDER BY "name";

-- Product query for order summary
--SELECT10.2
SELECT "address", username, order_status
FROM user, order, order_history
WHERE user.id = order.id_user 
      AND order.id = order_history.id_order

--Retrieve information for manager 
--SELECT11
SELECT username,email
FROM user
WHERE user.user_role = "Manager" AND user.id = $id

--Retrieve stock information about products
--SELECT12
SELECT "name" AS product_name, price, stock
FROM product

--Retrieve pending orders
--SELECT13
SELECT shipping_id,order_date,order_status
FROM order, order_history
WHERE order.id = order_history.id_order

--Retrieve information FROM all the managers
--SELECT14
SELECT "image"."path" AS image_path, username, "date" AS created_at
FROM "image", user
WHERE "image".id = user.id_image




