<?php
namespace Craft;

class WysiwygFieldType extends BaseFieldType implements IPreviewableFieldType
{
  public function getName() {
    return Craft::t('Wysiwyg');
  }

  public function defineContentAttribute() {
    return AttributeType::Mixed;
  }


	public function getInputHtml($name, $value) {


    $inputId = craft()->templates->formatInputId($name);
    $namespacedId = craft()->templates->namespaceInputId($inputId);

    craft()->templates->includeJs("$(function(){ $('#{$namespacedId}').froalaEditor({
      imageUploadParam: 'file',
      imageUploadParams: {CRAFT_CSRF_TOKEN: $('input[name=CRAFT_CSRF_TOKEN]').val() },
      imageUploadURL: '". UrlHelper::getActionUrl('wysiwyg/upload') ."',
      imageAllowedTypes: ['jpeg', 'jpg', 'png'],
      
      fileUploadParam: 'file',
      fileUploadParams: {CRAFT_CSRF_TOKEN: $('input[name=CRAFT_CSRF_TOKEN]').val() },
      fileUploadURL: '". UrlHelper::getActionUrl('wysiwyg/uploadFile') ."',
      fileAllowedTypes: ['*']
    })
    });");


    return craft()->templates->renderMacro('_includes/forms', 'textarea', array(
      array(
        'name'  => $name,
        'id' => $name,
        'value' => $value,
      ),
    ));
  }

  public function prepValueFromPost($value) {
    if ($value)
    {
      // Prevent everyone from having to use the |raw filter when outputting RTE content
      $charset = craft()->templates->getTwig()->getCharset();
      return new RichTextData($value, $charset);
    }
    else
    {
      return null;
    }
  }



  public function prepValue($value)
  {
    if ($value)
    {
      // Prevent everyone from having to use the |raw filter when outputting RTE content
      $charset = craft()->templates->getTwig()->getCharset();
      return new WysiwygModel($value, $charset);
    }
    else
    {
      return null;
    }
  }



}