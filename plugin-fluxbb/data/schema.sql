CREATE TABLE IF NOT EXISTS `plugin_fluxbb` (
  `id_garradin` INTEGER NOT NULL UNIQUE,
  `id_fluxbb` INTEGER UNIQUE,
  `fluxbb_mail` TEXT UNIQUE,
  `fluxbb_username` TEXT UNIQUE
)