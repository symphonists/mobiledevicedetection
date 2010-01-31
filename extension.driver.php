<?php
 
  Class extension_mobiledevicedetection extends Extension
  { 
    /*-------------------------------------------------------------------------
      Extension definition
    -------------------------------------------------------------------------*/
    
    public function about()
    {
      return array(
        'name' => 'Mobile Device Detection',
        'version' => '1.0',
        'release-date' => '2010-01-28',
        'author' => array(
          'name' => 'Max Wheeler',
          'email' => 'max@makenosound.com',
        )
      );
    }
 }