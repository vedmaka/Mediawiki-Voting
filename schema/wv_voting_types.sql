-- Stores voting widget types --

CREATE TABLE IF NOT EXISTS /*_*/wv_voting_types (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) DEFAULT NULL,
  control_id INT(11) NOT NULL DEFAULT 0,
  view_format INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) /*$wgDBTableOptions*/;