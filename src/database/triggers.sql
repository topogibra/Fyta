CREATE FUNCTION buy_item() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS ( SELECT * FROM product WHERE NEW.id_product = product.id AND product.stock = 0) THEN
        RAISE EXCEPTION 'An item can only be bought when there is stock!';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER buy_item
    BEFORE INSERT OR UPDATE product_order
    FOR EACH ROW
    EXECUTE PROCEDURE buy_item();
