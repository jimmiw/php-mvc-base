<?php
function topLayout($title_for_layout) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title><?php echo $title_for_layout; ?> - WIP</title>
	<meta name="keywords" content="company message private talk" />
	<meta name="description" content="Post messages privately in your company" />
	<!--<script type="text/javascript" src="<?php echo get_javascript('jquery-1.4.1.min.js');?>"></script>-->
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet('stylesheet.css'); ?>" />
</head>
<body>

<?php
} // topLayout ENDS
?>

<?php
function bottomLayout() {
?>

</body>
</html>
<?php
} // bottomLayout ENDS
?>
