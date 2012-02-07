<?php
ERROR_REPORTING(0);
include("ezsql/ez_sql_core.php");
include("ezsql/ez_sql_mysql.php");

/** The database name of your baseball statistics database (that is compatible with Sean Forman's Baseball-Databank database  (http://baseball-databank.org) or Sean Lahman's Baseball Database http://www.seanlahman.com/baseball-archive/statistics/) */

	/** MySQL database name */
	define('BB_DB_NAME', 'database_name_here');
	
	/** MySQL database username */
	define('BB_DB_USER', 'username_here');
	
	/** MySQL database password */
	define('BB_DB_PASSWORD', 'password_here');
	
	/** MySQL hostname */
	define('BB_DB_SERVER', 'localhost');
	
$db = new ezSQL_mysql(BB_DB_USER,BB_DB_PASSWORD,BB_DB_NAME,BB_DB_SERVER);
if (! ($db->quick_connect(BB_DB_USER,BB_DB_PASSWORD,BB_DB_NAME))) {
  die("<b>Baseball Tools Error</b>:: Cannot connect to the database, did you set up the username and password in /lib/lib.php correctly?");
}


  
