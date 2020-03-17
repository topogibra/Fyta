-- Types
CREATE TYPE ticket_type  ENUM (‘Payment Error’, ‘Faulty Delivery’, ‘Product Complaint’);
CREATE TYPE ticket_status	ENUM(‘Opened’, ‘In Progress’, ‘Closed’);
CREATE TYPE payment_method	ENUM(‘Stripe’, ‘Bank Transfer’);
CREATE TYPE order_status	  ENUM(‘Awaiting Payment’, ‘Ready for Shipping’, ‘Processed’);

-- Tables

DROP TABLE IF EXISTS product;
CREATE TABLE product
(
  id SERIAL,
  "name" TEXT NOT NULL ,
  "description" TEXT NOT NULL,
  price NUMBER NOT NULL,
  stock NUMBER NOT NULL,
  views NUMBER NOT NULL,
  CONSTRAINT product_price_check CHECK (price>=0),
  CONSTRAINT product_stock_check CHECK (stock>=0),
  CONSTRAINT product_views_check CHECK (views>=0),
  CONSTRAINT product_pk PRIMARY KEY (id)
);

DROP TABLE IF EXISTS order;
CREATE TABLE order
(
  id SERIAL,
  orderId NUMBER NOT NULL,
  billing_address TEXT NOT NULL,
  delivery_address TEXT NOT NULL,
  order_date DATE DEFAULT now() NOT NULL,
  TYPE payment_method NOT NULL,
  CONSTRAINT order_pk PRIMARY KEY (id),
  CONSTRAINT order_orderId_uk UNIQUE (orderId)
);

DROP TABLE IF EXISTS product_order;
CREATE TABLE product_order
(
  id_product INTEGER NOT NULL,
  id_order INTEGER NOT NULL,
  CONSTRAINT product_order_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT product_order_order_fk FOREIGN KEY (id_order) REFERENCES order(id) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS review;
CREATE TABLE review
(
  id_product INTEGER NOT NULL,
  id_order INTEGER NOT NULL,
  "description" TEXT NOT NULL,
  rating NUMBER NOT NULL,
  review_date DATE DEFAULT now() NOT NULL,
  CONSTRAINT review_rating_check CHECK (rating>=1 AND rating<=5),
  CONSTRAINT review_pk PRIMARY KEY (id_product,id_order),
  CONSTRAINT review_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT review_order_fk FOREIGN KEY (id_order) REFERENCES order(id)
);

DROP TABLE IF EXISTS order_history;
CREATE TABLE order_history
(
  id SERIAL,
  date_begin DATE DEFAULT now() NOT NULL,
  id_order INTEGER NOT NULL,
  TYPE order_status NOT NULL,
  CONSTRAINT order_history_pk PRIMARY KEY (id),
  CONSTRAINT order_history_order_pk FOREIGN KEY (id_order) REFERENCES order(id),
);

DROP TABLE IF EXISTS user;
CREATE TABLE user
(
  id SERIAL,
  username TEXT NOT NULL,
  email TEXT NOT NULL,
  password_hash TEXT NOT NULL,
  id_image INTEGER NOT NULL,
  CONSTRAINT user_pk PRIMARY KEY (id),
  CONSTRAINT user_username_uk UNIQUE (username),
  CONSTRAINT user_email_uk UNIQUE (email),
  CONSTRAINT user_image_fk FOREIGN KEY (id_image) REFERENCES "image"(id) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS customer;
CREATE TABLE customer
(
  id_user INTEGER NOT NULL,
  "address" TEXT NOT NULL,
  CONSTRAINT customer_pk PRIMARY KEY (id_user),
  CONSTRAINT customer_user_fk FOREIGN KEY (id_user) REFERENCES user(id) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS manager;
CREATE TABLE manager
(
  id_user INTEGER NOT NULL,
  created_at DATE DEFAULT now() NOT NULL,
  CONSTRAINT manager_pk PRIMARY KEY (id_user),
  CONSTRAINT manager_user_fk FOREIGN KEY (id_user) REFERENCES user(id)
);

DROP TABLE IF EXISTS wishlist;
CREATE TABLE wishlist
(
  id SERIAL,
  "name" TEXT NOT NULL,
  CONSTRAINT wishlist_pk PRIMARY KEY (id) 
);

DROP TABLE IF EXISTS customer_wishlist;
CREATE TABLE customer_wishlist
(
  id_customer INTEGER NOT NULL,
  id_wishlist INTEGER NOT NULL,
  CONSTRAINT customer_wishlist_pk PRIMARY KEY (id_wishlist),
  CONSTRAINT customer_wishlist_customer_fk FOREIGN KEY (id_customer) REFERENCES customer(id_user) ON UPDATE CASCADE,
  CONSTRAINT customer_wishlist_wishlist_fk FOREIGN KEY (id_wishlist) REFERENCES wishlist(id) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS wishlist_product;
CREATE TABLE wishlist_product
(
  id_product INTEGER NOT NULL,
  id_wishlist INTEGER NOT NULL,
  CONSTRAINT wishlist_product_pk PRIMARY KEY (id_product,id_wishlist),
  CONSTRAINT wishlist_product_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT wishlist_product_wishlist_fk FOREIGN KEY (id_wishlist) REFERENCES wishlist(id) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS customer_product;
CREATE TABLE customer_product
(
  id_customer INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  quantity NUMBER NOT NULL,
  CONSTRAINT customer_product_pk PRIMARY KEY (id_customer,id_product),
  CONSTRAINT customer_product_customer_fk FOREIGN KEY (id_customer) REFERENCES customer(id) ON UPDATE CASCADE,
  CONSTRAINT customer_product_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT customer_product_quantity_check CHECK (quantity > 0)
);

DROP TABLE IF EXISTS discount;
CREATE TABLE discount
(
  id SERIAL,
  "value" NUMBER NOT NULL,
  date_begin DATE DEFAULT now() NOT NULL,
  date_end DATE NOT NULL,
  CONSTRAINT discount_pk PRIMARY KEY (id),
  CONSTRAINT discount_value_check CHECK ("value" > 0),
  CONSTRAINT discount_dates_check CHECK (date_end > date_begin)
);

DROP TABLE IF EXISTS discount_code;
CREATE TABLE discount_code
(
  id_discount SERIAL,
  code TEXT NOT NULL,
  CONSTRAINT discount_code_pk PRIMARY KEY (id_discount),
  CONSTRAINT discount_code_discount_fk FOREIGN KEY (id_discount) REFERENCES discount(id) ON UPDATE CASCADE,
  CONSTRAINT discount_code_uk UNIQUE (code)
);

DROP TABLE IF EXISTS "apply";
CREATE TABLE "apply"
(
  id_product INTEGER NOT NULL,
  id_discount INTEGER NOT NULL,
  CONSTRAINT apply_pk PRIMARY KEY (id_product,id_discount),
  CONSTRAINT apply_product_fk FOREIGN KEY (id_product) REFERENCES product(id) ON UPDATE CASCADE,
  CONSTRAINT apply_discount_fk FOREIGN KEY (id_discount) REFERENCES discount(id) ON UPDATE CASCADE
);  

DROP TABLE IF EXISTS tag;
CREATE TABLE tag
(
  id SERIAL,
  "name" TEXT NOT NULL,
  CONSTRAINT tag_pk PRIMARY KEY (id),
  CONSTRAINT tag_name_uk UNIQUE ("name") 
);

DROP TABLE IF EXISTS product_tag;
CREATE TABLE product_tag
(
  id_tag  INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  CONSTRAINT product_tag_pk PRIMARY KEY (id_tag,id_product),
  CONSTRAINT product_tag_tag_fk FOREIGN KEY (id_tag) REFERENCES tag(id),
  CONSTRAINT product_tag_product_fk FOREIGN KEY (id_product) REFERENCES product(id)
);

DROP TABLE IF EXISTS ticket;
CREATE TABLE ticket
(
  id INTEGER NOT NULL,
  TYPE ticket_type NOT NULL,
  CONSTRAINT ticket_pk PRIMARY KEY (id)
);

DROP TABLE IF EXISTS customer_ticket;
CREATE TABLE customer_ticket
(
  id_ticket INTEGER NOT NULL,
  id_customer INTEGER NOT NULL,
  CONSTRAINT customer_ticket_pk PRIMARY KEY (id_ticket,id_customer),
  CONSTRAINT customer_ticket_ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id),
  CONSTRAINT customer_ticket_customer_fk FOREIGN KEY (id_customer) REFERENCES customer(id_user)
);

DROP TABLE IF EXISTS ticket_message;
CREATE TABLE ticket_message
(
  id SERIAL,
  sent_date DATE NOT NULL,
  "message" TEXT NOT NULL,
  id_ticket INTEGER NOT NULL,
  id_user INTEGER NOT NULL,
  CONSTRAINT ticket_message_pk PRIMARY KEY (id),
  CONSTRAINT ticket_message_ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id),
  CONSTRAINT ticket_message_user_fk FOREIGN KEY (id_user) REFERENCES user(id)
);

DROP TABLE IF EXISTS ticket_history;
CREATE TABLE ticket_history
(
  id SERIAL,
  date_begin DATE DEFAULT now() NOT NULL,
  TYPE ticket_status NOT NULL,
  id_ticket INTEGER,
  CONSTRAINT ticket_history_pk PRIMARY KEY (id),
  CONSTRAINT ticket_history_ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id)
);

DROP TABLE IF EXISTS "image";
CREATE TABLE "image"
(
  id SERIAL,
  img TEXT NOT NULL,
  "description" TEXT NOT NULL,
  CONSTRAINT image_pk PRIMARY KEY (id)
);

DROP TABLE IF EXISTS product_image;
CREATE TABLE product_image
(
  id_image INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  CONSTRAINT product_image_pk PRIMARY KEY (id_image,id_product),
  CONSTRAINT product_image_image_fk FOREIGN KEY (id_image) REFERENCES "image"(id),
  CONSTRAINT product_image_product_fk FOREIGN KEY (id_product) REFERENCES product(id)
);