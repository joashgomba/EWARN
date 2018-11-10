-- phpMyAdmin SQL Dump - for users/websites example
-- http://www.web-design-talk.co.uk

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- Table structure for table `users`

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL auto_increment,
  `Username` varchar(150) NOT NULL,
  `Password` varchar(200) NOT NULL,
  PRIMARY KEY  (`UserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- Table structure for table `users_websites_link`

CREATE TABLE IF NOT EXISTS `users_websites_link` (
  `UserID` int(11) NOT NULL,
  `WebsiteID` int(11) NOT NULL,
  PRIMARY KEY  (`UserID`,`WebsiteID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Table structure for table `websites`

CREATE TABLE IF NOT EXISTS `websites` (
  `WebsiteID` int(11) NOT NULL auto_increment,
  `Website_URL` varchar(250) NOT NULL,
  PRIMARY KEY  (`WebsiteID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;
