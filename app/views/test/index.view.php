<?php

// constructs a layout array, which can hold basically anything.
//
// NOTE: Optional!
// Here i'm just adding a title that is to be used in the top layout file.
$layout = array(
  'title' => "Test of php-mvc-base"
);

// including the layout file that renders the top part of the page.
// (headers, title etc)
include('views/layouts/default.top.layout.php');

?>

<p>This written from the view!</p>

<?php 

// Writes data that is "sent" from the controller
// Actually it's just a variable that was created in the controller, ready to
// be used in the view. It could be anything.
// (Used for splitting up the controller / view responsibilities)
echo "<p>".$some_data."</p>";


// including the layout file that renders the bottom part of the page.
include('views/layouts/default.bottom.layout.php');

?>