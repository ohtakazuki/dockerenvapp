create table books
(
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  title VARCHAR(100),
  insert_timestamp DATETIME DEFAULT NULL
);
