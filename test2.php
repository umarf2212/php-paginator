<?php

include("pagination.php");

$pag = new DBPagination();
$pag->rowsperpage = 5; //rows per page
$pag->links_range = 4; //range of links
$pag->dbdata = array("localhost", "root", "", "umarcms", "admin"); //database handles
$pag->add_sqlquery[0] = "WHERE id = $_GET[something]";
$pag->add_sqlquery[1] = "WHERE id = $_GET[something]";
$pag->d_prev = "Previous";
$pag->d_next = "Next"; 
$pag->d_first = "First";
$pag->d_last = "Last";
$pag->d_links_class "links_class";

function pp_main_content($umar){
	echo $umar['title']."<br />";
	echo $umar['content']."<br />";	
}

$pag->paginator();

?>