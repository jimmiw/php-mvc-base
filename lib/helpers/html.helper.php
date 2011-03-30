<?php

/**
 * A helper for various HTML methods.
 *
 * @author Jimmi Westerberg
 * @since 2011-03-30
 */
class HtmlHelper {
  /**
   * Constructs an a-tag, using the given data.
   * @param string $contents the contents to have inside the link
   * @param string $url the url to link to
   * @param array $htmlOptions the options to add to the link (e.g. the class, style etc)
   * @return string the a-tag constructed, using the given details.
   */
  public function linkTo($contents, $url, $htmlOptions = array()) {
    $options = "";
    // runs through the HTML options and adds the keys and values
    // one by one.
    foreach($htmlOptions as $key => $value) {
      $options .= sprintf(
        ' %s="%s"',
        $key,
        $value
      );
    }

    // completes the a-tag
    $tag = sprintf(
      '<a href="%s"%s>%s</a>',
      addPath($url),
      $options,
      $contents
    );

    return $tag;
  }
  
  /**
   * Creates a html image element, using the given image src and the options array.
   * @param $image, the image src.
   * @param $options, an array with additional options to set.
   * @return returns the html image element, with a src set to the given image.
   */
  public function imageTag($image, $options = null) {
    $htmlImage = '<img src="';
    $htmlImage .= app_path('image').$image;
    $htmlImage .= '"';
    $htmlImage .= ' alt="';
    $htmlImage .= (isset($options) && isset($options['alt'])? $options['alt'] : $image);
    $htmlImage .= '"';

    if(isset($options) && isset($options['class']) && $options['class'] != "") {
      $htmlImage .= ' class="'.$options['class'].'"';
    }
    if(isset($options) && isset($options['id']) && $options['id'] != "") {
      $htmlImage .= ' id="'.$options['id'].'"';
    }
    if(isset($options) && isset($options['style']) && $options['style'] != "") {
      $htmlImage .= ' style="'.$options['style'].'"';
    }

    $htmlImage .= '" />';
    return $htmlImage;
  }
  
  /**
   * Helper function for finding the correct path of the given stylesheet
   * in the system
   * When linking to stylesheets, always remember to put them in the 
   * /public/stylesheets folder. You can have subfolders in the folder etc.
   *
   * Usage:
   * <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet('my_css.css'); ?>" />
   * This goes into your head section of your layout document.
   *
   * @param $stylesheet, the stylesheet you are trying to link to.
   * @return the path of the given stylesheet.
   */
  function stylesheetTag($stylesheet) {
    $tag = sprintf(
      '<link rel="stylesheet" type="text/css" href="%s%s" />',
      app_path('stylesheet'),
      $stylesheet
    );

    return $tag;
  }


  /**
   * Helper function for finding the correct path of the given javascript
   * in the system.
   * When linking to javascripts, always remember to put them in the 
   * /public/javascripts folder. You can have subfolders in the folder etc.
   *
   * Usage:
   * <?php echo javascript_include_tag('my_js.js');?>
   * This goes into your head section of your layout document.
   *
   * @param $javascript, the javascript you are trying to link to.
   * @return the path of the given stylesheet.
   */
  public function javascriptIncludeTag($javascript) {
    $tag = sprintf(
      '<script type="text/javascript" src="%s%s"></script>',
      app_path('javascript'),
      $javascript
    );

    return $tag;
  }
}

//
// Shorthand tags for the HTML helper class
//

/**
 * Shorthand for the HtmlHelper->linkTo method.
 */
function link_to($contents, $url, $htmlOptions = array()) {
  $html = new HtmlHelper();
  return $html->linkTo($contents, $url, $htmlOptions);
}

/**
 * Shorthand for the HtmlHelper->imageTag method.
 */
function image_tag($image, $options = null) {
  $html = new HtmlHelper();
  return $html->imageTag($image, $options);
}

/**
 * Shorthand for the HtmlHelper->stylesheetTag method.
 */
function stylesheet_tag($stylesheet) {
  $html = new HtmlHelper();
  return $html->stylesheetTag($stylesheet);
}

/**
 * Shorthand for the HtmlHelper->javascriptIncludeTag method.
 */
function javascript_include_tag($javascript) {
  $html = new HtmlHelper();
  return $html->javascriptIncludeTag($javascript);
}

?>