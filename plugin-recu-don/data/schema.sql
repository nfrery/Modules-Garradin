CREATE TABLE IF NOT EXISTS `plugin_recudon` (
  `id`  INTEGER DEFAULT 1,
  `membre_id` INTEGER,
  `nom` TEXT NOT NULL,
  `prenom`  TEXT NOT NULL,
  `adresse` TEXT NOT NULL,
  `codepostal`  TEXT NOT NULL,
  `ville` TEXT NOT NULL,
  `montant` TEXT NOT NULL,
  `mode_paiement` INTEGER NOT NULL,
  `date`  TEXT NOT NULL,
  `gen_ordre` TEXT NOT NULL UNIQUE,
  `gen_date`  TEXT NOT NULL,
  `gen_signature` TEXT NOT NULL,
  PRIMARY KEY(id)
);