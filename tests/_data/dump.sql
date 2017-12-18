PRAGMA foreign_keys = on;
BEGIN TRANSACTION;

-- Table: email_template
DROP TABLE IF EXISTS email_template;

CREATE TABLE email_template(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  key STRING NOT NULL
);

-- Table: email_tamplate_translation
DROP TABLE IF EXISTS email_template_translation;

CREATE TABLE email_template_translation(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  templateId INTEGER NOT NULL,
  language STRING(16) NOT NULL,
  subject STRING NOT NULL,
  body TEXT NOT NULL,
  hint STRING(500)
);

-- Table: demo
DROP TABLE IF EXISTS demo;

CREATE TABLE demo(
  id INTEGER PRIMARY KEY AUTOINCREMENT
);

COMMIT TRANSACTION;
PRAGMA foreign_keys = on;