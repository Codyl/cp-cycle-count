CREATE TABLE scriptures(
    id serial,
    book varchar,
    chapter int,
    verse int,
    content text
);
/*
Doctrine and Covenants 88:49

Doctrine and Covenants 93:28

Mosiah 16:9
*/
INSERT INTO scriptures (book, chapter, verse, content)
VALUES ('John', 1, 5, 'And the light shineth in bdarkness; and the darkness ccomprehended it not.');

INSERT INTO scriptures (book, chapter, verse, content)
VALUES ('Doctrine and Covenants', 88, 49, 'And the light shineth in darkness; and the darkness ccomprehended it not.');

INSERT INTO scriptures (book, chapter, verse, content)
VALUES ('Doctrine and Covenants', 93, 28, 'And the light shineth in darkness; and the darkness ccomprehended it not.');

INSERT INTO scriptures (book, chapter, verse, content)
VALUES ('Mosiah', 16, 9, 'And the light shineth in bdarkness; and the darkness ccomprehended it not.');