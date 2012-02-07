Baseball Tools Player Library v. 0.003 pre-beta by Matthew Gargano


PHP Library of functions that provide access to the Baseball-Databank 
(www.baseball-databank.org) and succeeding databases (as of this release 
managed by Sean Lahman at www.seanlahman.com/baseball-archive/statistics/).
This library includes the open source database class ezSQL by Justin Vincent 
for more information : http://justinvincent.com/ezsql 

Installation
	
* Explode package to your local machine.
* Enter your database information in /baseball-tools/lib/lib.php.
* Upload the folder /baseball-tools/ into your web project. (n.b. this should include your updated lib.php)
*	Include the package's "/path/to/baseball-tools/connect.php" (e.g. require_once("baseball-tools/connect.php");)
*	You're done! If you receive an error verify you entered correct database credentials.

Usage

Instantiate object like such:

$bb=new Baseball_tools_player($player_id);

* for example, if we were to use Ike Davis who's player ID is davisik01 we would issue the following:

$bb=new Baseball_tools_player("davisik01");
	
* Call the associated method containing which you want to access, for example if we want Ike's age we would call $bb->get_age(); and it would return his current age.

Current function/method list: (see code comments for instructions on their usage)
* get_age ()
* get_bats ()
* get_bbref_id ()
* get_birthday ()
* get_birthplace ()
* get_college ()
* get_deathday ()
* get_deathplace ()
* get_given_name ()
* get_height_feet ()
* get_height_inches ()
* get_hof_id ()
* get_holtz_id ()
* get_lahman_id ()
* get_lahman_4_0_id ()   
* get_lahman_4_5_id ()
* get_manager_id ()
* get_name ()
* get_name_note ()
* get_nick_name ()     
* get_player_type ()
* get_retro_id ()
* get_stats ($year [optional])
* get_throws ()
* get_weight ()        

Download the library from http://matgargano.com/baseball-tools



Release Notes

Version 0.003 pre-beta
* Added connect.php to make for easier implementation
* Updated lib.php to check for - and die - if the database credentials are invalid.
	
Version 0.002 pre-beta
* Added functionality for pitchers. 
* Updated functionality for get_stats
* Added more documentation.  

Version 0.001 Alpha 
* Introducing a PHP library for that is compatible with Sean Forman's Baseball Databank database or Sean Lahman's Baseball Database. This is still in a beta format and it currently only provides statistics for batters, I am working on adding pitcher's for the next release.

<<!!IMPORTANT!!>>

This software is meant for personal research purposes. Please consult the terms of use, terms of service for each source of data, IDs, information and data.
License: Copyright 2012  Matthew Gargano  (email : mgargano@gmail.com)
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as  published by the Free Software Foundation. 
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or  FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA.
