<?php
/**
 * 
 *   @package baseball-tools 
 * 
 */

/** 
*
*   Baseball Player Library
*   This class, serves as a static representation of arrays used for 
*   handling special circumstances in locations and colleges from the 
*   baseball statistics database. 
*
*   @author Matthew Gargano <mgargano@gmail.com>
*   @version 0.003 pre-beta
*   @package baseball-tools 
*    
*   This software is meant for personal research purposes. Please consult the 
*   terms of use, terms of service for each source of data, IDs, information and 
*   data.
*   
*   License: Copyright 2012  Matthew Gargano  (email : mgargano@gmail.com)

*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License, version 2, as 
*   published by the Free Software Foundation. 
*   
*   This program is distributed in the hope that it will be useful, but WITHOUT 
*   ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
*   FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
*   more details.
*   
*   You should have received a copy of the GNU General Public License
*   along with this program; if not, write to the Free Software
*   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA.
*
*
*
*/
class Baseball_tools_player_replace {
  /**
  * Array of verbose replacements for references in the database for locations
  * e.g. database contains P.R. in place of Puerto Rico.
  *          
  */
  
  public static $place_replace = array(  
    'P.R.'      =>  'Puerto Rico',
    'D.R.'      =>  'Dominican Republic',
    'V.I.'      =>  'Virgin Islands',
    'CAN'       =>  'Canada',
    'W.Germany' =>  'West Germany'
    );

  /**
  * Array of verbose replacements for references in the database for locations
  * e.g. database contains "none" for some players, this replaces that with 
  *   blank 
  *          
  */
  
  public static $college_replace = array(
    'None'      =>  '',
   );
  

}