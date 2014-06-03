-- Stores voting ratings --

CREATE TABLE IF NOT EXISTS /*_*/wv_voting_ratings (
  id INT(11) NOT NULL AUTO_INCREMENT,
  group_id INT(11) NOT NULL,
  name VARCHAR(255) DEFAULT NULL,
  type_id INT(11) NOT NULL,
  description VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) /*$wgDBTableOptions*/;