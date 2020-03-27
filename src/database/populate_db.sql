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
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (43,70,10),(52,44,14),(1,38,17),(21,14,11),(90,68,15),(72,81,20),(24,35,19),(27,87,11),(24,8,7),(2,20,9);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (87,6,9),(67,98,18),(21,12,12),(98,85,18),(98,49,20),(17,49,4),(25,13,8),(91,18,20),(29,36,14),(70,9,20);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (25,35,12),(61,12,10),(96,60,5),(32,36,4),(61,96,1),(12,47,17),(27,55,7),(48,86,1),(26,88,9),(93,96,17);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (19,55,8),(88,45,1),(63,1,1),(79,78,19),(73,84,6),(46,43,20),(50,93,10),(13,56,16),(22,24,18),(68,18,17);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (20,65,3),(46,59,10),(95,3,16),(12,16,8),(65,17,10),(83,98,9),(54,87,9),(100,60,6),(59,37,17),(33,1,15);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (17,95,8),(36,43,6),(44,18,6),(38,12,4),(80,25,15),(14,98,16),(48,82,8),(58,27,8),(20,50,1),(25,5,6);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (57,68,11),(72,11,2),(75,51,20),(8,72,5),(47,72,3),(7,50,12),(41,33,1),(25,54,11),(87,1,10),(24,43,18);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (39,75,2),(56,100,1),(2,16,11),(16,78,1),(46,14,3),(65,29,19),(5,97,10),(8,18,6),(45,36,11),(81,36,6);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (77,56,8),(95,62,12),(38,83,6),(83,34,11),(90,30,1),(99,64,11),(8,52,16),(60,92,15),(79,98,15),(60,29,6);
INSERT INTO shopping_cart (id_user,id_product,quantity) VALUES (7,72,3),(94,19,1),(85,96,14),(73,57,10),(87,35,20),(14,48,18),(84,55,4),(40,66,17),(32,73,14),(35,93,11);

--R10
INSERT INTO discount (id,percentage,date_begin,date_end) VALUES (1,96,'2019-04-11','2019-12-21'),(2,88,'2020-02-25','2020-06-26'),(3,2,'2020-01-11','2020-02-02'),(4,88,'2019-08-03','2019-11-09');
INSERT INTO discount (id,percentage,date_begin,date_end) VALUES (5,2,'2020-02-01','2020-09-20'),(6,3,'2020-03-10','2020-07-30'),(7,53,'2019-02-25','2020-06-29'),(8,41,'2020-10-21','2021-01-27');
INSERT INTO discount (id,percentage,date_begin,date_end) VALUES (9,42,'2019-04-18','2020-11-30'),(10,94,'2020-08-11','2021-07-07'),(11,33,'2019-06-12','2020-04-21'),(12,65,'2019-09-27','2019-12-21');
INSERT INTO discount (id,percentage,date_begin,date_end) VALUES (13,31,'2020-06-30','2020-07-05'),(14,27,'2020-03-20','2020-07-07'),(15,77,'2019-12-11','2020-03-10'),(16,4,'2019-04-07','2020-06-21');
INSERT INTO discount (id,percentage,date_begin,date_end) VALUES (17,18,'2021-03-25','2019-08-17'),(18,79,'2020-05-18','2020-12-05'),(19,47,'2020-07-13','2021-02-08'),(20,80,'2020-10-10','2020-10-20');

--R11
INSERT INTO discount_code (id_discount,code) VALUES (2,'Guy'),(4,'Yoshi'),(1,'Callie'),(5,'Raja'),(16,'Rudyard');
INSERT INTO discount_code (id_discount,code) VALUES (20,'Noelani'),(9,'Ralph'),(6,'Russell'),(7,'Nehru'),(10,'Salvador');

--R12
INSERT INTO "apply" (id_product,id_discount) VALUES (21,4),(10,1),(27,14),(44,3),(91,14);
INSERT INTO "apply" (id_product,id_discount) VALUES (20,11),(95,8),(34,1),(55,11),(49,18);
INSERT INTO "apply" (id_product,id_discount) VALUES (84,10),(96,17),(6,18),(20,9),(63,8);
INSERT INTO "apply" (id_product,id_discount) VALUES (35,14),(26,20),(28,11),(26,6),(78,10);
INSERT INTO "apply" (id_product,id_discount) VALUES (66,15),(64,17),(34,2),(18,11),(83,12);
INSERT INTO "apply" (id_product,id_discount) VALUES (76,15),(82,11),(59,20),(91,16),(89,16);
INSERT INTO "apply" (id_product,id_discount) VALUES (3,20),(30,10),(60,20),(39,4),(26,11);
INSERT INTO "apply" (id_product,id_discount) VALUES (94,4),(99,8),(37,14),(25,7),(36,18);
INSERT INTO "apply" (id_product,id_discount) VALUES (32,11),(89,15),(27,20),(51,18),(2,2);
INSERT INTO "apply" (id_product,id_discount) VALUES (87,18),(46,8),(66,4),(82,7),(76,11);

--R13
INSERT INTO tag (id,name) VALUES (1,'Winifred'),(2,'Aspen'),(3,'Audrey'),(4,'April');
INSERT INTO tag (id,name) VALUES (5,'Grace'),(6,'Martena'),(7,'Lilah'),(8,'Alika');
INSERT INTO tag (id,name) VALUES (9,'Yen'),(10,'Haviva'),(11,'Gisela'),(12,'Bertha');
INSERT INTO tag (id,name) VALUES (13,'Hadassah'),(14,'Dai'),(15,'Brooke'),(16,'Xandra');
INSERT INTO tag (id,name) VALUES (17,'Sydnee'),(18,'Quon'),(19,'Clare'),(20,'Xyla');

--R14
INSERT INTO product_tag (id_tag,id_product) VALUES (15,61),(9,42),(11,71),(5,95),(10,67);
INSERT INTO product_tag (id_tag,id_product) VALUES (16,27),(20,66),(15,58),(17,38),(9,22);
INSERT INTO product_tag (id_tag,id_product) VALUES (10,28),(9,9),(18,29),(18,93),(15,76);
INSERT INTO product_tag (id_tag,id_product) VALUES (2,30),(1,17),(9,11),(4,91),(9,13);
INSERT INTO product_tag (id_tag,id_product) VALUES (7,15),(9,72),(11,92),(16,60),(18,74);
INSERT INTO product_tag (id_tag,id_product) VALUES (12,35),(9,98),(17,56),(15,58),(17,49);
INSERT INTO product_tag (id_tag,id_product) VALUES (3,3),(11,35),(19,10),(9,77),(17,78);
INSERT INTO product_tag (id_tag,id_product) VALUES (4,22),(18,40),(8,100),(3,51),(16,6);
INSERT INTO product_tag (id_tag,id_product) VALUES (2,26),(17,76),(16,100),(9,93),(20,56);
INSERT INTO product_tag (id_tag,id_product) VALUES (20,89),(15,65),(15,51),(8,67),(4,70);

--R15
INSERT INTO ticket (id,ticket_type,id_user) VALUES (1,'Faulty_Delivery',18),(2,'Product_Complaint',1),(3,'Faulty_Delivery',5),(4,'Faulty_Delivery',8);
INSERT INTO ticket (id,ticket_type,id_user) VALUES (5,'Faulty_Delivery',9),(6,'Payment_Error',8),(7,'Payment_Error',8),(8,'Payment_Error',11);

--R16
INSERT INTO ticket_message (id,send_date,message,id_ticket,id_user) VALUES (1,'2019-06-27 06:48:10','I cought the delivery man throwing my package at the door. It was a bonsai. I want my money back. NOW.',4,4);
INSERT INTO ticket_message (id,send_date,message,id_ticket,id_user) VALUES (2,'2020-09-27 20:36:10','Im waiting for my delivery for a thousand days now, just give me my money back...',5,11);
INSERT INTO ticket_message (id,send_date,message,id_ticket,id_user) VALUES (3,'2021-01-09 10:50:51','I got my orqid last wek and its already ded. Found later that u shud water it... y isnt on the package that shud water it???!!!',2,2);
INSERT INTO ticket_message (id,send_date,message,id_ticket,id_user) VALUES (4,'2020-10-28 10:13:18','My Plant arrived at my house wrapped in bubble-wrap. Who hired that packager?.. I demand imediate restitution of my money!',3,23);
INSERT INTO ticket_message (id,send_date,message,id_ticket,id_user) VALUES (5,'2019-05-28 11:09:46','My Plant came in a box. It was dead. WTH IS WRONG WITH YOU PEOPLE????',1,28);
INSERT INTO ticket_message (id,send_date,message,id_ticket,id_user) VALUES (6,'2020-01-12 08:32:52','My reference expired and paid after. Now it demands the payment again. HELL NO. Give me my order or give me back my money.',6,22);
INSERT INTO ticket_message (id,send_date,message,id_ticket,id_user) VALUES (7,'2019-10-16 11:28:11','Stripe is down. I dont trust bank references. Please fix this issue.',8,47);
INSERT INTO ticket_message (id,send_date,message,id_ticket,id_user) VALUES (8,'2020-09-19 16:00:17','Dude, I read sprite on phone and I like order a bunch of bottles, like, weird way of payment but ok, i guess you guys need it. But the order didnt ship it, then i realize it said stripe... Can i pay with bottles of soda now??? PS: Pls keep selling that sativa, the best i ever had bros!',7,12);

--R17
INSERT INTO ticket_history (id,date,ticket_status,id_ticket) VALUES (1,'2019-06-24 23:00:54','In_Progress',5),(2,'2020-09-28 07:59:42','In_Progress',8);
INSERT INTO ticket_history (id,date,ticket_status,id_ticket) VALUES (3,'2021-01-09 10:50:51','Opened',4),(4,'2020-11-01 23:49:25','Closed',1);
INSERT INTO ticket_history (id,date,ticket_status,id_ticket) VALUES (5,'2019-05-29 11:09:46','Opened',8),(6,'2020-01-13 07:57:42','In_Progress',7);
INSERT INTO ticket_history (id,date,ticket_status,id_ticket) VALUES (7,'2019-10-18 15:14:24','Closed',5),(8,'2020-09-19 16:00:17','Opened',4);

--R18
INSERT INTO "image" (id,path,description) VALUES (1,'../assets/orquideas.jpg','Rose Orchid');
INSERT INTO "image" (id,path,description) VALUES (2,'../assets/vaso.jpg','XPR Vase');
INSERT INTO "image" (id,path,description) VALUES (3,'../assets/bonsai2.jpg','Bonsai CRT');
INSERT INTO "image" (id,path,description) VALUES (4,'../assets/tulipas.jpg','Orange Tulips');
INSERT INTO "image" (id,path,description) VALUES (5,'../assets/meatrose_indoor.jpg','Meat Rose');
INSERT INTO "image" (id,path,description) VALUES (6,'../assets/reddahlia_indoor.jpg','Red Dahlias');
INSERT INTO "image" (id,path,description) VALUES (7,'../assets/pinktulips_indoor.jpg','Pink Tulips');
INSERT INTO "image" (id,path,description) VALUES (8,'../assets/sativa_indoor.jpg','Sativa Prime');
INSERT INTO "image" (id,path,description) VALUES (9,'../assets/greenpalm_outdoor.jpg','Green Palm Tree');
INSERT INTO "image" (id,path,description) VALUES (10,'../assets/lavender_outdoor.jpg','Lavender Premium');
INSERT INTO "image" (id,path,description) VALUES (11,'../assets/mohammad-faruque-AgYOuy8kA7M-unsplash.jpg','Mohammad Faruque');
INSERT INTO "image" (id,path,description) VALUES (12,'../assets/dannie_almir.jpg','Dannie Almir');
INSERT INTO "image" (id,path,description) VALUES (13,'../assets/simone.jpeg','Simone Biles');
INSERT INTO "image" (id,path,description) VALUES (14,'../assets/sisay_jeremiah_small.jpg','Sisay Jeremiah');

--R19
INSERT INTO product_image (id_image,id_product) VALUES (1,33);
INSERT INTO product_image (id_image,id_product) VALUES (2,47);
INSERT INTO product_image (id_image,id_product) VALUES (3,45);
INSERT INTO product_image (id_image,id_product) VALUES (4,31);
INSERT INTO product_image (id_image,id_product) VALUES (5,43);
INSERT INTO product_image (id_image,id_product) VALUES (6,27);
INSERT INTO product_image (id_image,id_product) VALUES (7,32);
INSERT INTO product_image (id_image,id_product) VALUES (8,3);
INSERT INTO product_image (id_image,id_product) VALUES (9,21);
INSERT INTO product_image (id_image,id_product) VALUES (10,33);

--R20
INSERT INTO user_removal (id,reason,username,removed_at) VALUES (1,'i just wanted to buy a gift for my vegan gf','whatever123123','2019-04-19 05:29:18');
INSERT INTO user_removal (id,reason,username,removed_at) VALUES (2,'my mom caught me gardening. she made me delete this. sry guyz','tr335_4r3_n07_d34d','2019-12-22 14:07:28');









