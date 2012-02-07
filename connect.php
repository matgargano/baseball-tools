<?php
 /**
 	*
 	*Fill out the required information in lib.php in subdirectory /lib and 
 	*fill out pertinent database information for the ezSQL class for more 
 	*information for the database visit http://baseball-databank.org or  
 	*http://www.seanlahman.com/baseball-archive/statistics/ 
 	*for how to retrieve the baseball database.                
 	*    
 	*/
    include_once("lib/lib.php");
    
 	/**
 	* Include the main player class  
 	*
 	*     
 	*/              
    include_once("class-baseball-tools-player.php");
 	/**
 	*Include the replace class for the handling of special circumstances in locations 
 	*     and colleges.
 	*     
 	*/              
  include_once("class-baseball-tools-player-replace.php");

?>