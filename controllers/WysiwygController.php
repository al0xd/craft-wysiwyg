<?php

namespace Craft;
use FroalaEditor\File;
class WysiwygController extends BaseController
{
  public function actionUpload()
  {
    try {
      $options = array(
        'validation' => array(
          'allowedExts' => array('gif', 'jpeg', 'jpg', 'png', 'svg', 'blob'),
          'allowedMimeTypes' => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/svg+xml')
        ));
      $response = \FroalaEditor_File::upload('/uploads/wysiwyg/', $options);
      $this->returnJson($response);
    }
    catch (Exception $e) {
      http_response_code(404);
      $this->returnErrorJson($e);
    }
  }

  public function actionUploadFile()
  {
    try {
      $response = \FroalaEditor_File::upload('/uploads/wysiwyg_files/');
      $this->returnJson($response);
    }
    catch (Exception $e) {
      http_response_code(404);
      $this->returnErrorJson($e);
    }
  }

}