<?php if (!defined('BASEPATH')) exit('No direct script acess allowed');

function encode_crip (string $text) {
  return hashPassword($text);
}

function decode_crip (string $text) {
  return base64_decode($text);
}

function hashPassword (string $password) {
  $options = ['cost' => 12];
  return password_hash($password, PASSWORD_BCRYPT, $options);
}

function compareHash (string $password, string $hash): bool {
  return password_verify($password, $hash);
}

function arrayToFormDropdownOptions (array $records, string $value, string $label, bool $required = true, string $emptyLabel = '') {
  $options = $required === true ? [] : ['' => (!empty($emptyLabel) ? $emptyLabel : 'Todos os registros')];
  foreach ($records as $record) {
    $options[$record->$value] = $record->$label;
  }
  return $options;
}

function setFileName (string $fileName): string {
  $fileInfo = pathinfo($fileName);
  $extension = $fileInfo['extension'];
  $fileName = $fileInfo['filename'];
  
  return slugify($fileName). '-' . date('d-m-Y') . ".$extension";
}

function normalize (string $text): string {
  $table = [
    'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
    'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
    'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
    'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
    'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
    'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
    'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r',
  ];

  return strtr($text, $table);
}

function slugify (string $text): string {
  $text = normalize($text);
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

function antiInjection (string $field, bool $addSlashes = false): string {
  $field = preg_replace('/(from|alter table|select|insert|delete|update|where|drop table|show tables|#|\*|--|\\\\)/i', '', $field);
  $field = trim($field);
  $field = strip_tags($field);

  if ($addSlashes) {
    $field = addslashes($field);
  }

  return $field;
}

function emailIsValid (string $email): bool {
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return false;
  }

  return true;
}
