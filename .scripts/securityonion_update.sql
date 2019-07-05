CREATE TABLE IF NOT EXISTS ip2c
(
  registry	VARCHAR(7),
  cc		VARCHAR(2),
  c_long	VARCHAR(255),
  type		VARCHAR(4),
  start_ip	VARBINARY(16) NOT NULL DEFAULT 0,
  end_ip	VARBINARY(16) NOT NULL DEFAULT 0,
  date		DATETIME,
  status	VARCHAR(25),
  INDEX registry (registry),
  INDEX cc (cc),
  INDEX c_long (c_long),
  INDEX type (type),
  INDEX start_ip (start_ip),
  INDEX end_ip (end_ip)
);  

INSERT IGNORE INTO ip2c (registry,cc,c_long,type,start_ip,end_ip,date,status)
VALUES ('RFC1918','LO','RFC1918','ipv4',INET6_ATON('10.0.0.0'),INET6_ATON('10.255.255.255'),'1996-02-01','allocated');

INSERT IGNORE INTO ip2c (registry,cc,c_long,type,start_ip,end_ip,date,status)
VALUES ('RFC1918','LO','RFC1918','ipv4',INET6_ATON('172.16.0.0'),INET6_ATON('172.31.255.255'),'1996-02-01','allocated');

INSERT IGNORE INTO ip2c (registry,cc,c_long,type,start_ip,end_ip,date,status)
VALUES ('RFC1918','LO','RFC1918','ipv4',INET6_ATON('192.168.0.0'),INET6_ATON('192.168.255.255'),'1996-02-01','allocated');

CREATE TABLE IF NOT EXISTS mappings
(
  registry       VARCHAR(7),
  cc             VARCHAR(2),
  c_long         VARCHAR(255),
  type           VARCHAR(4),
  ip             VARBINARY(16) NOT NULL DEFAULT 0,
  date           DATETIME,
  status         VARCHAR(25),
  age            TIMESTAMP,
  PRIMARY KEY (ip),
  INDEX registry (registry),
  INDEX cc (cc),
  INDEX c_long (c_long),
  INDEX age (age)
);

CREATE TABLE IF NOT EXISTS stats
(
  timestamp	DATETIME,
  type		TINYINT,
  object        INT UNSIGNED NOT NULL DEFAULT 0,
  count		INT UNSIGNED NOT NULL DEFAULT 0,
  INDEX type (type),
  INDEX object (object)
);

CREATE TABLE IF NOT EXISTS stat_types
(
  type		TINYINT,
  description   VARCHAR(255)
);

INSERT IGNORE INTO stat_types (type,description) VALUES ('1','Event Severity');
INSERT IGNORE INTO stat_types (type,description) VALUES ('2','Sensor ID');
INSERT IGNORE INTO stat_types (type,description) VALUES ('3','Source IP');
INSERT IGNORE INTO stat_types (type,description) VALUES ('4','Destination IP');
INSERT IGNORE INTO stat_types (type,description) VALUES ('5','Signature ID'); 

CREATE TABLE IF NOT EXISTS object_mappings
(
  type   VARCHAR(4),
  object VARCHAR(255),
  value  VARCHAR(255),
  hash   CHAR(32),
  INDEX type (type),
  INDEX object (object),
  PRIMARY KEY (hash)
);

CREATE TABLE IF NOT EXISTS filters
(
  type           VARCHAR(16),
  name           VARCHAR(255),
  alias		 VARCHAR(12),
  username       VARCHAR(16),
  filter         BLOB,
  notes		 VARCHAR(255) NOT NULL DEFAULT 'None.',
  global	 TINYINT(1) NOT NULL DEFAULT 0,
  age            TIMESTAMP,
  INDEX type (type),
  PRIMARY KEY (username,alias)
);

INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D20436F756E74727920436F6465','546869732069732061206275696c742d696e20726561642d6f6e6c792066696c7465722e','cc','286D7372632E6363203D20272427204F52206D6473742E6363203D2027242729');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D2044657374696E6174696F6E204950','546869732069732061206275696c742d696e20726561642d6f6e6c792066696c7465722e','dip','286473745F6970203D20494E45545F41544F4E282724272929');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D2044657374696E6174696F6E20506F7274','546869732069732061206275696c742d696e20726561642d6f6e6c792066696c7465722e','dpt','286473745F706F7274203D2027242729');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D204950','546869732069732061206275696c742d696e20726561642d6f6e6c792066696c7465722e','ip','287372635F6970203D20494E45545F41544F4E2827242729204F52206473745F6970203D20494E45545F41544F4E282724272929');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D205369676E6174757265204944','546869732069732061206275696c742d696e20726561642d6f6e6c792066696c7465722e','sid','287369676E61747572655F6964203D2027242729');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D205369676E6174757265','546869732069732061206275696c742d696e20726561642d6f6e6c792066696c7465722e','sig','287369676E6174757265204C494B45202725242527204F52207369676E6174757265204C494B4520272524252729');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D20536F75726365204950','546869732069732061206275696c742d696e20726561642d6f6e6c792066696c7465722e','sip','287372635F6970203D20494E45545F41544F4E282724272929');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D20536F7572636520506F7274','546869732069732061206275696c742d696e20726561642d6f6e6c792066696c7465722e','spt','287372635F706F7274203D2027242729');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D20536F7572636520436F756E74727920436F6465','546869732069732061206275696C742D696E20726561642D6F6E6C792066696C7465722E','scc','286D7372632E6363203D2027242729');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D2044657374696E6174696F6E20436F756E74727920436F6465','546869732069732061206275696C742D696E20726561642D6F6E6C792066696C7465722E','dcc','286D6473742E6363203D2027242729');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('filter','','1','5368656C6C202D204576656E7420537461747573','546869732069732061206275696C742D696E20726561642D6F6E6C792066696C7465722E','st','286576656e742e737461747573203d2027242729');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('url','','1','5669727573546f74616c','','VirusTotal','68747470733a2f2f7777772e7669727573746f74616c2e636f6d2f656e2f69702d616464726573732f247b7661727d2f696e666f726d6174696f6e2f0a');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('url','','1','446f6d61696e546f6f6c73','','DomainTools','687474703a2f2f77686f69732e646f6d61696e746f6f6c732e636f6d2f247b7661727d0a');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('url','','1','43656e7472616c4f7073','','CentralOps','687474703a2f2f63656e7472616c6f70732e6e65742f636f2f446f6d61696e446f73736965722e617370783f616464723d247b7661727d0a');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('url','','1','476f6f676c65','','Google','68747470733a2f2f7777772e676f6f676c652e636f6d2f7365617263683f713d247b7661727d0a');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('url','','1','42696e67','','Bing','68747470733a2f2f7777772e62696e672e636f6d2f7365617263683f713d6970253341247b7661727d0a');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('url','','1','416c657861','','Alexa','687474703a2f2f7777772e616c6578612e636f6d2f73697465696e666f2f247b7661727d0a');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('url','','1','5361666542726f7773696e67','','SafeBrowsing','68747470733a2f2f7777772e676f6f676c652e636f6d2f7361666562726f7773696e672f646961676e6f737469633f736974653d247b7661727d0a');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('url','','1','5a657573547261636b6572','','ZeusTracker','68747470733a2f2f7a657573747261636b65722e61627573652e63682f6d6f6e69746f722e7068703f7365617263683d247b7661727d0a');
INSERT IGNORE INTO filters (type,username,global,name,notes,alias,filter)
VALUES ('url','','1','4d616c77617265446f6d61696e4c697374','','MDL','687474703a2f2f7777772e6d616c77617265646f6d61696e6c6973742e636f6d2f6d646c2e7068703f7365617263683d247b7661727d0a');


GRANT INSERT,UPDATE,DELETE ON filters TO 'readonly'@'localhost';

GRANT DELETE on autocat to 'readonly'@'localhost';

GRANT DELETE on history to 'readonly'@'localhost';

GRANT UPDATE on user_info TO 'readonly'@'localhost';

GRANT INSERT,UPDATE ON object_mappings TO 'readonly'@'localhost';
