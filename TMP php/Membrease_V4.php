<?php

$host = '127.0.0.1';
$username = 'root';
$password = 'Asia09159128448!';
$database = 'membrease_v1';

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS membrease_v1";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

$conn->select_db($database);

$conn->query("SET NAMES utf8");

$conn->query("SET FOREIGN_KEY_CHECKS = 0");

$conn->query("DROP TABLE IF EXISTS `registration`");
$sql = "
CREATE TABLE `registration` (
  `PIN` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `memberName` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `sex` char(1) NOT NULL,
  `mobileNo` varchar(15) NOT NULL,
  `emailAdd` varchar(100) NOT NULL,
  PRIMARY KEY (`PIN`),
  CONSTRAINT `chk_password_format` CHECK (
    CHAR_LENGTH(password) BETWEEN 8 AND 32
    AND password REGEXP '[0-9]'
    AND password REGEXP '[A-Z]'
    AND password REGEXP '[a-z]'
    AND password REGEXP '[^a-zA-Z0-9]'
  ),
  CONSTRAINT `chk_registration_sex` CHECK (
    sex IN ('M','F')
  )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";
if ($conn->query($sql) === TRUE) {
    echo "Table registration created successfully\n";
} else {
    echo "Error creating table registration: " . $conn->error . "\n";
}

$conn->query("DROP TABLE IF EXISTS `memberdetails`");
$sql = "
CREATE TABLE `memberdetails` (
  `PIN` varchar(20) NOT NULL,
  `pkp` varchar(60) DEFAULT NULL,
  `memberName` varchar(100) NOT NULL,
  `memberMiddleName` CHAR(3) DEFAULT NULL,
  `memberMononym` CHAR(3) DEFAULT NULL,
  `motherMaidenName` varchar(100) NOT NULL,
  `motherMaidenMiddleName` CHAR(3) NOT NULL,
  `mmaidenMononym` CHAR(3) NOT NULL,
  `spouseID` varchar(10) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `sex` char(1) NOT NULL,
  `civilStatus` char(2) NOT NULL,
  `citizenship` varchar(50) NOT NULL,
  `philsysID` varchar(20) DEFAULT NULL,
  `tinID` varchar(15) DEFAULT NULL,
  `permaHomeAddress` varchar(250) NOT NULL,
  `mailingAddress` varchar(250) DEFAULT NULL,
  `homePhoneNo` varchar(15) NOT NULL,
  `mobileNo` varchar(15) NOT NULL,
  `directNo` varchar(15) DEFAULT NULL,
  `emailAdd` varchar(100) NOT NULL,
  `contributorType` varchar(50) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `monthlyIncome` decimal(10,2) NOT NULL,
  `incomeProof` CHAR(4) DEFAULT NULL,
  PRIMARY KEY (`PIN`),
  KEY `spouseID` (`spouseID`),
  CONSTRAINT `chk_civil_status` CHECK ((`civilStatus` IN ('S','M','W','A','LS'))),
  CONSTRAINT `chk_contributorType` CHECK ((`contributorType` IN ('Direct','Indirect'))),
  CONSTRAINT `chk_sex` CHECK ((`sex` IN ('M','F'))),
  CONSTRAINT `chk_income_proof` CHECK ((`incomeProof` IN ('ITR','COE','PA','NONE')))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";
if ($conn->query($sql) === TRUE) {
    echo "Table memberdetails created successfully\n";
} else {
    echo "Error creating table memberdetails: " . $conn->error . "\n";
}

$conn->query("DROP TABLE IF EXISTS `spousedetails`");
$sql = "
CREATE TABLE `spousedetails` (
  `spouseID` varchar(10) NOT NULL,
  `spouseName` varchar(100) NOT NULL,
  `sMiddleName` CHAR(3) DEFAULT NULL,
  `sMononym` CHAR(3) DEFAULT NULL,
  PRIMARY KEY (`spouseID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";
if ($conn->query($sql) === TRUE) {
    echo "Table spousedetails created successfully\n";
} else {
    echo "Error creating table spousedetails: " . $conn->error . "\n";
}

$conn->query("DROP TABLE IF EXISTS `dependents`");
$sql = "
CREATE TABLE `dependents` (
  `PIN` varchar(20) NOT NULL,
  `depID` varchar(10) NOT NULL,
  `depName` varchar(100) NOT NULL,
  `depMiddleName` CHAR(3) DEFAULT NULL,
  `depMononym` CHAR(3) DEFAULT NULL,
  `depPWD` CHAR(3) DEFAULT NULL,
  `relationship` varchar(50) NOT NULL,
  `depBirthdate` date NOT NULL,
  `depCitizenship` varchar(50) NOT NULL,
  PRIMARY KEY (`PIN`,`depID`),
  CONSTRAINT `fk_dependents_member` FOREIGN KEY (`PIN`) REFERENCES `memberdetails` (`PIN`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";
if ($conn->query($sql) === TRUE) {
    echo "Table dependents created successfully\n";
} else {
    echo "Error creating table dependents: " . $conn->error . "\n";
}

$sql = "
INSERT INTO `registration` VALUES 
('2025-0515-1529','BellaBelen#4','Mhicaela Belen','2002-06-29','F','09852147963','bellabelen4@yahoo.com'),
('2025-0515-1546','Sy_eddie0108','Eduardo Sy','1950-01-08','M','09963852741','eddiesy@gmail.com'),
('2025-0518-1595','jheSantos10*','Jerome Santos','1978-09-09','M','09081234567','jeromesantos98@gmail.com'),
('2025-0520-1531','alvinM-0520','Alvin Manalo','1989-03-14','M','09171122334','alvinmanalo.ph@gmail.com'),
('2025-0520-1557','DC_Rowena123','Rowena Dela Cruz','1994-12-05','F','09239575325','rowenadc@yahoo.com'),
('2025-0521-0649','Liza@Tan123','Liza Tan','1994-03-18','F','09178234567','lizatan94@gmail.com'),
('2025-0521-0956','P@bloRamos90','Pablo Ramos','1988-11-02','M','09952346789','pramos88@yahoo.com'),
('2025-0522-1859','Emilio_2024','Emilio Santiago','1977-07-23','M','09061237890','emilios1977@gmail.com'),
('2025-0523-0912','Tina_Basa24!','Kristina Basa','1995-02-24','F','09178881234','kristinabasa24@gmail.com'),
('2025-0523-0935','RR_Mendoza78$','Roberto Mendoza','1978-11-30','M','09213456789','rrmendoza78@yahoo.com'),
('2025-0524-0844','CathyTan_99','Catherine Tan','1999-06-12','F','09171239876','cathytan99@gmail.com'),
('2025-0524-0917','JMcruz2020*','Juan Miguel Cruz','1986-04-01','M','09987654321','jmcruz86@gmail.com'),
('2025-0525-1001','allyMarquez77!','Allysa Marquez','1993-08-22','F','09051112233','allymarquez77@gmail.com'),
('2025-0526-0810','Garlitos_61$','Carlos Enriquez','1961-10-19','M','09234445678','carlos.enriquez61@gmail.com'),
('2025-0526-0902','LhenSoriano08#','Evelyn Soriano','1980-03-08','F','09179998877','evelynsoriano08@yahoo.com')";
if ($conn->query($sql) === TRUE) {
    echo "Data inserted into registration successfully\n";
} else {
    echo "Error inserting into registration: " . $conn->error . "\n";
}

$sql = "
INSERT INTO `spousedetails` VALUES 
('S001','Merlina Sy','No','No'),
('S002','Antonio Dela Cruz','Yes','No'),
('S003','Daniel Tan','No','No'),
('S004','Arlene Santiago','Yes','No'),
('S005','Raul Mendoza','No','No'),
('S006','Marco Enriquez','Yes','No'),
('S007','Daniel Soriano','No','No')";
if ($conn->query($sql) === TRUE) {
    echo "Data inserted into spousedetails successfully\n";
} else {
    echo "Error inserting into spousedetails: " . $conn->error . "\n";
}

$sql = "
INSERT INTO `memberdetails` VALUES 
('2025-0515-1529','Quezon City Health Office','Mhicaela Belen','No','No','Angelica','No','Yes',NULL,'2002-06-29','Quezon City','F','S','Filipino',NULL,NULL,'135 Matalino St., Quezon City',NULL,'(02) 8123-4567','09852147963','(045) 961-2345','bellabelen4@yahoo.com','Direct','Volleyball Player',542000.00,'PA'),
('2025-0515-1546','Antipolo City Health Center','Eduardo Sy','No','No','Lin Aang','No','No','S001','1950-01-08','Beijing, China','M','M','Dual Citizen','4376-8820-1395-2207','298-735-649-822','B1 L15 Nazareth Ave., Antipolo City',NULL,'(02) 1234-5678','09963852741','(02) 8345-6789','eddiesy@gmail.com','Direct','Family Driver',36000.00,'COE'),
('2025-0518-1595','Taguig City Health Center','Jerome Santos','No','No','Isabel Luna','No','No',NULL,'1978-09-09','Taguig City','M','W','Filipino','5902-7351-6849-1763','740-119-385-406','28 Daan Hari St., Taguig City',NULL,'(02) 8432-8765','09081234567',NULL,'jeromesantos98@gmail.com','Indirect','Tricycle Driver',15000.00,'PA'),
('2025-0520-1531','Pasig City Medical Center','Alvin Manalo','Yes','No','Cynthia Torres','No','No',NULL,'1989-03-14','Pasig City','M','S','Filipino','8251-4927-1048-3051','872-903-114-327','10 St. Joseph St., Pasig City',NULL,'(02) 8567-1222','09171122334',NULL,'alvinmanalo.ph@gmail.com','Indirect','Construction Worker',22000.00,'PA'),
('2025-0520-1557','Cebu Provincial Hospital','Rowena Dela Cruz','No','No','Maria Lozano','No','No','S002','1994-12-05','Cebu City','F','M','Filipino','6582-2345-6789-0012',NULL,'Lot 7 Block 3, Lahug, Cebu City','PO Box 156 Cebu','(032) 4567-7890','09239575325',NULL,'rowenadc@yahoo.com','Direct','Nurse',48000.00,'COE'),
('2025-0521-0649','Pasig City Health Office','Liza Tan','No','No','Maria Dela Cruz','No','No','S003','1994-03-18','Pasig City','F','M','Filipino','6123-7845-9261-4401','208-356-790-144','11 F. Manalo St., Pasig',NULL,'(02) 8883-7612','09178234567','(02) 8213-4876','lizatan94@gmail.com','Direct','Public School Teacher',43500.00,'COE'),
('2025-0521-0956','Makati Medical Center','Pablo Ramos','Yes','No','Jasmin Enriquez','No','No',NULL,'1988-11-02','Makati City','M','S','Filipino','9874-3398-1125-6903','123-765-432-019','Blk 10 Lot 7 Makati Hills, Makati',NULL,'(02) 8876-4321','09952346789','(02) 8312-4456','pramos88@yahoo.com','Direct','Software Engineer',94500.00,'ITR'),
('2025-0522-1859','Taguig Community Clinic','Emilio Santiago','No','No','Norma Reyes','Yes','No','S004','1977-07-23','Taguig City','M','M','Filipino','8901-5678-4321-0021','564-982-110-883','8 JP Rizal Ext., Taguig',NULL,'(02) 8672-9087','09061237890','(02) 8711-2345','emilios1977@gmail.com','Indirect','Tricycle Driver',15500.00,'PA'),
('2025-0523-0912','Manila Health Office','Kristina Basa','No','No','Elena Rivera','No','No',NULL,'1995-02-24','Manila','F','S','Filipino','7823-4567-9823-4421','203-456-789-111','24 St. Anthony St., Manila',NULL,'(02) 8654-9876','09178881234',NULL,'kristinabasa24@gmail.com','Indirect','Cashier',18000.00,'PA'),
('2025-0523-0935','Caloocan City Health Office','Roberto Mendoza','No','No','Lucia Garcia','No','No','S005','1978-11-30','Caloocan City','M','M','Filipino','5193-9871-6712-5511','903-234-567-891','Unit 4 Block 5 Camarin, Caloocan',NULL,'(02) 8234-5643','09213456789',NULL,'rrmendoza78@yahoo.com','Direct','Security Guard',19500.00,'COE'),
('2025-0524-0844','Quezon City Women’s Clinic','Catherine Tan','No','No','Fely Ong','No','No',NULL,'1999-06-12','Quezon City','F','S','Filipino','1845-2390-8976-5432','456-987-321-009','B4 L3 Mariposa St., QC',NULL,'(02) 8412-3345','09171239876',NULL,'cathytan99@gmail.com','Indirect','Pharmacist',25500.00,'COE'),
('2025-0524-0917','Taguig City Medical Center','Juan Miguel Cruz','No','No','Andrea Torres','No','No',NULL,'1986-04-01','Taguig City','M','W','Filipino','9832-1033-9002-1123','782-344-123-654','10 JP Laurel St., Taguig',NULL,'(02) 8567-7654','09987654321',NULL,'jmcruz86@gmail.com','Indirect','Maintenance Supervisor',26800.00,'PA'),
('2025-0525-1001','Pasay City Clinic','Allysa Marquez','No','No','Gina Llamas','No','No',NULL,'1993-08-22','Pasay City','F','S','Filipino','3287-6574-1088-2001','341-255-789-004','Margarita Heights, Pasay',NULL,'(02) 8677-2323','09051112233',NULL,'allymarquez77@gmail.com','Direct','Call Center Agent',30500.00,'COE'),
('2025-0526-0810','Mandaluyong General Hospital','Carlos Enriquez','No','No','Diana Manuel','No','No','S006','1961-10-19','Mandaluyong City','M','M','Filipino','4123-5556-7889-3411','123-888-456-900','9 Kalayaan St., Mandaluyong',NULL,'(02) 8999-3321','09234445678',NULL,'carlos.enriquez61@gmail.com','Direct','Retired Military',37000.00,'NONE'),
('2025-0526-0902','Navotas City Clinic','Evelyn Soriano','No','No','Conchita Lopez','No','No','S007','1980-03-08','Navotas City','F','M','Filipino','7851-9034-1182-2040','667-333-102-541','Blk 2 Lot 18, Navotas City',NULL,'(02) 8321-9901','09179998877',NULL,'evelynsoriano08@yahoo.com','Indirect','Small Business Owner',48000.00,'ITR')";
if ($conn->query($sql) === TRUE) {
    echo "Data inserted into memberdetails successfully\n";
} else {
    echo "Error inserting into memberdetails: " . $conn->error . "\n";
}

$sql = "
INSERT INTO `dependents` VALUES 
('2025-0515-1529','D001','Bubay Belen','No','No','No','Sister','2004-08-06','Filipino'),
('2025-0515-1546','D002','Marie Amity Sy','No','No','No','Daughter','1988-11-12','Filipino'),
('2025-0515-1546','D003','Jan Vier Sy','No','No','No','Son','1992-07-15','Filipino'),
('2025-0518-1595','D007','Luzviminda Santos','No','No','Yes','Mother','1952-03-31','Filipino'),
('2025-0520-1531','D004','Gino Manalo','No','No','No','Brother','2001-05-30','Filipino'),
('2025-0520-1557','D005','Charles Dela Cruz','No','No','No','Son','2017-10-12','Filipino'),
('2025-0520-1557','D006','Lewis Dela Cruz','No','No','Yes','Son','2020-01-28','Filipino'),
('2025-0521-0649','D008','Lian Tan','No','No','No','Daughter','2012-05-14','Filipino'),
('2025-0521-0649','D009','Miguel Tan','No','No','No','Son','2015-09-11','Filipino'),
('2025-0521-0956','D010','Marco Pablo Ramos','No','No','No','Nephew','2016-08-22','Filipino'),
('2025-0521-0956','D011','Cecilia Ramos','No','No','Yes','Mother','1961-04-01','Filipino'),
('2025-0522-1859','D012','Eric Santiago','No','No','No','Son','2005-03-19','Filipino'),
('2025-0522-1859','D013','Roselyn Santiago','No','No','No','Daughter','2010-12-30','Filipino'),
('2025-0522-1859','D014','Jomarie Reyes','No','No','Yes','Step-son','2008-06-25','Filipino'),
('2025-0523-0912','D015','Jamie Basa','No','No','No','Daughter','2015-09-12','Filipino'),
('2025-0523-0912','D016','Lance Basa','No','No','Yes','Son','2018-02-08','Filipino'),
('2025-0523-0935','D017','Rey Mendoza','No','No','No','Son','2010-03-15','Filipino'),
('2025-0523-0935','D018','Alexa Mendoza','No','No','No','Daughter','2013-07-30','Filipino'),
('2025-0523-0935','D019','Jude Mendoza','No','No','Yes','Son','2016-11-02','Filipino'),
('2025-0524-0844','D020','Mia Tan','No','No','No','Daughter','2020-01-18','Filipino'),
('2025-0524-0844','D021','Enzo Tan','No','No','No','Son','2022-06-21','Filipino'),
('2025-0524-0917','D022','Juanito Cruz','No','No','No','Son','2012-10-10','Filipino'),
('2025-0524-0917','D023','Sofia Cruz','No','No','No','Daughter','2015-08-25','Filipino'),
('2025-0525-1001','D024','Marco Marquez','No','No','No','Son','2017-03-11','Filipino'),
('2025-0525-1001','D025','Celine Marquez','No','No','Yes','Daughter','2021-12-19','Filipino'),
('2025-0525-1001','D026','Joaquin Marquez','No','No','No','Son','2023-04-07','Filipino'),
('2025-0526-0810','D027','Miriam Enriquez','No','No','Yes','Daughter','1995-05-12','Filipino'),
('2025-0526-0902','D028','Elijah Soriano','No','No','No','Son','2010-09-30','Filipino'),
('2025-0526-0902','D029','Rachel Soriano','No','No','No','Daughter','2014-06-30','Filipino')";
if ($conn->query($sql) === TRUE) {
    echo "Data inserted into dependents successfully\n";
} else {
    echo "Error inserting into dependents: " . $conn->error . "\n";
}

$conn->query("SET FOREIGN_KEY_CHECKS = 1");
$conn->close();
?>