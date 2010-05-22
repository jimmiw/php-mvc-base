<?php

// including the layout file.
include('views/layouts/default.layout.php');

// renders the top part of the layout
// the string given, is the title of the current page
echo topLayout("Test of php-mvc-base");

?>

<p>this is the view!</p>

<?php 

// Writing out the data sent from the controller
echo "<p>".$some_data."</p>";

?>