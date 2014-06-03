-- Stores voting widget types values --

CREATE TABLE IF NOT EXISTS /*_*/wv_voting_types_values (
  id INT(11) NOT NULL AUTO_INCREMENT,
  type_id INT(11) NOT NULL,
  title VARCHAR(255) DEFAULT NULL,
  value INT(11) DEFAULT NULL,
  PRIMARY KEY (id)
) /*$wgDBTableOptions*/;