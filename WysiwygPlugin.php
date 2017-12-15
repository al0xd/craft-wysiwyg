<?php

namespace Craft;

class WysiwygPlugin extends BasePlugin
{
  protected $version = "2.7.2";
  public function getName() {
    return 'Wysiwyg Editor';
  }

  public function getVersion() {
    return '1.1.0';
  }

  public function getSchemaVersion() {
    return '1.0.0';
  }

  public function getDeveloper() {
    return 'Hung Dinh';
  }

  public function getDeveloperUrl() {
    return 'https://www.it-s.vn';
  }

  public function registerCpRoutes()
  {
    return array(
      "wysiwyg/upload" => array( 'action' => "wysiwyg/upload"),
      "wysiwyg/uploadFile" => array( 'action' => "wysiwyg/uploadFile"),
    );
  }


  public function init()
  {
    require_once __DIR__ . '/vendor/autoload.php';
    if ( craft()->request->isCpRequest() && craft()->userSession->isLoggedIn() )
    {
	    $pluginAvaiables = craft()->config->get('plugins', 'wysiwyg');
	    $thirdPartyPlugins = craft()->config->get('third_party', 'wysiwyg');

      craft()->templates->includeCSSFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css');
      craft()->templates->includeCSSFile('https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.2/css/froala_editor.min.css');
      craft()->templates->includeCSSFile('https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.2/css/froala_style.min.css');
      craft()->templates->includeJsResource("wysiwyg/froala_editor_2.7.2/js/froala_editor.min.js");


      craft()->templates->includeJsFile('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js');
      craft()->templates->includeJsFile('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js');

      foreach($pluginAvaiables as $handle => $plugin){
      	if( is_array($plugin) ){
		      if( ! isset($plugin["js"]) or $plugin["js"] == true ){
			      craft()->templates->includeJsResource("wysiwyg/froala_editor_2.7.2/js/plugins/$handle.min.js");
		      }
		      if( ! isset($plugin["css"]) or $plugin["css"] == true ) {
			      craft()->templates->includeCssResource("wysiwyg/froala_editor_2.7.2/css/plugins/$handle.css");
		      }
	      }else{
		      craft()->templates->includeJsResource("wysiwyg/froala_editor_2.7.2/js/plugins/$plugin.min.js");
		      craft()->templates->includeCssResource("wysiwyg/froala_editor_2.7.2/css/plugins/$plugin.css");
	      }
      }


	    foreach($thirdPartyPlugins as $handle => $plugin){
		    if( is_array($plugin) ){
			    if( ! isset($plugin["js"]) or $plugin["js"] == true ){
				    craft()->templates->includeJsResource("wysiwyg/froala_editor_2.7.2/js/third_party/$handle.min.js");
			    }
			    if( ! isset($plugin["css"]) or $plugin["css"] == true ) {
				    craft()->templates->includeCssResource("wysiwyg/froala_editor_2.7.2/css/third_party/$handle.css");
			    }
		    }else{
			    craft()->templates->includeJsResource("wysiwyg/froala_editor_2.7.2/js/third_party/$plugin.min.js");
			    craft()->templates->includeCssResource("wysiwyg/froala_editor_2.7.2/css/third_party/$plugin.css");
		    }
	    }

	    craft()->templates->includeCSSFile('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css');

    }
  }

}