-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 17, 2014 at 09:45 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `arn-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `arn_content`
--

CREATE TABLE `arn_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_id` int(11) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(252) NOT NULL,
  `slug` varchar(252) NOT NULL,
  `description` text NOT NULL,
  `main_image_url` varchar(252) NOT NULL,
  `main_image_title` varchar(252) NOT NULL,
  `state` int(11) NOT NULL,
  `published_at` int(11) DEFAULT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `created_user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `arn_content_field`
--

CREATE TABLE `arn_content_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `arn_content_media`
--

CREATE TABLE `arn_content_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `title` varchar(252) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `arn_content_type`
--

CREATE TABLE `arn_content_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(252) NOT NULL,
  `description` varchar(252) DEFAULT NULL,
  `has_media` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `arn_field`
--

CREATE TABLE `arn_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_id` int(11) NOT NULL,
  `title` varchar(252) NOT NULL,
  `description` varchar(252) DEFAULT NULL,
  `value_type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------