-- Stores voting values --

CREATE TABLE IF NOT EXISTS /*_*/wv_voting_visible_rules (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) DEFAULT NULL,
  value INT(11) NOT NULL,
  PRIMARY KEY (id)
) /*$wgDBTableOptions*/;