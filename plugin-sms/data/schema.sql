
CREATE TABLE IF NOT EXISTS `rappels_sms` (
  `id`	INTEGER NOT NULL PRIMARY KEY,
  `id_cotisation`	INTEGER NOT NULL,
  `delai`	TEXT NOT NULL,
  `texte`	TEXT NOT NULL
);