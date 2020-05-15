CREATE DATABASE container_packaging;
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
VALUES ('Kentucky');
--SELECT
SELECT * FROM warehouses;
SELECT name FROM warehouses WHERE name = 'Kentucky';
/*
* Bins
* Can add flag for primary bin but 
*/
DROP TABLE IF EXISTS bins cascade;
CREATE TABLE bins (
  bin_id serial8,
  name varchar(12),
  item_id varchar(20),
  is_pick_bin boolean,
  area varchar(1),
  row int,
  rack int,
  shelf_lvl int,
  position varchar(1),
  CHECK (area = 'A' OR area = 'B'),
  CHECK (row > 0 AND row < 4),
  CHECK (rack > 0 AND rack < 8),
  CHECK (shelf_lvl > 0 AND shelf_lvl < 4),
  CHECK (position = 'A' OR position = 'B' OR position = 'C'),
  PRIMARY KEY (bin_id)
);
--ALTER
-- ALTER TABLE bins
--INSERT
INSERT INTO bins (item_id, is_pick_bin, area, row, rack, shelf_lvl, position)
VALUES ('DP600', false, 'A', 1, 1, 1, 'A');

SELECT area, row, rack, shelf_lvl, position,
concat(area, ':', row, ':', rack, ':', shelf_lvl, ':', position) AS name
FROM bins;
SELECT name FROM bins;
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
VALUES (0.51, '12/10/2019', 0, 100, false);
/*
* ITEMS
*/

CREATE TABLE items (
  item_id serial8 NOT NULL,
  name varchar(100) NOT NULL UNIQUE,
  cost float8,
  description varchar(100),
  qoh int,
  qty_avail int,
  case_qty int,
  case_lyr int,
  bin_id int,
  has_pick_bin boolean,
  counts_id int,
  PRIMARY KEY (item_id),
  --CHECK (has_pick_bin = 1),
  CONSTRAINT fk_bin_id FOREIGN KEY (bin_id) REFERENCES bins (bin_id),
  --CONSTRAINT fk_bin_is_pick FOREIGN KEY (has_pick_bin) REFERENCES bins (is_pick_bin),
  CONSTRAINT fk_counts_id FOREIGN KEY (counts_id) REFERENCES counts (counts_id)
);
--ALTER TABLE here

--INSERT data below here
INSERT INTO items(name, cost, qoh, qty_avail, case_qty, case_lyr, bin_id, has_pick_bin, counts_id)
VALUES ('DP600', 0.51, 100, 100, 1200, 7, 1, false, 1);

--Find all counts for items
SELECT i.name, c.valuation FROM counts AS c
JOIN items AS i
ON c.counts_id = i.counts_id
WHERE i.counts_id = 1
ORDER BY i.name DESC;

--Check for pick bins
SELECT i.name, b.is_pick_bin, i.has_pick_bin FROM items AS i
JOIN bins AS b
ON i.bin_id = b.bin_id
ORDER BY i.name DESC;