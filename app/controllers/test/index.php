<?php

// This is your controller.

// Have your database selects here (if not in models elsewhere)

// example, setting a variable that is to be used in the view. This could
// have been data fetched from a database select as well.

$some_data = "data from the controller";

// To execute the view, use the following include:
include('views/test/index.view.php');

// using .inc. in the view name is just a personal preference.

// A small tip is to use the same name for the view folder 
// as for the controller folder. This way, things won't get mixed up later on

?>
