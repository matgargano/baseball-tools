<?php
	/**
 	*
 	*  @package baseball-tools 
 	*
 	*/

	/**
	*
	*  Baseball Tools Player Library
	*  PHP Library of functions that provide access to the Baseball-Databank 
	*  (http://www.baseball-databank.org) and succeeding databases (as of this release 
	*  managed by Sean Lahman at www.seanlahman.com/baseball-archive/statistics/).
	*  This library includes the open source database class ezSQL by Justin Vincent 
	*  for more information : http://justinvincent.com/ezsql 
	*
	*  @author Matthew Gargano <mgargano@gmail.com>
	*  @version 0.003 pre-beta
	*  @package baseball-tools 
	*   
	*  This software is meant for personal research purposes. Please consult the 
	*  terms of use, terms of service for each source of data, IDs, information and 
	*  data.
	*  
	*  License: Copyright 2012  Matthew Gargano  (email : mgargano@gmail.com)
	*
	*  This software is meant for personal research purposes. Please consult the 
	*  terms of use, terms of service for each source of data, IDs, information and 
	*  data.
	*  
	*  License: Copyright 2012  Matthew Gargano  (email : mgargano@gmail.com)
	*  This program is free software; you can redistribute it and/or modify
	*  it under the terms of the GNU General Public License, version 2, as 
	*  published by the Free Software Foundation. 
	*  
	*  This program is distributed in the hope that it will be useful, but WITHOUT 
	*  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
	*  FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
	*  more details.
	*  
	*  You should have received a copy of the GNU General Public License
	*  along with this program; if not, write to the Free Software
	*  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA.
	*
	*  Initialized object requires:
	*  
	*  @param string $player_id  
	*  database.
	*
	*/


class Baseball_tools_player {
  function __construct($player_id) {
    
   	/**
 	*reference $db from lib.php
 	*/    
    global $db;
    
   	/**
 	*The current player_id, which comes from the current object's instantiation
 	*
 	*/              
    $this->player_id=$player_id;
    
    
   	/**
 	*The most recent year that we have information for, from the database 
 	*
 	*@var int 
 	*/     
    $this->current_year = max($db->get_var("select max(yearID) as year from 
      Batting"), $db->get_var("select max(yearID) as year from Pitching"));
    
   	/**
 	*
 	*Upon instantiation, obtain necessary information about player from database.
 	*         
 	*/         
    
    $this->_get_player_info();
  }

  	/**
	* Convert inches to string of feet/inches  
*
	*  @param int $inches
	*  @return string Takes an input of inches and converts it to (Feet'Inches") sans parenthesis. For example if given value fo 73 it will return string (6'1") sans parenthesis. 
	*           
	*/
  
    protected function convert_height($inches) {
      $inches=int($inches);
      if ( ! is_numeric($inches) ) {
        return false;
      }
      
      if( (int)$inches < 60 ) {
        return false;
      }
      $feet = $inches/12;
      $feet = round($feet, 2);
      $parts = explode(".", $feet);
      $whole_feet = $parts[0];
      $remaining_inches = round(($parts[1]/100)*12);
      $height = $whole_feet."&#39; ".$remaining_inches."&quot;";
      return $height;
    }


  	/**
	* Get player information  Note: This function is used by this class' construct and should not need to be invoked otherwise.  
	* 
	* @return boolean Returns true if any of the necessary information is available. False if not. sets this object up with all fields listed above from Master table that are available for player.
 	*
 	* 
	*/
  
    
  private function _get_player_info() {
    global $db;
  	$player_type_query_template = 'select sum(G) from Batting where playerID="%s" 
      group by playerID';
  	$player_type_query = sprintf($player_type_query_template,$this->player_id);
  	$gameF = $db->get_var($player_type_query);
  	$player_type_query_template = 'select sum(G) from Pitching where 
      playerID="%s" group by playerID';
  	$player_type_query = sprintf($player_type_query_template,$this->player_id);
  	$gameP = $db->get_var($player_type_query);
  	$gameF = (int)$gameF;
  	$gameP = (int)$gameP;
  	if ( $gameF + $gameP == 0 ) {
  		return false;
  	}
  	elseif ( (! $gameP ) || ($gameP/$gameF) < .8 ) {
  		$this->player_type = "F";
  	}
  	else {
  		$this->player_type="P";
    }
    $query_template = 'select * from Master where playerID="%s" limit 0,1';
    $query = sprintf($query_template,$this->player_id);
    $result = $db->get_results($query,ARRAY_A);
    if ($result) {
      foreach ( $result as $record ) {
        $this->lahman_id      =   $record['lahmanID'];
        $this->manager_id     =   $record['managerID'];
        $this->hof_id         =   $record['hofID'];
        $this->birth_year     =   $record['birthYear'];
        $this->birth_month    =   $record['birthMonth'];
        $this->birth_day      =   $record['birthDay'];
        $this->birth_country  =   $record['birthCountry'];
        $this->birth_state    =   $record['birthState'];
        $this->birth_city     =   $record['birthCity'];
        $this->death_year     =   $record['deathYear'];
        $this->death_month    =   $record['deathMonth'];
        $this->death_day      =   $record['deathDay'];
        $this->death_country  =   $record['deathCountry'];
        $this->death_state    =   $record['deathState'];
        $this->death_city     =   $record['deathCity'];
        $this->name_first     =   $record['nameFirst'];
        $this->name_last      =   $record['nameLast'];
        $this->name_note      =   $record['nameNote'];
        $this->name_given     =   $record['nameGiven'];
        $this->name_nick      =   $record['nameNick'];
        $this->weight         =   $record['weight'];
        $this->height         =   $record['height'];
        $this->bats           =   $record['bats'];
        $this->throws         =   $record['throws'];
        $this->debut          =   $record['debut'];
        $this->final_game     =   $record['finalGame'];
        $this->college        =   $record['college'];
        $this->lahman_4_0_id  =   $record['lahman40ID'];
        $this->lahman_4_5_id  =   $record['lahman45ID'];
        $this->retro_id       =   $record['retroID'];
        $this->holtz_id       =   $record['holtzID'];
        $this->bbref_id       =   $record['bbrefID'];
      }
      foreach( Baseball_tools_player_replace::$college_replace as $key => $val ) {
        if ( $this->college == $key ) { 
          $this->college = ""; 
        }
      }
      foreach( Baseball_tools_player_replace::$place_replace as $key => $val ) {
        if ( $this->death_country == $key ) { 
          $this->death_country = $val; 
        }
        if ( $this->birth_country == $key ) { 
          $this->birth_country = $val; 
        }
          
      }
    }
    return true;
  } 
    
    
  

  	/**
 	* Get player's age as of today 
 	* 
 	*  @return int|boolean If fields are all available and correctly formed this returns the player's age as of today, if not it returns false. 
 	*  @access public
 	*/  
  
    public function get_age() {
        if ( is_numeric( $this->death_year ) 
              && is_numeric ( $this->death_day ) 
              && is_numeric ( $this->death_month ) 
              && $this->death_year > 1800 ) {
          return -1;
        }
        if ( is_numeric( $this->birth_year ) 
              && is_numeric ( $this->birth_day ) 
              && is_numeric ( $this->birth_month ) 
              && $this->birth_year > 1800 ) {
          $date = $this->birth_month . "/" . $this->birth_day . "/" . 
              $this->birth_year;
          $date_array = explode("/", $date);
          return (date("md", 
                  date("U", 
                  mktime(0, 0, 0, $date_array[0], $date_array[1], $date_array[2]))) > date("md") ? 
                    ((date("Y")-$date_array[2])-1):(date("Y")-$date_array[2]));
        }
        return false;
    }
  
  	/**
 	* Get batting handedness of player
 	* 
 	*  @return string|boolean Returns "L" , "R" or "B" depending on the player' batting handedness or false if information is not provided in database.
 	*  @access public
 	*/  
  
  
  
    public function get_bats() {
      if ($this->bats) {
        return $this->bats;
        }
      else {
        return false;
      }
    }

  	/**
	* Get bbref ID (from retrosheet.org) 
	* 
	*  @return string|boolean Returns ID from Baseball Reference website (www.baseball-reference.com) if available, false if not.
	*  @access public   
	*/
  
  public function get_bbref_id() {
    if ( $this->bbref_id) {
      return $this->bbref_id;
    }
    return false;
  }


  
   	/**
	* Get player's birthday
	*  
	*@return string|boolean Returns player's birthday if the database has all of player's proper relevant information, or false if not.
 	*@access public
 	*
 	*     
 	*/  
  
    public function get_birthday() {
        if ( is_numeric( $this->birth_year ) 
              && is_numeric ( $this->birth_day ) 
              && is_numeric ( $this->birth_month ) 
              && $this->birth_year > 1800 ) {
              
               $date = $this->birth_month . "/" . $this->birth_day . "/" . $this->birth_year;
               $date_array = explode("/", $date);
               return date("m/d/y",mktime(0, 0, 0, $date_array[0], $date_array[1], $date_array[2]));
        }
      return false;
      }
  
  
  	/**
 	* Get player's place of birth 
 	* 
 	*  @return string|boolean Returns location of the player's birth if available, if not returns false
 	*  @access public
 	*
 	*/  
  
  
    public function get_birthplace() {
      if ( is_numeric( $this->birth_state)  
            || $this->birth_state=="" 
            || !isset($this->birth_state)){
                return "$this->birth_city, $this->birth_country";
        } elseif(($this->birth_city) 
                  && ($this->birth_state) 
                  && ($this->birth_country)) {
                    
                    return "$this->birth_city, $this->birth_state, $this->birth_country";
        } else {
          return false;  
        }
    }

  	/**
	* Get player's college 
	* 
	*  @return string|boolean Returns player's college if they attended, false if they did not attend college or this information is not accurately populated in the database. 
	*  @access public
	*/
    
  public function get_college() {
    if ( $this->college) {
      return $this->college;
    }
    return false;
  }      


  
  	/**
	* Get player's date of death
	*     
	*  @return string|boolean Returns date of death. Note: if player is no longer alive, the day they became deceased. If they alive or death 
	*  @access public  
	*    
	*/  
  
    
    public function get_deathday() {
      if ( is_numeric( $this->death_year ) 
            && is_numeric ( $this->death_day ) 
            && is_numeric ( $this->death_month ) 
            && $this->death_year > 1800 ) {
              $date = $this->death_month . "/" . $this->death_day . "/" . $this->death_year;
              $date_array = explode("/", $date);
              return date("m/d/y",mktime(0, 0, 0, $date_array[0], $date_array[1], $date_array[2]));
        }
      return false;
      }
  
  	/**
 	* Get player's place of death
 	* 
 	*  @return string|boolean Returns location of the player's death if available, if player is alive or database does not contain death information, returns false
 	*  @access public  
 	*
 	*/  
  
  
    public function get_deathplace() {
      if ( $this->player_id ) {
        if ( $this->death_year>1800 ) {
          if ( ( trim ( $this->death_city ) == "") && trim( $this->death_country ) != "" ) {
            return strtoupper(substr($this->death_country, 0, 1)) . substr($this->death_country, 1);
          }
          elseif ( is_numeric ( $this->death_state) 
                    || $this->death_state=="" 
                    || !isset($this->death_state) ) {
                    
                      return "$this->death_city, $this->death_country";
          } else {
            return "$this->death_city, $this->death_state, $this->death_country";
          }
        }
      }
      return false;
    }

  
  	/**
 	* Get player's height in inches
 	*
 	*   @return int|boolean Player's height in inches. If field is not available in database, returns false.
 	*   @access public  
 	*    
 	*
 	*/
  
  public function get_height_inches() {
    if ( $this->height && is_numeric($this->height)) {
      return $this->height;
    }
    return false;
  }    
  
  	/**
	* Get player's height in feet
	*  
	*    @return string|boolean Returns player's height in feet/inch format e.g. if field's value is 73 it would return  6'1" as a string. If field is not available in database, returns false.
	*    @access public  
	*    
	*/  
    
  public function get_height_feet() {
    if ( $this->height) {
      return $this->convert_height( $this->height );
    }
    return false;
  }    


  	/**
	* Get player's given name
	* 
	*  @return string|boolean Returns player's given name if available in the database, if unavailable or does not exist, returns false
	*  @access public  
	*    
	*
	*/  
  
    public function get_given_name() {
      if ( strlen($this->name_given ) > 0) {
        return $this->name_given;
      }
      return false;
    }  

  	/**
	* Get Hall of Fame (HOF) ID 
	* 
	*  @return string|boolean Returns Hall of Fame ID if available, false if not. 
	*  @access public  
	*    
	*/
  
  
  public function get_hof_id() {
    if ( $this->hof_id) {
      return $this->hof_id;
    }
    return false;
    }

  	/**
	* Get Holtz ID (from Sean Holt'z Baseball Almanac, baseball-almanac.com) 
	* 
	*  @return 	string|boolean Returns Holtz ID (from baseball-almanac.com) if available 
	*  @access 	public  
	*    
	*/
  
  
  public function get_holtz_id() {
    if ( $this->holtz_id) {
      return $this->holtz_id;
    }
    return false;
  }


  	/**
	* Get Lahman ID 
	* 
	*  @return string|boolean Returns Lahman ID if available, false if not.
	*  @access public  
	*    
	*/
  
  public function get_lahman_id() {
    if ( $this->lahman_id) {
      return $this->lahman_id;
    }
    return false;
  }
  
  	/**
	* Get Lahman 4.0 ID 
	* 
	*  @return string|boolean Returns ID from Lahman Database 4.0, if available, false if not.
	*  @access public  
	*    
	*/
  
  public function get_lahman_4_0_id() {
    if ( $this->lahman_4_0_id) {
      return $this->lahman_4_0_id;
    }
    return false;
  }
  
  	/**
	* Get Lahman 4.5 ID 
	*
	*  @return string returns ID from Lahman Database 4.5 if available, false if not. 
	*  @access public  
	*    
	*/
  
  public function get_lahman_4_5_id() {
    if ( $this->lahman_4_5_id) {
      return $this->lahman_4_5_id;
    }
    return false;
  }

  	/**
	* Get Manager ID 
	* 
	*  @return string|boolean Returns Manager ID if available, false if not. 
	*  @access public  
	*    
	*/
  
  public function get_manager_id() {
    if ( $this->manager_id) {
      return $this->manager_id;
    }
    return false;
  }

  
  	/**
	* Get player's first and last name
	*   
	*  @return string|boolean Returns player's first name + space + last name if the database has all of player's proper relevant information (i.e. database/Table(s): fields) or false if not.
	*  @access public  
	*    
	*/  
    
    public function get_name() {
      if($this->name_first && $this->name_last) {
        return $this->name_first." ".$this->name_last;
      }
	  return false;
    }

  
  	/**
 	*
 	* Get note about player's name
 	* 
 	*  @return string|boolean Returns note about player's name if available in the database, false if not.
 	*  @access public  
 	*    
 	*
 	*/  
  
  
    public function get_name_note() {
      if ( strlen($this->name_note ) > 0) {
        return $this->name_note;
      }
      return false;
    }  


  
  	/**
 	* Get player's nick name
 	* 
 	*  @return string|boolean Returns player's nickname if available in the database, false if not.
 	*  @access public  
 	*    
 	*
 	*/  
  
    public function get_nick_name () {
      if ( strlen($this->name_nick ) > 0) {
        return $this->name_nick;
      }
      return false;
    }

  	/**
	* Get player type (Fielder or Pitcher)
	* 
	*  @return string|boolean Returns "F" for non-pitcher and "P" for pitcher, false if neither.
	*  @access public  
	*    
	*
	*/  
  
  public function get_player_type() {
    if ( $this->player_type) {
      return $this->player_type;
    }
    return false;
  }

  	/**
	* Get RetroSheet ID (from retrosheet.org) 
	*    
	*  @return string|boolean Returns RetroSheet ID (from retrosheet.org) if available, false if not 
	*  @access public  
	*    
	*/
  
  public function get_retro_id() {
    if ( $this->retro_id) {
      return $this->retro_id;
    }
    return false;
  }


  
/**
 * 
 * Get statistics for a particular year for the current player (parameter for year is optional).
 * Note about the array returned:<br /><br />
 * 	The number of elements in the returned array depends on the number of stints a player has during the season. If the number of stints >1 then the last element of the array will be "total" and will be the total stats for the season over all of the player's respective stints. For example:<br /><br />
 *     Byung-Hyun Kim's 2007 campaign was something of a whirlwind. He began the season with Colorado Rockies, on May 13, 2007 he was dealt to the Florida Marlins. The Florida Marlins placed him on waivers and he was claimed by the Arizona Diamondbacks on August 3, 2007. After pitching for the Arizona Diamondbacks for less than 3 weeks, he was released and became a free agent on August 22, 2007. On August 25, 2007 he (re)signed with the Florida Marlins, donning the Marlins jersey for the second time that season. So what does this mean? Well if you run this method for Byung-Hyun Kim for 2007 it will return an array with 5 elements, see below:<br /><br />
 *          $array[1] will have his stats from his stint with the Colorado Rockies<br />
 *          $array[2] will have his stats from his FIRST stint with the Florida Marlins<br />
 *          $array[3] will have his stats from his stint with the Arizona Diamondbacks<br />
 *          $array[4] will have his stats from his SECOND stint with the Florida Marlins<br />
 *          $array['total'] will have his cumulative stats for the entire 2007 season   <br />
 *  
 *
 * @param int $year
 * @return array|boolean Returns array of player information if player_type can be resolved, false if the player did not play that year or the ID given is not proper.
 * @access public
 * 
 * 
 * 
 */
   
  public function get_stats($year=0) {
  	global $db;
        $output=array();
  	if ( !$this->player_type ) { 
      return false;
    }
  	if ($year == 0) {
  		$year = $this->current_year;
  	}
  	if ($this->player_type=="F") {
  		$multiple_stints_query = 'select count(*) from Batting where playerID="%s"  AND yearID=%d';
  		$query_stats           = sprintf($multiple_stints_query,$this->player_id, $year);
  		$stints                = $db->get_var($query_stats);
  		$query_stats_template  = 'SELECT teamID, yearID, stint, lgID, SUM(G) as G, SUM(G_batting) as G_batting, SUM(AB) as AB, SUM(R) as R, SUM(H) as H, SUM(2B) as 2B, SUM(3B) as 3B, SUM(HR) as HR, SUM(RBI) as RBI, SUM(SB) as SB, SUM(CS) as CS, SUM(BB) as BB, SUM(SO) as SO, SUM(IBB) as IBB, SUM(HBP) as HBP, SUM(SH) as SH, SUM(SF) as SF, SUM(GIDP) as GIDP, SUM(G_old) as G_old, if(sum(AB)>0,format(sum(H)/sum(AB),3),format(0,3)) as AVG, if(sum(AB)>0,format((SUM(H)-(SUM(2B)+SUM(3B)+SUM(HR))+(SUM(2B)*2)+(SUM(3B)*3)+(SUM(HR)*4))/SUM(AB),3),format(0,3)) as SLG, if((sum(AB)+sum(BB)+sum(HBP)+sum(SF))>0,format((sum(H)+sum(BB)+sum(HBP))/((sum(AB)+sum(BB)+sum(HBP)+sum(SF))),3),format(0,3)) as OBP, format(((SUM(H)-(SUM(2B)+SUM(3B)+SUM(HR))+(SUM(2B)*2)+(SUM(3B)*3)+(SUM(HR)*4))/SUM(AB)) +((sum(H)+sum(BB)+sum(HBP))/((sum(AB)+sum(BB)+sum(HBP)+sum(SF)))),3) AS OPS from Batting where playerID="%s"  AND yearID=%d GROUP BY stint, yearID order by stint asc';
  		$query_stats           = sprintf($query_stats_template, $this->player_id, $year);
  		$stints_array          = $db->get_results($query_stats , ARRAY_A);
  		
      foreach($stints_array as $array) {
        $stint=$array['stint'];
        $output[$stint]=$array;
      }
      
    if ($stints > 1) {
    		$query_stats_total_template='SELECT "TOT" as teamID, yearID, "-" as lgID, SUM(G) as G, SUM(G_batting) as G_batting, SUM(AB) as AB, SUM(R) as R, SUM(H) as H, SUM(2B) as 2B, SUM(3B) as 3B, SUM(HR) as HR, SUM(RBI) as RBI, SUM(SB) as SB, SUM(CS) as CS, SUM(BB) as BB, SUM(SO) as SO, SUM(IBB) as IBB, SUM(HBP) as HBP, SUM(SH) as SH, SUM(SF) as SF, SUM(GIDP) as GIDP, SUM(G_old) as G_old, if(sum(AB)>0,format(sum(H)/sum(AB),3),format(0,3)) as AVG, if(sum(AB)>0,format((SUM(H)-(SUM(2B)+SUM(3B)+SUM(HR))+(SUM(2B)*2)+(SUM(3B)*3)+(SUM(HR)*4))/SUM(AB),3),format(0,3)) as SLG, if((sum(AB)+sum(BB)+sum(HBP)+sum(SF))>0,format((sum(H)+sum(BB)+sum(HBP))/((sum(AB)+sum(BB)+sum(HBP)+sum(SF))),3),format(0,3)) as OBP, format(((SUM(H)-(SUM(2B)+SUM(3B)+SUM(HR))+(SUM(2B)*2)+(SUM(3B)*3)+(SUM(HR)*4))/SUM(AB)) +((sum(H)+sum(BB)+sum(HBP))/((sum(AB)+sum(BB)+sum(HBP)+sum(SF)))),3) AS OPS from Batting where playerID="%s"  AND yearID=%d GROUP BY yearID';
  			$query_stats_total = sprintf($query_stats_total_template, $this->player_id, $year);
  			$total_array = $db->get_results($query_stats_total , ARRAY_A);
        foreach($total_array as $array) {
          $output['total']=$array;
          }
  			}
       
  		return $output;        
  	}
    elseif ($this->player_type=="P") {
      $multiple_stints_query  =   'select count(*) from Pitching where playerID="%s"  AND yearID=%d';
  		$query_stats            =   sprintf($multiple_stints_query, $this->player_id, $year);
  		$stints                 =   $db->get_var($query_stats);
      $query_stats_template   =   'SELECT teamID, yearID, stint, lgID, sum( W ) AS W, sum( L ) AS L, sum( G ) AS G, sum( GS ) AS GS, sum( CG ) AS CG, sum( SHO ) AS SHO, sum( SV ) AS SV, sum( IPouts ) AS IPouts, sum( H ) AS H, sum( ER ) AS ER, sum( HR ) AS HR, sum( BB ) AS BB, sum( SO ) AS SO, sum( BAOpp ) AS BAOpp, sum( IBB ) AS IBB, sum( WP ) AS WP, sum( HBP ) AS HBP, sum( BK ) AS BK, sum( BFP ) AS BFP, sum( GF ) AS GF, sum( R ) AS R, if( sum( IPouts ) /3 >0, format( ( sum( BB ) + sum( H ) ) / ( sum( IPouts ) /3 ) , 3 ) , format( 0, 3 )) AS WHIP, if( sum( IPouts ) /3 >0, format( ( (sum( ER ) ) / ( sum( IPouts ) /3 ) ) *9, 2), format( 0, 2 )) AS ERA, if((sum(IPOuts)/3)-FLOOR((sum(IPOuts)/3))=0,FLOOR(sum(IPOuts)/3)+0,if(sum(IPouts)/3-FLOOR(sum(IPOuts)/3)=(1/3),FLOOR(sum(IPOuts)/3)+.1,FLOOR(sum(IPOuts)/3)+.2)) as IP FROM Pitching WHERE playerID = "%s" AND yearID = %d  GROUP BY stint, yearID ORDER BY stint ASC';
      //$query_stats_template   =   'select teamID, yearID, stint, lgID, sum(W) as W, sum(L) as L, sum(G) as G, sum(GS) as GS, sum(CG) as CG, sum(SHO) as SHO, sum(SV) as SV, sum(IPouts) as IPouts, sum(H) as H, sum(ER) as ER, sum(HR) as HR, sum(BB) as BB, sum(SO) as SO, sum(BAOpp) as BAOpp, sum(ERA) as ERA, sum(IBB) as IBB, sum(WP) as WP, sum(HBP) as HBP, sum(BK) as BK, sum(BFP) as BFP, sum(GF) as GF, sum(R) as R from Pitching where playerID="%s"  AND yearID=%d GROUP BY stint, yearID order by stint asc';
  		$query_stats           = sprintf($query_stats_template, $this->player_id, $year);
  		$stints_array          = $db->get_results($query_stats , ARRAY_A);
      foreach($stints_array as $array) {
        $stint=$array['stint'];
        $output[$stint]=$array;
      }
      if ($stints > 1) {
      		$query_stats_total_template='SELECT "TOT" as teamID, yearID, sum(W) as W, sum(L) as L, sum(G) as G, sum(GS) as GS, sum(CG) as CG, sum(SHO) as SHO, sum(SV) as SV, sum(IPouts) as IPouts, sum(H) as H, sum(ER) as ER, sum(HR) as HR, sum(BB) as BB, sum(SO) as SO, sum(BAOpp) as BAOpp, sum(ERA) as ERA, sum(IBB) as IBB, sum(WP) as WP, sum(HBP) as HBP, sum(BK) as BK, sum(BFP) as BFP, sum(GF) as GF, sum(R) as R from Pitching where playerID="%s"  AND yearID=%d GROUP BY yearID';
    			$query_stats_total = sprintf($query_stats_total_template, $this->player_id, $year);
          $total_array = $db->get_results($query_stats_total , ARRAY_A);
          foreach($total_array as $array) {
            $output["total"]=$array;
            }
    	}
      return $output;        
    }
    else {
    return false;
    }
    
  }                                                  
  
      
  
  	/**
	* Get throwing handedness of player
	* 
	*  @return string|boolean Returns "L" or "R" depending on the player's throwing handedness or false if information is not provided in database.
	*  @access public  
	*    
	*
	*/  
  
    public function get_throws() {
      if ($this->throws) {
        return $this->throws;
      }
      else {
        return false;
      }
    }
  
  
  
  	/**
	* Get player's weight in pounds
	* 
	*  @return int|boolean Returns player's weight in pounds, if field is not available in database, returns false.
	*  @access public  
	*    
	*/  
  
  public function get_weight() {
    if ( $this->weight) {
      return $this->weight;
    }
    return false;
  }

    
  
  
  }
  
  
  
?>