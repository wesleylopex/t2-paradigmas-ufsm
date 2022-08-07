<?php

class FileModel extends CI_Model {
  public function __construct () {
    parent::__construct();
  }
  
  function removeFile (string $folderName, string $fileName, string $fileType) {
    $basePath = 'assets/uploads/'.$fileType.'s/';
    $filePath = $basePath . $folderName . $fileName;
    return $this->unlinkFile($filePath);
  }

  private function unlinkFile ($filePath) {
    if (!is_file($filePath)) {
      return false;
    }

    return @unlink($filePath);
  }

  public function uploadFile (
    string $folderName,
    string $fileName,
    string $fieldName,
    string $fileType,
    bool $resizeImage = true,
    bool $cropImage = false
  ) : array {
    $allowedTypesByFileType = [
      'video' => 'mp4',
      'file' => 'pdf|doc|docx|odt',
      'image' => 'gif|jpeg|jpg|png|svg'
    ];

    if (!array_key_exists($fileType, $allowedTypesByFileType)) {
      return ['success' => false, 'error' => 'Arquivo inválido'];
    }

    $settings = [
      'upload_path' => 'assets/uploads/'. $fileType . 's/' . $folderName,
      'allowed_types' => $allowedTypesByFileType[$fileType],
      'file_name' => setFileName($fileName),
      'file_ext_tolower' => true
    ];

    $this->load->library('upload', $settings);
    
    if (!$this->upload->do_upload($fieldName)) {
      return ['success' => false, 'error' => strip_tags($this->upload->display_errors())];
    }
    
    $uploadData = $this->upload->data();
    
    if ($fileType === 'image' && $cropImage === true) {
      $this->cropImage($uploadData);
    }

    if ($fileType === 'image' && $resizeImage === true) {
      $this->resizeImage($uploadData);
    }

    chmod($uploadData['full_path'], 0777);

    return ['success' => true, 'uploadData' => $uploadData];
  }

  private function cropImage (array $uploadData) {
    $this->load->library('image_lib');
      
    $imageWidth = $uploadData['image_width'];
    $imageHeight = $uploadData['image_height'];

    $resizeSettings = [
      'image_library' => 'gd2',
      'source_image' => $uploadData['full_path'],
      'maintain_ratio' => false
    ];

    $size = min($imageWidth, $imageHeight);

    $resizeSettings['width'] = $size;
    $resizeSettings['height'] = $size;

    $halfImageWidth = $imageWidth / 2;
    $halfImageHeight = $imageHeight / 2;
    
    $resizeSettings['x_axis'] = $halfImageWidth - ($size / 2);
    $resizeSettings['y_axis'] = $halfImageHeight - ($size / 2);

    $this->image_lib->clear();
    $this->image_lib->initialize($resizeSettings);
    $this->image_lib->crop();
  }

  private function resizeImage (array $uploadData) {
    if ($uploadData['image_width'] <= 400) {
      return false;
    }

    $this->load->library('image_lib');

    $resizeSettings = [
      'image_library' => 'gd2',
      'source_image' => $uploadData['full_path'],
      'maintain_ratio' => true,
      'width' => 400,
      'quality' => '60%'
    ];

    $this->image_lib->clear();
    $this->image_lib->initialize($resizeSettings);
    $this->image_lib->resize();
  }
}
