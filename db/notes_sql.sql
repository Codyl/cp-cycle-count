-- PostgreSQL commands:
-- heroku pg:psql start psql CLI tool using the remote Heroku database
-- \q             quit psql CLI tool
-- \l             list databases
-- \c <dbName>    connect to a database (initially connected to default database)
-- \dt            display tables (MySQL: SHOW TABLES)
-- \d <tableName> display table structure (MySQL: DESCRIBE <tableName>)
-- \d+ <tableName> display table structure in detail (MySQL: DESCRIBE <tableName>)
------------------------------------------------------------------------------


-- CREATE DATABASE <dbName>; (a database named "DATABASE" was already created by Heroku)

--
-- week 04 team activity core requirements
--
DROP TABLE IF EXISTS notes; -- must drop this first due to foreign keys

DROP TABLE IF EXISTS app_users;
CREATE TABLE app_users (
  app_user_id serial8 NOT NULL, -- serial is equivalent to: int UNSIGNED NOT NULL AUTO_INCREMENT
  name varchar(100),
  PRIMARY KEY (app_user_id)
);

DROP TABLE IF EXISTS speakers;
CREATE TABLE speakers (
  speaker_id serial8 NOT NULL,
  name varchar(100),
  title varchar(100),
  PRIMARY KEY (speaker_id)
);
ALTER TABLE speakers
ADD CONSTRAINT unique_name  
UNIQUE (name);

DROP TABLE IF EXISTS conferences;
CREATE TABLE conferences (
  conference_id serial8 NOT NULL,
  name varchar(100),
  month varchar(12) NOT NULL,
  year int NOT NULL,
  PRIMARY KEY (conference_id)
);

CREATE TABLE notes (
  note_id serial8 NOT NULL,
  app_user_id int NOT NULL,
  speaker_id int,
  conference_id int,
  note varchar(1000),
  created_at TIMESTAMP DEFAULT NOW(),
  PRIMARY KEY (note_id),
  CONSTRAINT fk_app_user_note FOREIGN KEY (app_user_id) REFERENCES app_users (app_user_id),
  CONSTRAINT fk_speaker_note FOREIGN KEY (speaker_id) REFERENCES speakers (speaker_id),
  CONSTRAINT fk_conference_note FOREIGN KEY (conference_id) REFERENCES conferences (conference_id)
);

--
-- week 04 team activity stretch challenges
--
DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
  session_id serial8 NOT NULL,
  name varchar(50),
  PRIMARY KEY (session_id)
);

ALTER TABLE notes
  ADD COLUMN session_id int,
  ADD CONSTRAINT fk_session_note FOREIGN KEY (session_id) REFERENCES sessions(session_id);

-- app_users
INSERT INTO app_users (name)
VALUES ('Bob'); -- !!!!     fill in the blank with any username you would like

SELECT * FROM app_users;

-- speakers
INSERT INTO speakers (name, title)
VALUES ('Russell M. Nelson', 'President of the Church of Jesus Christ of Latter-day Saints'),
       ('D. Todd Christofferson', 'Elder, of the Quorum of the Twelve Apostles'),
       ('L. Whitney Clayton', 'Elder, of the Presidency of the Seventy');

SELECT * FROM speakers;

-- conferences
INSERT INTO conferences (name, month, year)
VALUES ('General Conference', 'April', 2020); -- 1

SELECT * FROM conferences;

-- sessions
INSERT INTO sessions (name)
VALUES ('Saturday Morning'),
       ('Saturday Afternoon'),
       ('Saturday Evening'),
       ('Sunday Morning'),
       ('Sunday Afternoon'); -- 5

SELECT * FROM sessions;

--notes
INSERT INTO notes (app_user_id, speaker_id, conference_id, note, session_id)
VALUES (1, 3, 1, 'The status of a home being "fine" has nothing to do with its furnishings, but everything to do with its spiritual condition.', 5),
       (1, 3, 1, E'Our home\'s spiritual condition is more important than any career.', 5), -- a varchar that contains an escaped character (\') must be preceded by an E
       (1, 2, 1, 'Sometimes it takes 20 years of close association even with an Apostle before some people choose to join the Church.', 5),
       (1, 2, 1, 'We should never lose hope for the conversion of our brothers and sisters.', 5),
       (1, 1, 1, 'New Temple to be built in Dubai', 5),
       (1, 1, 1, 'New Temple to be built in Shanghai China.', 5);

SELECT * FROM notes;
