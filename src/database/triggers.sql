-- An item can only be bought when there is stock

DROP FUNCTION IF EXISTS buy_item() CASCADE;
CREATE FUNCTION buy_item() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS ( SELECT * FROM product WHERE NEW.id_product = product.id AND product.stock < NEW.quantity) THEN
        RAISE EXCEPTION 'An item can only be bought when there is stock!';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER buy_item
    BEFORE INSERT OR UPDATE ON product_order
    FOR EACH ROW
    EXECUTE PROCEDURE buy_item();


-- A review for a product can only be made once per order
DROP FUNCTION IF EXISTS review_product() CASCADE;
CREATE FUNCTION review_product() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM review WHERE review.id_order = NEW.id_order AND review.id_product = NEW.id_product) THEN
        RAISE EXCEPTION 'A review for a product can only be made once per order';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER review_product
    BEFORE INSERT ON review
    FOR EACH ROW
    EXECUTE PROCEDURE review_product();


-- A review can only be made if the user has purchased the product
DROP FUNCTION IF EXISTS review_after_purchase() CASCADE;
CREATE FUNCTION review_after_purchase() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS (SELECT * FROM product_order WHERE product_order.id_order = NEW.id_order AND product_order.id_product = NEW.id_product) THEN
        RAISE EXCEPTION 'A review can only be made if the user has purchased the product';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER review_after_purchase
    BEFORE INSERT ON review
    FOR EACH ROW
    EXECUTE PROCEDURE review_after_purchase();
    
    
-- A review can only be made after a purchase
DROP FUNCTION IF EXISTS review_date() CASCADE;
CREATE FUNCTION review_date() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM "order" WHERE order_date > NEW.review_date) THEN
        RAISE EXCEPTION 'A review can only be made after a purchase';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER review_date
    BEFORE INSERT OR UPDATE ON review
    FOR EACH ROW
    EXECUTE PROCEDURE review_date();

    
-- Only one discount can only be applied to a product in a given period of time 
DROP FUNCTION IF EXISTS discount_period() CASCADE;
CREATE FUNCTION discount_period() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM discount, "apply", discount as new_discount WHERE "apply".id_discount = NEW.id_discount OR
    ("apply".id_discount = discount.id AND new_discount.date_begin >= discount.date_begin AND new_discount.date_begin <= discount.date_end) ) THEN
        RAISE EXCEPTION 'Only one discount can only be applied to a product in a given period of time';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER discount_period
    BEFORE INSERT OR UPDATE ON discount
    FOR EACH ROW
    EXECUTE PROCEDURE discount_period();


-- All shopping cart products and wishlist products must be removed with the removal of the product
DROP FUNCTION IF EXISTS product_removal() CASCADE;
CREATE FUNCTION product_removal() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM product_order
    WHERE id_product = OLD.id;

    DELETE FROM wishlist_product
    WHERE id_product = OLD.id;
    RETURN OLD; 
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER product_removal
    BEFORE DELETE ON product
    FOR EACH ROW
    EXECUTE PROCEDURE product_removal();


