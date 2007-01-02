#
# Table structure for table 'tx_ccf_relations'
# 
#
CREATE TABLE tx_ccf_relations (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	tx_ccf_relations int(11) DEFAULT '0' NOT NULL
);