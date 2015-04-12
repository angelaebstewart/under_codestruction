<?php

class Mail {

    /** @var mixed variable to collect errors */
    private $error;

    /**
     * Sends an e-mail using PHP's native method.
     * returns true if the mail sent successfully false otherwise.
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
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
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     * @param string $errorMessage
     */
    public function setError(string $errorMessage) {
        $this->error = $errorMessage;
    }

    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     * @return type
     */
    public function getError() {
        return $this->error;
    }

}
