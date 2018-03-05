# php-paginator


-   [Full Use](#full-use)
-   [FAQs](#faqs)
-   [License](license.txt)
-   [Help](#help)
-   [PHP Paginator UWT Section](http://umarwebtechs.com/php-paginator)

About
-----

**PHP Paginator** is a free script developed under the GNU General
Public License. This script allows you to paginate the results of MySQL
Database's tables. **PHP Paginator** is developed with **Object Oriented
Programming** techniques and hence is very powerful and fully
customizable.\
\
 You can use it as many times as you want by just including a single php
file. As it is programmed in OOP, you have to use very less source code
to generate the results with pagination. \
\
 All you need is just to create a new object with a class that is
already programmed. Define some variables, and you're done.

How to Use
----------

This is all about how to use the PHP Paginator script.\

### Basic

This is the basic use of PHP Paginator. Everything inside this code is
going to be explained.

    <?php
    include("pagination.php");

    $pag = new DBPagination();
    $pag->rowsperpage = 3; //rows per page
    $pag->links_range = 5; //range of links
    $pag->dbdata = array("localhost", "root", "", "umarcms", "admin"); //database handles

    function pp_main_content($rows){
        echo "<h2>".$rows['title']."</h2>";
        echo "<p>".$rows['content']."</p>";
    }

    $pag->paginator();

    ?>

**\$pag-\>paginator();** is the main function which runs the whole
script.

Read these FAQs which describe all about PHP Paginator and problems
troubleshooting.\
 But if you want to get a quick full illustration of the codes used for
this script, go to [Full Use](#full-use)

### FAQs

![](arrow.png)  **How to include the Main Source File ?**\

Name of the main source file is **pagination.php** and to include it,
simply use :-

    <?php
    include("pagination.php");
    ?>

![](arrow.png)  **How to make the object and what's the main Class ?**\

Name of the main class inside which all the coding work is done is
**DBPagination** and to make an object with the class, simply use this
code :-

    <?php
    include("pagination.php");

    $pag = new DBPagination();

    ?>

Don't forget to include the main source file i.e. **pagination.php**.
Instead of **\$pag** name, you can use any name of the variable of your
choice (this is the basic information for those who don't know OOP).

![](arrow.png)  **List of all available & customizable variables ?**\

-   **\$pag-\>rowsperpage**: the value of this variable is numerical.
    You can only give a non-negative integral value to this variable.
    The value of this variable will decide the number of rows or results
    to show per page.
-   **\$pag-\>add\_sqlquery**: this is an array with maximum two values
    i.e. of 0 and 1 indexes. This is an opional array which is used for
    adding extra query to the variable of mysqlquery. Means for the
    first and second index of this array, you can put extra MySQL
    query's clauses like WHERE, ORDER BY etc.\
     **You can use it like this :-**

        <?php
        include("pagination.php");

        $pag = new DBPagination();

        $pag->add_sqlquery = "WHERE id = $_GET['somevalue1']";
        $pag->add_sqlquery = "WHERE id = $_GET['somevalue2']";

        ?>

    Or use same values for both indexes.

-   **\$pag-\>dbdata**: this is also an array with 5 indexes that are 0,
    1, 2, 3 and 4 which holds the information about you MySQL Database.
    See the values coressponding to the index number :- \
     **0** - Your **Host** of Database \
     **1** - **Username** of Database \
     **3** - **Password** of Database \
     **4** - **Name** of Database to use \
     **5** - **Table which** exists in the given Database \
    \
     You can use it like this :-

        <?php
        include("pagination.php");

        $pag = new DBPagination();

        $pag->dbdata = array("localhost", "username", "password", "database_name", "table_name");

        ?>

-   **\$pag-\>d\_prev | \$pag-\>d\_next | \$pag-\>d\_first |
    \$pag-\>d\_last**: these four variables are similar in use. These
    variables handle the display of navigation links to navigate to
    First, Last, Next and Previous pages. The default values for these
    variables are \<\<, \>\>, \>, \< respectively in case if you don't
    provide.
-   **\$pag-\>d\_links\_class**: this is the CSS class for the
    navigation links in the preceding example.
-   **\$pag-\>links\_range**: this is the range of number of links to
    show for pagination. This variable has numerical value.

And here ends all the variables.

![](arrow.png)  **How to implement the main content ?**\

Now, to do this, you have to create a function named
**pp\_main\_content(\$rows)** and inside this function, put all the SQL
content to show. Here's a quick illustration to understand it easily.

    <?php
    include("pagination.php");

    $pag = new DBPagination();

    //This is in a file called file1.php
    function pp_main_content($rows){
        echo $rows['Title']."<br />;
        echo $rows['Posts'];
    }

    //This is in another file called file2.php
    function pp_main_content($list){
        echo $list['Title']."<br />;
        echo $list['Posts'];
    }

    ?>

So, that's how you can make the content. Whatever you put inside this
function, it is put by the script in the **while loop** of the main
source file. See the **bold** variables, you can use the name of the
variables according to your choice.\
\
 Remember, don't create the function in the same file again once after a
single use or don't use it in the two files that are combined together
by **include** or **require** functions. Because PHP will not be able to
redeclare the function again.

A look at full Use of the script {#full-use}
--------------------------------

This is the full use of available variables and is fully customized
illustration.

    <?php

    include("pagination.php");

    $pag = new DBPagination();
    $pag->rowsperpage = 5; //rows per page
    $pag->links_range = 4; //range of links
    $pag->dbdata = array("localhost", "root", "", "umarcms", "admin"); //database handles
    $pag->add_sqlquery = "WHERE id = $_GET[something]";
    $pag->add_sqlquery = "WHERE id = $_GET[something]";
    $pag->d_prev = "Previous";
    $pag->d_next = "Next"; 
    $pag->d_first = "First";
    $pag->d_last = "Last";
    $pag->d_links_class = "links_class";

    function pp_main_content($umar){
        echo $umar['title']."<br />";
        echo $umar['content']."<br />";   
    }

    $pag->paginator();

    ?>

**\$pag-\>paginator();** is the main function which runs the whole
script.

Copyright © 2012 - PHP Paginator by [Umar
Farooque.](http://codeforeal.com)
