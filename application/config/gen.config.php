<?php

/**
 * This is an associated array list, for general website configurations.
 */
return array(
    /**
     * Configuration for: Base URL
     * This detects your URL/IP incl. sub-folder automatically. You can also deactivate auto-detection and provide the
     * URL manually. This should then look like 'http://192.168.33.44/' ! Note the slash in the end.
     */
    //Uncomment this line and delete the following line for production.
    //'URL' => 'https://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),
    'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),
    /**
     * Configuration for: Folders
     * Usually there's no reason to change this.
     */
    'PATH_CONTROLLER' => realpath(dirname(__FILE__) . '/../../') . '/application/controller/',
    'PATH_VIEW' => realpath(dirname(__FILE__) . '/../../') . '/application/view/',
    /**
     * Configuration for: Default controller and action
     */
    'DEFAULT_CONTROLLER' => 'login',
    'DEFAULT_ACTION' => 'index',
    /*
     * Configuration for phpass
     * HASH_COST_LOG2 - Base-2 logarithm of the iteration count used for password stretching
     * HASH_PORTABLE - Do we require the hashes to be portable to older systems (less secure)?
     */
    'HASH_COST_LOG2' => '8',
    'HASH_PORTALBE' => 'FALSE',
    /*
     * What Token is used to id a teacher or student.
     */
    'ROLE_STUDENT' => 1,
    'ROLE_TEACHER' => 2,
);
