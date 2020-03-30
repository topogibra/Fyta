BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ 

INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES ($id_user,$id_product,$quantity);

COMMIT;