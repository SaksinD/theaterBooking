CREATE DATABASE IF NOT EXISTS `movie_theater`;

USE `movie_theater`;

-- Table structure for table `movieImages`
CREATE TABLE IF NOT EXISTS `movieImages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `poster` LONGBLOB NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `movies`
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_name` varchar(255) NOT NULL,
  `date1` DATE,
  `date2` DATE,
  `date3` DATE,
  `time1` ENUM('no', '6.30 pm') DEFAULT 'no',
  `time2` ENUM('no', '9.30 pm') DEFAULT 'no',
  `time3` ENUM('no', '10.30 am') DEFAULT 'no',
  `time4` ENUM('no', '2.30 am') DEFAULT 'no',
  `Batti Cinima` ENUM('yes', 'no') NOT NULL DEFAULT 'no',
  `Yal Cinima` ENUM('yes', 'no') NOT NULL DEFAULT 'no',
  `Colombo Cinima` ENUM('yes', 'no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELIMITER //

CREATE TRIGGER `update_dates` BEFORE INSERT ON `movies`
FOR EACH ROW
BEGIN
    SET NEW.date1 = CURDATE() + INTERVAL 0 DAY;
    SET NEW.date2 = CURDATE() + INTERVAL 1 DAY;
    SET NEW.date3 = CURDATE() + INTERVAL 2 DAY;
END;
//

DELIMITER ;

DELIMITER //
CREATE TRIGGER `insert_movie_from_image` AFTER INSERT ON `movieImages`
FOR EACH ROW
BEGIN
    INSERT INTO movies (movie_name) VALUES (NEW.name);
END;
//
DELIMITER ;

-- Trigger to delete corresponding movie rows when a movie image is deleted
DELIMITER //
CREATE TRIGGER `delete_movie_on_image_delete` AFTER DELETE ON `movieImages`
FOR EACH ROW
BEGIN
    DELETE FROM movies WHERE movie_name = OLD.name;
END;
//
DELIMITER ;


CREATE TABLE users (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(100) NOT NULL,
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `updationDate` timestamp NOT NULL DEFAULT current_timestamp()
);


CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(120) DEFAULT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `FullName`, `AdminEmail`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'upcinima', 'admin@a.com', 'admin', 'upcinima', '2024-04-27 12:25:56');

-- --------------------------------------------------------

CREATE TABLE SeatStatus (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    SeatID VARCHAR(10) UNIQUE,
    BookingStatus ENUM('booked', 'not booked') DEFAULT 'not booked'
);

INSERT INTO SeatStatus (SeatID)
VALUES
    ('1'), ('2'), ('3'), ('4'), ('5'), 
    ('6'), ('7'), ('8'), ('9'), ('10'),
    ('11'), ('12'), ('13'), ('14'), ('15'), 
    ('16'), ('17'), ('18'), ('19'), ('20'),
    ('21'), ('22'), ('23'), ('24'), ('25'), 
    ('26'), ('27'), ('28'), ('29'), ('30'),
    ('31'), ('32'), ('33'), ('34'), ('35'), 
    ('36'), ('37'), ('38'), ('39'), ('40'),
    ('41'), ('42'), ('43'), ('44'), ('45'), 
    ('46'), ('47'), ('48'), ('49'), ('50'),
    ('51'), ('52'), ('53'), ('54'), ('55'), 
    ('56'), ('57'), ('58'), ('59'), ('60'),
    ('61'), ('62'), ('63'), ('64'), ('65'), 
    ('66'), ('67'), ('68'), ('69'), ('70'),
    ('71'), ('72'), ('73'), ('74'), ('75'), 
    ('76'), ('77'), ('78'), ('79'), ('80'),
    ('81'), ('82'), ('83'), ('84'), ('85'), 
    ('86'), ('87'), ('88'), ('89'), ('90'),
    ('91'), ('92'), ('93'), ('94'), ('95'), 
    ('96'), ('97'), ('98'), ('99'), ('100');

CREATE TABLE BookingDetails (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    FullName VARCHAR(100) NOT NULL,
    NIC VARCHAR(15) NOT NULL,
    PhoneNumber VARCHAR(15) NOT NULL,
    Seats TEXT NOT NULL,
    SeatFare DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    BookingStatus VARCHAR(3) NOT NULL DEFAULT 'No'
);

-- Your data insertion and other operations go here...

-- Update SeatStatus based on BookingDetails
UPDATE SeatStatus AS ss
JOIN BookingDetails AS bd ON FIND_IN_SET(ss.SeatID, bd.Seats) > 0
SET ss.BookingStatus = 'booked'
WHERE bd.BookingStatus = 'Yes';


CREATE TABLE CardPayment (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CardNumber VARCHAR(16) NOT NULL,
    ExpiryMonth INT NOT NULL,
    ExpiryYear INT NOT NULL,
    CVC VARCHAR(4) NOT NULL
);
