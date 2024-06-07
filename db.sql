CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male', 'Female') DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  INDEX (email),
  INDEX (national_id)
);


CREATE TABLE `applicants` (
  `id_applicant` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male', 'Female') DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `username` varchar(50) DEFAULT NULL,
  INDEX (email),
  INDEX (national_id)
);


CREATE TABLE `applications` (
  `id_application` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_applicant` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `statename` varchar(50) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `payam` varchar(50) DEFAULT NULL,
  `boma` varchar(50) DEFAULT NULL,
  `residential_address` varchar(50) DEFAULT NULL,
  `residential_city` varchar(50) DEFAULT NULL,
  `residential_street` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `marital_status` enum('Single', 'Married', 'Divorced', 'Widowed') DEFAULT NULL,
  `education_level` varchar(50) DEFAULT NULL,
  `profession` varchar(50) DEFAULT NULL,
  `previous_party_affiliation` varchar(50) DEFAULT NULL,
  `date_of_join_splm` date DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `application_status` enum('Pending', 'Approved', 'Rejected') NOT NULL DEFAULT 'Pending',
  `application_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_applicant`) REFERENCES `applicants` (`id_applicant`),
  FOREIGN KEY (`id_admin`) REFERENCES `admins` (`id_admin`)
);
