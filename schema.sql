CREATE DATABASE yeticave_db
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE yeticave_db;

CREATE TABLE categories
(
    id             INT(12) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_title CHAR(64)         NOT NULL UNIQUE,
    symbolic_code  CHAR(64)         NOT NULL UNIQUE
);

CREATE TABLE lots
(
    id              INT(12) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    date_creation   TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    lot_title       CHAR(64)         NOT NULL,
    lot_description CHAR(128)        NOT NULL,
    lot_image       CHAR(128)        NOT NULL,
    starting_price  INT(12) UNSIGNED NOT NULL,
    date_finish     TIMESTAMP        NOT NULL,
    bet_step        INT(12) UNSIGNED NOT NULL,
    author_id       INT(12) UNSIGNED NOT NULL,
    winner_id       INT(12) UNSIGNED,
    category_id     INT(12) UNSIGNED NOT NULL,
    FULLTEXT INDEX search (lot_title, lot_description)
);

CREATE TABLE bets
(
    id         INT(12) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    date_bet   TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    bet_amouth INT(12) UNSIGNED NOT NULL,
    user_id    INT(12) UNSIGNED NOT NULL,
    lot_id     INT(12) UNSIGNED NOT NULL
);

CREATE TABLE users
(
    id                INT(12) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    date_registration TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    email             CHAR(24)         NOT NULL UNIQUE,
    user_name         CHAR(24)         NOT NULL,
    password          CHAR(64) BINARY  NOT NULL,
    avatar            CHAR(24),
    contacts          TINYTEXT         NOT NULL
)