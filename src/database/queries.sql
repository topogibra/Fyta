-- Product query  of class based on Tag (Homepage)
--SELECT01
--nome,imagem,preco
SELECT "name",price,"path" AS image_path, "image"."description" AS image_alt
FROM product,tag,product_tag,product_image,"image"
WHERE tag = $tag AND product.id = product_tag.id_product AND
    tag.id = product_tag.id_tag AND product_image.id_product = product.id
    AND product_image.id_image = "image".id
ORDER BY "name";

-- Product query based on id (Product page)
--SELECT02
SELECT "name",product."description",price,"path" as image_path,"image"."description" as image_alt
FROM product, "image", product_image
WHERE product.id = $id AND product_image.id_product = product.id 
    AND product_image.id_image = "image".id;

-- Reviews retrival query based on product id (Product page)
--SELECT03
SELECT review."description", rating, review_date, username, "path" as image_path, "image"."description" as image_alt 
FROM review,product_order,order,user,"image"
WHERE review.id_product = $id AND review.id_order = product_order.id_order
    AND product_order.id_product = $id AND product_order.id_order = order.id
    AND order.id_user = user.id AND user.id_image = "image".id
ORDER BY review_date DESC;

-- Tags retrieve query (Search page)
--SELECT04
SELECT "name" as tag
FROM Tags

-- Products retrive query based on tag (Search page)
--SELECT05
SELECT product."name", price, "path" AS image_path, "image".description AS image_alt
FROM product,tag,product_tag,product_image,"image"
WHERE tag.id = $id AND product_tag.id_tag = $id
    AND product_tag.id_product = product.id AND product_image.id_product = product.id
    AND product_image.id_image = image.id
ORDER BY product."name";

-- Customer information retrieval query (Profile page)
--SELECT06
SELECT username, email, "date", "path" AS image_path, "description" AS image_alt
FROM user,image
WHERE user.id = $id AND user.user_role = 'Customer'
    user.id_image = "image".id;

-- Wishilist and size retrieval based on user id(Wishlist page)
--SELECT08
SELECT "name", COUNT(id_product) AS size
FROM wishlist, wishlist_product
WHERE wishlist.id_user = $id 
AND wishlist_product.id_wishlist = wishlist.id