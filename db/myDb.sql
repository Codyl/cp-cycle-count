--CREATE DATABASE container_packaging;

/*
* Bins
* Can add flag for primary bin but 
*/
DROP TABLE IF EXISTS binsKy cascade;
CREATE TABLE binsKy (
  bin_id serial8,
  name varchar(12),
  is_pick_bin boolean,
  area varchar(1),
  row int,
  rack int,
  shelf_lvl int,
  CHECK (area = 'A' OR area = 'B'),
  CHECK (row > 0 AND row <= 15),
  CHECK (rack > 0 AND rack < 32),
  CHECK (shelf_lvl > 0 AND shelf_lvl < 8),
  PRIMARY KEY (bin_id)
);
--ALTER
-- ALTER TABLE bins
--INSERT
INSERT INTO binsKy (is_pick_bin, area, row, rack, shelf_lvl)
VALUES 
(false, 'A', 1, 1, 1),
(true,  'A', 1, 1, 2),
(false, 'A', 1, 1, 3),
(false, 'A', 1, 2, 1),
(false, 'A', 1, 2, 2),
(false, 'A', 1, 2, 3),
(false, 'B', 1, 1, 1),
(false, 'B', 1, 2, 1),
(false, 'A', 2, 1, 1),
(false, 'A', 2, 1, 2),
(false, 'A', 15, 1, 2),
(false, 'A', 15, 1, 3);

UPDATE binsKy--****
SET name = concat(area, ':', row, ':', rack, ':', shelf_lvl);

DROP TABLE IF EXISTS binsIdaho cascade;
CREATE TABLE binsIdaho (
  bin_id serial8,
  name varchar(12),
  is_pick_bin boolean,
  area varchar(1),
  row int,
  rack int,
  shelf_lvl int,
  CHECK (area = 'A' OR area = 'B'),
  CHECK (row > 0 AND row <= 15),
  CHECK (rack > 0 AND rack < 32),
  CHECK (shelf_lvl > 0 AND shelf_lvl < 8),
  PRIMARY KEY (bin_id)
);
--ALTER
-- ALTER TABLE bins
--INSERT
INSERT INTO binsIdaho (is_pick_bin, area, row, rack, shelf_lvl)
VALUES 
(false, 'A', 1, 1, 1),
(true,  'A', 1, 1, 2),
(false, 'A', 1, 1, 3),
(false, 'A', 1, 2, 1),
(false, 'A', 1, 2, 2),
(false, 'A', 1, 2, 3),
(false, 'B', 1, 1, 1),
(false, 'B', 1, 2, 1),
(false, 'A', 2, 1, 1),
(false, 'A', 2, 1, 2);

UPDATE binsIdaho--****
SET name = concat(area, ':', row, ':', rack, ':', shelf_lvl);
/*
*COUNTS
*/
DROP TABLE IF EXISTS countsKy cascade;
CREATE TABLE countsKy (
  counts_id serial8,
  item_id int,
  count_date DATE,
  qty_start int,
  qty_end int,
  exceedsLimit boolean,
  PRIMARY KEY (counts_id),
  CONSTRAINT fk_item_id FOREIGN KEY (item_id) REFERENCES items (item_id)
);
--ALTER
--INSERT
INSERT INTO countsKy (count_date, qty_start, qty_end)
VALUES ('12/10/2019', 0, 100),
 ('12/21/2019', 100, 100),
 ('1/10/2018', 200, 0);

UPDATE countsKy AS c
SET item_id= i.item_id
FROM itemsKy AS i
WHERE c.counts_id = i.counts_id;

 UPDATE countsKy AS c--****
 SET exceedsLimit=true
 FROM items AS i
 WHERE i.item_id = c.item_id AND qty_end-qty_start >= i.case_qty*3 OR qty_end-qty_start <= -i.case_qty*3;

 SELECT item_id FROM countsKy
 WHERE exceedsLimit=true;
--need to create table orders and countsHistory

DROP TABLE IF EXISTS countsIdaho cascade;
CREATE TABLE countsIdaho (
  counts_id serial8,
  count_date DATE,
  qty_start int,
  qty_end int,
  exceedsLimit boolean,
  PRIMARY KEY (counts_id)
);
--ALTER
--INSERT
INSERT INTO countsIdaho (count_date, qty_start, qty_end, exceedsLimit)
VALUES ('12/10/2019', 0, 100, false),
 ('12/21/2019', 100, 100, false),
 ('1/10/2018', 200, 0, false);
/*
* ITEMS
*/
DROP TABLE IF EXISTS items cascade;
CREATE TABLE items (
  item_id serial8 NOT NULL PRIMARY KEY,
  name varchar(100) NOT NULL UNIQUE,
  cost float8 NOT NULL,
  description varchar(100),
  case_qty int NOT NULL,
  case_lyr int NOT NULL,
  cases_per_plt int NOT NULL
);
--ALTER TABLE here

--INSERT data below here
INSERT INTO items(name, cost, case_qty, case_lyr, cases_per_plt)
VALUES 
('J071CL', 0.34, 400 , 4 , 16),
('G841AM', 0.91, 80  , 10, 35),
('DP600' , 0.51, 1200, 7 , 35),
('J115'  , 0.91, 40  , 4 , 16),
('G040'  , 1.50, 12  , 20, 150),
('M653BK', 0.21, 180 , 5 , 28),
('S400'  , 0.41, 1000, 7 , 35),
('J101'  , 0.95, 100 , 7 , 20),
('M654BK', 0.50, 180 , 5 , 35),
('M653WH', 0.55, 180 , 5 , 35),
('B500'  , 2.50, 40  , 2 , 16);
SELECT * FROM items;




--Check for pick bins
-- SELECT concat(area, ':', row, ':', rack, ':', shelf_lvl) AS bin, i.name AS stored_item, b.is_pick_bin FROM items AS i
-- JOIN itemList AS b
-- ON i.item_id = il.item_id
-- JOIN bins AS il
-- ON il.bin_id = b.bin_id
-- ORDER BY b.bin_id ASC;

DROP TABLE IF EXISTS itemsKy cascade;
CREATE TABLE itemsKy(
  id serial8,
  item_id int NOT NULL,
  counts_id int,
  qoh int NOT NULL,
  qty_avail int NOT NULL,
  PRIMARY KEY(id),
  CONSTRAINT fk_item_id FOREIGN KEY (item_id) REFERENCES items (item_id),
  CONSTRAINT fk_counts_id FOREIGN KEY (counts_id) REFERENCES countsKy (counts_id)
);

INSERT INTO itemsKy(item_id, counts_id, qoh, qty_avail)
VALUES
(1,1,200,100),(2,2,1300,0);
INSERT INTO itemsKy(item_id, qoh, qty_avail)
VALUES
(3,200,100),(4,200,100),(5,200,100),(6,200,100),(7,200,100),(8,200,100),(9,200,100),(10,200,100),(11,200,100);

--Find all counts for items in ky
SELECT items.name, items.cost, (c.qty_end - c.qty_start) AS qty_change, (c.qty_end * items.cost - c.qty_start * items.cost) AS cost FROM countsKy AS c
JOIN itemsKy AS i
ON c.counts_id = i.counts_id
JOIN items
ON items.item_id = i.item_id
ORDER BY items.name DESC;

SELECT id, I.item_id, name FROM itemsKy AS IK
JOIN items AS I
ON I.item_id = IK.item_id;

DROP TABLE IF EXISTS itemsIdaho cascade;
CREATE TABLE itemsIdaho(
  id serial8,
  item_id int,
  counts_id int,
  qoh int NOT NULL,
  qty_avail int NOT NULL,
  PRIMARY KEY(id),
  CONSTRAINT fk_item_id FOREIGN KEY (item_id) REFERENCES items (item_id),
  CONSTRAINT fk_counts_id FOREIGN KEY (counts_id) REFERENCES countsIdaho (counts_id)
);

INSERT INTO itemsIdaho(item_id, counts_id, qoh, qty_avail)
VALUES
(1,3, 400, 400);
INSERT INTO itemsIdaho(item_id, qoh, qty_avail)
VALUES
(4, 5000, 4500),(5, 1400, 1300),(6, 4355, 4354),(7, 4000, 0);

SELECT id, I.item_id, name FROM itemsIdaho AS II
JOIN items AS I
ON I.item_id = II.item_id;

--Find all counts for items in Idaho
SELECT items.name, items.cost, (c.qty_end - c.qty_start) AS qty_change, (c.qty_end * items.cost - c.qty_start * items.cost) AS cost FROM countsIdaho AS c
JOIN itemsIdaho AS i
ON c.counts_id = i.counts_id
JOIN items
ON items.item_id = i.item_id
ORDER BY items.name DESC;

--Allows for multiple bins per item
DROP TABLE IF EXISTS itemListKy;
CREATE TABLE itemListKy(
  id serial8,
  item_id int NOT NULL,
  bin_id int NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_bin_id FOREIGN KEY (bin_id) REFERENCES bins (bin_id),
  CONSTRAINT fk_item_id FOREIGN KEY (item_id) REFERENCES itemsKy (id)
);

INSERT INTO itemListKy(item_id, bin_id)
VALUES
(1,1),(2,2),(3,3),(4,4),(5,5),(1,6),(6,7),(2,8),(2,9),(4,1),(5,11),(5,2),(7,10),(8,12),(9,10),(10,11),(11,1);

DROP TABLE IF EXISTS itemListIdaho;
CREATE TABLE itemListIdaho(
  id serial8,
  item_id int NOT NULL,
  bin_id int NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_bin_id FOREIGN KEY (bin_id) REFERENCES bins (bin_id),
  CONSTRAINT fk_item_id FOREIGN KEY (item_id) REFERENCES itemsIdaho (id)
);

INSERT INTO itemListIdaho(item_id, bin_id)
VALUES
(1,1),(2,6),(3,2),(4,1),(5,1),(1,2);

--Create tables
DROP TABLE IF EXISTS warehouses;
CREATE TABLE warehouses (
  warehouse_id serial8 NOT NULL,
  name varchar(100),
  PRIMARY KEY (warehouse_id)
);

--ALTER
--INSERT
INSERT INTO warehouses (name)
VALUES ('Kentucky'),('Idaho');
--SELECT

DROP TABLE IF EXISTS userTable;
CREATE TABLE userTable (
  user_id SERIAL PRIMARY KEY,
  username varchar,
  password_hash varchar,
  warehouse_id int,
  counts_complete int
);