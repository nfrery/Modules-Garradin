CREATE TABLE IF NOT EXISTS `plugin_vote_questions` (
  `id`  INTEGER PRIMARY KEY AUTOINCREMENT,
  `question`  TEXT,
  `duree` TEXT,
  `time_ouverture`  INTEGER,
  `time_fermeture`  INTEGER,
  `mode_vote` INTEGER,
  `active`  INTEGER
);
CREATE TABLE IF NOT EXISTS `plugin_vote_vq` (
  `id`  INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_id` INTEGER,
  `question_id` INTEGER,
  `reponse_id` INTEGER
);
CREATE TABLE IF NOT EXISTS `plugin_vote_reponses` (
  `id`  INTEGER PRIMARY KEY AUTOINCREMENT,
  `question_id` INTEGER,
  `reponse` TEXT
);