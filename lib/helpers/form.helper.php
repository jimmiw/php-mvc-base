<?php

/**
 * A form helper class, that makes it easier to create forms in the system.
 *
 * This class has been introduced, to make prettier code, when creating forms,
 * since you _had_ to add an <?php echo app_path(); ?>my_real_path to all
 * form tags, to ensure you application worked in subfolders.
 * 
 * I have also added some shorthand tags for the methods, so you can avoid 
 * using the object oriented approach if you do not want to.
 *
 * @author Jimmi Westerberg
 * @since 2011-03-30
 */
class FormHelper {
  // a constants defining the default enctype on a form
  const DEFAULT_ENCTYPE = 'application/x-www-form-urlencoded';
  
  /**
   * Creates the form start tag, using the given attributes
   * @param string $action the action (page) to send the form information to.
   * @param string $method the method to use, "post" is the default
   * @param string $enctype the enctype to set on the form, "application/x-www-form-urlencoded" is the default
   * @return string the form start tag
   */
  public function startTag($action, $method = 'post', $enctype = FormHelper::DEFAULT_ENCTYPE) {
    return sprintf(
      '<form method="%s" action="%s" enctype="%s">',
      $method,
      // using the addPath method from the lib/functions.php script, to add the
      // applications path to the action url
      _addPath($action),
      $enctype
    );
  }
  
  /**
   * Creates a form's end tag.
   * @return string a forms end tag.
   */
  public function endTag() {
    return '</form>';
  }
}

//
// Short hand functions for usage of the form helper
//

/**
 * Short hand for the "FormHelper->formTag" method call.
 */
function form_tag($action, $method = 'post', $enctype = FormHelper::DEFAULT_ENCTYPE) {
  $form = new FormHelper();
  
  return $form->startTag($action, $method, $enctype);
}

/**
 * Short hand for the "FormHelper->endTag" method call.
 */
function form_end() {
  $form = new FormHelper();
  return $form->endTag();
}

?>