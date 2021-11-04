-- -------------------------------------------------------------
-- TablePlus 4.1.2(382)
--
-- https://tableplus.com/
--
-- Database: app
-- Generation Time: 2021-11-03 17:34:01.5430
-- -------------------------------------------------------------

INSERT INTO "public"."article" ("id", "name") VALUES
(1, 'productA'),
(2, 'productB'),
(3, 'productC'),
(4, 'productD'),
(5, 'productE'),
(6, 'productF'),
(7, 'productH');

INSERT INTO "public"."attribute" ("id", "key", "value") VALUES
(1, 'param1', 'A'),
(2, 'param1', 'B'),
(3, 'param1', 'C'),
(4, 'param2', 'X'),
(5, 'param2', 'Y'),
(6, 'param2', 'Z');

INSERT INTO "public"."article_attribute" ("article_id", "attribute_id") VALUES
(1, 1),
(1, 4),
(2, 1),
(2, 6),
(3, 2),
(3, 4),
(4, 2),
(4, 5),
(5, 2),
(5, 6),
(6, 3),
(6, 4),
(7, 3),
(7, 5);
