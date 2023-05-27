-- CREATE TABLE users
-- (id INTEGER PRIMARY KEY AUTOINCREMENT,
-- email text UNIQUE,
-- password text,
-- data text);

CREATE TABLE products
(id INTEGER PRIMARY KEY AUTOINCREMENT,
name text UNIQUE,
image text,
price integer,
desc text);






















-- DROP TABLE users;
-- DELETE FROM users;
-- UPDATE users set data = NULL;

-- DROP TABLE products;
-- DELETE FROM products;