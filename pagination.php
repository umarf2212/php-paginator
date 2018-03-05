<?php
/*

    PHP Paginator is a free php script which you can use for displaying
	the results of MySQL Database tables. It is programmed with Object
	Oriented Programming of PHP (OOP) of Object Oriented PHP. This script
	is fully customizable and is powerful in what it is supposed to do.
	
    Copyright (C) 2012 - Umar Farooque (http://umarwebtechs.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.


*/

class DBPagination {

	public $rowsperpage; //number of rows to show per page
	public $add_sqlquery; //additional SQL Query
	public $dbdata = array(); //host, username, password and database name
	public $d_prev; //previous display link
	public $d_next; //next display link
	public $d_first; //first display link
	public $d_last; //last display links
	public $d_links_class; //class of the navigation links
	public $links_range; //range of links to show
	private $_conn; //private member holding the connection variable
	
	
public function paginator(){
/*

This method holds all the main functions and logics 
which are used for pagination of results we get
from the MySQL database provided during the
instatiation.

*/	
	
	//Connect to the database with user given values.
	$this->_conn = mysql_connect($this->dbdata[0], $this->dbdata[1], $this->dbdata[2]) or die("<h2>Error</h2>".mysql_error());
	
	//Now we have to select the database which
	//which is specified while instantiation.
	mysql_select_db($this->dbdata[3], $this->_conn) or die("<h2>Error</h2>".mysql_error());

/********************************/
	//this is the page number which gives the non-negative integer
	$paged = $_GET['page'];

	//Now we'll find the number of rows which exists in our
	//database's table.
	#########################################################
	//This is the SQL query that we are running, the table name
	//is specified by the users and result is run.
	$counter = "SELECT COUNT(*) FROM ".$this->dbdata[4]." ".$this->add_sqlquery;
	$result = mysql_query($counter, $this->_conn) or die("<h2>Error</h2>".mysql_error());
	$r = mysql_fetch_row($result);
	$numrows = $r[0];
		
	//To find the total pages that will be made according to
	//the number of rows found in the table, divide the number
	//of rows by the rows we have to show per page.
	###########################################################
	//As this is a regular maths division, there can come
	//decimal values, to get exact non-negative integer, we use
	//the ceil() function which rounds "up" any decimal number.
	$totalpages = ceil($numrows / $this->rowsperpage);
	
	//Now, we'll get the value of current page or set the value
	//of current page to default i.e. 1
	if (isset($paged) && is_numeric($paged)) {
	   //cast this variable as integer so that php understands
	   //that the variable can only have an integral value.
	   $page = (int) $paged;
	} else {
	   //or set a default page number that is 1
	   $page = 1;
	}
	
	//if current page is greater than total pages caste current page
	//equal to total pages i.e. the last page of the paginated results.
	if ($page > $totalpages) {
	   // set current page to last page
	   $page = $totalpages;
	}
	
	//if current page is less than first page caste the current page
	//eqaul to 1 i.e. the first page of the paginated results.
	if ($page < 1) {
	   // set current page to first page
	   $page = 1;
	}
	
	//this is the offset of the paginated results based on
	//current page
	$offset = ($page - 1) * $this->rowsperpage;
	
	
	//Now this is the SQL query which shows the main content with pagination.
	$sql2 = "SELECT * FROM ".$this->dbdata[4]." ".$this->add_sqlquery." LIMIT ".$offset.", ".$this->rowsperpage;
	$result = mysql_query($sql2, $this->_conn) or die("<h2>Error</h2>".mysql_error());
	
	//While loop which will display the results with pagination.
	while ($rows = mysql_fetch_assoc($result)){
		//Now here goes the main content.
		
		pp_main_content($rows); //this is the function made by user, the main
							//structure of the dipslay of results.
		
	echo "<br />";
	}//end while
	

	#############################################################
	/*
	Now these are the codes for displaying navigation links of 
	paginated results. These are too customizable.
	*/
	#############################################################

	//If these values of navigation handles are not defined or
	//are empty, give them the default display values.
	
	if (empty($this->d_prev)){
		$this->d_prev = "<";
	}
	if (empty($this->d_next)){
		$this->d_next = ">";
	}
	if (empty($this->d_first)){
		$this->d_first = "<<";
	}
	if (empty($this->d_last)){
		$this->d_last = ">>";
	}

//If the range of links is not defined, set a default value for it.
if (empty($this->links_range)){
	$this->links_range = 1; //to get the actual number of by-default links, i.e. 3 (2-1).
} else {
	$this->links_range -= 2; //to get the actual number of links as by user.
}

//If class is not defined for th enavigation links, give them
//a default class
if (empty($this->d_links_class)){
	$this->d_links_class = "pagi_default_class";
}

// if not on page 1, show back links
if ($page > 1) {
   // show first page link to go back to page 1
   echo "<a href='{$_SERVER['PHP_SELF']}?page=1' class='".$this->d_links_class."'>".$this->d_first."</a>\n";
   // get previous page num
   $prevpage = $page - 1;
   // show < link to go back to 1 page
   echo "<a href='{$_SERVER['PHP_SELF']}?page=$prevpage' class='".$this->d_links_class."'>".$this->d_prev."</a>\n";
} // end if 

// loop to show links to range of pages around current page
if ($this->links_range != "none"){

	for ($x = ($page - $this->links_range); $x < (($page + $this->links_range) + 1); $x++) {
		   // if it's a valid page number...
		   if (($x > 0) && ($x <= $totalpages)) {
			  // if we're on current page...
			  if ($x == $page) {
				 // 'highlight' it but don't make a link
				 echo "<b class='".$this->d_links_class."'>".$x."</b>\n";
			  // if not current page...
			  } else {
				 // make it a link
				 echo "<a href='{$_SERVER['PHP_SELF']}?page=$x' class='".$this->d_links_class."'>".$x."</a>\n";
			  } // end else
		   } // end if 
	} // end for

}//end if
                 
// if not on last page, show forward and last page links        
if ($page != $totalpages) {
   // get next page
   $nextpage = $page + 1;
    // echo forward link for next page 
   echo "<a href='{$_SERVER['PHP_SELF']}?page=$nextpage' class='".$this->d_links_class."'>".$this->d_next."</a>\n";
   // echo forward link for lastpage
   echo "<a href='{$_SERVER['PHP_SELF']}?page=$totalpages' class='".$this->d_links_class."'>".$this->d_last."</a>\n";
} // end if

}//end function paginator()

//Now __destruct() function, we'll close the connection with MySQL Database just after the last query
//was run. This is done automatically by Object Oriented PHP.
function __destruct(){
	mysql_close($this->_conn) or die("<h2>Error</h2>".mysql_error());
}

}//end class DBPagination


?>