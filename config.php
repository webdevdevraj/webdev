<?php //config.php

//other site settings

// Google reCAPTCHA v3 keys
// For reducing spam contact form submissions

// Site key (public)
$reCAPTCHA_site_key = '6LeOO3McAAAAAPk0N5Hmb3p9Um_7ZanI2_SnXqZH';

// Secret key
$reCAPTCHA_secret_key = '6LeOO3McAAAAAI6GB3EeQJAC_j2A1r3YFm-uAWL-';

// Min score returned from reCAPTCHA to allow form submission
$g_recaptcha_allowable_score = 0.5; //Number between 0 and 1. You choose this. Setting a number closer to 0 will let through more spam, closer to 1 and you may start to block valid submissions.
