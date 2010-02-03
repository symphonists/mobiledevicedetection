<?php

  require_once(TOOLKIT . '/class.datasource.php');
  Class datasourcemobiledevicedetection extends Datasource{
    
    public function __construct(&$parent, $env=NULL, $process_params=true)
    {
      parent::__construct($parent, $env, $process_params);
      $this->_dependencies = array();
    }
    
    public function about()
    {
      return array(
           'name' => 'Mobile Device Detection',
           'author' => array(
              'name' => 'Max Wheeler',
              'website' => 'http://makenosound.com/'),
           'version' => '1.0',
           'release-date' => '2010-01-28');
    }
      
    public function allowEditorToParse()
    {
      return false;
    }
    
    public function grab(&$param_pool)
    {
      $xml = new XMLElement('device');
      $xml->setAttribute('mobile', ($this->is_mobile()) ? "true" : "");
      $xml->setAttribute('iphone', ($this->is_iphone()) ? "true" : "");
      return ($xml);
    }
    
    # Check if request is from an iPhone
    private function is_iphone()
    {
      return strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
    }
    
    # Check if request is from an mobile device
    private function is_mobile()
    {
      if(isset($_SERVER["HTTP_X_WAP_PROFILE"])) return true;
      if(preg_match("/wap\.|\.wap/i",$_SERVER["HTTP_ACCEPT"])) return true;
      if(isset($_SERVER["HTTP_USER_AGENT"]))
      {
        # Kill matches in the user agent that might cause false positives
        $bad_matches = array("OfficeLiveConnector","MSIE\ 8\.0","OptimizedIE8","MSN\ Optimized","Creative\ AutoUpdate","Swapper");
        foreach($bad_matches as $bad_string)
        {
          if(preg_match("/" . $bad_string . "/i", $_SERVER["HTTP_USER_AGENT"])) return false;
        }
        
        # Positive matches
        $ua_matches = array(
          "midp",
          "j2me",
          "avantg",
          "docomo",
          "novarra",
          "palmos",
          "palmsource",
          "240x320",
          "opwv",
          "chtml",
          "pda",
          "windows\ ce",
          "mmp\/",
          "blackberry",
          "mib\/",
          "symbian",
          "wireless",
          "nokia",
          "hand",
          "mobi",
          "phone",
          "cdm",
          "up\.b",
          "audio",
          "SIE\-",
          "SEC\-",
          "samsung",
          "HTC",
          "mot\-",
          "mitsu",
          "sagem",
          "sony",
          "alcatel",
          "lg",
          "erics",
          "vx",
          "NEC",
          "philips",
          "mmm",
          "xx",
          "panasonic",
          "sharp",
          "wap",
          "sch",
          "rover",
          "pocket",
          "benq",
          "java",
          "pt",
          "pg",
          "vox",
          "amoi",
          "bird",
          "compal",
          "kg",
          "voda",
          "sany",
          "kdd",
          "dbt",
          "sendo",
          "sgh",
          "gradi",
          "jb",
          "\d\d\di",
          "moto",
          "webos"
        );

        foreach($ua_matches as $ua_string){
          if(preg_match("/" . $ua_string . "/i", $_SERVER["HTTP_USER_AGENT"])) return true;
        }
      }
      return false;
    }
  }
