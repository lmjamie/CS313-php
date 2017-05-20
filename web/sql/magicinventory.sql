CREATE DATABASE magiccardinventory;
\c magiccardinventory

CREATE TABLE collectors
(
  id SERIAL PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password CHAR(60) NOT NULL,
  fname VARCHAR(100) NOT NULL,
  lname VARCHAR(100) NOT NULL
);
\d collectors

CREATE TABLE conditions
(
  id SERIAL PRIMARY KEY,
  code VARCHAR(4) NOT NULL UNIQUE
);
\d conditions

CREATE TABLE rarities(
  id SERIAL PRIMARY KEY,
  type VARCHAR(25) UNIQUE
);
\d rarities

CREATE TABLE sets(
  id SERIAL PRIMARY KEY,
  code VARCHAR(10) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL UNIQUE
);
\d sets

CREATE TABLE types(
  id SERIAL PRIMARY KEY,
  name VARCHAR(25) NOT NULL UNIQUE
);
\d types

CREATE TABLE supertypes(
  id SERIAL PRIMARY KEY,
  name VARCHAR(25) NOT NULL UNIQUE
);
\d supertypes

CREATE TABLE subtypes(
  id SERIAL PRIMARY KEY,
  name VARCHAR(25) NOT NULL UNIQUE
);
\d subtypes

CREATE TABLE colors(
  id SERIAL PRIMARY KEY,
  name VARCHAR(25) NOT NULL UNIQUE
);

CREATE TABLE inventories(
  id SERIAL PRIMARY KEY,
  totalcards INT NOT NULL,
  distinctcards INT NOT NULL,
  collectorid INT NOT NULL REFERENCES collectors(id)
);
\d inventories

CREATE TABLE wantlists(
  id SERIAL PRIMARY KEY,
  totalwanted INT NOT NULL,
  distinctwanted INT NOT NULL,
  collectorid INT NOT NULL REFERENCES collectors(id)
);
\d wantlists

CREATE TABLE tradelists(
  id SERIAL PRIMARY KEY,
  totaltrade INT NOT NULL,
  distincttrade INT NOT NULL,
  inventoryid INT NOT NULL REFERENCES inventories(id)
);
\d tradelists

CREATE TABLE cards(
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  cmc INT NOT NULL,
  manacost VARCHAR(100),
  colorid1 INT NOT NULL REFERENCES colors(id),
  colorid2 INT REFERENCES colors(id),
  colorid3 INT REFERENCES colors(id),
  colorid4 INT REFERENCES colors(id),
  colorid5 INT REFERENCES colors(id),
  typeid1 INT NOT NULL REFERENCES types(id),
  typeid2 INT REFERENCES types(id),
  supertypeid1 INT REFERENCES supertypes(id),
  supertypeid2 INT REFERENCES supertypes(id),
  subtypeid1 INT REFERENCES subtypes(id),
  subtypeid2 INT REFERENCES subtypes(id),
  subtypeid3 INT REFERENCES subtypes(id),
  subtypeid4 INT REFERENCES subtypes(id),
  rules TEXT,
  power VARCHAR(10),
  toughness VARCHAR(10),
  loyalty INT
);
\d cards

CREATE TABLE specificcards(
  id SERIAL PRIMARY KEY,
  flavor TEXT,
  imageurl VARCHAR(256) NOT NULL UNIQUE,
  rarityid INT NOT NULL REFERENCES rarities(id),
  numinset VARCHAR(10) NOT NULL,
  setid INT NOT NULL REFERENCES sets(id),
  cardid INT NOT NULL REFERENCES cards(id)
);
\d specificcards

CREATE TABLE inventorycontents(
  id SERIAL PRIMARY KEY,
  qty INT NOT NULL,
  foil BOOL NOT NULL,
  modified TIMESTAMP NOT NULL,
  conditionid INT NOT NULL REFERENCES conditions(id),
  specificcardid INT NOT NULL REFERENCES specificcards(id),
  inventoryid INT NOT NULL REFERENCES inventories(id)
);
\d inventorycontents

CREATE TABLE wantcontents(
  id SERIAL PRIMARY KEY,
  qty INT NOT NULL,
  foil BOOL NOT NULL,
  modified TIMESTAMP NOT NULL,
  conditionid INT NOT NULL REFERENCES conditions(id),
  specificcardid INT NOT NULL REFERENCES specificcards(id),
  wantlistid INT NOT NULL REFERENCES wantlists(id)
);
\d wantcontents

CREATE TABLE tradecontents(
  id SERIAL PRIMARY KEY,
  qty INT NOT NULL,
  modified TIMESTAMP NOT NULL,
  inventorycontentid INT NOT NULL REFERENCES inventorycontents(id),
  tradelistid INT NOT NULL REFERENCES tradelists(id)
);
\d tradecontents

INSERT INTO collectors(username, password, fname, lname)
VALUES
('landon1', '$2y$10$B.Wqg0X7kBeTHCWJmx9qm.uW6lenNWJ4DmJ9eMxAziV4G6cvUVemy', 'Landon', 'Jamieson'),
('test', '$2y$10$hahYKaiOiehFesD0Qsv7iu/ESQw.RHVa42gABIoB9rpwgq5AROyJi', 'Tester', 'McTesterson');

INSERT INTO inventories(totalcards, distinctcards, collectorid)
VALUES
(0, 0, 1),
(0, 0, 2);

INSERT INTO tradelists(totaltrade, distincttrade, inventoryid)
VALUES
(0, 0, 1),
(0, 0, 2);

INSERT INTO wantlists(totalwanted, distinctwanted, collectorid)
VALUES
(0, 0, 1),
(0, 0, 2);

INSERT INTO specificcards(flavor, imageurl, rarityid, numinset, setid, cardid)
VALUES ()
