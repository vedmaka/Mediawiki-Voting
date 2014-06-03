-- Stores voting values comments --

CREATE TABLE IF NOT EXISTS /*_*/wv_voting_comments (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  page_id INT(11) NOT NULL,
  group_id INT(11) NOT NULL,
  hash VARCHAR(13) DEFAULT NULL,
  comment VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) /*$wgDBTableOptions*/;