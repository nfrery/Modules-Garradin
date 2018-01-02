
CREATE TABLE IF NOT EXISTS `plugin_benevolat_enregistrement` (
  `id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
  `id_compta`	INTEGER UNIQUE,
  `heures`	INTEGER,
  `id_categorie`	INTEGER,
  `id_benevole`	INTEGER,
  `nom_benevole`	TEXT,
  `description`	TEXT,
  `date`	TEXT DEFAULT CURRENT_DATE,
  `plage`	INTEGER DEFAULT 0,
  `date_fin`	TEXT,
  FOREIGN KEY(`id_compta`) REFERENCES `compta_journal`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY(`id_categorie`) REFERENCES `plugin_benevolat_categorie`(`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `plugin_benevolat_categorie` (
  `id`           INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
  `nom`          TEXT NOT NULL,
  `taux_horaire` REAL NOT NULL,
  `description`  TEXT,
  `activer`      INTEGER             DEFAULT 1
);
