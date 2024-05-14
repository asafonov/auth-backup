<?php

const DATA_DIR = './data/';
const TRANSPORT_EMAIL = 'email';
const KEY_LENGTH = 6;
const TRANSPORT = TRANSPORT_EMAIL;

function getDataFilename ($user_id) {
  return DATA_DIR . $user_id;
}

function getKeyFilename ($user_id) {
  return DATA_DIR . "$user_id.key";
}

function userExists ($user_id) {
  isTransportFormatted($user_id) && file_exists(getDataFilename($user_id));
}

function replaceParam ($user_id) {
  if (TRANSPORT === TRANSPORT_EMAIL) {
    return preg_replace('/[^A-z0-9_\.@\-\+]/i', '', $user_id);
  }
}

function isTransportFormatted ($user_id) {
  if (TRANSPORT === TRANSPORT_EMAIL) {
    return preg_match('/^[A-z0-9_\+\-\.]+@[A-z0-9_\-\.]+\.[A-z0-9]+$/i', $user_id);
  }
}

function genKey() {
  $max = pow(10, KEY_LENGTH - 1);
  $rand = rand(0, $max);
  $len = strlen($rand);

  for ($i = 0; $i < KEY_LENGTH - $len; ++$i) {
    $rand = "0$rand";
  }

  return $rand;
}

function sendKey ($user_id, $key) {
  if (TRANSPORT === TRANSPORT_EMAIL) {
    $to = $user_id;
    $subject = 'key';
    $message = $key;
    mail($to, $subject, $message);
  }
}

if (isset($_POST['user_id']) && isset($_POST['key'])) {
} elseif (isset($_POST['user_id'])) {
} elseif (isset($_GET['user_id'])) {
  $user_id = replaceParam($_GET['user_id']);

  if (userExists($user_id)) {
    $key = genKey();
    sendKey($user_id, $key);
    saveKey($user_id, $key);
  }
}
