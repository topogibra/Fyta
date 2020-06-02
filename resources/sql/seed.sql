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
  "date" DATE DEFAULT now() NOT NULL,
  address TEXT,
  security_question TEXT,
  id_image INTEGER,
  user_role "user_role" NOT NULL,
  CONSTRAINT user_pk PRIMARY KEY (id),
  CONSTRAINT user_username_uk UNIQUE (username),
  CONSTRAINT user_email_uk UNIQUE (email),
  CONSTRAINT user_image_fk FOREIGN KEY (id_image) REFERENCES "image"(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS "order" CASCADE;
CREATE TABLE "order" (
  id SERIAL,
  shipping_id TEXT NOT NULL,
  billing_address TEXT,
  delivery_address TEXT NOT NULL,
  order_date TIMESTAMP DEFAULT DATE_TRUNC('second', NOW()) NOT NULL,
  payment_method "payment_method" NOT NULL,
  username TEXT NOT NULL,
  id_user INTEGER,
  CONSTRAINT order_pk PRIMARY KEY (id),
  CONSTRAINT order_order_id_uk UNIQUE (shipping_id),
  CONSTRAINT order_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE SET NULL
);
DROP TABLE IF EXISTS product_order CASCADE;
CREATE TABLE product_order (
  id_product INTEGER NOT NULL,
  id_order INTEGER NOT NULL,
  quantity INTEGER NOT NULL,
  CONSTRAINT product_order_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE ON DELETE SET NULL,
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
  review_date TIMESTAMP DEFAULT DATE_TRUNC('second', NOW()) NOT NULL,
  CONSTRAINT review_rating_check CHECK (
    rating >= 1
    AND rating <= 5
  ),
  CONSTRAINT review_pk PRIMARY KEY (id_product, id_order),
  CONSTRAINT review_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT review_order_fk FOREIGN KEY (id_order) REFERENCES "order"(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS order_history CASCADE;
CREATE TABLE order_history (
  id SERIAL,
  "date" TIMESTAMP DEFAULT  DATE_TRUNC('second', NOW()) NOT NULL,
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
  CONSTRAINT wishlist_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE
);
DROP TABLE IF EXISTS wishlist_product CASCADE;
CREATE TABLE wishlist_product (
  id_product INTEGER NOT NULL,
  id_wishlist INTEGER NOT NULL,
  CONSTRAINT wishlist_product_pk PRIMARY KEY (id_product, id_wishlist),
  CONSTRAINT wishlist_product_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT wishlist_product_wishlist_fk FOREIGN KEY (id_wishlist) REFERENCES wishlist(id) ON UPDATE CASCADE ON DELETE CASCADE
);
DROP TABLE IF EXISTS shopping_cart CASCADE;
CREATE TABLE shopping_cart (
  id_user INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  quantity INTEGER NOT NULL,
  CONSTRAINT shopping_cart_pk PRIMARY KEY (id_user, id_product),
  CONSTRAINT shopping_cart_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT shopping_cart_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE ON DELETE CASCADE,
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
  CONSTRAINT discount_dates_check CHECK (date_end >= date_begin)
);
DROP TABLE IF EXISTS discount_code CASCADE;
CREATE TABLE discount_code (
  id_discount SERIAL,
  code TEXT NOT NULL,
  CONSTRAINT discount_code_pk PRIMARY KEY (id_discount),
  CONSTRAINT discount_code_discount_fk FOREIGN KEY (id_discount) REFERENCES discount(id) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT discount_code_uk UNIQUE (code)
);
DROP TABLE IF EXISTS apply_discount CASCADE;
CREATE TABLE apply_discount (
  id_product INTEGER NOT NULL,
  id_discount INTEGER NOT NULL,
  CONSTRAINT apply_pk PRIMARY KEY (id_product, id_discount),
  CONSTRAINT apply_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT apply_discount_fk FOREIGN KEY (id_discount) REFERENCES discount(id) ON UPDATE CASCADE ON DELETE CASCADE
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
  CONSTRAINT product_tag_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE ON DELETE CASCADE
);
DROP TABLE IF EXISTS ticket CASCADE;
CREATE TABLE ticket (
  id SERIAL,
  ticket_type "ticket_type" NOT NULL,
  id_user INTEGER NOT NULL,
  CONSTRAINT ticket_pk PRIMARY KEY (id),
  CONSTRAINT ticket_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE
);
DROP TABLE IF EXISTS ticket_message CASCADE;
CREATE TABLE ticket_message (
  id SERIAL,
  sent_date TIMESTAMP NOT NULL,
  "message" TEXT NOT NULL,
  id_ticket INTEGER NOT NULL,
  id_user INTEGER NOT NULL,
  CONSTRAINT ticket_message_pk PRIMARY KEY (id),
  CONSTRAINT ticket_message_ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT ticket_message_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE
);
DROP TABLE IF EXISTS ticket_history CASCADE;
CREATE TABLE ticket_history (
  id SERIAL,
  "date" TIMESTAMP DEFAULT DATE_TRUNC('second', NOW()) NOT NULL,
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
  CONSTRAINT product_image_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE ON DELETE CASCADE
);
DROP TABLE IF EXISTS user_removal CASCADE;
CREATE TABLE user_removal (
  id SERIAL,
  reason TEXT NOT NULL,
  username TEXT NOT NULL,
  removed_at TIMESTAMP DEFAULT DATE_TRUNC('second', NOW()) NOT NULL,
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
      apply_discount as new_apply,
      discount as new_discount
    WHERE
      discount.id <> new_discount.id
      AND apply_discount.id_discount = discount.id
      AND new_apply.id_discount = new_discount.id
      AND apply_discount.id_product = new_apply.id_product
      AND (
        (new_discount.date_begin >= discount.date_begin AND new_discount.date_begin <= discount.date_end)
        OR (new_discount.date_begin <= discount.date_begin AND new_discount.date_end >= discount.date_end)
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
--Indoor plants
INSERT INTO "image" (img_name,"description") VALUES ('orquideas.jpg','Rose Orchid'),('bonsai2.jpg','Bonsai CRT'),('tulipas.jpg','Orange Tulips'),('meatrose_indoor.jpg','Meat Rose');
INSERT INTO "image" (img_name,"description") VALUES ('pinktulips_indoor.jpg','Pink Tulips'),('sativa_indoor.jpg','Sativa Prime'),('bulb_bonsai.jpg','Bulbous Bonsai'),('reddahlia_indoor.jpg','Red Dahlias');
--Outdoor plants
INSERT INTO "image" (img_name,"description") VALUES ('greenpalm_outdoor.jpg','Green Palm Tree'),('lavender_outdoor.jpg','Lavender Premium'),('pondlilies_outdoor.jpg','White Pond Lilies'),('sunflower_outdoor.jpg','Golden Sunflowers');
INSERT INTO "image" (img_name,"description") VALUES ('hydrangeas_outdoor.jpg','Lilac Hydrangeas'),('succulent_outdoor.jpg','Green Succulents'),('pinkcaladium_outdoor.jpg','Pink Caladium'),('redroses_outdoor.jpg','Red Roses');
--Tools
INSERT INTO "image" (img_name,"description") VALUES ('gloves_tool.jpg','Gardening Gloves'),('mower_tool.jpg','Lawn Mower'),('grass_cutter.jpg','Grass Cutter'),('green_trowel.jpg','Green Trowel');
INSERT INTO "image" (img_name,"description") VALUES ('red_cutters.jpg','Small Red Scissors'),('toolkit.jpg','Gardening Toolkit'),('watering_can.jpg','Green Water Can - 12l');
--Vases
INSERT INTO "image" (img_name,"description") VALUES ('vaso.jpg','XPR Vase'),('babyblue_vase.jpg','Baby Blue Vase'),('blueceramic_vase.jpg','Traditional Ceramic Vase'),('blackplastic_vase.jpg','Black Vase');
INSERT INTO "image" (img_name,"description") VALUES ('beige_vase.jpg','Beige Ceramic Vase'),('greenglass_vase.jpg','Green Glass Vase'),('pink_vase.jpg','Pink Bright Vase');

--users
INSERT INTO "image" (img_name,"description") VALUES ('sisay_jeremiah_small.jpg','Sisay Jeremiah'),('dannie_almir.jpg','Dannie Almir'),('mohammad-faruque-AgYOuy8kA7M-unsplash.jpg','Mohammad Faruque'),('simone.jpeg','Simone Biles'),('josh_miller.jpg','Josh Miller');
INSERT INTO "image" (img_name,"description") VALUES ('kelly_mahagan.jpg','Kelly Mahagan'),('suzana_constancia.jpg','Suzana Constancia'),('savingcountrysinceborn.jpg','Ellie Black'),('nadal.jpg','Thomas'),('frederique_cousteau.jpg','Frederique Cousteau');

INSERT INTO "image" (img_name,"description") VALUES ('marius_ciocirlan11.jpg','Marius Ciocirlan'),('seth-doyle12.jpg','Seth Doyle'),('girl-13.jpg','Ramona Martinez'),('girl-14.jpg','Meghan'),('boy-15.jpg','Robert Muchamore');
INSERT INTO "image" (img_name,"description") VALUES ('boy-16.jpg','Timothy Donald'),('jessica-felicio-17.jpg','Jessica Felicio'),('milada-vigerova-18.jpg','Milada Vigerova'),('emily-sea-19.jpg','Emily Sea'),('boy-20.jpg','Hiram');

INSERT INTO "image" (img_name,"description") VALUES ('boy-21.jpg','Cadman Lilac'),('girl-22.jpg','Beatrice'),('girl-23.jpg','Mercedes'),('boy-24.jpg','Amir'),('boy-25.jpg','Nell ONeil');
INSERT INTO "image" (img_name,"description") VALUES ('girl-26.jpg','Holly Frax'),('nicolas-horn-27.jpg','Nicolas Horn'),('clem-onojeghuo-28.jpg','Clem Onojeghuo'),('daniel-pascoa-29.jpg','Daniel Pascoa'),('boy-30.jpg','Gavin Mohall');

INSERT INTO "image" (img_name,"description") VALUES ('lucas-lenzi-4-31.jpg','Lucas Lenzi'),('hannah-busing-32.jpg','Hannah Busing'),('raquel-santana-33.jpg','Raquel Santana'),('girl-34.jpg','Chantale'),('nikola-jelenkovic-35.jpg','Nikola Jelenkovic');
INSERT INTO "image" (img_name,"description") VALUES ('billie-36.jpg','Billie Jean'),('mika-37.jpg','Mika'),('girl-38.jpg','Aretha Frank'),('girl-39.jpg','Xena'),('boy-40.jpg','Chandler Bong');

INSERT INTO "image" (img_name,"description") VALUES ('roman-stetskov-41.jpg','Roman Stetskov'),('boy-42.jpg','Drew Barry'),('leighann-blackwood-43.jpg','Leighann Blackwood'),('girl-44.jpg','Inga'),('girl-45.jpg','Anika');
INSERT INTO "image" (img_name,"description") VALUES ('girl-46.jpg','Alexis'),('ishan-seefromthesky-47.jpg','Ishan Seefrom'),('girl-48.jpg','Colette Raquelette'),('simon-berger-49.jpg','Simon Berger'),('jorge-saavedra-50.jpg','Jorge Saavedra');

--special
INSERT INTO "image" (img_name,"description") VALUES ('kitty.jpg','The best kitty');


--R01
INSERT INTO product ("name","description",price,stock,views) VALUES ('Rose Orchids',
'Every plant lover has one. These rose orchids are grown in eco-friendly growing facilities in the US and brought to you as fresh as the day they left. 
This beautiful and elegant flower looks good in any house and anywhere in the house. Bring life to your home with one or more of our precious Rose Orchids',51.99,50,350),
                                                                   ('Bonsai CRT',
'How long have you wanted a bonsai tree at home? Are you only seeing it now? It does not matter because here and now you have the opportunity to become a bonsai owner and take care of this magnificent plant.
Shipping directly from China, where the art of Bonsai originated first, we provide you a great experience of the oriental culture. Let it fill your heart and soul with joy and peace.',60.00,50,500),
                                                                    ('Orange Tulips Assorted',
'Spray your place with colour with this assorted of gorgeous orange toned tulips. These tulips are great for adding warmth to spring border displays. 
Best placed in sunny spots with well-drained soils, these are sure to give life to your garden or indoors. Each order contains 20 stems of Orange Tulips.',46.50,50,450),
                                                                    ('"Meat" Rose',
'This funny looking flower sures gives a special touch to your place. Also known as Tiger Rose, this red and white rose hybrid will give your guests a lot to talk about!
Each order contains 10 stems of "Meat" Roses',30.00,50,450),
                                                                    ('Pink Tulips',
'Coming straight from the fields of Holland, we proudly present to you these fresh pink tulips. Full of brightness and liveliness, give a new life to your home with these tulips.
Each order contains 20 stems of Pink Tulips',30.00,50,380),
                                                                    ('Sativa Prime',
'Freshly grown in the mountains of California, this plant is meant to take you to the clouds. Sometimes used as a medicine, this plant gives your place a relaxed vibe and you feel
 the weight of the world coming off your shoulders. Besides the multiple health benefits, it also looks great and has an amazing scent.',40.00,50,10000),
                                                                    ('Bulbous Bonsai',
'This customized bonsai with bulbs gives a very exotic touch to your home. It is low maintenance so you will not have the usual trouble taking care of it. 
Feel the soul of the bonsai at your house',68.00,50,640),
                                                                    ('Red Dahlias',
'Feel the vivacity of the Dahlia! This beautiful flower needs little description, and make up for great addition to any garden indoor or outdoor. Each order contains 20 stems.',36.00,50,364),
                                                                    ('Green Palm Tree',
'If you need to give a "big" exotic touch to your garden, what is better than one of our palm trees? They are resistant to almost any weather and thrive with low resources.',120.00,50,200),
                                                                    ('Lavender Premium',
'There is almost no one that have never smelled the lovely lavender. Besides being such a pretty flower, the scent of the lavender washes any room of bad vibes. Each order contains 40 stems',30.00,50,700);
INSERT INTO product ("name","description",price,stock,views) VALUES ('White Pond Lilies',
'These exclusive pond white lilies give life to any garden or pond. They are pretty and petite, fitting in the smallest ponds or aquariums. Each order contains 10 stems.',30.00,50,200),
                                                                   ('Golden Sunflowers',
'Pay a homage to the sun with these magnificent sunflowers. Bred from the best seeds, this flower light a bright sunshine on your life. Each order contains 20 stems.',25.00,50,400),
                                                                    ('Lilac Hydrangeas',
'Remember those cute flowers you saw at your local gardens? These Hydrangeas are sure to take you back in time. Look good in any garden and give them a great scent. Each order contains 15 stems',35.00,50,300),
                                                                    ('Green Succulent',
'These hot climate succulents are fit to any place you want. Very low maintenance and resistant, they are a great addition to your garden.',30.00,50,450),
                                                                    ('Pink Caladium',
'This exotic plant will give your home a special touch. This pink Caladium adds color and joy to your life.',45.00,50,500),
                                                                    ('Red Roses',
'The flower of passion. The Rose has been a symbol of passion and love for ages and you can have it blooming in your farden. With such an amazing shade of red and incredible scent you are sure to be satisfied. Each order contains 30 stems.',75.00,50,750),
                                                                    ('Gardening Gloves',
'These practical gloves will be a great assistance will attending to your garden. Made of resistant materials and very lightweight, your hands will thanking you for it.',15.00,50,784),
                                                                    ('Lawn Mower',
'If you need a clean and smooth cut in your garden grass this mower is just the right one for you. Eco friendly and high performance, long hours of cutting grass are a thing of the past.',85.00,50,364),
                                                                    ('Grass Cutter',
'This slick grass cutter will make your life much easier cutting grass. Power effiecient and eco-friendly, make your spot, spotless.',22.00,50,123),
                                                                    ('Green Trowel',
'Every gardener needs one. This trowel is the basic tool to build your garden. Very resistant and light weight.',8.00,50,100);
INSERT INTO product ("name","description",price,stock,views) VALUES ('Small Red Scissors',
'Make sure you put your personal touch into every part of your garden of plant by using this nifty small scissors. They are tough and easy to use, and for sure you will make great use of it making your plants looking perfect.',16.00,50,260),
                                                                   ('Gardening Toolkit',
'This toolkit is a must have! From shovels to brushes and rakes this kit will make your life easier tidying your garden. What you see is what you get, no parts are sold separately',69.99,50,150),
                                                                    ('Green Water Can',
'Do not forget to water your plants! With this nice water can of 12 liters (3.17 gallons) you can fresh every corner of your garden and water your plants comfortably.',12.00,50,450),
                                                                    ('XPR Vase',
'This modern vase is a great addition to your home or even your office. Holds small plants and is very resistant.',20.00,50,450),
                                                                    ('Baby Blue Vase',
'This baby blue vase gives you a sense of calm and serenity that alongside with your favorite plant will make you much more chill. A great purchase!',22.00,50,451),
                                                                    ('Traditional Ceramic Vase',
'This cute ceramic vase besides being very pretty is quite light, so you do not have to worry about carrying it around. Make your friends jealous with this fine piece of ceramic!',30.00,50,450),
                                                                    ('Black Vase',
'This minimalistic vase has one job and it does not fail at that. Very light and robust, this small vase is great to have at your home or office.',14.00,50,784),
                                                                    ('Beige Ceramic Vase',
'Make your home a little bit more your home with this great beige ceramic vase. Very polished and resistant, will adapt to your style easily and while being very adequate to your plants.',36.00,50,364),
                                                                    ('Green Glass Vase',
'This is a great glass vase. It is both appealing aesthetically and practically. Give your place a more natural look with this vase and you will find a plant that fits there quite easily!',40.00,50,123),
                                                                    ('Pink Bright Vase',
'This is it. The vase to have. The Pink Bright Vase is just what you need to bring back the spark to your home. Everytime you shine a light at it, it will give back 10x the shine. 
Any plant fits well here, and for sure is a good fit for you!',30.00,50,1204);

--R06
INSERT INTO "user" (username,email,password_hash,date,address,id_image,user_role, security_question) VALUES ('Sisay Jeremiah','ornare.placerat@lacus.ca','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1990-07-26','Ap 246-7207 Vehicula Av. Porto Portugal',31,'Customer', 'security'),('Dannie Almir','dui.augue.eu@mauris.edu','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1981-03-25','Ap #673-3696 Eu Rd. Porto Portugal',32,'Customer', 'security'),('Mohammad Faruque','ipsum.dolor.sit@pedesagittis.net','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1993-03-08','871-7115 Ipsum Avenue Porto Portugal',33,'Customer', 'security'),('Simone Biles','euismod.enim@malesuadamalesuadaInteger.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1992-06-02','Ap #266-9713 Dictum St. Porto Portugal',34,'Customer', 'security'),('Josh Miller','Integer.urna.Vivamus@tinciduntcongue.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','2017-03-06',NULL,35,'Manager', 'security'),('Kelly Mahagan','et@Namconsequatdolor.net','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1999-03-09','610 Sit Street Porto Portugal',36,'Customer', 'security'),('Suzana Constancia','lorem.lorem.luctus@malesuadamalesuada.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1988-09-22','8542 Felis Street Porto Portugal',37,'Customer', 'security'),('Ellie Black','augue@nonummy.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1995-07-16','P.O. Box 368, 9339 Nec Av. Porto Portugal',38,'Customer', 'security'),('Thomas','Aliquam.nisl@tempus.edu','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1983-01-02','P.O. Box 378, 8174 Montes, St. Porto Portugal',39,'Customer', 'security'),('Frederique Cousteau','sed.turpis.nec@massa.edu','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1992-11-27','Ap #580-1755 Duis Rd. Porto Portugal',40,'Customer', 'security');
INSERT INTO "user" (username,email,password_hash,date,address,id_image,user_role, security_question) VALUES ('Marius Ciocirlan','odio.Aliquam@mauris.ca','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1983-05-22','Ap #330-8894 Mauris Av. Calgary Canada',41,'Customer', 'security'),('Seth Doyle','turpis@Vestibulumante.edu','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1982-08-01','208-733 Eu Road Calgary Canada',42,'Customer', 'security'),('Ramona Martinez','elementum@imperdietornare.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1984-09-03','Ap #307-3111 Lacus Road Calgary Canada',43,'Customer', 'security'),('Meghan','turpis.vitae.purus@ornareliberoat.org','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1994-10-15','P.O. Box 351, 5494 Eu Road Calgary Canada',44,'Customer', 'security'),('Robert Muchamore','iaculis.odio@diamluctus.org','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1989-07-31','850-6268 Mus. Av. Calgary Canada',45,'Customer', 'security'),('Timothy Donald','lorem.eu@rutrum.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1998-05-31','8469 Dapibus Rd. Calgary Canada',46,'Customer', 'security'),('Jessica Felicio','vestibulum@nislsemconsequat.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1996-07-29','P.O. Box 540, 5258 Ac Avenue Calgary Canada',47,'Customer', 'security'),('Milada Vigerova','nec@Aenean.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1987-09-26','311-8126 Malesuada Rd. Calgary Canada',48,'Customer', 'security'),('Emily Sea','Vestibulum.ante.ipsum@Nam.edu','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1987-06-13','788-3392 Tristique Avenue Calgary Canada',49,'Customer', 'security'),('Hiram','est.tempor.bibendum@acurnaUt.net','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','2018-01-30',NULL,50,'Manager', 'security');
INSERT INTO "user" (username,email,password_hash,date,address,id_image,user_role, security_question) VALUES ('Cadman Lilac','sem.molestie@euismodmauris.ca','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1960-02-12','7617 Dapibus St. London UK',51,'Customer', 'security'),('Beatrice','quis.massa@blanditNam.net','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1980-01-06','Ap #199-4090 Phasellus Ave London UK',52,'Customer', 'security'),('Mercedes','augue.ut@vitae.edu','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1990-04-15','458-5797 Ante Rd. London UK',53,'Customer', 'security'),('Amir','nulla.Integer@nibhlaciniaorci.ca','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1997-10-26','P.O. Box 784, 942 Cursus, Rd. London UK',54,'Customer', 'security'),('Nell ONeil','Donec@porttitor.co.uk','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1991-01-01','753-5549 Libero Rd. London UK',55,'Customer', 'security'),('Holly Frax','Curabitur.consequat.lectus@arcuVestibulumante.net','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','2018-01-30',NULL,56,'Manager', 'security'),('Nicolas Horn','sit.amet@maurisa.org','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1985-05-25','Ap #631-9220 Vestibulum Avenue London UK',57,'Customer', 'security'),('Clem Onojeghuo','mattis@dolor.net','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','2019-04-04',NULL,58,'Manager', 'security'),('Daniel Pascoa','volutpat.Nulla@gravidaPraesent.co.uk','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1982-02-25','Ap #779-5525 Aliquam Av. London UK',59,'Customer', 'security'),('Gavin Mohall','adipiscing@ac.edu','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1986-09-08','P.O. Box 140, 3716 Integer Street London UK',60,'Customer', 'security');
INSERT INTO "user" (username,email,password_hash,date,address,id_image,user_role, security_question) VALUES ('Lucas Lenzi','commodo.ipsum@turpis.net','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','2017-02-16',NULL,61,'Manager', 'security'),('Hannah Busing','Nullam.vitae.diam@arcuCurabitur.edu','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1981-02-26','P.O. Box 617, 6889 Elementum Rd. Madrid Spain',62,'Customer', 'security'),('Raquel Santana','Maecenas@liberoat.net','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1995-12-29','8772 Ac Rd. Madrid Spain',63,'Customer', 'security'),('Chantale','eu@ametnullaDonec.ca','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1981-03-20','433-9413 Proin Road Madrid Spain',64,'Customer', 'security'),('Nikola Jelenkovic','Curabitur.dictum.Phasellus@amet.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1956-11-11','917-9728 Enim. Avenue Madrid Spain',65,'Customer', 'security'),('Billie Jean','felis.eget@maurisSuspendissealiquet.ca','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1973-03-18','799-4928 At, St. Madrid Spain',66,'Customer', 'security'),('Elmo','faucibus.Morbi.vehicula@eleifendnon.ca','PPP57OLD0VJ','1977-01-30','Ap #607-4184 Tortor, St. Madrid Spain',37,'Customer', 'security'),('Aretha Frank','ultricies.ligula.Nullam@ut.net','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1984-12-25','P.O. Box 807, 5205 Massa Ave Madrid Spain',68,'Customer', 'security'),('Xena','malesuada@Maecenasliberoest.org','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1976-12-15','Ap #432-5930 Praesent Av. Madrid Spain',69,'Customer', 'security'),('Chandler Bong','vestibulum.massa.rutrum@turpisnonenim.ca','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','2019-06-25',NULL,70,'Manager', 'security');
INSERT INTO "user" (username,email,password_hash,date,address,id_image,user_role, security_question) VALUES ('Roman Stetskov','hymenaeos@sitametdapibus.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1989-12-14','Ap #588-6898 Mauris St. Florence Italy',71,'Customer', 'security'),('Drew Barry','ullamcorper.nisl@semut.org','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1963-01-31','858-2361 Risus Rd. Florence Italy',72,'Customer', 'security'),('Leighann Blackwood','dictum@nonenim.ca','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1972-02-18','3512 Vel Rd. Florence Italy',73,'Customer', 'security'),('Inga','orci@velpedeblandit.edu','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1958-02-13','9015 Lacinia. Avenue Florence Italy',74,'Customer', 'security'),('Anika','sem.mollis.dui@convallisligulaDonec.org','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1968-05-07','5373 Eu, St. Florence Italy',75,'Customer', 'security'),('Alexis','nisl.Maecenas.malesuada@esttempor.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','2020-01-15',NULL,76,'Manager', 'security'),('Ishan Seemfrom','Duis.a.mi@Nullam.ca','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1977-03-28','152-7120 Tincidunt Rd. Florence Italy',77,'Customer', 'security'),('Colette Raquelette','nisi@loremtristiquealiquet.com','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1963-07-03','Ap #748-3754 Amet, Rd. Florence Italy',78,'Customer', 'security'),('Simon Berger','auctor.ullamcorper@Crasegetnisi.edu','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','1975-12-15','419-6046 Ante. St. Florence Italy',79,'Customer', 'security'),('Jorge Saavedra','aptent.taciti@magnaSedeu.ca','$2y$10$i3XKoROiGm.SzBpBWHpLXOVMvDjOWecSmgpGySS3OX472ji.flof2','2000-07-06','9554 Montes, St. Florence Italy',80,'Customer', 'security');

--R02
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,username,id_user) VALUES ('5ed5092ae5177','Ap #804-5785 Ipsum St.','Ap #498-7968 Magna St.','2020-05-01 01:53:08','Bank_Transfer','Knapp',8),('5ed5092ae5198','P.O. Box 326, 2203 Ligula St.','P.O. Box 740, 885 Sapien, St.','2019-07-20 08:52:04','Bank_Transfer','Ortega',39),('5ed5092ae51a9','P.O. Box 531, 4107 Lorem St.','656-6263 Nonummy. St.','2020-01-01 07:35:17','Bank_Transfer','Meyer',15),('5ed5092ae51ba','P.O. Box 940, 1673 Risus. St.','386-3860 Neque Road','2020-03-29 11:24:30','Bank_Transfer','Fernandez',36),('5ed5092ae51cb','P.O. Box 624, 5229 Etiam Ave','966-8624 Sapien. St.','2019-12-23 03:45:48','Bank_Transfer','Carson',25),('5ed5092ae51db','Ap #333-6584 Iaculis Ave','P.O. Box 120, 1817 Gravida. Road','2019-12-05 17:03:12','Bank_Transfer','Wheeler',8),('5ed5092ae51fe','Ap #588-7253 Ac Rd.','Ap #389-2684 Nullam Ave','2020-04-03 10:32:35','Bank_Transfer','Henry',16),('5ed5092ae520f','636-1515 Mus. Ave','Ap #494-1114 Iaculis Rd.','2019-08-13 14:54:33','Bank_Transfer','Villarreal',35),('5ed5092ae5240','832-171 Diam Rd.','P.O. Box 584, 5275 Nunc. Avenue','2020-02-28 01:12:54','Bank_Transfer','Mckinney',4),('5ed5092ae5261','866-8552 A St.','152-5553 Fringilla, Rd.','2019-11-09 04:18:41','Bank_Transfer','Porter',45);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,username,id_user) VALUES ('5ed5092ae518a','663-5664 Nisi St.','6935 In St.','2019-11-10 09:07:58','Bank_Transfer','Parker',24),('5ed5092ae519a','749-5742 Duis St.','P.O. Box 751, 2942 Nec Street','2019-10-21 06:16:35','Bank_Transfer','Pate',12),('5ed5092ae51ab','P.O. Box 474, 5779 Vestibulum St.','Ap #647-7054 Pharetra. St.','2020-03-11 22:32:19','Bank_Transfer','Garcia',10),('5ed5092ae51bc','7660 Lacus. St.','P.O. Box 985, 2548 Sapien, Street','2020-02-25 09:32:02','Bank_Transfer','Osborn',29),('5ed5092ae51cc','P.O. Box 502, 1114 Massa. St.','Ap #541-9392 Posuere Street','2020-05-05 10:43:38','Bank_Transfer','Conner',14),('5ed5092ae51dd','Ap #672-6516 Primis Street','758-9485 Metus Road','2020-04-27 07:09:25','Bank_Transfer','Osborn',37),('5ed5092ae5200','2721 Vitae, Rd.','5057 Lacus. Ave','2019-09-26 22:47:56','Bank_Transfer','Chapman',36),('5ed5092ae5210','P.O. Box 527, 6325 Dolor St.','Ap #267-5620 Non, Ave','2020-01-12 05:53:45','Bank_Transfer','Buck',18),('5ed5092ae523d','1013 Cursus St.','768-294 Malesuada Road','2019-11-10 10:07:13','Bank_Transfer','Mcleod',15),('5ed5092ae524d','P.O. Box 391, 9278 Erat Ave','Ap #425-4914 Dictum Road','2020-02-15 03:46:27','Bank_Transfer','Brock',9);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,username,id_user) VALUES ('5ed5092ae518c','808-8296 Pede. Av.','834-8881 Rhoncus. Av.','2020-05-05 18:57:21','Bank_Transfer','Jordan',33),('5ed5092ae519c','413 Augue Av.','P.O. Box 335, 331 Pede Road','2019-11-05 11:13:44','Bank_Transfer','Hutchinson',2),('5ed5092ae51ac','Ap #937-8669 Purus, Rd.','7073 Volutpat. Avenue','2019-11-30 07:56:37','Bank_Transfer','Pearson',10),('5ed5092ae51bd','P.O. Box 645, 5084 Mauris St.','185-7644 Leo. St.','2019-07-09 19:57:29','Bank_Transfer','Casey',12),('5ed5092ae51ce','P.O. Box 774, 9986 Nunc. Rd.','Ap #313-2415 Eu, Rd.','2019-09-09 02:04:38','Bank_Transfer','Pearson',47),('5ed5092ae51df','5439 Vitae, St.','262-9030 Diam. Rd.','2019-09-07 03:20:24','Bank_Transfer','Freeman',17),('5ed5092ae5202','P.O. Box 129, 3106 Turpis. St.','3183 Semper, Rd.','2019-06-23 09:57:00','Bank_Transfer','Gomez',25),('5ed5092ae5212','Ap #693-4486 Ipsum St.','P.O. Box 729, 6144 A Ave','2019-06-15 00:56:41','Bank_Transfer','Byers',38),('5ed5092ae5236','Ap #505-9014 Blandit Road','Ap #757-1987 Senectus St.','2020-03-09 14:34:51','Bank_Transfer','Stevenson',43),('5ed5092ae524a','P.O. Box 233, 5000 Metus. St.','Ap #484-1384 Montes, Av.','2020-05-03 03:23:18','Bank_Transfer','Wheeler',48);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,username,id_user) VALUES ('5ed5092ae518e','8890 Vitae Rd.','669-1839 Ut Rd.','2019-08-03 10:56:03','Bank_Transfer','Steele',29),('5ed5092ae519d','5281 Lectus Ave','P.O. Box 188, 2763 Sed Rd.','2020-01-28 21:23:09','Bank_Transfer','Espinoza',21),('5ed5092ae51ae','Ap #207-6881 Sed St.','P.O. Box 963, 8042 Nec St.','2020-02-13 12:37:59','Bank_Transfer','Fletcher',36),('5ed5092ae51bf','P.O. Box 627, 8412 Auctor Rd.','Ap #638-9105 Mattis. Rd.','2019-09-04 17:06:47','Bank_Transfer','Austin',25),('5ed5092ae51d0','Ap #366-379 Ante, Road','Ap #904-687 Nulla St.','2019-07-30 06:25:21','Bank_Transfer','Clayton',39),('5ed5092ae51e0','787-3817 Tortor St.','9866 Ac Av.','2019-10-27 22:40:48','Bank_Transfer','Duran',39),('5ed5092ae5203','323-9959 Ante Ave','Ap #290-367 Mi St.','2020-04-12 11:00:45','Bank_Transfer','Patel',2),('5ed5092ae5228','8314 Egestas, Rd.','Ap #493-4139 Interdum. St.','2019-10-20 11:18:35','Bank_Transfer','Steele',14),('5ed5092ae5264','652-7338 Magna. Avenue','P.O. Box 444, 2624 Malesuada Street','2020-02-17 23:05:39','Bank_Transfer','Blake',35),('5ed5092ae5247','200-5826 Libero St.','822 Arcu. Rd.','2019-12-03 22:28:18','Bank_Transfer','Mueller',44);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,username,id_user) VALUES ('5ed5092ae5190','P.O. Box 549, 1723 Pellentesque, Road','826-6927 Luctus, Av.','2020-01-27 03:40:06','Bank_Transfer','Rosa',43),('5ed5092ae519f','4433 Pellentesque Avenue','P.O. Box 673, 3761 Tincidunt St.','2020-04-16 14:43:35','Bank_Transfer','Dotson',3),('5ed5092ae51b0','P.O. Box 422, 1052 Justo Rd.','797-7604 Metus. St.','2019-12-17 04:15:37','Bank_Transfer','Ross',38),('5ed5092ae51c1','Ap #268-3136 Id, Road','P.O. Box 956, 7723 Enim Ave','2020-03-14 05:32:52','Bank_Transfer','Patton',15),('5ed5092ae51d1','4529 Tempus Ave','658-3075 Laoreet St.','2020-04-03 01:22:33','Bank_Transfer','Cannon',39),('5ed5092ae51e4','877 Ut St.','2538 A Ave','2019-10-04 04:41:11','Bank_Transfer','Hammond',13),('5ed5092ae5205','1232 Sem Rd.','P.O. Box 286, 837 Sit Road','2020-01-20 09:00:22','Bank_Transfer','Logan',38),('5ed5092ae522a','2312 Sapien, Avenue','P.O. Box 136, 5457 Odio Av.','2020-01-14 10:02:10','Bank_Transfer','Fernandez',33),('5ed5092ae5238','420-683 Dolor. Ave','P.O. Box 345, 1726 Sit Rd.','2019-10-13 11:50:37','Bank_Transfer','Hendrix',39),('5ed5092ae5248','P.O. Box 597, 4022 Placerat, St.','636-9587 Aenean Ave','2019-10-31 20:56:11','Bank_Transfer','Ashley',43);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,username,id_user) VALUES ('5ed5092ae5192','490-4639 Auctor. St.','8979 Dictum Ave','2019-07-19 07:11:40','Bank_Transfer','Frye',13),('5ed5092ae51a1','Ap #709-7379 Tincidunt St.','P.O. Box 880, 6213 Tincidunt Rd.','2019-07-08 22:32:23','Bank_Transfer','Neal',18),('5ed5092ae51b1','726-2327 Tempus Street','902-9490 Blandit St.','2019-06-28 11:01:18','Bank_Transfer','Gilmore',42),('5ed5092ae51c2','559-463 Duis Rd.','Ap #739-3403 Diam Road','2020-03-01 17:44:46','Bank_Transfer','Sanford',41),('5ed5092ae51d3','264-1056 In Rd.','P.O. Box 252, 3951 Eu Rd.','2020-04-20 01:31:48','Bank_Transfer','Torres',41),('5ed5092ae51f6','663-2634 Molestie Rd.','P.O. Box 912, 9657 Ipsum St.','2019-08-25 20:12:33','Bank_Transfer','Cannon',21),('5ed5092ae5206','Ap #111-1021 Integer Av.','556-8333 Est Rd.','2020-05-12 23:08:07','Bank_Transfer','Fuentes',41),('5ed5092ae522c','915-321 Erat Street','Ap #604-3753 Hendrerit St.','2019-11-09 10:10:10','Bank_Transfer','Bass',43),('5ed5092ae5235','8985 Sed, Road','P.O. Box 649, 9039 Magna. Av.','2019-07-21 20:50:54','Bank_Transfer','Lindsay',4),('5ed5092ae5245','777-1498 Eget Av.','619-4469 Amet Ave','2019-06-19 22:08:40','Bank_Transfer','Wilkinson',16);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,username,id_user) VALUES ('5ed50c4f5aa1f','427 Laoreet Street','P.O. Box 684, 2210 Orci Av.','2019-08-07 05:24:33','Bank_Transfer','Harris',9),('5ed5092ae51a2','656-3973 Libero Rd.','P.O. Box 450, 1085 Id Road','2020-04-05 08:08:32','Bank_Transfer','Carey',48),('5ed5092ae51b3','P.O. Box 648, 1638 Natoque Street','P.O. Box 714, 5255 Vulputate, St.','2019-05-25 13:44:18','Bank_Transfer','Landry',27),('5ed5092ae51c4','P.O. Box 411, 5128 Id St.','P.O. Box 461, 424 Faucibus Av.','2020-04-06 05:40:09','Bank_Transfer','Schneider',34),('5ed5092ae51d5','Ap #761-8916 Sem, Rd.','P.O. Box 430, 1892 Pellentesque Av.','2019-12-26 06:40:16','Bank_Transfer','House',33),('5ed5092ae51f8','Ap #729-6069 Sagittis St.','P.O. Box 791, 962 Donec Street','2019-06-12 01:04:26','Bank_Transfer','Turner',36),('5ed5092ae5208','P.O. Box 943, 1848 Amet, Road','P.O. Box 458, 691 Interdum. Rd.','2020-04-27 13:38:17','Bank_Transfer','Koch',27),('5ed5092ae522e','318 Vestibulum Rd.','588-5678 Nec, Av.','2019-11-05 04:32:42','Bank_Transfer','Hyde',7),('5ed5092ae5242','P.O. Box 184, 6267 Pretium St.','Ap #929-1737 Posuere St.','2019-07-24 23:53:06','Bank_Transfer','Vincent',45),('5ed5092ae5263','7974 Amet Rd.','Ap #893-7487 Adipiscing Av.','2020-01-06 07:39:01','Bank_Transfer','Crawford',38);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,username,id_user) VALUES ('5ed5092ae5193','P.O. Box 391, 4565 Aliquam Rd.','Ap #956-2280 Lectus St.','2019-07-22 02:04:27','Bank_Transfer','White',14),('5ed5092ae51a4','4848 Donec Ave','3950 Magnis St.','2019-11-01 02:01:34','Bank_Transfer','Barron',14),('5ed5092ae51b5','286-3766 Consectetuer St.','P.O. Box 832, 7954 Turpis Av.','2020-04-21 12:12:20','Bank_Transfer','Luna',9),('5ed5092ae51c6','P.O. Box 897, 7038 Enim Avenue','P.O. Box 629, 2560 Id Street','2019-10-01 00:12:46','Bank_Transfer','Crosby',3),('5ed5092ae51d6','P.O. Box 182, 5383 Gravida Street','5409 Dolor, Rd.','2020-02-26 04:45:53','Bank_Transfer','Dillard',49),('5ed5092ae51f9','Ap #147-8594 Nulla Rd.','P.O. Box 923, 3704 Ut Av.','2019-09-08 21:53:32','Bank_Transfer','Romero',37),('5ed5092ae520a','8011 Suspendisse Avenue','6634 Cursus Rd.','2019-07-28 06:28:28','Bank_Transfer','Waller',22),('5ed5092ae522f','723-3961 Tempor Road','387-7460 Neque Rd.','2019-06-16 02:07:38','Bank_Transfer','Rasmussen',29),('5ed5092ae523e','5818 Ligula. Rd.','Ap #359-7518 Id, St.','2019-11-23 09:11:33','Bank_Transfer','Finley',24),('5ed5092ae524c','Ap #962-3933 Nisl. Avenue','Ap #313-5442 Nunc St.','2020-05-12 01:46:53','Bank_Transfer','Wagner',39);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,username,id_user) VALUES ('5ed5092ae5195','Ap #606-1079 Hendrerit. Ave','589-3564 Elit Rd.','2019-10-26 06:10:49','Bank_Transfer','Atkins',16),('5ed5092ae51a6','1359 Vestibulum Road','P.O. Box 576, 235 Libero Av.','2019-12-10 00:09:55','Bank_Transfer','Mcfarland',41),('5ed5092ae51b6','8618 Sed, St.','546-4535 Morbi St.','2019-11-08 19:45:08','Bank_Transfer','Morse',1),('5ed5092ae51c7','Ap #920-9311 Morbi Road','Ap #386-4205 Eget Ave','2019-08-25 16:42:09','Bank_Transfer','Ratliff',1),('5ed5092ae51d8','2280 Accumsan Rd.','P.O. Box 939, 7867 Lorem, Rd.','2019-08-23 05:27:11','Bank_Transfer','Warren',34),('5ed5092ae51fb','P.O. Box 381, 3113 Sed Street','9747 Arcu. Road','2019-09-26 04:38:10','Bank_Transfer','Foley',3),('5ed5092ae520b','2556 Fermentum Avenue','P.O. Box 582, 3566 Odio. Av.','2020-01-07 11:24:22','Bank_Transfer','Reid',42),('5ed5092ae5231','Ap #289-9273 In, St.','5060 Ligula Ave','2020-04-22 00:56:16','Bank_Transfer','Dejesus',47),('5ed5092ae5239','758-6382 Non, Rd.','514-4972 Lorem St.','2019-12-29 11:27:29','Bank_Transfer','Ferguson',33),('5ed5092ae5243','982-542 Risus, Ave','Ap #461-4408 Vitae Rd.','2019-08-11 07:53:29','Bank_Transfer','Barron',10);
INSERT INTO "order" (shipping_id,billing_address,delivery_address,order_date,payment_method,username,id_user) VALUES ('5ed5092ae5197','9797 Tortor Av.','Ap #749-4052 Quisque Rd.','2019-09-26 02:32:25','Bank_Transfer','Clayton',48),('5ed5092ae51a7','P.O. Box 426, 2107 Non, Rd.','P.O. Box 742, 5239 Integer Street','2019-07-18 03:50:53','Bank_Transfer','Lee',25),('5ed5092ae51b8','P.O. Box 807, 7056 Pharetra Av.','298-7029 Amet, Street','2020-04-04 05:42:24','Bank_Transfer','Banks',11),('5ed5092ae51c9','437-3262 Vel Road','P.O. Box 316, 4116 Est Avenue','2019-11-04 03:02:52','Bank_Transfer','Murray',7),('5ed5092ae51da','895-6474 Nisi. St.','890-4570 Tellus Ave','2020-02-06 13:04:46','Bank_Transfer','Warner',10),('5ed5092ae51fd','146-4672 Vulputate, St.','Ap #540-7754 Ligula. St.','2019-06-06 04:54:29','Bank_Transfer','Juarez',22),('5ed5092ae520d','516-1365 Sit Rd.','P.O. Box 773, 851 Enim Rd.','2020-04-09 11:15:31','Bank_Transfer','Mcdowell',6),('5ed5092ae5233','P.O. Box 512, 5802 Arcu. Ave','P.O. Box 777, 9292 Sit Rd.','2019-09-10 22:11:12','Bank_Transfer','Haley',35),('5ed5092ae523b','693-3841 Faucibus Avenue','873-4960 Lectus St.','2019-12-07 04:19:06','Bank_Transfer','Carpenter',19),('5ed5092ae524f','P.O. Box 249, 9237 Vestibulum Av.','P.O. Box 426, 6361 Cras Rd.','2020-01-29 08:39:21','Bank_Transfer','Morgan',19);

--R03
INSERT INTO product_order (id_product,id_order,quantity) VALUES (16,40,2),(2,99,5),(24,41,16),(22,77,19),(6,1,2),(1,56,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (4,92,13),(29,90,10),(9,2,4),(15,5,2),(26,7,1),(2,59,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (22,98,19),(20,58,18),(1,9,1),(2,12,2),(3,13,1),(3,60,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (15,4,8),(4,15,1),(5,17,2),(6,18,1),(7,19,2),(4,61,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (13,40,3),(28,33,18),(7,31,14),(16,84,7),(8,20,1),(5,62,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (26,39,6),(30,16,8),(12,52,5),(9,23,2),(10,24,1),(6,63,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (20,93,19),(10,89,9),(5,81,15),(11,25,2),(12,26,1),(7,65,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (27,31,12),(29,35,6),(24,34,14),(13,27,1),(14,29,2),(8,68,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (1,39,6),(27,98,6),(30,8,14),(3,87,20),(15,36,1),(9,69,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (24,75,19),(6,74,18),(15,64,18),(15,67,3),(16,34,2),(10,70,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (4,3,10),(17,4,9),(24,6,8),(13,8,5),(2,10,5),(11,72,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (28,11,3),(12,14,9),(24,16,1),(16,39,1),(17,37,2),(12,76,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (21,21,3),(9,22,3),(30,28,3),(11,30,5),(18,38,1),(13,78,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (21,32,8),(1,40,8),(19,43,1),(20,44,1),(21,45,2),(14,79,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (8,42,10),(22,46,1),(23,47,1),(24,48,2),(25,49,1),(15,83,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (25,57,6),(9,58,8),(26,50,1),(27,51,1),(28,53,1),(16,88,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (5,66,8),(29,54,1),(30,55,2),(16,90,5),(27,100,10),(17,91,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (3,71,8),(21,73,3),(1,75,6),(17,77,7),(14,80,3),(18,97,1);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (29,82,9),(15,84,4),(16,85,7),(15,86,8),(13,89,2),(19,30,2);
INSERT INTO product_order (id_product,id_order,quantity) VALUES (24,92,8),(2,93,1),(20,94,8),(20,95,4),(22,96,2),(25,100,1);

--R04
INSERT INTO review (id_product,id_order,description,rating,review_date) VALUES (6,1,'Bro, what an amazing plant! 5/7 guaranteed',5,'2020-05-08 14:59:14'),(15,4,'This Caladium is incredibly. So vivacious!',5,'2020-03-30 08:16:58'),(24,16,'Very slippery!',3,'2020-04-30 23:52:05'),(6,18,'This exquisite plant quite lives up to the expectations. Well done, indeed.',5,'2020-01-12 17:34:37');
INSERT INTO review (id_product,id_order,description,rating,review_date) VALUES (21,21,'Quite handy and resistant, needs strength though',4,'2020-05-13 16:36:50'),(21,32,'They broke after 5 days of usage. Disapprove.',2,'2020-02-02 21:46:47'),(24,34,'This vase is great',5,'2019-09-14 23:05:00'),(16,34,'Kinda disappointed with the plant quality',1,'2020-06-12 14:41:10');
INSERT INTO review (id_product,id_order,description,rating,review_date) VALUES (16,39,'Very fragile and not as pretty! FAKE!',2,'2020-06-04 14:41:10'),(16,40,'Loved this lovely plant! Very easy to take care',5,'2020-06-20 14:41:10'),(25,49,'Not as big as I expected',4,'2019-11-08 09:28:59'),(12,52,'I order this sunflower but when it arrived it was dead. Did you not tell the delivery guys to give it light?',1,'2019-08-09 10:22:33');
INSERT INTO review (id_product,id_order,description,rating,review_date) VALUES (25,57,'Excellent vase!',5,'2020-05-15 19:19:15'),(20,58,'Really happy to try out this brand, great products and costumer support!',1,'2020-06-23 14:41:10'),(6,63,'I thought this was fake, but totally wasnt. Great product and great service, very nice guys!',5,'2019-06-07 15:56:35'),(6,74,'Very good.',5,'2019-10-02 09:43:51');
INSERT INTO review (id_product,id_order,description,rating,review_date) VALUES (24,75,'A little less bright than i expected but still good',4,'2020-03-12 10:25:50'),(16,84,'Kinda dissapointed with the plant quality',4,'2020-06-20 14:41:10'),(20,93,'Loved this lovely plant! Very easy to take care',5,'2020-06-20 14:41:10'),(25,100,'This is light gray!',4,'2020-02-18 18:13:03');

--R05
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-04-30 13:59:14',1,'Ready_for_Shipping'),('2019-02-05 13:01:42',2,'Processed'),('2019-12-16 13:40:37',3,'Awaiting_Payment'),('2019-01-03 04:16:58',4,'Ready_for_Shipping'),('2019-04-11 13:04:18',5,'Ready_for_Shipping'),('2019-09-08 03:05:35',6,'Processed'),('2019-05-29 07:28:16',7,'Awaiting_Payment'),('2019-01-02 00:09:57',8,'Processed'),('2019-04-06 09:40:03',9,'Processed'),('2019-01-25 13:07:57',10,'Awaiting_Payment');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-01-06 02:19:06',11,'Ready_for_Shipping'),('2019-11-06 08:45:52',12,'Awaiting_Payment'),('2019-01-14 16:36:31',13,'Awaiting_Payment'),('2019-06-02 02:46:01',14,'Processed'),('2019-04-14 05:17:46',15,'Ready_for_Shipping'),('2019-12-01 22:52:05',16,'Ready_for_Shipping'),('2019-11-17 00:56:38',17,'Ready_for_Shipping'),('2019-07-12 13:34:37',18,'Processed'),('2019-04-24 22:18:16',19,'Awaiting_Payment'),('2019-10-17 04:32:40',20,'Processed');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-02-03 10:36:50',21,'Processed'),('2019-05-01 11:29:00',22,'Processed'),('2019-12-01 23:06:37',23,'Awaiting_Payment'),('2019-01-04 01:45:59',24,'Awaiting_Payment'),('2019-05-18 05:43:05',25,'Ready_for_Shipping'),('2019-01-05 09:33:48',26,'Processed'),('2019-07-03 11:03:50',27,'Processed'),('2019-03-28 09:37:09',28,'Ready_for_Shipping'),('2019-06-21 17:31:28',29,'Awaiting_Payment'),('2019-05-30 06:51:43',30,'Ready_for_Shipping');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-10-25 01:45:25',31,'Awaiting_Payment'),('2019-11-30 19:46:47',32,'Processed'),('2019-02-07 05:56:22',33,'Awaiting_Payment'),('2019-03-14 21:05:00',34,'Awaiting_Payment'),('2019-11-05 19:08:42',35,'Awaiting_Payment'),('2019-07-04 09:25:30',36,'Awaiting_Payment'),('2019-05-02 22:07:41',37,'Ready_for_Shipping'),('2019-02-13 05:43:54',38,'Processed'),('2019-02-24 17:31:46',39,'Processed'),('2019-09-14 08:43:32',40,'Processed');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-01-15 18:29:00',41,'Awaiting_Payment'),('2019-08-16 03:18:50',42,'Ready_for_Shipping'),('2019-07-25 12:44:06',43,'Ready_for_Shipping'),('2019-04-15 03:16:45',44,'Awaiting_Payment'),('2019-11-23 09:22:29',45,'Ready_for_Shipping'),('2019-12-08 13:09:58',46,'Ready_for_Shipping'),('2019-03-19 05:33:19',47,'Ready_for_Shipping'),('2019-08-16 21:28:38',48,'Processed'),('2019-08-08 02:28:59',49,'Awaiting_Payment'),('2019-03-19 03:49:56',50,'Processed');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-01-30 19:58:05',51,'Ready_for_Shipping'),('2019-08-09 00:22:33',52,'Processed'),('2019-07-26 00:44:27',53,'Processed'),('2019-02-06 16:40:08',54,'Processed'),('2019-04-16 15:58:24',55,'Awaiting_Payment'),('2019-04-20 10:32:55',56,'Processed'),('2019-04-15 16:19:15',57,'Awaiting_Payment'),('2019-07-22 04:38:28',58,'Awaiting_Payment'),('2019-12-14 00:08:39',59,'Processed'),('2019-02-28 02:08:11',60,'Ready_for_Shipping');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-07-17 21:23:03',61,'Awaiting_Payment'),('2019-11-09 06:46:50',62,'Awaiting_Payment'),('2019-04-07 14:56:35',63,'Awaiting_Payment'),('2019-08-07 08:15:59',64,'Ready_for_Shipping'),('2019-08-31 00:39:24',65,'Awaiting_Payment'),('2019-07-15 21:54:32',66,'Awaiting_Payment'),('2019-08-24 21:10:11',67,'Processed'),('2019-09-30 00:15:59',68,'Processed'),('2019-06-01 21:02:16',69,'Awaiting_Payment'),('2019-12-05 05:20:14',70,'Ready_for_Shipping');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-01-29 12:49:03',71,'Processed'),('2019-09-04 08:25:40',72,'Ready_for_Shipping'),('2019-09-15 02:38:01',73,'Processed'),('2019-06-01 08:43:51',74,'Awaiting_Payment'),('2019-05-11 23:25:50',75,'Ready_for_Shipping'),('2019-10-07 23:20:37',76,'Processed'),('2019-02-25 08:46:30',77,'Ready_for_Shipping'),('2019-01-14 09:14:00',78,'Ready_for_Shipping'),('2019-09-30 22:43:25',79,'Ready_for_Shipping'),('2019-10-07 17:31:12',80,'Awaiting_Payment');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-09-05 03:46:59',81,'Awaiting_Payment'),('2019-07-11 08:05:35',82,'Ready_for_Shipping'),('2019-02-26 18:37:05',83,'Ready_for_Shipping'),('2019-09-07 06:33:37',84,'Awaiting_Payment'),('2019-06-20 08:47:49',85,'Processed'),('2019-11-22 09:29:22',86,'Awaiting_Payment'),('2019-10-01 12:43:22',87,'Ready_for_Shipping'),('2019-12-16 14:17:24',88,'Ready_for_Shipping'),('2019-06-18 12:37:25',89,'Ready_for_Shipping'),('2019-04-29 02:46:49',90,'Ready_for_Shipping');
INSERT INTO "order_history" (date,id_order,order_status) VALUES ('2019-11-24 11:43:09',91,'Awaiting_Payment'),('2019-01-19 04:54:47',92,'Processed'),('2019-05-28 10:42:34',93,'Ready_for_Shipping'),('2019-06-12 20:18:59',94,'Awaiting_Payment'),('2019-07-28 12:18:18',95,'Processed'),('2019-08-11 20:23:10',96,'Ready_for_Shipping'),('2019-11-18 10:34:23',97,'Processed'),('2019-04-27 00:29:44',98,'Processed'),('2019-05-07 05:39:15',99,'Ready_for_Shipping'),('2019-10-18 16:13:03',100,'Processed');

--R07
INSERT INTO wishlist (name,id_user) VALUES (' Flowers ',23),(' Accessories',23),(' Vases ',23),(' Vases ',38),(' Tulips ',8),('Orchids ',29),(' Flowers ',17),('Orchids ',44),(' Flowers ',22);
INSERT INTO wishlist (name,id_user) VALUES (' Accessories',32),(' Accessories',14),(' Accessories',16),(' Vases ',17),(' Flowers ',32),(' Tulips ',10),(' Flowers ',22),('Orchids ',33),(' Vases ',32),(' Tulips ',48);
INSERT INTO wishlist (name,id_user) VALUES ('Orchids ',12),('Orchids ',48),('Orchids ',36),(' Vases ',3),('Orchids ',39),(' Flowers ',4),('Orchids ',37),(' Accessories',30),('Orchids ',32);
INSERT INTO wishlist (name,id_user) VALUES (' Accessories',43),(' Flowers ',14),(' Vases ',16),(' Accessories',12),(' Accessories',22),('Orchids ',42);
INSERT INTO wishlist (name,id_user) VALUES (' Flowers ',38),('Orchids ',49),('Orchids ',21),(' Tulips ',7),('Orchids ',2),('Orchids ',35),(' Flowers ',3),(' Accessories',21),(' Flowers ',6),(' Flowers ',24);

--R08
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (25,32),(1,5),(3,1),(6,3),(8,2),(10,12);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (15,24),(5,15),(17,33),(24,4),(18,23),(23,31);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (26,34),(28,8),(7,17),(21,4),(12,34);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (17,29),(2,22),(16,25),(19,34),(20,11),(30,18);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (30,23),(23,29),(11,18),(1,8);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (14,8),(4,28),(21,16),(9,10),(5,31),(28,19);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (15,16),(2,17),(29,4),(2,35),(3,25),(4,10);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (27,4),(22,40),(23,40),(4,27),(1,32),(5,13);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (30,36),(27,27),(17,13),(10,23),(6,39),(3,6);
INSERT INTO wishlist_product (id_product,id_wishlist) VALUES (15,38),(15,33),(17,10),(20,15),(4,7),(24,9);

--R09
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (21,14,11),(24,8,7),(2,20,9),(12,2,1),(45,4,2),(30,7,1);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (37,6,9),(21,12,12),(25,13,8),(41,18,20),(21,9,20),(14,10,1);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (11,12,10),(41,15,2),(3,21,1),(4,22,1),(6,23,1),(6,26,1);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (44,18,6),(38,12,4),(30,25,15),(8,27,8),(25,5,6),(50,28,1);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (45,3,16),(12,16,8),(15,17,10),(33,1,15),(11,2,1),(15,27,1);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (2,16,11),(45,14,3),(15,29,19),(8,18,6),(8,16,1),(9,13,2);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (13,1,1),(22,24,18),(18,18,17),(4,19,1),(7,26,1),(43,12,1);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (22,11,2),(37,1,10),(43,22,1),(32,10,1),(24,21,2),(38,15,1);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (41,30,1),(10,29,6),(14,14,1),(29,5,1),(50,14,1),(41,29,2);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (44,19,1),(4,18,1),(11,11,1),(22,30,1),(35,23,1),(47,2,1);

--R10
INSERT INTO discount ("percentage",date_begin,date_end) VALUES (96,'2018-04-11','2018-05-21'),(88,'2019-02-25','2019-07-26'),(2,'2020-01-11','2020-02-02'),(88,'2020-04-03','2020-05-09');
INSERT INTO discount ("percentage",date_begin,date_end) VALUES (2,'2020-02-01','2020-06-20'),(3,'2020-03-10','2020-07-30'),(53,'2020-05-25','2020-06-29'),(41,'2020-03-21','2020-04-27');
INSERT INTO discount ("percentage",date_begin,date_end) VALUES (42,'2020-04-18','2020-07-30'),(94,'2020-08-11','2020-09-07'),(33,'2020-06-12','2020-07-21'),(65,'2020-09-27','2020-10-21');
INSERT INTO discount ("percentage",date_begin,date_end) VALUES (31,'2020-06-2','2020-06-10'),(27,'2020-03-20','2020-07-07'),(77,'2020-06-01','2020-07-10'),(4,'2020-04-07','2020-07-21');
INSERT INTO discount ("percentage",date_begin,date_end) VALUES (18,'2020-05-2','2020-07-10'),(79,'2019-05-18','2020-07-05'),(47,'2020-07-01','2020-07-08'),(80,'2020-10-10','2020-11-20');

-- --R11
INSERT INTO discount_code (id_discount,code) VALUES (2,'Guy'),(4,'Yoshi'),(1,'Callie'),(5,'Raja'),(16,'Rudyard');
INSERT INTO discount_code (id_discount,code) VALUES (20,'Noelani'),(9,'Ralph'),(6,'Russell'),(7,'Nehru'),(10,'Salvador');

--R12
INSERT INTO apply_discount (id_product,id_discount) VALUES (2,2),(3,20),(6,18),(10,1),(21,4);
INSERT INTO apply_discount (id_product,id_discount) VALUES (1,11),(1,3),(2,3),(3,3),(4,4);
INSERT INTO apply_discount (id_product,id_discount) VALUES (17,9),(27,14),(5,5),(10,6),(13,7);
INSERT INTO apply_discount (id_product,id_discount) VALUES (26,20),(28,11),(14,6),(3,7),(18,8);
INSERT INTO apply_discount (id_product,id_discount) VALUES (18,11),(30,12),(29,12),(28,13),(23,13);
INSERT INTO apply_discount (id_product,id_discount) VALUES (30,10),(29,11),(26,15),(8,16),(24,17);
INSERT INTO apply_discount (id_product,id_discount) VALUES (25,7),(23,19),(22,19),(21,19),(20,19);
INSERT INTO apply_discount (id_product,id_discount) VALUES (27,20),(19,4),(7,6),(28,20),(8,2);

--R13
INSERT INTO tag ("name") VALUES ('Indoor'),('Outdoor'),('Vases'),('Tools');
INSERT INTO tag ("name") VALUES ('Orchid'),('Tulips'),('Bonsai'),('Rose');
INSERT INTO tag ("name") VALUES ('Green'),('Pink'),('Red'),('Yellow');


--R14
INSERT INTO product_tag (id_tag,id_product) VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8);
INSERT INTO product_tag (id_tag,id_product) VALUES (2,9),(2,10),(2,11),(2,12),(2,13),(2,14),(2,15),(2,16);
INSERT INTO product_tag (id_tag,id_product) VALUES (3,24),(3,25),(3,26),(3,27),(3,28),(3,29),(3,30);
INSERT INTO product_tag (id_tag,id_product) VALUES (4,17),(4,18),(4,19),(4,20),(4,21),(4,22),(4,23);

INSERT INTO product_tag (id_tag,id_product) VALUES (5,1),(6,3),(6,5),(7,2),(7,7),(8,4),(8,16);
INSERT INTO product_tag (id_tag,id_product) VALUES (9,6),(9,2),(9,7),(9,9),(9,14),(9,20),(9,22),(9,29);
INSERT INTO product_tag (id_tag,id_product) VALUES (10,1),(10,5),(10,15),(10,30);
INSERT INTO product_tag (id_tag,id_product) VALUES (11,4),(11,8),(11,16),(11,21),(12,12);



--R15
INSERT INTO ticket (ticket_type,id_user) VALUES ('Faulty_Delivery',18),('Product_Complaint',1),('Faulty_Delivery',8);
INSERT INTO ticket (ticket_type,id_user) VALUES ('Faulty_Delivery',9),('Payment_Error',8),('Payment_Error',8),('Payment_Error',11);

--R16
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2019-06-27 06:48:10','I cought the delivery man throwing my package at the door. It was a bonsai. I want my money back. NOW.',4,8);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2019-09-27 20:36:10','Im waiting for my delivery for a thousand days now, just give me my money back...',5,9);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2019-01-09 10:50:51','I got my orqid last wek and its already ded. Found later that u shud water it... y isnt on the package that shud water it???!!!',2,1);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2019-05-28 11:09:46','My Plant came in a box. It was dead. WTH IS WRONG WITH YOU PEOPLE????',1,18);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2019-01-12 08:32:52','My reference expired and paid after. Now it demands the payment again. HELL NO. Give me my order or give me back my money.',6,8);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2019-10-16 11:28:11','Stripe is down. I dont trust bank references. Please fix this issue.',7,11);
INSERT INTO ticket_message (sent_date,"message",id_ticket,id_user) VALUES ('2019-09-19 16:00:17','Dude, I read sprite on phone and I like order a bunch of bottles, like, weird way of payment but ok, i guess you guys need it. But the order didnt ship it, then i realize it said Stripe... Can i pay with bottles of soda now??? PS: Pls keep selling that sativa, the best i ever had bros!',7,8);

--R17
INSERT INTO ticket_history ("date",ticket_status,id_ticket) VALUES ('2019-06-24 23:00:54','In_Progress',5);
INSERT INTO ticket_history ("date",ticket_status,id_ticket) VALUES ('2019-01-09 10:50:51','Opened',4),('2019-11-01 23:49:25','Closed',1);
INSERT INTO ticket_history ("date",ticket_status,id_ticket) VALUES ('2019-01-13 07:57:42','In_Progress',7);
INSERT INTO ticket_history ("date",ticket_status,id_ticket) VALUES ('2019-10-18 15:14:24','Closed',5),('2019-09-19 16:00:17','Opened',4);


--R19
INSERT INTO product_image (id_product,id_image) VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10);
INSERT INTO product_image (id_product,id_image) VALUES (11,11),(12,12),(13,13),(14,14),(15,15),(16,16),(17,17),(18,18),(19,19),(20,20);
INSERT INTO product_image (id_product,id_image) VALUES (21,21),(22,22),(23,23),(24,24),(25,25),(26,26),(27,27),(28,28),(29,29),(30,30);

--R20
INSERT INTO user_removal (reason,username,removed_at) VALUES ('i just wanted to buy a gift for my vegan gf','whatever123123','2019-04-19 05:29:18');
INSERT INTO user_removal (reason,username,removed_at) VALUES ('my mom caught me gardening. she made me delete this. sry guyz','tr335_4r3_n07_d34d','2019-12-22 14:07:28');