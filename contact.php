<?php  //contact.php

    require_once('config.php');

    //do server-side validation of other form fields

    if (/*form has been submitted and has passed server-side validation of the other form fields*/) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $url =  'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($reCAPTCHA_secret_key) . '&response=' . urlencode($g_recaptcha_response) . '&remoteip=' . urlencode($ip);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response, true);

        if ($responseKeys["success"] && $responseKeys["action"] == 'contactForm') {
            if ($responseKeys["score"] >= $g_recaptcha_allowable_score) {
                //send email with contact form submission data to site owner/ submit to database/ etc
                //redirect to confirmation page or whatever you need to do
            } elseif ($responseKeys["score"] < $g_recaptcha_allowable_score) {
                //failed spam test. Offer the visitor the option to try again or use an alternative method of contact.
            }
        } elseif($responseKeys["error-codes"]) { //optional
            //handle errors. See notes below for possible error codes
            //(I handle errors by sending myself an email with the error code for debugging and offering the visitor the option to try again or use an alternative method of contact)
        } else {
            //unkown screw up. Again, offer the visitor the option to try again or use an alternative method of contact.
        }

        exit;

    } else { //(re)display the page with the form

        echo <<<_END

            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <title>Contact | Your website</title>
                    <link rel="stylesheet" href="css/style.css">
                    <script src="https://www.google.com/recaptcha/api.js?render=6LeOO3McAAAAAPk0N5Hmb3p9Um_7ZanI2_SnXqZH"></script>
                </head>
                <body>

                    <!-- header etc -->

                    <form id="contactForm" method="post" action="contact">
                        //other form inputs
                        <input type="hidden" id="gRecaptchaResponse" name="gRecaptchaResponse">
                        <input type="submit" name="contact_submit" value="Send message">
                    </form>
                    <script>
                        contactForm.addEventListener('submit', event => {
                            event.preventDefault()
                            validate(contactForm)
                        });
                    </script>

                    <!-- footer etc -->

                    <script>
                        function validate(form) {
                            //perform optional client-side error checking of the form. If no errors are found then request a token and put it into the hidden field. Finally submit the form.
                            getRecaptchaToken(form)
                        }

                        //some (optional) form field validation functions

                        function getRecaptchaToken(form) {
                            grecaptcha.ready(function() {
                                grecaptcha.execute(6LeOO3McAAAAAPk0N5Hmb3p9Um_7ZanI2_SnXqZH, {action: 'contactForm'}).then(function(token) {
                                    gRecaptchaResponse.value = token
                                    form.submit()
                                });
                            });
                        }
                    </script>
                </body>
            </html>

_END;
