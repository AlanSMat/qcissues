# DynamicDropDown - SQL Table Dump
# version 1.0.0
# http://www.gobinath.com
#
# Generation Time: May 06, 2005 at 04:14 PM
# 
# Author : gobinath ( gobinathm <at> gmail <dot> com )
# 

# --------------------------------------------------------

#
# Table structure for table `brand`
#

CREATE TABLE `brand` (
  `brand_id` smallint(9) NOT NULL auto_increment,
  `brand_name` varchar(255) NOT NULL default '',
  `type_id` smallint(9) NOT NULL default '0',
  PRIMARY KEY  (`brand_id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# Dumping data for table `brand`
#

INSERT INTO `brand` VALUES (1, 'brand 1', 1);
INSERT INTO `brand` VALUES (2, 'brand 2', 1);
INSERT INTO `brand` VALUES (3, 'brand 3', 2);

# --------------------------------------------------------

#
# Table structure for table `model`
#

CREATE TABLE `model` (
  `model_id` smallint(9) NOT NULL auto_increment,
  `model_name` varchar(255) NOT NULL default '',
  `brand_id` smallint(9) NOT NULL default '0',
  PRIMARY KEY  (`model_id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# Dumping data for table `model`
#

INSERT INTO `model` VALUES (1, 'model 1', 1);
INSERT INTO `model` VALUES (2, 'model 2', 2);
INSERT INTO `model` VALUES (3, 'model 3', 1);

# --------------------------------------------------------

#
# Table structure for table `type`
#

CREATE TABLE `type` (
  `type_id` smallint(9) NOT NULL auto_increment,
  `type_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`type_id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Dumping data for table `type`
#

INSERT INTO `type` VALUES (1, 'Type 1');
INSERT INTO `type` VALUES (2, 'Type 2');
