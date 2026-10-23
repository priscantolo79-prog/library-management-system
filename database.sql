CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(100) NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `books` (
  `BookID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `Author` varchar(100) DEFAULT NULL,
  `Status` enum('Available','Borrowed') DEFAULT 'Available',
  `CategoryID` int(11) DEFAULT NULL,
  PRIMARY KEY (`BookID`),
  KEY `CategoryID` (`CategoryID`),
  CONSTRAINT `books_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `friends` (
  `FriendID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`FriendID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `loans` (
  `LoanID` int(11) NOT NULL AUTO_INCREMENT,
  `BookID` int(11) DEFAULT NULL,
  `FriendID` int(11) DEFAULT NULL,
  `DateBorrowed` date DEFAULT (curdate()),
  `DueDate` date DEFAULT NULL,
  `DateReturned` date DEFAULT NULL,
  PRIMARY KEY (`LoanID`),
  KEY `BookID` (`BookID`),
  KEY `FriendID` (`FriendID`),
  CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`),
  CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`FriendID`) REFERENCES `friends` (`FriendID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
