<?php

class Mail {

    /** @var mixed variable to collect errors */
    private $error;

    /**
     * Name: sendMail
     * Description:
     * Sends an e-mail using PHP's native method.
     * returns true if the mail sent successfully false otherwise.
     * @author FRAMEWORK (modified by: Walter Conway to use only the native mailer, done before init github deposit)
     * @Date ?
     */
    public function sendMail($user_email, $from_email, $from_name, $subject, $body) {
        if (function_exists('mail')) {
            $result = mail($user_email, $subject, $body);
            if ($result == FALSE) {
                setError("Wasn't able to send the verification e-mail.");
                return FALSE;
            }
            return true;
        } else {
            setError("The Mail function is not enabled in PHP.");
            return FALSE;
        }
    }

    /**
     * Name: setError
     * Description:
     * sets an error 
     * @author FRAMEWORK
     * @Date ?
     * @param string $errorMessage
     */
    public function setError(string $errorMessage) {
        $this->error = $errorMessage;
    }

    /**
     * Name: getError
     * Description:
     * get the error that was previously set
     * @author FRAMEWORK
     * @Date 
     * @return type
     */
    public function getError() {
        return $this->error;
    }

}
