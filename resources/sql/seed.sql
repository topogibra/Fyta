-- Types
DROP TYPE IF EXISTS ticket_type CASCADE;
CREATE TYPE ticket_type AS ENUM (
  'Payment_Error',
  'Faulty_Delivery',
  'Product_Complaint'
);
DROP TYPE IF EXISTS ticket_status CASCADE;
CREATE TYPE ticket_status AS ENUM('Opened', 'In_Progress', 'Closed');
DROP TYPE IF EXISTS payment_method CASCADE;
CREATE TYPE payment_method AS ENUM('Stripe', 'Bank_Transfer');
DROP TYPE IF EXISTS order_status CASCADE;
CREATE TYPE order_status AS ENUM(
  'Awaiting_Payment',
  'Ready_for_Shipping',
  'Processed'
);
DROP TYPE IF EXISTS user_role CASCADE;
CREATE TYPE user_role as ENUM('Customer', 'Manager');
-- Tables
DROP TABLE IF EXISTS "image" CASCADE;
CREATE TABLE "image" (
  id SERIAL,
  img_name TEXT NOT NULL,
  "description" TEXT NOT NULL,
  CONSTRAINT image_pk PRIMARY KEY (id)
);
DROP TABLE IF EXISTS product CASCADE;
CREATE TABLE product (
  id SERIAL,
  "name" TEXT NOT NULL,
  "description" TEXT NOT NULL,
  price FLOAT NOT NULL,
  stock INTEGER NOT NULL,
  views INTEGER NOT NULL,
  CONSTRAINT product_price_check CHECK (price >= 0),
  CONSTRAINT product_stock_check CHECK (stock >= 0),
  CONSTRAINT product_views_check CHECK (views >= 0),
  CONSTRAINT product_pk PRIMARY KEY (id)
);
DROP TABLE IF EXISTS "user" CASCADE;
CREATE TABLE "user" (
  id SERIAL,
  username TEXT NOT NULL,
  email TEXT NOT NULL,
  password_hash TEXT NOT NULL,
  "date" DATE NOT NULL,
  id_image INTEGER NOT NULL,
  user_role "user_role" NOT NULL,
  CONSTRAINT user_pk PRIMARY KEY (id),
  CONSTRAINT user_username_uk UNIQUE (username),
  CONSTRAINT user_email_uk UNIQUE (email),
  CONSTRAINT user_image_fk FOREIGN KEY (id_image) REFERENCES "image"(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS "order" CASCADE;
CREATE TABLE "order" (
  id SERIAL,
  shipping_id INTEGER NOT NULL,
  billing_address TEXT,
  delivery_address TEXT NOT NULL,
  order_date DATE DEFAULT now() NOT NULL,
  payment_method "payment_method" NOT NULL,
  id_user INTEGER NOT NULL,
  CONSTRAINT order_pk PRIMARY KEY (id),
  CONSTRAINT order_order_id_uk UNIQUE (shipping_id),
  CONSTRAINT order_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS product_order CASCADE;
CREATE TABLE product_order (
  id_product INTEGER NOT NULL,
  id_order INTEGER NOT NULL,
  quantity INTEGER NOT NULL,
  CONSTRAINT product_order_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT product_order_order_fk FOREIGN KEY (id_order) REFERENCES "order"(id) ON UPDATE CASCADE,
  PRIMARY KEY(id_product, id_order),
  CONSTRAINT quantity_check CHECK (quantity > 0)
);
DROP TABLE IF EXISTS review CASCADE;
CREATE TABLE review (
  id_product INTEGER NOT NULL,
  id_order INTEGER NOT NULL,
  "description" TEXT,
  rating INTEGER NOT NULL,
  review_date DATE DEFAULT now() NOT NULL,
  CONSTRAINT review_rating_check CHECK (
    rating >= 1
    AND rating <= 5
  ),
  CONSTRAINT review_pk PRIMARY KEY (id_product, id_order),
  CONSTRAINT review_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT review_order_fk FOREIGN KEY (id_order) REFERENCES "order"(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS order_history CASCADE;
CREATE TABLE order_history (
  id SERIAL,
  "date" DATE DEFAULT now() NOT NULL,
  id_order INTEGER NOT NULL,
  order_status "order_status" NOT NULL,
  CONSTRAINT order_history_pk PRIMARY KEY (id),
  CONSTRAINT order_history_order_pk FOREIGN KEY (id_order) REFERENCES "order"(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS wishlist CASCADE;
CREATE TABLE wishlist (
  id SERIAL,
  "name" TEXT NOT NULL,
  id_user INTEGER NOT NULL,
  CONSTRAINT wishlist_pk PRIMARY KEY (id),
  CONSTRAINT wishlist_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS wishlist_product CASCADE;
CREATE TABLE wishlist_product (
  id_product INTEGER NOT NULL,
  id_wishlist INTEGER NOT NULL,
  CONSTRAINT wishlist_product_pk PRIMARY KEY (id_product, id_wishlist),
  CONSTRAINT wishlist_product_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT wishlist_product_wishlist_fk FOREIGN KEY (id_wishlist) REFERENCES wishlist(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS shopping_cart CASCADE;
CREATE TABLE shopping_cart (
  id_user INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  quantity INTEGER NOT NULL,
  CONSTRAINT shopping_cart_pk PRIMARY KEY (id_user, id_product),
  CONSTRAINT shopping_cart_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE,
  CONSTRAINT shopping_cart_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT shopping_cart_quantity_check CHECK (quantity > 0)
);
DROP TABLE IF EXISTS discount CASCADE;
CREATE TABLE discount (
  id SERIAL,
  "percentage" INTEGER NOT NULL,
  date_begin DATE DEFAULT now() NOT NULL,
  date_end DATE NOT NULL,
  CONSTRAINT discount_pk PRIMARY KEY (id),
  CONSTRAINT discount_value_check CHECK (
    "percentage" > 0
    AND "percentage" < 100
  ),
  CONSTRAINT discount_dates_check CHECK (date_end > date_begin)
);
DROP TABLE IF EXISTS discount_code CASCADE;
CREATE TABLE discount_code (
  id_discount SERIAL,
  code TEXT NOT NULL,
  CONSTRAINT discount_code_pk PRIMARY KEY (id_discount),
  CONSTRAINT discount_code_discount_fk FOREIGN KEY (id_discount) REFERENCES discount(id) ON UPDATE CASCADE,
  CONSTRAINT discount_code_uk UNIQUE (code)
);
DROP TABLE IF EXISTS apply_discount CASCADE;
CREATE TABLE apply_discount (
  id_product INTEGER NOT NULL,
  id_discount INTEGER NOT NULL,
  CONSTRAINT apply_pk PRIMARY KEY (id_product, id_discount),
  CONSTRAINT apply_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT apply_discount_fk FOREIGN KEY (id_discount) REFERENCES discount(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS tag CASCADE;
CREATE TABLE tag (
  id SERIAL,
  "name" TEXT NOT NULL,
  CONSTRAINT tag_pk PRIMARY KEY (id),
  CONSTRAINT tag_name_uk UNIQUE ("name")
);
DROP TABLE IF EXISTS product_tag CASCADE;
CREATE TABLE product_tag (
  id_tag INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  CONSTRAINT product_tag_pk PRIMARY KEY (id_tag, id_product),
  CONSTRAINT product_tag_tag_fk FOREIGN KEY (id_tag) REFERENCES tag(id) ON UPDATE CASCADE,
  CONSTRAINT product_tag_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS ticket CASCADE;
CREATE TABLE ticket (
  id SERIAL,
  ticket_type "ticket_type" NOT NULL,
  id_user INTEGER NOT NULL,
  CONSTRAINT ticket_pk PRIMARY KEY (id),
  CONSTRAINT ticket_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS ticket_message CASCADE;
CREATE TABLE ticket_message (
  id SERIAL,
  sent_date DATE NOT NULL,
  "message" TEXT NOT NULL,
  id_ticket INTEGER NOT NULL,
  id_user INTEGER NOT NULL,
  CONSTRAINT ticket_message_pk PRIMARY KEY (id),
  CONSTRAINT ticket_message_ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE,
  CONSTRAINT ticket_message_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS ticket_history CASCADE;
CREATE TABLE ticket_history (
  id SERIAL,
  "date" DATE DEFAULT now() NOT NULL,
  ticket_status "ticket_status" NOT NULL,
  id_ticket INTEGER,
  CONSTRAINT ticket_history_pk PRIMARY KEY (id),
  CONSTRAINT ticket_history_ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS product_image CASCADE;
CREATE TABLE product_image (
  id_image INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  CONSTRAINT product_image_pk PRIMARY KEY (id_image, id_product),
  CONSTRAINT product_image_image_fk FOREIGN KEY (id_image) REFERENCES "image"(id) ON UPDATE CASCADE,
  CONSTRAINT product_image_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS user_removal CASCADE;
CREATE TABLE user_removal (
  id SERIAL,
  reason TEXT NOT NULL,
  username TEXT NOT NULL,
  removed_at DATE DEFAULT now() NOT NULL,
  CONSTRAINT user_removal_pk PRIMARY KEY (id)
);
-- Triggers
-- An item can only be bought when there is stock
DROP FUNCTION IF EXISTS buy_item() CASCADE;
CREATE FUNCTION buy_item() RETURNS TRIGGER AS $BODY$ BEGIN IF EXISTS (
  SELECT
    *
  FROM product
  WHERE
    NEW.id_product = product.id
    AND product.stock < NEW.quantity
) THEN RAISE EXCEPTION 'An item can only be bought when there is stock!';
END IF;
RETURN NEW;
END $BODY$ LANGUAGE plpgsql;
CREATE TRIGGER buy_item BEFORE
INSERT
  OR
UPDATE ON product_order FOR EACH ROW EXECUTE PROCEDURE buy_item();
-- A review for a product can only be made once per order
  DROP FUNCTION IF EXISTS review_product() CASCADE;
CREATE FUNCTION review_product() RETURNS TRIGGER AS $BODY$ BEGIN IF EXISTS (
    SELECT
      *
    FROM review
    WHERE
      review.id_order = NEW.id_order
      AND review.id_product = NEW.id_product
  ) THEN RAISE EXCEPTION 'A review for a product can only be made once per order';
END IF;
RETURN NEW;
END $BODY$ LANGUAGE plpgsql;
CREATE TRIGGER review_product BEFORE
INSERT ON review FOR EACH ROW EXECUTE PROCEDURE review_product();
-- A review can only be made if the user has purchased the product
  DROP FUNCTION IF EXISTS review_after_purchase() CASCADE;
CREATE FUNCTION review_after_purchase() RETURNS TRIGGER AS $BODY$ BEGIN IF NOT EXISTS (
    SELECT
      *
    FROM product_order
    WHERE
      product_order.id_order = NEW.id_order
      AND product_order.id_product = NEW.id_product
  ) THEN RAISE EXCEPTION 'A review can only be made if the user has purchased the product';
END IF;
RETURN NEW;
END $BODY$ LANGUAGE plpgsql;
CREATE TRIGGER review_after_purchase BEFORE
INSERT ON review FOR EACH ROW EXECUTE PROCEDURE review_after_purchase();
-- A review can only be made after a purchase
  DROP FUNCTION IF EXISTS review_date() CASCADE;
CREATE FUNCTION review_date() RETURNS TRIGGER AS $BODY$ BEGIN IF EXISTS (
    SELECT
      *
    FROM "order"
    WHERE
      order_date :: date > NEW.review_date :: date
      AND "order".id = NEW.id_order
  ) THEN RAISE EXCEPTION 'A review can only be made after a purchase';
END IF;
RETURN NEW;
END $BODY$ LANGUAGE plpgsql;
CREATE TRIGGER review_date BEFORE
INSERT
  OR
UPDATE ON review FOR EACH ROW EXECUTE PROCEDURE review_date();
-- Only one discount can only be applied to a product in a given period of time
  DROP FUNCTION IF EXISTS discount_period() CASCADE;
CREATE FUNCTION discount_period() RETURNS TRIGGER AS $BODY$ BEGIN IF EXISTS (
    SELECT
      *
    FROM discount,
      apply_discount,
      discount as new_discount
    WHERE
      apply_discount.id_discount = NEW.id
      OR (
        apply_discount.id_discount = discount.id
        AND new_discount.date_begin >= discount.date_begin
        AND new_discount.date_begin <= discount.date_end
      )
  ) THEN RAISE EXCEPTION 'Only one discount can only be applied to a product in a given period of time';
END IF;
RETURN NEW;
END $BODY$ LANGUAGE plpgsql;
CREATE TRIGGER discount_period BEFORE
INSERT
  OR
UPDATE ON discount FOR EACH ROW EXECUTE PROCEDURE discount_period();
-- All shopping cart products and wishlist products must be removed with the removal of the product
  DROP FUNCTION IF EXISTS product_removal() CASCADE;
CREATE FUNCTION product_removal() RETURNS TRIGGER AS $BODY$ BEGIN
DELETE FROM product_order
WHERE
  id_product = OLD.id;
DELETE FROM wishlist_product
WHERE
  id_product = OLD.id;
RETURN OLD;
END $BODY$ LANGUAGE plpgsql;
CREATE TRIGGER product_removal BEFORE DELETE ON product FOR EACH ROW EXECUTE PROCEDURE product_removal();
-- Indexes
--IDX01
CREATE INDEX review_date ON review USING btree(review_date);
--IDX02
CREATE INDEX order_date_hash ON "order" USING btree(order_date);
--IDX03
CREATE INDEX product_price_idx on product USING btree(price);
--IDX04
CREATE INDEX product_views_idx on product USING btree(views);
--IDX05
CREATE INDEX discount_date_start_idx on discount USING btree(date_begin);
--IDX06
CREATE INDEX discount_date_end_idx on discount USING btree(date_end);
--Full-text Search Indice
CREATE INDEX product_fts ON product USING GIN (
  (
    setweight(to_tsvector('english', COALESCE("name", '')), 'A') || setweight(
      to_tsvector('english', COALESCE("description")),
      'B'
    )
  )
);


--R18
INSERT INTO "image" (img_name,"description") VALUES ('orquideas.jpg','Rose Orchid');
INSERT INTO "image" (img_name,"description") VALUES ('vaso.jpg','XPR Vase');
INSERT INTO "image" (img_name,"description") VALUES ('bonsai2.jpg','Bonsai CRT');
INSERT INTO "image" (img_name,"description") VALUES ('tulipas.jpg','Orange Tulips');
INSERT INTO "image" (img_name,"description") VALUES ('meatrose_indoor.jpg','Meat Rose');
INSERT INTO "image" (img_name,"description") VALUES ('reddahlia_indoor.jpg','Red Dahlias');
INSERT INTO "image" (img_name,"description") VALUES ('pinktulips_indoor.jpg','Pink Tulips');
INSERT INTO "image" (img_name,"description") VALUES ('sativa_indoor.jpg','Sativa Prime');
INSERT INTO "image" (img_name,"description") VALUES ('greenpalm_outdoor.jpg','Green Palm Tree');
INSERT INTO "image" (img_name,"description") VALUES ('lavender_outdoor.jpg','Lavender Premium');
INSERT INTO "image" (img_name,"description") VALUES ('mohammad-faruque-AgYOuy8kA7M-unsplash.jpg','Mohammad Faruque');
INSERT INTO "image" (img_name,"description") VALUES ('dannie_almir.jpg','Dannie Almir');
INSERT INTO "image" (img_name,"description") VALUES ('simone.jpeg','Simone Biles');
INSERT INTO "image" (img_name,"description") VALUES ('sisay_jeremiah_small.jpg','Sisay Jeremiah');


--R01
INSERT INTO product ("name","description",price,stock,views) VALUES ('Erica carnea White',
'This variety will provide you with white flowers and plenty of interest in your garden or on your patio long after other 
flowers have faded and the garden takes on a somewhat barren look. Not as fussy with soil as their counterparts, 
they will thrive in any well drained soil and form a low maintenance ground cover plant.',16.00,50,100),
                                                                   ('Amaryllis Floris Hekker',
'Hippeastrum Amaryllis Floris Hekker is an excellent variety to help brighten up your home. It produces plenty of large 
velvety-red blooms with deep dark red centres.It’s a great variety for an eye-catching display in your home or as a memorable
gift for a very special person. Plant your Amaryllis 8 weeks before you would like them to bloom!',18.00,50,150),
                                                                    ('Mini Lemon Tree',
'This cold resistant Lemon tree is highly decorative providing year round interest with its glossy evergreen leaves, 
pretty fragrant flowers and edible fruit.These miniature trees are easy to care for and ideal for on a sunny windowsill indoors, 
they can also be moved outdoors once temperatures are above freezing. ',26.00,50,650),
                                                                    ('Mini Phalaenopsis Purple',
'This New Miniature Phalaenopsis is so unusual and so cute. It arrives in flower making a wonderful gift. 
The long lasting dark Purple flowers make them perfect as centrepieces.',30.00,50,450),
                                                                    ('Crassula perforata Giant Form',
'Crassula perforata Giant Form is a rare succulent plant with pretty bluish red tips which sets off the grey/blue foliage beautifully. 
Jade plants make great housewarming gifts as they are often called the money plant 
or dollar plant, because they were once thought to bring good luck to their owners.',14.00,50,451),
                                                                    ('Aloes mitriformis fluorescent',
'This dwarf version of Aloe has strong sturdy leaves arranged in rosettes with fine yellow-white serrations.
It is useful for many skin conditions as it eases pain and reduces inflammation.
Aloe also makes a great houseplant, it is very easy to grow and will thrive on any sunny windowsill 
with the minimum of effort.',20.00,50,450),
                                                                    ('Gardenia jasminoides',
'This beautiful plant is perfect for both indoors and out. The lovely rose-like flowers in ivory-white emit a heavy scent 
perfuming your living room or patio. In the language of flowers gardenia signifies ‘secret love’ 
and represents purity, refinement and peace.',14.00,50,784),
                                                                    ('Mini Apple Tree Malus Red Spur',
'Harvest your own delicious apples from this fine self-fertile mini apple tree. It produces full sized tasty
 fruit and makes an impressive display on your patio, decking, or just in the garden.',36.00,50,364),
                                                                    ('Aquilegia Spring Magic Blue',
'Aquilegia or Columbines produce fabulous shaped flowers which will be the talking point of your neighbours.
The dainty blooms with elegant spurs are exquisite and will come back to grace your garden year after year.
They are hardy, grow in sun or partial shade and are suitable for your herbaceous borders or for planters on your patio or decking.',22.00,50,123),
                                                                    ('Climbing Rose New Dawn',
'Climbing rose New Dawn is thought by many to be one of the best repeat-flowering climbing rose, producing medium sized, 
silvery blush-pink semi-double blossoms in attractive clusters with a sweet fruity fragrance all summer long.  
This vigorous climber flourishes in both sun or partial shade and its attractive dark green glossy foliage has 
a good disease resistance.',65.00,50,1204);
INSERT INTO product ("name","description",price,stock,views) VALUES ('Erica carnea White',
'This variety will provide you with white flowers and plenty of interest in your garden or on your patio long after other 
flowers have faded and the garden takes on a somewhat barren look. Not as fussy with soil as their counterparts, 
they will thrive in any well drained soil and form a low maintenance ground cover plant.',16.00,50,100),
                                                                   ('Amaryllis Floris Hekker',
'Hippeastrum Amaryllis Floris Hekker is an excellent variety to help brighten up your home. It produces plenty of large 
velvety-red blooms with deep dark red centres.It’s a great variety for an eye-catching display in your home or as a memorable
gift for a very special person. Plant your Amaryllis 8 weeks before you would like them to bloom!',18.00,50,150),
                                                                    ('Mini Lemon Tree',
'This cold resistant Lemon tree is highly decorative providing year round interest with its glossy evergreen leaves, 
pretty fragrant flowers and edible fruit.These miniature trees are easy to care for and ideal for on a sunny windowsill indoors, 
they can also be moved outdoors once temperatures are above freezing. ',26.00,50,650),
                                                                    ('Mini Phalaenopsis Purple',
'This New Miniature Phalaenopsis is so unusual and so cute. It arrives in flower making a wonderful gift. 
The long lasting dark Purple flowers make them perfect as centrepieces.',30.00,50,450),
                                                                    ('Crassula perforata Giant Form',
'Crassula perforata Giant Form is a rare succulent plant with pretty bluish red tips which sets off the grey/blue foliage beautifully. 
Jade plants make great housewarming gifts as they are often called the money plant 
or dollar plant, because they were once thought to bring good luck to their owners.',14.00,50,451),
                                                                    ('Aloes mitriformis fluorescent',
'This dwarf version of Aloe has strong sturdy leaves arranged in rosettes with fine yellow-white serrations.
It is useful for many skin conditions as it eases pain and reduces inflammation.
Aloe also makes a great houseplant, it is very easy to grow and will thrive on any sunny windowsill 
with the minimum of effort.',20.00,50,450),
                                                                    ('Gardenia jasminoides',
'This beautiful plant is perfect for both indoors and out. The lovely rose-like flowers in ivory-white emit a heavy scent 
perfuming your living room or patio. In the language of flowers gardenia signifies ‘secret love’ 
and represents purity, refinement and peace.',14.00,50,784),
                                                                    ('Mini Apple Tree Malus Red Spur',
'Harvest your own delicious apples from this fine self-fertile mini apple tree. It produces full sized tasty
 fruit and makes an impressive display on your patio, decking, or just in the garden.',36.00,50,364),
                                                                    ('Aquilegia Spring Magic Blue',
'Aquilegia or Columbines produce fabulous shaped flowers which will be the talking point of your neighbours.
The dainty blooms with elegant spurs are exquisite and will come back to grace your garden year after year.
They are hardy, grow in sun or partial shade and are suitable for your herbaceous borders or for planters on your patio or decking.',22.00,50,123),
                                                                    ('Climbing Rose New Dawn',
'Climbing rose New Dawn is thought by many to be one of the best repeat-flowering climbing rose, producing medium sized, 
silvery blush-pink semi-double blossoms in attractive clusters with a sweet fruity fragrance all summer long.  
This vigorous climber flourishes in both sun or partial shade and its attractive dark green glossy foliage has 
a good disease resistance.',65.00,50,1204);
INSERT INTO product ("name","description",price,stock,views) VALUES ('Erica carnea White',
'This variety will provide you with white flowers and plenty of interest in your garden or on your patio long after other 
flowers have faded and the garden takes on a somewhat barren look. Not as fussy with soil as their counterparts, 
they will thrive in any well drained soil and form a low maintenance ground cover plant.',16.00,50,100),
                                                                   ('Amaryllis Floris Hekker',
'Hippeastrum Amaryllis Floris Hekker is an excellent variety to help brighten up your home. It produces plenty of large 
velvety-red blooms with deep dark red centres.It’s a great variety for an eye-catching display in your home or as a memorable
gift for a very special person. Plant your Amaryllis 8 weeks before you would like them to bloom!',18.00,50,150),
                                                                    ('Mini Lemon Tree',
'This cold resistant Lemon tree is highly decorative providing year round interest with its glossy evergreen leaves, 
pretty fragrant flowers and edible fruit.These miniature trees are easy to care for and ideal for on a sunny windowsill indoors, 
they can also be moved outdoors once temperatures are above freezing. ',26.00,50,650),
                                                                    ('Mini Phalaenopsis Purple',
'This New Miniature Phalaenopsis is so unusual and so cute. It arrives in flower making a wonderful gift. 
The long lasting dark Purple flowers make them perfect as centrepieces.',30.00,50,450),
                                                                    ('Crassula perforata Giant Form',
'Crassula perforata Giant Form is a rare succulent plant with pretty bluish red tips which sets off the grey/blue foliage beautifully. 
Jade plants make great housewarming gifts as they are often called the money plant 
or dollar plant, because they were once thought to bring good luck to their owners.',14.00,50,451),
                                                                    ('Aloes mitriformis fluorescent',
'This dwarf version of Aloe has strong sturdy leaves arranged in rosettes with fine yellow-white serrations.
It is useful for many skin conditions as it eases pain and reduces inflammation.
Aloe also makes a great houseplant, it is very easy to grow and will thrive on any sunny windowsill 
with the minimum of effort.',20.00,50,450),
                                                                    ('Gardenia jasminoides',
'This beautiful plant is perfect for both indoors and out. The lovely rose-like flowers in ivory-white emit a heavy scent 
perfuming your living room or patio. In the language of flowers gardenia signifies ‘secret love’ 
and represents purity, refinement and peace.',14.00,50,784),
                                                                    ('Mini Apple Tree Malus Red Spur',
'Harvest your own delicious apples from this fine self-fertile mini apple tree. It produces full sized tasty
 fruit and makes an impressive display on your patio, decking, or just in the garden.',36.00,50,364),
                                                                    ('Aquilegia Spring Magic Blue',
'Aquilegia or Columbines produce fabulous shaped flowers which will be the talking point of your neighbours.
The dainty blooms with elegant spurs are exquisite and will come back to grace your garden year after year.
They are hardy, grow in sun or partial shade and are suitable for your herbaceous borders or for planters on your patio or decking.',22.00,50,123),
                                                                    ('Climbing Rose New Dawn',
'Climbing rose New Dawn is thought by many to be one of the best repeat-flowering climbing rose, producing medium sized, 
silvery blush-pink semi-double blossoms in attractive clusters with a sweet fruity fragrance all summer long.  
This vigorous climber flourishes in both sun or partial shade and its attractive dark green glossy foliage has 
a good disease resistance.',65.00,50,1204);
INSERT INTO product ("name","description",price,stock,views) VALUES ('Erica carnea White',
'This variety will provide you with white flowers and plenty of interest in your garden or on your patio long after other 
flowers have faded and the garden takes on a somewhat barren look. Not as fussy with soil as their counterparts, 
they will thrive in any well drained soil and form a low maintenance ground cover plant.',16.00,50,100),
                                                                   ('Amaryllis Floris Hekker',
'Hippeastrum Amaryllis Floris Hekker is an excellent variety to help brighten up your home. It produces plenty of large 
velvety-red blooms with deep dark red centres.It’s a great variety for an eye-catching display in your home or as a memorable
gift for a very special person. Plant your Amaryllis 8 weeks before you would like them to bloom!',18.00,50,150),
                                                                    ('Mini Lemon Tree',
'This cold resistant Lemon tree is highly decorative providing year round interest with its glossy evergreen leaves, 
pretty fragrant flowers and edible fruit.These miniature trees are easy to care for and ideal for on a sunny windowsill indoors, 
they can also be moved outdoors once temperatures are above freezing. ',26.00,50,650),
                                                                    ('Mini Phalaenopsis Purple',
'This New Miniature Phalaenopsis is so unusual and so cute. It arrives in flower making a wonderful gift. 
The long lasting dark Purple flowers make them perfect as centrepieces.',30.00,50,450),
                                                                    ('Crassula perforata Giant Form',
'Crassula perforata Giant Form is a rare succulent plant with pretty bluish red tips which sets off the grey/blue foliage beautifully. 
Jade plants make great housewarming gifts as they are often called the money plant 
or dollar plant, because they were once thought to bring good luck to their owners.',14.00,50,451),
                                                                    ('Aloes mitriformis fluorescent',
'This dwarf version of Aloe has strong sturdy leaves arranged in rosettes with fine yellow-white serrations.
It is useful for many skin conditions as it eases pain and reduces inflammation.
Aloe also makes a great houseplant, it is very easy to grow and will thrive on any sunny windowsill 
with the minimum of effort.',20.00,50,450),
                                                                    ('Gardenia jasminoides',
'This beautiful plant is perfect for both indoors and out. The lovely rose-like flowers in ivory-white emit a heavy scent 
perfuming your living room or patio. In the language of flowers gardenia signifies ‘secret love’ 
and represents purity, refinement and peace.',14.00,50,784),
                                                                    ('Mini Apple Tree Malus Red Spur',
'Harvest your own delicious apples from this fine self-fertile mini apple tree. It produces full sized tasty
 fruit and makes an impressive display on your patio, decking, or just in the garden.',36.00,50,364),
                                                                    ('Aquilegia Spring Magic Blue',
'Aquilegia or Columbines produce fabulous shaped flowers which will be the talking point of your neighbours.
The dainty blooms with elegant spurs are exquisite and will come back to grace your garden year after year.
They are hardy, grow in sun or partial shade and are suitable for your herbaceous borders or for planters on your patio or decking.',22.00,50,123),
                                                                    ('Climbing Rose New Dawn',
'Climbing rose New Dawn is thought by many to be one of the best repeat-flowering climbing rose, producing medium sized, 
silvery blush-pink semi-double blossoms in attractive clusters with a sweet fruity fragrance all summer long.  
This vigorous climber flourishes in both sun or partial shade and its attractive dark green glossy foliage has 
a good disease resistance.',65.00,50,1204);
INSERT INTO product ("name","description",price,stock,views) VALUES ('Erica carnea White',
'This variety will provide you with white flowers and plenty of interest in your garden or on your patio long after other 
flowers have faded and the garden takes on a somewhat barren look. Not as fussy with soil as their counterparts, 
they will thrive in any well drained soil and form a low maintenance ground cover plant.',16.00,50,100),
                                                                   ('Amaryllis Floris Hekker',
'Hippeastrum Amaryllis Floris Hekker is an excellent variety to help brighten up your home. It produces plenty of large 
velvety-red blooms with deep dark red centres.It’s a great variety for an eye-catching display in your home or as a memorable
gift for a very special person. Plant your Amaryllis 8 weeks before you would like them to bloom!',18.00,50,150),
                                                                    ('Mini Lemon Tree',
'This cold resistant Lemon tree is highly decorative providing year round interest with its glossy evergreen leaves, 
pretty fragrant flowers and edible fruit.These miniature trees are easy to care for and ideal for on a sunny windowsill indoors, 
they can also be moved outdoors once temperatures are above freezing. ',26.00,50,650),
                                                                    ('Mini Phalaenopsis Purple',
'This New Miniature Phalaenopsis is so unusual and so cute. It arrives in flower making a wonderful gift. 
The long lasting dark Purple flowers make them perfect as centrepieces.',30.00,50,450),
                                                                    ('Crassula perforata Giant Form',
'Crassula perforata Giant Form is a rare succulent plant with pretty bluish red tips which sets off the grey/blue foliage beautifully. 
Jade plants make great housewarming gifts as they are often called the money plant 
or dollar plant, because they were once thought to bring good luck to their owners.',14.00,50,451),
                                                                    ('Aloes mitriformis fluorescent',
'This dwarf version of Aloe has strong sturdy leaves arranged in rosettes with fine yellow-white serrations.
It is useful for many skin conditions as it eases pain and reduces inflammation.
Aloe also makes a great houseplant, it is very easy to grow and will thrive on any sunny windowsill 
with the minimum of effort.',20.00,50,450),
                                                                    ('Gardenia jasminoides',
'This beautiful plant is perfect for both indoors and out. The lovely rose-like flowers in ivory-white emit a heavy scent 
perfuming your living room or patio. In the language of flowers gardenia signifies ‘secret love’ 
and represents purity, refinement and peace.',14.00,50,784),
                                                                    ('Mini Apple Tree Malus Red Spur',
'Harvest your own delicious apples from this fine self-fertile mini apple tree. It produces full sized tasty
 fruit and makes an impressive display on your patio, decking, or just in the garden.',36.00,50,364),
                                                                    ('Aquilegia Spring Magic Blue',
'Aquilegia or Columbines produce fabulous shaped flowers which will be the talking point of your neighbours.
The dainty blooms with elegant spurs are exquisite and will come back to grace your garden year after year.
They are hardy, grow in sun or partial shade and are suitable for your herbaceous borders or for planters on your patio or decking.',22.00,50,123),
                                                                    ('Climbing Rose New Dawn',
'Climbing rose New Dawn is thought by many to be one of the best repeat-flowering climbing rose, producing medium sized, 
silvery blush-pink semi-double blossoms in attractive clusters with a sweet fruity fragrance all summer long.  
This vigorous climber flourishes in both sun or partial shade and its attractive dark green glossy foliage has 
a good disease resistance.',65.00,50,1204);
INSERT INTO product ("name","description",price,stock,views) VALUES ('Erica carnea White',
'This variety will provide you with white flowers and plenty of interest in your garden or on your patio long after other 
flowers have faded and the garden takes on a somewhat barren look. Not as fussy with soil as their counterparts, 
they will thrive in any well drained soil and form a low maintenance ground cover plant.',16.00,50,100),
                                                                   ('Amaryllis Floris Hekker',
'Hippeastrum Amaryllis Floris Hekker is an excellent variety to help brighten up your home. It produces plenty of large 
velvety-red blooms with deep dark red centres.It’s a great variety for an eye-catching display in your home or as a memorable
gift for a very special person. Plant your Amaryllis 8 weeks before you would like them to bloom!',18.00,50,150),
                                                                    ('Mini Lemon Tree',
'This cold resistant Lemon tree is highly decorative providing year round interest with its glossy evergreen leaves, 
pretty fragrant flowers and edible fruit.These miniature trees are easy to care for and ideal for on a sunny windowsill indoors, 
they can also be moved outdoors once temperatures are above freezing. ',26.00,50,650),
                                                                    ('Mini Phalaenopsis Purple',
'This New Miniature Phalaenopsis is so unusual and so cute. It arrives in flower making a wonderful gift. 
The long lasting dark Purple flowers make them perfect as centrepieces.',30.00,50,450),
                                                                    ('Crassula perforata Giant Form',
'Crassula perforata Giant Form is a rare succulent plant with pretty bluish red tips which sets off the grey/blue foliage beautifully. 
Jade plants make great housewarming gifts as they are often called the money plant 
or dollar plant, because they were once thought to bring good luck to their owners.',14.00,50,451),
                                                                    ('Aloes mitriformis fluorescent',
'This dwarf version of Aloe has strong sturdy leaves arranged in rosettes with fine yellow-white serrations.
It is useful for many skin conditions as it eases pain and reduces inflammation.
Aloe also makes a great houseplant, it is very easy to grow and will thrive on any sunny windowsill 
with the minimum of effort.',20.00,50,450),
                                                                    ('Gardenia jasminoides',
'This beautiful plant is perfect for both indoors and out. The lovely rose-like flowers in ivory-white emit a heavy scent 
perfuming your living room or patio. In the language of flowers gardenia signifies ‘secret love’ 
and represents purity, refinement and peace.',14.00,50,784),
                                                                    ('Mini Apple Tree Malus Red Spur',
'Harvest your own delicious apples from this fine self-fertile mini apple tree. It produces full sized tasty
 fruit and makes an impressive display on your patio, decking, or just in the garden.',36.00,50,364),
                                                                    ('Aquilegia Spring Magic Blue',
'Aquilegia or Columbines produce fabulous shaped flowers which will be the talking point of your neighbours.
The dainty blooms with elegant spurs are exquisite and will come back to grace your garden year after year.
They are hardy, grow in sun or partial shade and are suitable for your herbaceous borders or for planters on your patio or decking.',22.00,50,123),
                                                                    ('Climbing Rose New Dawn',
'Climbing rose New Dawn is thought by many to be one of the best repeat-flowering climbing rose, producing medium sized, 
silvery blush-pink semi-double blossoms in attractive clusters with a sweet fruity fragrance all summer long.  
This vigorous climber flourishes in both sun or partial shade and its attractive dark green glossy foliage has 
a good disease resistance.',65.00,50,1204);
INSERT INTO product ("name","description",price,stock,views) VALUES ('Erica carnea White',
'This variety will provide you with white flowers and plenty of interest in your garden or on your patio long after other 
flowers have faded and the garden takes on a somewhat barren look. Not as fussy with soil as their counterparts, 
they will thrive in any well drained soil and form a low maintenance ground cover plant.',16.00,50,100),
                                                                   ('Amaryllis Floris Hekker',
'Hippeastrum Amaryllis Floris Hekker is an excellent variety to help brighten up your home. It produces plenty of large 
velvety-red blooms with deep dark red centres.It’s a great variety for an eye-catching display in your home or as a memorable
gift for a very special person. Plant your Amaryllis 8 weeks before you would like them to bloom!',18.00,50,150),
                                                                    ('Mini Lemon Tree',
'This cold resistant Lemon tree is highly decorative providing year round interest with its glossy evergreen leaves, 
pretty fragrant flowers and edible fruit.These miniature trees are easy to care for and ideal for on a sunny windowsill indoors, 
they can also be moved outdoors once temperatures are above freezing. ',26.00,50,650),
                                                                    ('Mini Phalaenopsis Purple',
'This New Miniature Phalaenopsis is so unusual and so cute. It arrives in flower making a wonderful gift. 
The long lasting dark Purple flowers make them perfect as centrepieces.',30.00,50,450),
                                                                    ('Crassula perforata Giant Form',
'Crassula perforata Giant Form is a rare succulent plant with pretty bluish red tips which sets off the grey/blue foliage beautifully. 
Jade plants make great housewarming gifts as they are often called the money plant 
or dollar plant, because they were once thought to bring good luck to their owners.',14.00,50,451),
                                                                    ('Aloes mitriformis fluorescent',
'This dwarf version of Aloe has strong sturdy leaves arranged in rosettes with fine yellow-white serrations.
It is useful for many skin conditions as it eases pain and reduces inflammation.
Aloe also makes a great houseplant, it is very easy to grow and will thrive on any sunny windowsill 
with the minimum of effort.',20.00,50,450),
                                                                    ('Gardenia jasminoides',
'This beautiful plant is perfect for both indoors and out. The lovely rose-like flowers in ivory-white emit a heavy scent 
perfuming your living room or patio. In the language of flowers gardenia signifies ‘secret love’ 
and represents purity, refinement and peace.',14.00,50,784),
                                                                    ('Mini Apple Tree Malus Red Spur',
'Harvest your own delicious apples from this fine self-fertile mini apple tree. It produces full sized tasty
 fruit and makes an impressive display on your patio, decking, or just in the garden.',36.00,50,364),
                                                                    ('Aquilegia Spring Magic Blue',
'Aquilegia or Columbines produce fabulous shaped flowers which will be the talking point of your neighbours.
The dainty blooms with elegant spurs are exquisite and will come back to grace your garden year after year.
They are hardy, grow in sun or partial shade and are suitable for your herbaceous borders or for planters on your patio or decking.',22.00,50,123),
                                                                    ('Climbing Rose New Dawn',
'Climbing rose New Dawn is thought by many to be one of the best repeat-flowering climbing rose, producing medium sized, 
silvery blush-pink semi-double blossoms in attractive clusters with a sweet fruity fragrance all summer long.  
This vigorous climber flourishes in both sun or partial shade and its attractive dark green glossy foliage has 
a good disease resistance.',65.00,50,1204);
INSERT INTO product ("name","description",price,stock,views) VALUES ('Erica carnea White',
'This variety will provide you with white flowers and plenty of interest in your garden or on your patio long after other 
flowers have faded and the garden takes on a somewhat barren look. Not as fussy with soil as their counterparts, 
they will thrive in any well drained soil and form a low maintenance ground cover plant.',16.00,50,100),
                                                                   ('Amaryllis Floris Hekker',
'Hippeastrum Amaryllis Floris Hekker is an excellent variety to help brighten up your home. It produces plenty of large 
velvety-red blooms with deep dark red centres.It’s a great variety for an eye-catching display in your home or as a memorable
gift for a very special person. Plant your Amaryllis 8 weeks before you would like them to bloom!',18.00,50,150),
                                                                    ('Mini Lemon Tree',
'This cold resistant Lemon tree is highly decorative providing year round interest with its glossy evergreen leaves, 
pretty fragrant flowers and edible fruit.These miniature trees are easy to care for and ideal for on a sunny windowsill indoors, 
they can also be moved outdoors once temperatures are above freezing. ',26.00,50,650),
                                                                    ('Mini Phalaenopsis Purple',
'This New Miniature Phalaenopsis is so unusual and so cute. It arrives in flower making a wonderful gift. 
The long lasting dark Purple flowers make them perfect as centrepieces.',30.00,50,450),
                                                                    ('Crassula perforata Giant Form',
'Crassula perforata Giant Form is a rare succulent plant with pretty bluish red tips which sets off the grey/blue foliage beautifully. 
Jade plants make great housewarming gifts as they are often called the money plant 
or dollar plant, because they were once thought to bring good luck to their owners.',14.00,50,451),
                                                                    ('Aloes mitriformis fluorescent',
'This dwarf version of Aloe has strong sturdy leaves arranged in rosettes with fine yellow-white serrations.
It is useful for many skin conditions as it eases pain and reduces inflammation.
Aloe also makes a great houseplant, it is very easy to grow and will thrive on any sunny windowsill 
with the minimum of effort.',20.00,50,450),
                                                                    ('Gardenia jasminoides',
'This beautiful plant is perfect for both indoors and out. The lovely rose-like flowers in ivory-white emit a heavy scent 
perfuming your living room or patio. In the language of flowers gardenia signifies ‘secret love’ 
and represents purity, refinement and peace.',14.00,50,784),
                                                                    ('Mini Apple Tree Malus Red Spur',
'Harvest your own delicious apples from this fine self-fertile mini apple tree. It produces full sized tasty
 fruit and makes an impressive display on your patio, decking, or just in the garden.',36.00,50,364),
                                                                    ('Aquilegia Spring Magic Blue',
'Aquilegia or Columbines produce fabulous shaped flowers which will be the talking point of your neighbours.
The dainty blooms with elegant spurs are exquisite and will come back to grace your garden year after year.
They are hardy, grow in sun or partial shade and are suitable for your herbaceous borders or for planters on your patio or decking.',22.00,50,123),
                                                                    ('Climbing Rose New Dawn',
'Climbing rose New Dawn is thought by many to be one of the best repeat-flowering climbing rose, producing medium sized, 
silvery blush-pink semi-double blossoms in attractive clusters with a sweet fruity fragrance all summer long.  
This vigorous climber flourishes in both sun or partial shade and its attractive dark green glossy foliage has 
a good disease resistance.',65.00,50,1204);
INSERT INTO product ("name","description",price,stock,views) VALUES ('Erica carnea White',
'This variety will provide you with white flowers and plenty of interest in your garden or on your patio long after other 
flowers have faded and the garden takes on a somewhat barren look. Not as fussy with soil as their counterparts, 
they will thrive in any well drained soil and form a low maintenance ground cover plant.',16.00,50,100),
                                                                   ('Amaryllis Floris Hekker',
'Hippeastrum Amaryllis Floris Hekker is an excellent variety to help brighten up your home. It produces plenty of large 
velvety-red blooms with deep dark red centres.It’s a great variety for an eye-catching display in your home or as a memorable
gift for a very special person. Plant your Amaryllis 8 weeks before you would like them to bloom!',18.00,50,150),
                                                                    ('Mini Lemon Tree',
'This cold resistant Lemon tree is highly decorative providing year round interest with its glossy evergreen leaves, 
pretty fragrant flowers and edible fruit.These miniature trees are easy to care for and ideal for on a sunny windowsill indoors, 
they can also be moved outdoors once temperatures are above freezing. ',26.00,50,650),
                                                                    ('Mini Phalaenopsis Purple',
'This New Miniature Phalaenopsis is so unusual and so cute. It arrives in flower making a wonderful gift. 
The long lasting dark Purple flowers make them perfect as centrepieces.',30.00,50,450),
                                                                    ('Crassula perforata Giant Form',
'Crassula perforata Giant Form is a rare succulent plant with pretty bluish red tips which sets off the grey/blue foliage beautifully. 
Jade plants make great housewarming gifts as they are often called the money plant 
or dollar plant, because they were once thought to bring good luck to their owners.',14.00,50,451),
                                                                    ('Aloes mitriformis fluorescent',
'This dwarf version of Aloe has strong sturdy leaves arranged in rosettes with fine yellow-white serrations.
It is useful for many skin conditions as it eases pain and reduces inflammation.
Aloe also makes a great houseplant, it is very easy to grow and will thrive on any sunny windowsill 
with the minimum of effort.',20.00,50,450),
                                                                    ('Gardenia jasminoides',
'This beautiful plant is perfect for both indoors and out. The lovely rose-like flowers in ivory-white emit a heavy scent 
perfuming your living room or patio. In the language of flowers gardenia signifies ‘secret love’ 
and represents purity, refinement and peace.',14.00,50,784),
                                                                    ('Mini Apple Tree Malus Red Spur',
'Harvest your own delicious apples from this fine self-fertile mini apple tree. It produces full sized tasty
 fruit and makes an impressive display on your patio, decking, or just in the garden.',36.00,50,364),
                                                                    ('Aquilegia Spring Magic Blue',
'Aquilegia or Columbines produce fabulous shaped flowers which will be the talking point of your neighbours.
The dainty blooms with elegant spurs are exquisite and will come back to grace your garden year after year.
They are hardy, grow in sun or partial shade and are suitable for your herbaceous borders or for planters on your patio or decking.',22.00,50,123),
                                                                    ('Climbing Rose New Dawn',
'Climbing rose New Dawn is thought by many to be one of the best repeat-flowering climbing rose, producing medium sized, 
silvery blush-pink semi-double blossoms in attractive clusters with a sweet fruity fragrance all summer long.  
This vigorous climber flourishes in both sun or partial shade and its attractive dark green glossy foliage has 
a good disease resistance.',65.00,50,1204);
INSERT INTO product ("name","description",price,stock,views) VALUES ('Erica carnea White',
'This variety will provide you with white flowers and plenty of interest in your garden or on your patio long after other 
flowers have faded and the garden takes on a somewhat barren look. Not as fussy with soil as their counterparts, 
they will thrive in any well drained soil and form a low maintenance ground cover plant.',16.00,50,100),
                                                                   ('Amaryllis Floris Hekker',
'Hippeastrum Amaryllis Floris Hekker is an excellent variety to help brighten up your home. It produces plenty of large 
velvety-red blooms with deep dark red centres.It’s a great variety for an eye-catching display in your home or as a memorable
gift for a very special person. Plant your Amaryllis 8 weeks before you would like them to bloom!',18.00,50,150),
                                                                    ('Mini Lemon Tree',
'This cold resistant Lemon tree is highly decorative providing year round interest with its glossy evergreen leaves, 
pretty fragrant flowers and edible fruit.These miniature trees are easy to care for and ideal for on a sunny windowsill indoors, 
they can also be moved outdoors once temperatures are above freezing. ',26.00,50,650),
                                                                    ('Mini Phalaenopsis Purple',
'This New Miniature Phalaenopsis is so unusual and so cute. It arrives in flower making a wonderful gift. 
The long lasting dark Purple flowers make them perfect as centrepieces.',30.00,50,450),
                                                                    ('Crassula perforata Giant Form',
'Crassula perforata Giant Form is a rare succulent plant with pretty bluish red tips which sets off the grey/blue foliage beautifully. 
Jade plants make great housewarming gifts as they are often called the money plant 
or dollar plant, because they were once thought to bring good luck to their owners.',14.00,50,451),
                                                                    ('Aloes mitriformis fluorescent',
'This dwarf version of Aloe has strong sturdy leaves arranged in rosettes with fine yellow-white serrations.
It is useful for many skin conditions as it eases pain and reduces inflammation.
Aloe also makes a great houseplant, it is very easy to grow and will thrive on any sunny windowsill 
with the minimum of effort.',20.00,50,450),
                                                                    ('Gardenia jasminoides',
'This beautiful plant is perfect for both indoors and out. The lovely rose-like flowers in ivory-white emit a heavy scent 
perfuming your living room or patio. In the language of flowers gardenia signifies ‘secret love’ 
and represents purity, refinement and peace.',14.00,50,784),
                                                                    ('Mini Apple Tree Malus Red Spur',
'Harvest your own delicious apples from this fine self-fertile mini apple tree. It produces full sized tasty
 fruit and makes an impressive display on your patio, decking, or just in the garden.',36.00,50,364),
                                                                    ('Aquilegia Spring Magic Blue',
'Aquilegia or Columbines produce fabulous shaped flowers which will be the talking point of your neighbours.
The dainty blooms with elegant spurs are exquisite and will come back to grace your garden year after year.
They are hardy, grow in sun or partial shade and are suitable for your herbaceous borders or for planters on your patio or decking.',22.00,50,123),
                                                                    ('Climbing Rose New Dawn',
'Climbing rose New Dawn is thought by many to be one of the best repeat-flowering climbing rose, producing medium sized, 
silvery blush-pink semi-double blossoms in attractive clusters with a sweet fruity fragrance all summer long.  
This vigorous climber flourishes in both sun or partial shade and its attractive dark green glossy foliage has 
a good disease resistance.',65.50,50,1204);

--R06
INSERT INTO "user" (username,email,password_hash,date,id_image,user_role) VALUES ('Seal','sed.dictum@eusem.ca','MMJ88EPA9AU','2015-01-26 12:19:47',11,'Customer'),('Navarro','senectus.et.netus@aarcu.com','JYG90CLM7NO','2016-02-14 16:03:25',13,'Customer'),('Rosa','semper.tellus@scelerisquemollis.net','XUI45BHW4MC','2018-10-28 09:42:00',12,'Customer'),('Wallace','sociis@vitaedolorDonec.org','TOJ48WCE2EY','2018-09-26 00:43:04',12,'Customer'),('Cunningham','urna.Nunc@eterosProin.org','RCM39OSA1SP','2018-09-26 21:57:58',13,'Manager'),('Flynn','eu.arcu.Morbi@temporaugueac.co.uk','RHM23ZHF5OX','2017-04-17 03:54:31',14,'Customer'),('Brady','egestas@dolortempus.com','VLQ80YJN3NL','2017-4-17 17:33:41',14,'Customer'),('Reynolds','ac@ipsumsodales.org','VMO93WZF7ZI','2016-06-15 11:28:45',12,'Customer'),('Mccall','erat.in@ornare.co.uk','XYQ55JBT6US','2016-5-19 21:07:17',14,'Customer'),('Morales','sagittis.augue.eu@blanditmattis.net','LUG55CNK2FF','2015-09-29 11:20:51',11,'Customer');
INSERT INTO "user" (username,email,password_hash,date,id_image,user_role) VALUES ('Mooney','Curabitur@Curabiturut.net','VYE08DQY9NC','2018-07-23 19:09:28',13,'Customer'),('Meyers','molestie.tortor.nibh@NulladignissimMaecenas.org','TOE84BLR2UB','2016-12-04 01:05:54',13,'Customer'),('Levy','risus.In@cursusaenim.ca','SVZ41HCC3GL','2015-04-19 08:12:00',11,'Customer'),('Howell','tincidunt@Duis.net','FUH32MKH5JD','2016-10-14 18:41:21',12,'Customer'),('Watson','sagittis.felis@euodio.net','UTI05IPB0RF','2015-08-07 23:20:13',14,'Customer'),('Hester','purus@etmalesuada.ca','UOM40WIO4MZ','2015-06-21 06:51:40',11,'Customer'),('Stout','lacus@etmagnisdis.net','HAE99HQA4UY','2016-02-23 11:23:18',12,'Customer'),('Henry','tortor.dictum@dictumPhasellusin.net','AJF61CUL7KL','2018-10-09 15:43:47',11,'Customer'),('Boyer','id.blandit@malesuadamalesuada.edu','QCC66IPA6SP','2016-03-03 03:23:02',14,'Customer'),('Pennington','aliquet.Proin@et.edu','DNN93MVZ6VH','2017-10-23 12:11:58',14,'Manager');
INSERT INTO "user" (username,email,password_hash,date,id_image,user_role) VALUES ('Bishop','gravida.sagittis@tincidunt.ca','ZSW35TZR8BE','2015-11-25 22:49:00',11,'Customer'),('Hurley','mollis.lectus@Cumsociisnatoque.co.uk','XNH23TQO4OQ','2015-08-15 21:25:04',13,'Customer'),('Fox','nec.mollis@Integeraliquamadipiscing.org','CVM61USP3EB','2015-10-05 19:42:04',11,'Customer'),('Smith','lobortis.risus.In@sollicitudinamalesuada.org','QFW04WHL7ZH','2016-01-20 07:18:42',12,'Customer'),('Sparks','Aliquam.fringilla.cursus@ipsumportaelit.net','ZZU20RDL9EN','2015-02-04 18:49:42',11,'Customer'),('Rodgers','et.netus@pede.com','OZP37SVF2ET','2020-01-25 21:50:05',12,'Manager'),('Roy','semper.cursus.Integer@nislarcuiaculis.ca','AHT65JAB9PP','2016-11-16 17:45:42',12,'Customer'),('Koch','odio.semper@seddictumeleifend.co.uk','YUF63OVE5ML','2016-06-22 17:43:45',13,'Manager'),('Mcmahon','Nunc@facilisismagna.org','AZP55TVC9KW','2020-01-21 07:14:08',12,'Customer'),('Gutierrez','euismod.ac@nonjusto.edu','PEN01QRY7EP','2016-05-18 04:18:06',14,'Customer');
INSERT INTO "user" (username,email,password_hash,date,id_image,user_role) VALUES ('Mccray','tempor.augue.ac@dapibus.net','IFD40ELF3TL','2016-01-22 12:11:17',12,'Manager'),('Marsh','pede@Lorem.net','VJR87DYO4RX','2015-02-18 11:10:53',14,'Customer'),('Neal','ut.quam.vel@ategestasa.com','NUE74QJS9NG','2015-09-17 13:11:36',14,'Customer'),('Combs','eleifend.vitae@utlacusNulla.ca','QPB79APV9MQ','2016-01-24 21:16:31',12,'Customer'),('Spencer','lorem@quislectus.co.uk','SFK49MPQ2CI','2015-03-11 06:52:33',13,'Customer'),('Lang','sed.dolor@etipsum.com','NRK70OAT5XV','2016-04-05 10:08:41',11,'Customer'),('Huff','ipsum@enimconsequatpurus.org','MNP10AAE9WO','2015-04-19 01:27:38',14,'Customer'),('Larson','Nullam@parturientmontesnascetur.ca','WON19LVB6RE','2015-03-12 07:09:08',11,'Customer'),('Avila','sollicitudin@Intinciduntcongue.co.uk','INP17WZM8BE','2020-01-13 13:38:00',14,'Customer'),('Gross','ullamcorper.magna@dolorvitae.net','PYU98URW6XS','2017-04-29 13:07:05',11,'Manager');
INSERT INTO "user" (username,email,password_hash,date,id_image,user_role) VALUES ('Salinas','rutrum@etmalesuada.ca','PBU60BOJ2EQ','2016-01-08 11:34:35',14,'Customer'),('Hanson','condimentum.Donec.at@Vestibulumaccumsanneque.co.uk','GCL91GSR3QG','2017-03-02 11:28:40',14,'Customer'),('Moses','congue.a.aliquet@facilisisfacilisismagna.edu','PXW74APJ9DW','2017-04-25 20:14:23',14,'Customer'),('Macdonald','lectus.sit@quam.net','JTQ52ZJN6DC','2015-09-29 12:40:55',13,'Customer'),('Riley','eu@convallisante.ca','NYR81ZRT4HJ','2016-06-08 09:28:20',13,'Customer'),('Trujillo','netus.et.malesuada@utipsum.ca','CDV74JBN5SH','2017-01-30 19:52:48',12,'Manager'),('Pope','Aliquam.erat.volutpat@duisemperet.com','MKK14GLN6RI','2016-02-13 03:16:52',12,'Customer'),('Williams','nascetur.ridiculus@nonenimcommodo.com','YEF19DCA8YN','2015-09-29 19:15:10',12,'Customer'),('Steele','Donec.felis.orci@lectus.ca','JOX13OKL9DW','2016-04-20 16:05:51',11,'Customer'),('Christensen','lobortis.tellus.justo@diamPellentesquehabitant.edu','GNK94QSX5HZ','2015-07-04 09:27:57',14,'Customer');
--R02
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,id_user) VALUES (12548,'537-2734 Tristique Rd.','563-4525 Libero St.','2018-10-12 13:36:05','Bank_Transfer',18),(12550,'114-7313 Lacus. Rd.','P.O. Box 371, 3830 Dolor Road','2017-05-19 21:41:56','Bank_Transfer',7),(12552,'3332 Ante, Road','P.O. Box 471, 9514 Sollicitudin St.','2015-09-04 03:50:43','Stripe',25),(12554,'P.O. Box 799, 5485 Eu Av.','615-6014 Dui. St.','2020-08-16 23:47:36','Bank_Transfer',49),(12556,'P.O. Box 473, 3684 Adipiscing Ave','P.O. Box 792, 4734 Sagittis Rd.','2017-03-22 13:28:07','Bank_Transfer',42),(12558,'P.O. Box 871, 445 Et, St.','P.O. Box 634, 7675 Id Street','2020-04-02 03:17:42','Stripe',4),(12560,'P.O. Box 489, 9021 Pede. Ave','P.O. Box 937, 7384 Nec Rd.','2016-10-04 06:00:19','Bank_Transfer',32),(12562,'4001 Enim. Rd.','292 Aliquam, St.','2015-04-07 01:50:13','Stripe',35),(12564,'5175 Augue, Rd.','Ap #925-9497 Eu Rd.','2015-03-20 20:07:28','Bank_Transfer',38),(12566,'505-6519 Ipsum Av.','326-3370 Molestie Avenue','2019-06-07 03:38:14','Stripe',8);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,id_user) VALUES (12568,'P.O. Box 564, 1935 Est, Avenue','711-1359 Dui Street','2018-08-18 15:51:37','Bank_Transfer',11),(12570,'5548 Tempus St.','P.O. Box 867, 746 Vel Avenue','2019-03-18 17:09:20','Bank_Transfer',18),(12572,'Ap #989-7150 Ipsum Avenue','P.O. Box 437, 9187 Dis Rd.','2016-03-19 18:22:45','Stripe',19),(12574,'Ap #351-9276 Suspendisse Rd.','P.O. Box 548, 3669 Ligula. Avenue','2018-07-05 02:18:02','Stripe',21),(12576,'Ap #850-5591 Elit. Street','163 Metus Ave','2018-05-26 12:35:27','Bank_Transfer',12),(12578,'Ap #294-5749 Amet, Road','P.O. Box 463, 7406 Quis Road','2020-02-19 14:27:36','Stripe',39),(12580,'P.O. Box 188, 1387 Eget Ave','Ap #172-9459 Class Road','2015-05-02 05:37:59','Bank_Transfer',37),(12582,'9423 Pellentesque Rd.','Ap #843-2471 Nisi. St.','2019-02-27 17:53:11','Stripe',11),(12584,'P.O. Box 174, 1074 Nam Road','1999 Sollicitudin Rd.','2017-12-12 23:34:26','Bank_Transfer',16),(12586,'P.O. Box 902, 9352 Aliquet Avenue','397-4831 Urna Av.','2016-05-17 03:37:16','Bank_Transfer',49);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,id_user) VALUES (12588,'621-7735 Elit, Rd.','P.O. Box 201, 8149 Adipiscing Av.','2017-11-24 21:08:35','Bank_Transfer',38),(12590,'2923 Neque Ave','409-6628 Tellus. St.','2016-03-29 05:55:50','Bank_Transfer',17),(12592,'Ap #692-1824 Donec Avenue','880-9004 Lacus. Rd.','2016-12-23 15:59:15','Bank_Transfer',27),(12594,'P.O. Box 422, 9340 Dictum Rd.','6046 Libero. Rd.','2017-05-04 20:24:05','Bank_Transfer',6),(12596,'769-9224 Libero. Rd.','463-1095 Neque St.','2019-01-28 11:13:26','Stripe',4),(12598,'205-6154 Velit. Road','435-2800 Lobortis Street','2015-10-26 12:55:29','Stripe',15),(12600,'412-7370 At Av.','P.O. Box 212, 8662 Interdum Av.','2017-05-03 16:43:22','Stripe',1),(12602,'871-8594 In Avenue','Ap #188-4603 Bibendum St.','2019-04-28 17:57:56','Bank_Transfer',6),(12604,'533-7667 Enim. Ave','Ap #907-9895 Dictum Road','2020-02-12 13:23:51','Bank_Transfer',29),(12606,'756-6680 Magna. St.','P.O. Box 815, 4116 Nunc Av.','2016-10-25 18:44:31','Bank_Transfer',14);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,id_user) VALUES (12608,'P.O. Box 324, 2810 Nascetur St.','P.O. Box 732, 5762 Est Road','2016-01-10 15:10:34','Bank_Transfer',41),(12610,'3061 Quis, St.','3716 Feugiat St.','2018-06-17 18:49:19','Stripe',42),(12612,'2388 Vel Ave','9431 Vel Av.','2016-06-09 03:45:40','Bank_Transfer',45),(12614,'Ap #556-1283 Eu Av.','Ap #246-3937 Dolor. Rd.','2016-08-31 15:30:16','Stripe',8),(12616,'Ap #790-6396 A Road','839-6746 Tellus Avenue','2015-10-10 13:48:29','Stripe',10),(12618,'Ap #111-5738 Ultricies Ave','P.O. Box 950, 4536 Purus. Street','2019-04-01 16:33:19','Stripe',4),(12620,'P.O. Box 131, 2200 Pretium St.','809-311 Neque St.','2019-08-16 17:39:31','Bank_Transfer',24),(12622,'8943 Phasellus Avenue','P.O. Box 352, 8433 Est Avenue','2019-12-06 20:39:26','Bank_Transfer',24),(12624,'469-2740 Vivamus St.','Ap #628-5019 Quam. Road','2017-12-07 17:51:56','Bank_Transfer',1),(12626,'517-6109 In Ave','854-8505 Duis Ave','2020-02-13 16:43:53','Stripe',33);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,id_user) VALUES (12628,'829-6026 Nec, Road','Ap #448-9372 Curabitur Rd.','2015-11-30 15:33:34','Stripe',48),(12630,'290-7919 Magna. Ave','Ap #747-8527 Tellus Ave','2016-06-02 19:22:13','Bank_Transfer',30),(12632,'658-9709 Cum Street','396-3877 Sed Rd.','2018-03-23 19:27:48','Stripe',30),(12634,'P.O. Box 529, 2784 Porttitor St.','688-802 Placerat Rd.','2018-02-07 17:29:24','Bank_Transfer',41),(12636,'Ap #369-5380 Egestas. Street','Ap #159-7467 Elit, Ave','2015-11-03 10:28:44','Bank_Transfer',16),(12638,'3143 Hendrerit Ave','327-1636 Quis Street','2016-11-01 21:01:01','Stripe',8),(12640,'P.O. Box 573, 5114 Nulla. St.','P.O. Box 723, 1800 Blandit Ave','2019-10-23 11:29:58','Bank_Transfer',35),(12642,'Ap #598-1715 Purus, Avenue','202 Tempor Rd.','2016-08-10 18:51:02','Stripe',34),(12644,'470-6858 Sapien, St.','Ap #800-6163 Enim. St.','2017-12-09 21:11:24','Stripe',37),(12646,'Ap #489-6730 Magna Avenue','410-722 Morbi St.','2020-03-08 19:33:22','Bank_Transfer',50);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,id_user) VALUES (12648,'Ap #115-9850 Libero St.','P.O. Box 565, 4091 Ultrices. Rd.','2016-07-02 14:02:26','Stripe',8),(12650,'P.O. Box 874, 6219 Ante. Ave','414-6530 Odio. St.','2015-09-26 23:46:28','Bank_Transfer',32),(12652,'P.O. Box 454, 899 Quis, Avenue','P.O. Box 353, 3707 Dolor. St.','2016-01-30 19:38:36','Stripe',23),(12654,'2603 Tincidunt Rd.','577-2135 Cursus. Road','2015-10-26 00:18:54','Bank_Transfer',23),(12656,'199-9424 Convallis Street','P.O. Box 801, 1780 Non, Rd.','2016-05-29 01:54:05','Bank_Transfer',36),(12658,'868-8585 Nascetur Rd.','P.O. Box 490, 2727 Congue Avenue','2015-10-06 18:15:00','Bank_Transfer',44),(12660,'334 Mauris Av.','7675 Ullamcorper, Rd.','2018-05-08 16:27:20','Bank_Transfer',42),(12662,'8670 Ligula Road','165-1112 Facilisis, St.','2017-10-22 14:07:24','Stripe',9),(12664,'P.O. Box 161, 8151 Faucibus. Rd.','P.O. Box 686, 2691 Amet Rd.','2019-06-26 16:33:28','Stripe',27),(12666,'Ap #618-4197 Inceptos Road','6296 Nec St.','2019-03-09 07:11:58','Bank_Transfer',1);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,id_user) VALUES (12668,'P.O. Box 582, 9509 Convallis Rd.','Ap #449-9559 Lectus Av.','2015-10-17 05:22:04','Bank_Transfer',16),(12670,'9140 Enim. Road','708-1005 Pellentesque Rd.','2018-11-24 08:44:17','Stripe',3),(12672,'Ap #715-6916 Proin Avenue','P.O. Box 815, 8411 Dictum Rd.','2015-08-10 16:03:39','Bank_Transfer',15),(12674,'Ap #871-9804 Id, Road','P.O. Box 650, 1768 Ante Rd.','2019-09-19 17:29:39','Bank_Transfer',7),(12676,'4431 Imperdiet Ave','781-7929 Amet Road','2015-08-14 23:40:25','Stripe',50),(12678,'Ap #897-5578 Nulla Av.','P.O. Box 451, 8944 Dolor Avenue','2018-05-24 06:33:30','Stripe',45),(12680,'538 Curabitur Road','Ap #155-1469 Mauris Av.','2018-01-22 10:05:14','Bank_Transfer',2),(12682,'7413 Tellus Rd.','2577 Duis Rd.','2018-08-15 22:44:45','Bank_Transfer',42),(12684,'6594 Elit. St.','765-1417 Odio. St.','2016-05-20 09:09:09','Stripe',9),(12686,'Ap #858-7499 Ac Street','6914 Ligula. Av.','2017-05-05 13:29:57','Stripe',43);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,id_user) VALUES (12688,'P.O. Box 893, 5647 Duis Av.','P.O. Box 296, 4055 Sapien, Ave','2016-02-23 21:20:19','Bank_Transfer',47),(12690,'P.O. Box 818, 1159 Lorem, Street','6052 Erat Rd.','2016-11-21 17:04:18','Bank_Transfer',15),(12692,'P.O. Box 683, 1250 Nullam St.','Ap #367-2354 Adipiscing St.','2018-04-17 16:41:16','Bank_Transfer',36),(12694,'9012 Felis Rd.','6748 Amet Street','2017-11-15 20:06:17','Stripe',49),(12696,'P.O. Box 892, 7201 Suspendisse St.','6064 In, Road','2018-11-28 19:02:30','Stripe',4),(12698,'Ap #754-722 Cursus Ave','3276 Vitae, Rd.','2016-12-13 21:26:22','Bank_Transfer',12),(12700,'P.O. Box 426, 8810 Lacus. Street','P.O. Box 622, 3114 Fusce Av.','2017-10-13 05:28:04','Stripe',15),(12702,'P.O. Box 613, 1291 Vehicula. St.','327-7662 Sit Av.','2019-12-28 11:40:04','Bank_Transfer',48),(12704,'Ap #314-7479 Velit St.','873 Magnis Rd.','2020-07-20 03:30:32','Stripe',33),(12706,'599-2883 Turpis. St.','Ap #404-8648 Nunc Av.','2016-10-01 05:30:32','Bank_Transfer',1);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,id_user) VALUES (12708,'632 Nec Street','451-9571 Arcu Road','2015-09-19 12:29:05','Bank_Transfer',33),(12710,'584 Lectus, St.','Ap #786-798 A Road','2015-04-26 16:37:06','Stripe',13),(12712,'Ap #764-8927 Diam. St.','8624 Felis Avenue','2020-03-25 04:35:28','Stripe',2),(12714,'Ap #612-2415 Consequat, Rd.','Ap #388-9520 Tellus Avenue','2019-12-31 16:37:43','Stripe',50),(12716,'P.O. Box 372, 7246 Vel, Rd.','917-7790 Nunc St.','2017-04-12 07:26:53','Stripe',12),(12718,'7121 Dis St.','Ap #785-5461 Lacus. Road','2019-02-14 08:06:58','Stripe',18),(12720,'191-7912 Mauris Ave','P.O. Box 811, 4343 Vivamus St.','2018-10-08 11:20:30','Bank_Transfer',4),(12722,'Ap #533-7285 Rhoncus Rd.','8343 Placerat, Rd.','2016-07-10 14:04:36','Stripe',21),(12724,'Ap #531-7605 Nulla Road','5937 Dui, St.','2016-11-15 22:07:23','Bank_Transfer',17),(12726,'707-2329 Id, Street','P.O. Box 740, 5001 Curabitur Rd.','2019-07-11 01:25:51','Stripe',49);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,id_user) VALUES (12728,'Ap #420-9999 Morbi St.','7102 Nec St.','2016-05-27 15:32:46','Bank_Transfer',2),(12730,'P.O. Box 844, 7429 Orci Road','P.O. Box 243, 4826 A, Road','2017-03-23 01:10:04','Bank_Transfer',1),(12732,'356-918 Tincidunt Ave','P.O. Box 967, 4955 Laoreet Street','2017-07-02 08:41:18','Stripe',22),(12734,'865-9867 Egestas St.','900-2292 Eu, Av.','2019-10-06 17:22:41','Bank_Transfer',3),(12736,'P.O. Box 160, 3189 Et, St.','P.O. Box 628, 3034 In Rd.','2018-12-08 15:38:40','Stripe',2),(12738,'9761 Ipsum Rd.','P.O. Box 825, 4684 Varius Rd.','2020-10-28 17:42:31','Bank_Transfer',17),(12740,'Ap #396-9072 Ac Rd.','144-3029 Pede. St.','2016-08-06 23:03:33','Stripe',1),(12742,'P.O. Box 661, 3834 Nibh Av.','P.O. Box 512, 6538 Enim. St.','2017-12-17 08:30:28','Bank_Transfer',24),(12744,'1764 Et Road','P.O. Box 831, 3767 Vestibulum St.','2017-10-15 21:23:25','Stripe',8),(12746,'Ap #470-721 Fermentum Av.','615-6212 Pede St.','2017-03-01 02:58:47','Stripe',10);

--R03
INSERT INTO product_order (id_product,id_order,quantity) VALUES (16,40,2),(71,44,7),(86,16,12),(54,79,8),(2,99,5),(84,41,16),(22,77,19),(53,3,19),(93,35,13),(70,42,15);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (4,92,13),(42,44,12),(87,70,3),(29,90,10),(87,68,4),(34,87,18),(83,13,1),(68,84,6),(43,38,7),(31,66,20);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (22,98,19),(38,49,18),(57,77,14),(20,58,18),(59,55,6),(39,4,15),(52,38,15),(34,86,1),(98,38,8),(32,34,11);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (95,28,3),(75,31,3),(96,77,5),(91,66,7),(34,68,9),(36,55,19),(86,56,10),(52,14,12),(15,4,8),(48,36,8);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (13,40,3),(62,50,5),(46,77,11),(78,47,8),(99,40,7),(67,21,13),(28,33,18),(7,31,14),(16,84,7),(69,17,12);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (37,83,9),(56,49,18),(99,78,19),(40,68,3),(26,39,6),(97,9,9),(65,41,12),(72,90,3),(30,16,8),(12,52,5);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (20,93,19),(51,4,11),(59,13,9),(36,70,4),(85,82,12),(10,89,9),(90,43,12),(5,81,15),(48,78,18),(69,19,7);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (74,38,7),(55,68,9),(42,40,2),(57,12,15),(49,25,11),(61,3,9),(27,31,12),(88,77,4),(29,35,6),(24,34,14);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (41,39,1),(1,39,6),(27,98,6),(83,50,11),(96,14,16),(30,8,14),(90,76,14),(3,87,20),(56,50,15),(69,57,6);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (57,98,5),(24,75,19),(71,100,6),(100,96,7),(6,74,18),(15,64,18),(91,48,9),(87,85,7),(15,67,3),(16,34,2), (16, 39, 1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (63,1,6),(97,2,2),(4,3,10),(17,4,9),(37,5,1),(24,6,8),(47,7,4),(13,8,5),(57,9,1),(2,10,5);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (28,11,3),(56,13,1),(12,14,9),(54,15,2),(24,16,1),(34,17,10),(73,18,9),(87,19,10),(54,20,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (21,21,3),(9,22,3),(52,23,10),(78,24,2),(64,25,10),(74,26,2),(58,27,1),(30,28,3),(62,29,6),(11,30,5);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (62,31,4),(21,32,8),(84,33,8),(37,34,8),(53,35,8),(74,36,9),(91,37,1),(32,38,5),(55,39,10),(1,40,8);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (68,41,4),(8,42,10),(32,43,1),(43,44,9),(84,45,2),(60,46,8),(76,47,10),(87,48,3),(41,49,8),(87,50,7);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (61,51,10),(41,52,5),(63,53,7),(80,54,7),(33,55,10),(70,56,7),(25,57,6),(9,58,8),(95,59,9),(98,60,4);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (83,61,3),(92,62,8),(84,63,5),(75,64,8),(93,65,5),(5,66,8),(56,67,10),(90,68,3),(53,69,8),(50,70,5);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (3,71,8),(91,72,5),(21,73,3),(60,74,4),(1,75,6),(63,76,6),(17,77,7),(87,78,5),(41,79,10),(14,80,3);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (53,81,8),(29,82,9),(84,83,6),(15,84,4),(16,85,7),(15,86,8),(73,87,4),(93,88,4),(13,89,2),(16,90,5);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (33,91,4),(24,92,8),(2,93,1),(20,94,8),(20,95,4),(22,96,2),(72,97,10),(60,98,6),(41,99,6),(27,100,10);

--R04
INSERT INTO review (id_product,id_order,description,rating,review_date) VALUES (16,40,'Loved this lovely plant! Very easy to take care',5,'2020-02-14 12:20:13'),(20,93,'Loved this lovely plant! Very easy to take care',5,'2017-07-05 08:41:18'),(20,58,'Really happy to try out this brand, great products and costumer support!',1,'2017-10-28 14:07:24'),(57,12,'Great product!',3,'2019-03-22 17:09:20');
INSERT INTO review (id_product,id_order,description,rating,review_date) VALUES (16,84,'Kinda dissapointed with the plant quality',4,'2020-01-07 16:37:43'),(42,40,'Really happy to try out this brand, great products and costumer support!',2,'2020-02-14 12:24:13'),(48,78,'Loved this lovely plant! Very easy to take care',1,'2019-12-31 11:40:04'),(69,17,'Loved this lovely plant! Very easy to take care',2,'2015-05-08 05:37:59');
INSERT INTO review (id_product,id_order,description,rating,review_date) VALUES (71,44,'Really happy to try out this brand, great products and costumer support!',5,'2018-02-13 17:29:24'),(16,34,'Kinda dissapointed with the plant quality',1,'2016-09-03 15:30:16'),(57,98,'Loved this lovely plant! Very easy to take care',1,'2017-12-24 08:30:28'),(69,19,'Really happy to try out this brand, great products and costumer support!',2,'2017-12-20 23:34:26');
INSERT INTO review (id_product,id_order,description,rating,review_date) VALUES (46,77,'Really happy to try out this brand, great products and costumer support!',5,'2017-10-17 05:28:04'),(59,55,'Kinda dissapointed with the plant quality',4,'2016-06-02 01:54:05'),(57,77,'Kinda dissapointed with the plant quality',3,'2017-10-17 05:33:04'),(69,57,'Really happy to try out this brand, great products and costumer support!',5,'2018-05-14 16:27:20');
INSERT INTO review (id_product,id_order,description,rating,review_date) VALUES (59,13,'Really happy to try out this brand, great products and costumer support!',2,'2016-03-24 18:22:45'),(42,44,'Loved this lovely plant! Very easy to take care',3,'2018-02-13 17:32:24'),(71,100,'Great product!',4,'2017-03-07 02:58:47'),(16,39,'Loved this lovely plant! Very easy to take care',2,'2017-12-15 17:51:56');


--R05
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2020-04-30 13:59:14',1,'Ready_for_Shipping'),('2021-02-05 13:01:42',2,'Processed'),('2020-12-16 13:40:37',3,'Awaiting_Payment'),('2021-01-03 04:16:58',4,'Ready_for_Shipping'),('2020-04-11 13:04:18',5,'Ready_for_Shipping'),('2020-09-08 03:05:35',6,'Processed'),('2019-05-29 07:28:16',7,'Awaiting_Payment'),('2020-01-02 00:09:57',8,'Processed'),('2020-04-06 09:40:03',9,'Processed'),('2021-01-25 13:07:57',10,'Awaiting_Payment');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2020-01-06 02:19:06',11,'Ready_for_Shipping'),('2019-11-06 08:45:52',12,'Awaiting_Payment'),('2021-01-14 16:36:31',13,'Awaiting_Payment'),('2020-06-02 02:46:01',14,'Processed'),('2020-04-14 05:17:46',15,'Ready_for_Shipping'),('2020-12-01 22:52:05',16,'Ready_for_Shipping'),('2020-11-17 00:56:38',17,'Ready_for_Shipping'),('2019-07-12 13:34:37',18,'Processed'),('2020-04-24 22:18:16',19,'Awaiting_Payment'),('2020-10-17 04:32:40',20,'Processed');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2020-02-03 10:36:50',21,'Processed'),('2019-05-01 11:29:00',22,'Processed'),('2020-12-01 23:06:37',23,'Awaiting_Payment'),('2020-01-04 01:45:59',24,'Awaiting_Payment'),('2019-05-18 05:43:05',25,'Ready_for_Shipping'),('2020-01-05 09:33:48',26,'Processed'),('2020-07-03 11:03:50',27,'Processed'),('2020-03-28 09:37:09',28,'Ready_for_Shipping'),('2020-06-21 17:31:28',29,'Awaiting_Payment'),('2019-05-30 06:51:43',30,'Ready_for_Shipping');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2020-10-25 01:45:25',31,'Awaiting_Payment'),('2019-11-30 19:46:47',32,'Processed'),('2020-02-07 05:56:22',33,'Awaiting_Payment'),('2020-03-14 21:05:00',34,'Awaiting_Payment'),('2020-11-05 19:08:42',35,'Awaiting_Payment'),('2019-07-04 09:25:30',36,'Awaiting_Payment'),('2020-05-02 22:07:41',37,'Ready_for_Shipping'),('2020-02-13 05:43:54',38,'Processed'),('2020-02-24 17:31:46',39,'Processed'),('2020-09-14 08:43:32',40,'Processed');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2021-01-15 18:29:00',41,'Awaiting_Payment'),('2020-08-16 03:18:50',42,'Ready_for_Shipping'),('2019-07-25 12:44:06',43,'Ready_for_Shipping'),('2020-04-15 03:16:45',44,'Awaiting_Payment'),('2020-11-23 09:22:29',45,'Ready_for_Shipping'),('2019-12-08 13:09:58',46,'Ready_for_Shipping'),('2020-03-19 05:33:19',47,'Ready_for_Shipping'),('2020-08-16 21:28:38',48,'Processed'),('2019-08-08 02:28:59',49,'Awaiting_Payment'),('2021-03-19 03:49:56',50,'Processed');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2020-01-30 19:58:05',51,'Ready_for_Shipping'),('2020-08-09 00:22:33',52,'Processed'),('2019-07-26 00:44:27',53,'Processed'),('2021-02-06 16:40:08',54,'Processed'),('2019-04-16 15:58:24',55,'Awaiting_Payment'),('2019-04-20 10:32:55',56,'Processed'),('2019-04-15 16:19:15',57,'Awaiting_Payment'),('2020-07-22 04:38:28',58,'Awaiting_Payment'),('2019-12-14 00:08:39',59,'Processed'),('2020-02-28 02:08:11',60,'Ready_for_Shipping');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2020-07-17 21:23:03',61,'Awaiting_Payment'),('2020-11-09 06:46:50',62,'Awaiting_Payment'),('2019-04-07 14:56:35',63,'Awaiting_Payment'),('2020-08-07 08:15:59',64,'Ready_for_Shipping'),('2019-08-31 00:39:24',65,'Awaiting_Payment'),('2019-07-15 21:54:32',66,'Awaiting_Payment'),('2020-08-24 21:10:11',67,'Processed'),('2020-09-30 00:15:59',68,'Processed'),('2020-06-01 21:02:16',69,'Awaiting_Payment'),('2020-12-05 05:20:14',70,'Ready_for_Shipping');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2021-01-29 12:49:03',71,'Processed'),('2020-09-04 08:25:40',72,'Ready_for_Shipping'),('2019-09-15 02:38:01',73,'Processed'),('2020-06-01 08:43:51',74,'Awaiting_Payment'),('2020-05-11 23:25:50',75,'Ready_for_Shipping'),('2019-10-07 23:20:37',76,'Processed'),('2021-02-25 08:46:30',77,'Ready_for_Shipping'),('2020-01-14 09:14:00',78,'Ready_for_Shipping'),('2019-09-30 22:43:25',79,'Ready_for_Shipping'),('2019-10-07 17:31:12',80,'Awaiting_Payment');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2020-09-05 03:46:59',81,'Awaiting_Payment'),('2020-07-11 08:05:35',82,'Ready_for_Shipping'),('2020-02-26 18:37:05',83,'Ready_for_Shipping'),('2020-09-07 06:33:37',84,'Awaiting_Payment'),('2020-06-20 08:47:49',85,'Processed'),('2019-11-22 09:29:22',86,'Awaiting_Payment'),('2019-10-01 12:43:22',87,'Ready_for_Shipping'),('2020-12-16 14:17:24',88,'Ready_for_Shipping'),('2020-06-18 12:37:25',89,'Ready_for_Shipping'),('2019-04-29 02:46:49',90,'Ready_for_Shipping');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-11-24 11:43:09',91,'Awaiting_Payment'),('2020-01-19 04:54:47',92,'Processed'),('2019-05-28 10:42:34',93,'Ready_for_Shipping'),('2019-06-12 20:18:59',94,'Awaiting_Payment'),('2020-07-28 12:18:18',95,'Processed'),('2020-08-11 20:23:10',96,'Ready_for_Shipping'),('2019-11-18 10:34:23',97,'Processed'),('2019-04-27 00:29:44',98,'Processed'),('2020-05-07 05:39:15',99,'Ready_for_Shipping'),('2019-10-18 16:13:03',100,'Processed');

--R07
INSERT INTO wishlist (name,id_user) VALUES (' Flowers ',23),(' Accessories',20),(' Accessories',23),(' Vases ',23),(' Vases ',38),(' Tulips ',8),('Orchids ',29),(' Flowers ',17),('Orchids ',44),(' Flowers ',22);
INSERT INTO wishlist (name,id_user) VALUES (' Accessories',32),(' Accessories',14),(' Accessories',16),(' Vases ',17),(' Flowers ',32),(' Tulips ',10),(' Flowers ',22),('Orchids ',33),(' Vases ',32),(' Tulips ',48);
INSERT INTO wishlist (name,id_user) VALUES ('Orchids ',12),('Orchids ',48),('Orchids ',36),(' Tulips ',46),(' Vases ',3),('Orchids ',39),(' Flowers ',4),('Orchids ',37),(' Accessories',30),('Orchids ',32);
INSERT INTO wishlist (name,id_user) VALUES (' Accessories',43),(' Tulips ',26),(' Flowers ',14),(' Accessories',46),(' Vases ',16),(' Tulips ',40),(' Accessories',12),(' Accessories',20),(' Accessories',22),('Orchids ',42);
INSERT INTO wishlist (name,id_user) VALUES (' Flowers ',38),('Orchids ',49),('Orchids ',21),(' Tulips ',7),('Orchids ',2),('Orchids ',35),(' Flowers ',3),(' Accessories',21),(' Flowers ',6),(' Flowers ',24);

--R08
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (32,20),(25,32),(31,18),(65,21),(93,18),(45,26),(77,20),(1,5),(60,8),(59,14);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (93,27),(15,24),(5,15),(55,21),(17,33),(24,4),(53,38),(34,3),(18,23),(23,31);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (78,39),(64,3),(26,34),(65,2),(28,8),(89,22),(93,17),(96,38),(7,17),(21,4);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (85,14),(17,29),(81,9),(46,16),(51,6),(84,40),(2,22),(71,14),(16,25),(19,34);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (92,12),(85,17),(30,23),(81,31),(23,29),(55,25),(91,14),(93,21),(34,28),(11,18);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (69,33),(14,8),(4,28),(87,20),(85,31),(21,16),(39,3),(50,2),(9,10),(5,31);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (15,16),(2,17),(67,16),(53,20),(29,4),(96,10),(92,21),(52,32),(51,8),(86,6);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (94,36),(27,4),(94,19),(22,40),(69,7),(45,5),(36,10),(57,11),(31,36),(39,16);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (42,17),(30,36),(53,4),(42,28),(85,15),(27,27),(91,25),(90,16),(99,37),(86,31);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (15,38),(75,3),(45,24),(60,24),(77,12),(48,28),(15,33),(69,34),(17,10),(20,15);

--R09
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (43,70,10),(2,44,14),(1,38,17),(21,14,11),(40,68,15),(22,81,20),(24,35,19),(27,87,11),(24,8,7),(2,20,9);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (37,6,9),(17,98,18),(21,12,12),(48,85,18),(48,49,20),(17,49,4),(25,13,8),(41,18,20),(29,36,14),(20,9,20);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (25,35,12),(11,12,10),(46,60,5),(32,36,4),(11,96,1),(12,47,17),(27,55,7),(48,86,1),(26,88,9),(43,96,17);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (19,55,8),(38,45,1),(13,1,1),(29,78,19),(23,84,6),(46,43,20),(50,93,10),(13,56,16),(22,24,18),(18,18,17);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (20,65,3),(46,59,10),(45,3,16),(12,16,8),(15,17,10),(33,98,9),(4,87,9),(50,60,6),(9,37,17),(33,1,15);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (17,95,8),(36,43,6),(44,18,6),(38,12,4),(30,25,15),(14,98,16),(48,82,8),(8,27,8),(20,50,1),(25,5,6);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (7,68,11),(22,11,2),(25,51,20),(8,72,5),(47,72,3),(7,50,12),(41,33,1),(25,54,11),(37,1,10),(24,43,18);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (39,75,2),(6,100,1),(2,16,11),(16,78,1),(46,14,3),(15,29,19),(5,97,10),(8,18,6),(45,36,11),(31,36,6);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (27,56,8),(45,62,12),(38,83,6),(33,34,11),(40,30,1),(49,64,11),(8,52,16),(10,92,15),(29,98,15),(10,29,6);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (7,72,3),(44,19,1),(35,96,14),(23,57,10),(37,35,20),(14,48,18),(34,55,4),(40,66,17),(32,73,14),(35,93,11);

--R10
INSERT INTO discount ("percentage",date_begin,date_end) VALUES (96,'2019-04-11','2019-12-21'),(88,'2020-02-25','2020-06-26'),(2,'2020-01-11','2020-02-02'),(88,'2019-08-03','2019-11-09');
INSERT INTO discount ("percentage",date_begin,date_end) VALUES (2,'2020-02-01','2020-09-20'),(3,'2020-03-10','2020-07-30'),(53,'2019-02-25','2020-06-29'),(41,'2020-10-21','2021-01-27');
INSERT INTO discount ("percentage",date_begin,date_end) VALUES (42,'2019-04-18','2020-11-30'),(94,'2020-08-11','2021-07-07'),(33,'2019-06-12','2020-04-21'),(65,'2019-09-27','2019-12-21');
INSERT INTO discount ("percentage",date_begin,date_end) VALUES (31,'2020-06-30','2020-07-05'),(27,'2020-03-20','2020-07-07'),(77,'2019-12-11','2020-03-10'),(4,'2019-04-07','2020-06-21');
INSERT INTO discount ("percentage",date_begin,date_end) VALUES (18,'2019-03-25','2019-08-17'),(79,'2020-05-18','2020-12-05'),(47,'2020-07-13','2021-02-08'),(80,'2020-10-10','2020-10-20');

--R11
INSERT INTO discount_code (id_discount,code) VALUES (2,'Guy'),(4,'Yoshi'),(1,'Callie'),(5,'Raja'),(16,'Rudyard');
INSERT INTO discount_code (id_discount,code) VALUES (20,'Noelani'),(9,'Ralph'),(6,'Russell'),(7,'Nehru'),(10,'Salvador');

--R12
INSERT INTO apply_discount (id_product,id_discount) VALUES (21,4),(10,1),(27,14),(44,3),(91,14);
INSERT INTO apply_discount (id_product,id_discount) VALUES (20,11),(95,8),(34,1),(55,11),(49,18);
INSERT INTO apply_discount (id_product,id_discount) VALUES (84,10),(96,17),(6,18),(20,9),(63,8);
INSERT INTO apply_discount (id_product,id_discount) VALUES (35,14),(26,20),(28,11),(26,6),(78,10);
INSERT INTO apply_discount (id_product,id_discount) VALUES (66,15),(64,17),(34,2),(18,11),(83,12);
INSERT INTO apply_discount (id_product,id_discount) VALUES (76,15),(82,11),(59,20),(91,16),(89,16);
INSERT INTO apply_discount (id_product,id_discount) VALUES (3,20),(30,10),(60,20),(39,4),(26,11);
INSERT INTO apply_discount (id_product,id_discount) VALUES (94,4),(99,8),(37,14),(25,7),(36,18);
INSERT INTO apply_discount (id_product,id_discount) VALUES (32,11),(89,15),(27,20),(51,18),(2,2);
INSERT INTO apply_discount (id_product,id_discount) VALUES (87,18),(46,8),(66,4),(82,7),(76,11);

--R13
INSERT INTO tag ("name") VALUES ('Gisela'),('Aspen'),('Audrey'),('Tools');
INSERT INTO tag ("name") VALUES ('Grace'),('Martena'),('Lilah'),('Alika');
INSERT INTO tag ("name") VALUES ('Outdoor'),('Haviva'),('Joan'),('Bertha');
INSERT INTO tag ("name") VALUES ('Hadassah'),('Dai'),('Deals'),('Indoor');
INSERT INTO tag ("name") VALUES ('Sydnee'),('Quon'),('Clare'),('Vases');

--R14
INSERT INTO product_tag (id_tag,id_product) VALUES (15,61),(9,42),(11,71),(5,95),(10,67);
INSERT INTO product_tag (id_tag,id_product) VALUES (16,27),(20,66),(15,58),(17,38),(9,22);
INSERT INTO product_tag (id_tag,id_product) VALUES (10,28),(9,9),(18,29),(18,93),(15,76);
INSERT INTO product_tag (id_tag,id_product) VALUES (2,30),(1,17),(9,11),(4,91),(9,13);
INSERT INTO product_tag (id_tag,id_product) VALUES (7,15),(20,72),(11,92),(16,60),(18,74);
INSERT INTO product_tag (id_tag,id_product) VALUES (12,35),(20,98),(17,56),(15,59),(17,49);
INSERT INTO product_tag (id_tag,id_product) VALUES (3,3),(11,35),(19,10),(4,77),(17,78);
INSERT INTO product_tag (id_tag,id_product) VALUES (4,22),(20,40),(8,100),(3,51),(16,6);
INSERT INTO product_tag (id_tag,id_product) VALUES (2,26),(17,76),(16,100),(9,93),(20,56);
INSERT INTO product_tag (id_tag,id_product) VALUES (20,89),(15,65),(15,51),(8,67),(4,70);

--R15
INSERT INTO ticket (ticket_type,id_user) VALUES ('Faulty_Delivery',18),('Product_Complaint',1),('Faulty_Delivery',5),('Faulty_Delivery',8);
INSERT INTO ticket (ticket_type,id_user) VALUES ('Faulty_Delivery',9),('Payment_Error',8),('Payment_Error',8),('Payment_Error',11);

--R16
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2019-06-27 06:48:10','I cought the delivery man throwing my package at the door. It was a bonsai. I want my money back. NOW.',4,8);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2020-09-27 20:36:10','Im waiting for my delivery for a thousand days now, just give me my money back...',5,9);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2021-01-09 10:50:51','I got my orqid last wek and its already ded. Found later that u shud water it... y isnt on the package that shud water it???!!!',2,1);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2020-10-28 10:13:18','My Plant arrived at my house wrapped in bubble-wrap. Who hired that packager?.. I demand imediate restitution of my money!',3,5);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2019-05-28 11:09:46','My Plant came in a box. It was dead. WTH IS WRONG WITH YOU PEOPLE????',1,18);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2020-01-12 08:32:52','My reference expired and paid after. Now it demands the payment again. HELL NO. Give me my order or give me back my money.',6,8);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2019-10-16 11:28:11','Stripe is down. I dont trust bank references. Please fix this issue.',8,11);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2020-09-19 16:00:17','Dude, I read sprite on phone and I like order a bunch of bottles, like, weird way of payment but ok, i guess you guys need it. But the order didnt ship it, then i realize it saidStripe... Can i pay with bottles of soda now??? PS: Pls keep selling that sativa, the best i ever had bros!',7,8);

--R17
INSERT INTO ticket_history ("date",ticket_status,id_ticket) VALUES ('2019-06-24 23:00:54','In_Progress',5),('2020-09-28 07:59:42','In_Progress',8);
INSERT INTO ticket_history ("date",ticket_status,id_ticket) VALUES ('2021-01-09 10:50:51','Opened',4),('2020-11-01 23:49:25','Closed',1);
INSERT INTO ticket_history ("date",ticket_status,id_ticket) VALUES ('2019-05-29 11:09:46','Opened',8),('2020-01-13 07:57:42','In_Progress',7);
INSERT INTO ticket_history ("date",ticket_status,id_ticket) VALUES ('2019-10-18 15:14:24','Closed',5),('2020-09-19 16:00:17','Opened',4);


--R19
INSERT INTO product_image (id_product,id_image) VALUES (1,7),(2,4),(3,1),(4,8),(5,6),(6,7),(7,4),(8,6),(9,6),(10,3);
INSERT INTO product_image (id_product,id_image) VALUES (11,9),(12,6),(13,1),(14,7),(15,2),(16,7),(17,8),(18,4),(19,10),(20,4);
INSERT INTO product_image (id_product,id_image) VALUES (21,9),(22,7),(23,9),(24,2),(25,6),(26,3),(27,1),(28,1),(29,6),(30,8);
INSERT INTO product_image (id_product,id_image) VALUES (31,3),(32,4),(33,3),(34,5),(35,5),(36,3),(37,1),(38,8),(39,9),(40,9);
INSERT INTO product_image (id_product,id_image) VALUES (41,4),(42,5),(43,2),(44,2),(45,9),(46,6),(47,3),(48,3),(49,8),(50,8);
INSERT INTO product_image (id_product,id_image) VALUES (51,8),(52,4),(53,9),(54,3),(55,8),(56,8),(57,5),(58,1),(59,1),(60,3);
INSERT INTO product_image (id_product,id_image) VALUES (61,8),(62,10),(63,9),(64,1),(65,6),(66,3),(67,10),(68,9),(69,1),(70,10);
INSERT INTO product_image (id_product,id_image) VALUES (71,7),(72,10),(73,9),(74,9),(75,5),(76,6),(77,4),(78,10),(79,3),(80,1);
INSERT INTO product_image (id_product,id_image) VALUES (81,1),(82,5),(83,8),(84,4),(85,5),(86,2),(87,8),(88,8),(89,6),(90,5);
INSERT INTO product_image (id_product,id_image) VALUES (91,6),(92,4),(93,6),(94,7),(95,6),(96,5),(97,9),(98,1),(99,1),(100,6);

--R20
INSERT INTO user_removal (reason,username,removed_at) VALUES ('i just wanted to buy a gift for my vegan gf','whatever123123','2019-04-19 05:29:18');
INSERT INTO user_removal (reason,username,removed_at) VALUES ('my mom caught me gardening. she made me delete this. sry guyz','tr335_4r3_n07_d34d','2019-12-22 14:07:28');
