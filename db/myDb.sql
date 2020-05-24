--CREATE DATABASE container_packaging;

/*
* Bins
* Can add flag for primary bin but 
*/
DROP TABLE IF EXISTS bins cascade;
CREATE TABLE bins (
  bin_id serial8,
  name varchar(12),
  is_pick_bin boolean,
  area varchar(1),
  row int,
  rack int,
  shelf_lvl int,
  position varchar(1),
  CHECK (area = 'A' OR area = 'B'),
  CHECK (row > 0 AND row <= 15),
  CHECK (rack > 0 AND rack < 3),
  CHECK (shelf_lvl > 0 AND shelf_lvl < 4),
  CHECK (position = 'A' OR position = 'B' OR position = 'C'),
  PRIMARY KEY (bin_id)
);
--ALTER
-- ALTER TABLE bins
--INSERT
INSERT INTO bins (is_pick_bin, area, row, rack, shelf_lvl, position)
VALUES 
(false, 'A', 1, 1, 1, 'A'),
(true,  'A', 1, 1, 1, 'B'),
(false, 'A', 1, 1, 1, 'C'),
(false, 'A', 1, 1, 2, 'A'),
(false, 'A', 1, 1, 2, 'B'),
(false, 'A', 1, 1, 2, 'C'),
(false, 'B', 1, 1, 1, 'A'),
(false, 'B', 1, 2, 1, 'A'),
(false, 'A', 2, 1, 1, 'A'),
(false, 'A', 1, 2, 2, 'A'),
(false, 'A', 15, 1, 2, 'B'),
(false, 'A', 15, 1, 3, 'A');

SELECT area, row, rack, shelf_lvl, position,
concat(area, ':', row, ':', rack, ':', shelf_lvl, ':', position) AS name
FROM bins;
/*
*COUNTS
*/
DROP TABLE IF EXISTS items;
DROP TABLE IF EXISTS counts;
CREATE TABLE counts (
  counts_id serial8,
  --item_name int,
  valuation float8,
  count_date DATE,
  qty_start int,
  qty_end int,
  exceedsLimit boolean,
  PRIMARY KEY (counts_id)
  --CONSTRAINT fk_item_id FOREIGN KEY (item_name) REFERENCES items (name),
);
--ALTER
--INSERT
INSERT INTO counts (valuation, count_date, qty_start, qty_end, exceedsLimit)
VALUES (0.51, '12/10/2019', 0, 100, false),
 (0.51, '12/21/2019', 100, 100, false),
 (0.51, '1/10/2018', 200, 0, false);
/*
* ITEMS
*/

CREATE TABLE items (
  item_id serial8 NOT NULL,
  name varchar(100) NOT NULL UNIQUE,
  cost float8 NOT NULL,
  description varchar(100),
  qoh int NOT NULL,
  qty_avail int NOT NULL,
  case_qty int NOT NULL,
  case_lyr int NOT NULL,
  bin_id int,
  counts_id int,
  PRIMARY KEY (item_id),
  --CHECK (has_pick_bin = 1),
  CONSTRAINT fk_bin_id FOREIGN KEY (bin_id) REFERENCES bins (bin_id),
  --CONSTRAINT fk_bin_is_pick FOREIGN KEY (has_pick_bin) REFERENCES bins (is_pick_bin),
  CONSTRAINT fk_counts_id FOREIGN KEY (counts_id) REFERENCES counts (counts_id)
);
--ALTER TABLE here

--INSERT data below here
INSERT INTO items(name, cost, qoh, qty_avail, case_qty, case_lyr, bin_id, counts_id)
VALUES 
('J071CL', 0.34, 18100, -100, 400, 4, 2, 2),
('G841AM', 0.91, 0, 0, 80, 7, 3, 3),
('DP600', 0.51, 100, 100, 1200, 7, 1, 1);
INSERT INTO items(name, cost, qoh, qty_avail, case_qty, case_lyr, bin_id)
VALUES 
('J115', 0.91, 0, 0, 80, 7, 4),
('G040', 0.91, 0, 0, 80, 7, 5),
('M653BK', 0.91, 0, 0, 80, 7, 6),
('S400', 0.91, 0, 0, 80, 7, 7),
('J101', 0.91, 0, 0, 80, 7, 8),
('M654BH', 0.91, 0, 0, 80, 7, 9),
('M653WH', 0.91, 0, 0, 80, 7, 10),
('B500', 0.91, 0, 0, 80, 7, 11);

--Find all counts for items
SELECT i.name, c.valuation, (c.qty_end - c.qty_start) AS qty_change, (c.qty_end * i.cost - c.qty_start * i.cost) AS cost FROM counts AS c
JOIN items AS i
ON c.counts_id = i.counts_id
WHERE i.counts_id = 1
ORDER BY i.name DESC;

--Check for pick bins
SELECT concat(area, ':', row, ':', rack, ':', shelf_lvl, ':', position) AS bin, i.name AS stored_item, b.is_pick_bin FROM items AS i
JOIN bins AS b
ON i.bin_id = b.bin_id
ORDER BY b.bin_id ASC;

--Create tables
DROP TABLE IF EXISTS warehouses;
CREATE TABLE warehouses (
  warehouse_id serial8 NOT NULL,
  name varchar(100),
  item_id int,
  PRIMARY KEY (warehouse_id),
  CONSTRAINT fk_item_id FOREIGN KEY (item_id) REFERENCES items (item_id)
);

--ALTER
--INSERT
INSERT INTO warehouses (name)
VALUES ('Kentucky'),('Idaho');
--SELECT
SELECT * FROM warehouses;
SELECT name FROM warehouses WHERE name = 'Kentucky';