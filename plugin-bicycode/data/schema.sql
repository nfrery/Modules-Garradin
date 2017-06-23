
CREATE TABLE IF NOT EXISTS `plugin_bicycode` (
  `id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
  `nom`	TEXT,
  `prenom`	TEXT,
  `adresse`	TEXT,
  `code_postal`	TEXT,
  `ville`	TEXT,
  `numero_piece_identite`	TEXT,
  `date_marquage`	TEXT,
  `telephone`	TEXT,
  `numero_bicycode`	TEXT
);