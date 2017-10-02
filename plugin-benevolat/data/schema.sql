
CREATE TABLE IF NOT EXISTS `plugin_benevolat_enregistrement` (
  `id`              INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
  `id_membre_ajout` INTEGER NOT NULL,
  `id_compta`       INTEGER UNIQUE,
  `id_categorie`    INTEGER NOT NULL,
  `id_exercice`    INTEGER NOT NULL,
  `id_membre`       INTEGER,
  `nom_prenom`      TEXT,
  `heures`          INTEGER NOT NULL,
  `description`     TEXT    NOT NULL,
  `date`            TEXT                DEFAULT CURRENT_DATE,
  `date_fin`        TEXT
);

CREATE TABLE IF NOT EXISTS `plugin_benevolat_categorie` (
  `id`           INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
  `nom`          TEXT NOT NULL,
  `taux_horaire` REAL NOT NULL,
  `description`  TEXT,
  `activer`      INTEGER             DEFAULT 1
);