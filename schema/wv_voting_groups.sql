-- Stores voting groups --

CREATE TABLE IF NOT EXISTS /*_*/wv_voting_groups (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) DEFAULT NULL,
  category VARCHAR(255) DEFAULT NULL,
  active INT(1) NOT NULL DEFAULT 0,
  result_message VARCHAR(255) DEFAULT NULL,
  title VARCHAR(255) DEFAULT NULL,
  description VARCHAR(255) DEFAULT NULL,
  rule_id INT(11) DEFAULT NULL,
  PRIMARY KEY (id)
) /*$wgDBTableOptions*/;