<?php
require_once '/autoload.php';
 
define("RECAPTCHA_V3_SECRET_KEY", '6LeOO3McAAAAAI6GB3EeQJAC_j2A1r3YFm-uAWL-');
  
if (isset($_POST['email']) && $_POST['email']) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
} else {
    // set error message and redirect back to form...
    header('location: subscribe_newsletter_form.php');
    exit;
}
 
$token = $_POST['token'];
$action = $_POST['action'];
 
// use the reCAPTCHA PHP client library for validation
$recaptcha = new \ReCaptcha\ReCaptcha(RECAPTCHA_V3_SECRET_KEY);
$resp = $recaptcha->setExpectedAction($action)
                  ->setScoreThreshold(0.5)
                  ->verify($token, $_SERVER['REMOTE_ADDR']);
 
 // verify the response
if ($resp->isSuccess()) {
    // valid submission
    // go ahead and do necessary stuff
} else {
    // collect errors and display it
    $errors = $resp->getErrorCodes();
}
