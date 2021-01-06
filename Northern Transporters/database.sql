CREATE TABLE `admin` (
 `admin_id` int(11) NOT NULL AUTO_INCREMENT,
 `admin_name` varchar(10) NOT NULL,
 `admin_password` varchar(100) NOT NULL,
 PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `customer` (
 `customer_id` int(11) NOT NULL AUTO_INCREMENT,
 `customer_name` varchar(20) NOT NULL,
 `username` varchar(20) NOT NULL,
 `customer_contact` varchar(10) NOT NULL,
 `customer_email` varchar(30) NOT NULL,
 `customer_location` varchar(30) NOT NULL,
 `password` varchar(100) NOT NULL,
 PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `customer messages` (
 `message_id` int(20) NOT NULL AUTO_INCREMENT,
 `customer_id` int(20) NOT NULL,
 `message` text NOT NULL,
 `assess` varchar(9) NOT NULL,
 `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`message_id`),
 KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `rental` (
 `rental_id` int(50) NOT NULL AUTO_INCREMENT,
 `customer_id` int(50) NOT NULL,
 `customer_username` varchar(20) NOT NULL,
 `vehicle_plate` varchar(11) NOT NULL,
 `type` varchar(20) NOT NULL,
 `source` varchar(20) NOT NULL,
 `destination` varchar(20) NOT NULL,
 `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `amount` varchar(10) NOT NULL,
 `status` int(1) NOT NULL,
 `approved` varchar(9) NOT NULL,
 PRIMARY KEY (`rental_id`),
 KEY `customer_id` (`customer_id`),
 KEY `vehicle_plate` (`vehicle_plate`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `vehicle` (
 `vehicle_plate` varchar(10) NOT NULL,
 `vehicle_profile` varchar(50) NOT NULL,
 `vehicle_model` varchar(15) NOT NULL,
 `vehicle_location` varchar(15) NOT NULL,
 `status` int(11) NOT NULL,
 PRIMARY KEY (`vehicle_plate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
