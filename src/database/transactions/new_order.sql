BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE; 

WITH order_inserted AS (
  INSERT INTO "order" (shipping_id, billing_address, delivery_address, order_date, payment_method, id_user)
  VALUES ($shipping_id, $billing_address, $delivery_address, $order_date, $payment_method, $id_user)
  RETURNING id
), 
product_inserted AS (
  INSERT INTO product_order (id_order, id_product, quantity)
  VALUES (order_inserted.id, $id_product, $quantity)
  RETURNING *
)
UPDATE product
SET stock = stock - product_inserted.quantity
WHERE id = product_inserted.id_product;

COMMIT;