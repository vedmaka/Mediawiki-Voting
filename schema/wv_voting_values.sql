-- Stores voting values --

CREATE TABLE IF NOT EXISTS /*_*/wv_voting_values (
  id INT(11) NOT NULL AUTO_INCREMENT,
  rating_id INT(11) NOT NULL,
  value INT(11) NOT NULL,
  user_id INT(11) NOT NULL,
  vote_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  page_id INT(11) NOT NULL,
  revision_id INT(11) NOT NULL,
  group_id INT(11) NOT NULL,
  value_id INT(11) NOT NULL,
  hash VARCHAR(13) DEFAULT NULL,
  PRIMARY KEY (id)
) /*$wgDBTableOptions*/;