<?php
    
    // Database configuration
    
    // Help Centre's own database.
    //
    // Requirements:
    //
    //   * Read access to entire database
    //   * Write access to 'issue', to update view count
    //   * Write access to 'searchterms' to log what users search for
    //   * Write access to 'rating' to save user feedback
    
    $helpDB = Array(
        'connection_string'  => 'mysql_host=__database_server__;dbname=__database_name__',
        'username'           => '__username__',
        'password'           => '__password__',
        'return_result_sets' => true
    )
    
    ORM::configure($helpDB, null, 'help');
    
    // Moodle database.
    //
    // Requirements:
    //
    //   * Read access to mdl_context and mdl_role_assignments to find which
    //     Moodle courses a user is a member of
    //   * Read access to mdl_user to find the Moodle internal user ID for a
    //     given GUID
    
    $moodleDB  = Array(
        'connection_string'  => 'mysql_host=__database_server__;dbname=__database_name__',
        'username'           => '__username__',
        'password'           => '__password__',
        'return_result_sets' => true
    )
    
    ORM::configure($moodleDB, null, 'moodle');
    
    // The URL where Help Centre can be found
    
    $cookieURL = 'moodleinspector.gla.ac.uk';
    $baseURL = 'http://moodleinspector.gla.ac.uk/help/';
        
?>