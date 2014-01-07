#Baseball Tools Player Library 
###v. 0.1 beta <br>
#####by Matthew Gargano <mgargano@gmail.com>
<br>


PHP Library of functions that provide access to the Baseball-Databank 
(www.baseball-databank.org) and succeeding databases (as of this release 
managed by Sean Lahman at www.seanlahman.com/baseball-archive/statistics/).
This library requires the open source database class ezSQL by Justin Vincent 
for more information: http://justinvincent.com/ezsql 

###Note

I've got a long way to go, but this update should really help get the ball rolling. When I first wrote this project I was far from a seasoned developer and my time is limited now, but I had some time one afternoon to fix this project up to improve it a little bit. Stay tuned for more updates; I plan to rewrite this at some point in the future. Don't get mad at me if you dive into the code, it's a little scary :).

###Installation

This package uses [composer](http://getcomposer.org) and once composer is installed globally is as easy as setting up a composer.json file containing require directives for [ezSQL](http://justinvincent.com/ezsql) and this project, i.e.:

    {
        "require": {
            "jv2222/ezsql": "dev-master",
            "mgargano/baseball-tools":"dev-master"
        }
    }


###Usage

The constructor method takes an object of database information, here is an example on how to instantiate an object and get information about 2 players ( from my beloved New York Mutts 8-) ) Note that the [namespace](http://us3.php.net/namespaces) for the class used is Baseball_tools

    require_once('vendor/autoload.php');
    $db = new stdClass;
    $db->user = 'baseball';
    $db->password = 'baseball';
    $db->db = 'baseball';
    $db->server = 'localhost';
    $bb = new Baseball_tools\Baseball_tools( $db );
    $bb->set_player( 'wrighda03' );
    $david_wright_age = $bb->get_age();
    $bb->set_player( 'murphda08' );
    $daniel_murphy_age = $bb->get_age();
    echo 'david wright is ' . $david_wright_age . ' years old<br />daniel murphy is ' . $daniel_murphy_age . ' years old';

* for example, if we were to use Ike Davis who's player ID is davisik01 we would issue the following:

Current function/method list:

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


Release Notes

Version 0.1 beta
* Refactored code a bit, easier to use. Stay tuned for more changes.

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
License: Copyright 2014  Matthew Gargano  (email : mgargano@gmail.com)
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as  published by the Free Software Foundation. 
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or  FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA.
