SELECT * FROM fce.interface;
LOAD DATA INFILE 'C:\\Users\\Maestro\\Documents\\School Stuff\\Senior\\Fall 2014\\SEN 405\\Extra-Credit\\FCE\\Extraction\\fCE Sample Spreadsheet (1).csv'
INTO TABLE interface
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';
delete from interface;