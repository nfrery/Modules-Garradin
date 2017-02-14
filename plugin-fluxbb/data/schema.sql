CREATE TABLE IF NOT EXISTS `plugin_fluxbb` (
  `garradin_id` INTEGER NOT NULL UNIQUE,
  `fluxbb_id` INTEGER UNIQUE,
  `fluxbb_mail` TEXT UNIQUE,
  `fluxbb_username` TEXT UNIQUE,
  `manuel` INTEGER NOT NULL
)