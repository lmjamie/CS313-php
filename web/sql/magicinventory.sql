CREATE DATABASE magiccardinventory;
\c magiccardinventory

CREATE TABLE collectors
(
  id SERIAL PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(50) NOT NULL,
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
  name VARCHAR(100) NOT NULL,
  cmc INT NOT NULL,
  manacost VARCHAR(100),
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
  imageurl VARCHAR(256) NOT NULL,
  rarityid INT NOT NULL REFERENCES rarities(id),
  numinset INT NOT NULL,
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
