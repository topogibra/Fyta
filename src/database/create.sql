-- Types
DROP TYPE IF EXISTS ticket_type CASCADE;
CREATE TYPE ticket_type AS ENUM ('Payment_Error', 'Faulty_Delivery', 'Product_Complaint');
DROP TYPE IF EXISTS ticket_status CASCADE;
CREATE TYPE ticket_status AS ENUM('Opened', 'In_Progress', 'Closed');
DROP TYPE IF EXISTS payment_method CASCADE;
CREATE TYPE payment_method AS ENUM('Stripe', 'Bank_Transfer');
DROP TYPE IF EXISTS order_status CASCADE;
CREATE TYPE order_status AS ENUM('Awaiting_Payment', 'Ready_for_Shipping', 'Processed');
DROP TYPE IF EXISTS user_role CASCADE;
CREATE TYPE user_role as ENUM('Customer', 'Manager');

-- Tables
DROP TABLE IF EXISTS "image" CASCADE;
CREATE TABLE "image"
(
  id SERIAL,
  path TEXT NOT NULL,
  "description" TEXT NOT NULL,
  CONSTRAINT image_pk PRIMARY KEY (id)
);
DROP TABLE IF EXISTS product CASCADE;
CREATE TABLE product
(
  id SERIAL,
  "name" TEXT NOT NULL ,
  "description" TEXT NOT NULL,
  price FLOAT NOT NULL,
  stock INTEGER NOT NULL,
  views INTEGER NOT NULL,
  CONSTRAINT product_price_check CHECK (price>=0),
  CONSTRAINT product_stock_check CHECK (stock>=0),
  CONSTRAINT product_views_check CHECK (views>=0),
  CONSTRAINT product_pk PRIMARY KEY (id)
);
DROP TABLE IF EXISTS "user" CASCADE;
CREATE TABLE "user"
(
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
CREATE TABLE wishlist
(
  id SERIAL,
  "name" TEXT NOT NULL,
  id_user INTEGER NOT NULL,
  CONSTRAINT wishlist_pk PRIMARY KEY (id),
  CONSTRAINT wishlist_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE 
);
DROP TABLE IF EXISTS wishlist_product CASCADE;
CREATE TABLE wishlist_product
(
  id_product INTEGER NOT NULL,
  id_wishlist INTEGER NOT NULL,
  CONSTRAINT wishlist_product_pk PRIMARY KEY (id_product,id_wishlist),
  CONSTRAINT wishlist_product_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT wishlist_product_wishlist_fk FOREIGN KEY (id_wishlist) REFERENCES wishlist(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS shopping_cart CASCADE;
CREATE TABLE shopping_cart
(
  id_user INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  quantity INTEGER  NOT NULL,
  CONSTRAINT shopping_cart_pk PRIMARY KEY (id_user,id_product),
  CONSTRAINT shopping_cart_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE,
  CONSTRAINT shopping_cart_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT shopping_cart_quantity_check CHECK (quantity > 0)
);
DROP TABLE IF EXISTS discount CASCADE;
CREATE TABLE discount
(
  id SERIAL,
  "percentage" INTEGER NOT NULL,
  date_begin DATE DEFAULT now() NOT NULL,
  date_end DATE NOT NULL,
  CONSTRAINT discount_pk PRIMARY KEY (id),
  CONSTRAINT discount_value_check CHECK ("percentage" > 0 AND "percentage" < 100),
  CONSTRAINT discount_dates_check CHECK (date_end > date_begin)
);
DROP TABLE IF EXISTS discount_code CASCADE;
CREATE TABLE discount_code
(
  id_discount SERIAL,
  code TEXT NOT NULL,
  CONSTRAINT discount_code_pk PRIMARY KEY (id_discount),
  CONSTRAINT discount_code_discount_fk FOREIGN KEY (id_discount) REFERENCES discount(id) ON UPDATE CASCADE,
  CONSTRAINT discount_code_uk UNIQUE (code)
);
DROP TABLE IF EXISTS "apply" CASCADE;
CREATE TABLE "apply"
(
  id_product INTEGER NOT NULL,
  id_discount INTEGER NOT NULL,
  CONSTRAINT apply_pk PRIMARY KEY (id_product,id_discount),
  CONSTRAINT apply_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT apply_discount_fk FOREIGN KEY (id_discount) REFERENCES discount(id) ON UPDATE CASCADE
);  
DROP TABLE IF EXISTS tag CASCADE;
CREATE TABLE tag
(
  id SERIAL,
  "name" TEXT NOT NULL,
  CONSTRAINT tag_pk PRIMARY KEY (id),
  CONSTRAINT tag_name_uk UNIQUE ("name") 
);
DROP TABLE IF EXISTS product_tag CASCADE;
CREATE TABLE product_tag
(
  id_tag  INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  CONSTRAINT product_tag_pk PRIMARY KEY (id_tag,id_product),
  CONSTRAINT product_tag_tag_fk FOREIGN KEY (id_tag) REFERENCES tag(id) ON UPDATE CASCADE,
  CONSTRAINT product_tag_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS ticket CASCADE;
CREATE TABLE ticket
(
  id INTEGER NOT NULL,
  ticket_type "ticket_type" NOT NULL,
  id_user INTEGER NOT NULL,
  CONSTRAINT ticket_pk PRIMARY KEY (id),
  CONSTRAINT ticket_user_fk FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS ticket_message CASCADE;
CREATE TABLE ticket_message
(
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
CREATE TABLE ticket_history
(
  id SERIAL,
  "date" DATE DEFAULT now() NOT NULL,
  ticket_status "ticket_status" NOT NULL,
  id_ticket INTEGER,
  CONSTRAINT ticket_history_pk PRIMARY KEY (id),
  CONSTRAINT ticket_history_ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS product_image CASCADE;
CREATE TABLE product_image
(
  id_image INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  CONSTRAINT product_image_pk PRIMARY KEY (id_image,id_product),
  CONSTRAINT product_image_image_fk FOREIGN KEY (id_image) REFERENCES "image"(id) ON UPDATE CASCADE,
  CONSTRAINT product_image_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE
);
DROP TABLE IF EXISTS user_removal CASCADE;
CREATE TABLE user_removal
(
  id SERIAL,
  reason TEXT NOT NULL,
  username TEXT NOT NULL,
  removed_at DATE DEFAULT now() NOT NULL,
  CONSTRAINT user_removal_pk PRIMARY KEY (id)
);