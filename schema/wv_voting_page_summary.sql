-- Stores voting values --

CREATE TABLE IF NOT EXISTS /*_*/wv_voting_page_summary (
  id INT(11) NOT NULL AUTO_INCREMENT,
  page_id INT(11) NOT NULL,
  group_id INT(11) NOT NULL,
  rating_id INT(11) NOT NULL,
  rule_key VARCHAR(255) DEFAULT NULL,
  summary INT(11) NOT NULL,
  title VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) /*$wgDBTableOptions*/;