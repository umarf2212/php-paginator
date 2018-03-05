<?php

include("pagination.php");

$pag = new DBPagination();
$pag->rowsperpage = 3; //rows per page
$pag->links_range = "none"; //range of links
$pag->dbdata = array("localhost", "root", "", "umarcms", "admin"); //database handles
$pag->d_prev = "Previous";
$pag->d_next = "Next"; 
$pag->d_first = "First";
$pag->d_last = "Last";

function pp_main_content($rows){
	echo "<h2>".$rows['Title']."</h2>";
	echo "<p>".$rows['Posts']."</p>";
}

$pag->paginator();

?>