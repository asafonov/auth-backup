<?php

const DATA_DIR = './data/';

function getDataFilename ($user_id) {
  return DATA_DIR . $user_id;
}

function getKeyFilename ($user_id) {
  return DATA_DIR . "$user_id.key";
}

function userExists ($user_id) {
  isEmail($user_id) && file_exists(getDataFilename($user_id));
}

function replaceParam ($user_id) {
  return preg_replace('/[^A-z0-9_\.@\-\+]/i', '', $user_id);
}

function isEmail ($email) {
  return preg_match('/^[A-z0-9_\+\-\.]+@[A-z0-9_\-\.]+\.[A-z0-9]+$/i', $email);
}

if (isset($_POST['user_id']) && isset($_POST['key'])) {
} elseif (isset($_POST['user_id'])) {
} elseif (isset($_GET['user_id'])) {
  $user_id = replaceParam($_GET['user_id']);

  if (userExists($user_id)) {
  }
}
