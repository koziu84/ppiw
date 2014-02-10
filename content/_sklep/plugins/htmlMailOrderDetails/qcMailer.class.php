<?php
/*
* qcMailer.class.php, part of htmlMailOrderDetails plugin
* Wizzud: 31/01/06
*/
require_once DIR_PLUGINS.'htmlMailOrderDetails/phpmailer/class.phpmailer.php';

if(!class_exists('qcMailer')){
  class qcMailer extends PHPMailer{
    var $bSendToAdmin = false;
    var $bSendToClient = false;
    var $bResendToAdmin = false; // temporary override
    var $bResendToClient = false; // temporary override
    var $sShopFolder; // with trailing slash
    var $sTemplate;
    var $sSubjectAdmin;
    var $sSubjectClient;
    var $sMailBody;
    var $sMailAltBody;
    var $sAdministrator;
    var $sTo;
    var $sToName;
    var $iInterceptID;
    var $bAdmin = false; // running from Admin?
    var $bEchoErrors = false;
    var $bShowAndStop = false;
    var $bHtmlAdmin = false;
    var $bTextAdmin = false;
    var $bHtmlClient = false;
    var $bTextClient = false;

    /* Constructor
    * @return object qcMailer
    */
    function qcMailer(){
      global $config, $lang;
      $this->bAdmin = (basename($_SERVER['PHP_SELF']) == 'admin.php');
      $this->sShopFolder = dirname( ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='') ? 'https' : 'http' ) . "://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}" ) . '/';
      $this->bSendToAdmin = (isset($config['hmod']['sendAdmin']) && $config['hmod']['sendAdmin'] === true);
      $this->bSendToClient = (isset($config['hmod']['sendClient']) && $config['hmod']['sendClient'] === true);
      // make sure the subjects have no new lines or carriage returns ...
      $this->sSubjectClient = preg_replace(array("/[\n\r]/"), array(" "), $lang['hmodSubjectClient']);
      $this->sSubjectAdmin = preg_replace(array("/[\n\r]/"), array(" "), $lang['hmodSubjectAdmin']);
      $this->sMailBody = $this->sMailAltBody = '';
      $this->sTemplate = 'htmlMailOrderDetails.tpl';
      $this->sTo = '';
      $this->sAdministrator = $config['hmod']['adminName'];
      $this->iInterceptID = null;
      $this->bResendToAdmin = $this->bResendToClient = false;
      $this->bEchoErrors = (isset($config['hmod']['reportErrors']) && $config['hmod']['reportErrors'] === true) ? true : false;
      $this->bShowAndStop = (isset($config['hmod']['showAndStop']) && $config['hmod']['showAndStop'] === true) ? true : false;

      if (!isset($config['shop_root'])) $config['shop_root'] = $this->sShopFolder;

      $this->CharSet = $config['charset'];
      $this->SetLanguage($config['language'],DIR_PLUGINS.'htmlMailOrderDetails/phpmailer/language/');
      switch($config['hmod']['method']){
        case 'sendmail':
          $this->IsSendmail(); if($config['hmod']['sendmailPath']!='') $this->Sendmail = $config['hmod']['sendmailPath']; break;
        case 'qmail':
          $this->IsQmail(); if($config['hmod']['qmailPath']!='') $this->Sendmail = $config['hmod']['qmailPath']; break;
        case 'smtp':
          $this->IsSMTP();
          $this->Host = $config['hmod']['smtpHosts'];
          if($config['hmod']['smtpPort'] > 0) $this->Port = $config['hmod']['smtpPort'];
          $this->SMTPAuth = $config['hmod']['smtpAuth'];
          if($this->SMTPAuth){ $this->Username = $config['hmod']['smtpUser']; $this->Password = $config['hmod']['smtpPword']; }
        case 'mail':
        default:
          $this->IsMail();
      }
      $this->bHtmlAdmin = in_array($config['hmod']['formatAdmin'], array('html','both'));
      $this->bTextAdmin = in_array($config['hmod']['formatAdmin'], array('text','both'));
      $this->bHtmlClient = in_array($config['hmod']['formatClient'], array('html','both'));
      $this->bTextClient = in_array($config['hmod']['formatClient'], array('text','both'));
      // if config says we can send neither HTML nor Text then we can't send anything! ...
      if(!$this->bHtmlAdmin && !$this->bTextAdmin){ $this->bSendToAdmin = false; }
      if(!$this->bHtmlClient && !$this->bTextClient){ $this->bSendToClient = false; }
      $this->WordWrap = 70;
      $this->From = EMAIL;
      $this->FromName = $GLOBALS['config']['title'];
      $this->AddReplyTo(EMAIL);
    } // end function qcMailer

/********************/
/* PUBLIC FUNCTIONS */
/********************/
// GETTERS
    /* Gets the template
    * @return string
    */
    function getTemplate(){
      return $this->sTemplate;
    } // end function getTemplate

    /* Returns false if the intercept has not YET been set (at all)
    * @return boolean
    */
    function isSetIntercept(){
      return is_null($this->iInterceptID) ? false : true;
    }

    /* Gets the current intercept for access via $tpl; returns false if not yet set
    * @return integer
    */
    function getInterceptID(){
      return is_null($this->iInterceptID) ? false : $this->iInterceptID;
    }

    /* Gets the shop URL
    * @return string
    */
    function getShopURL(){
      return $this->sShopFolder;
    }

// SETTERS
    /* Sets the email address of the client
    * @param integer order number
    * @return void
    */
    function setSendTo($sTo = '', $sToName = '') {
      $this->sTo = $sTo;
      $this->sToName = $sToName;
    } // end function setSendTo

    /* Sets the body of the order
    * @param integer order number
    * @return void
    */
    function setMailBody($sContent = '') {
      $this->sMailBody = $sContent;
    } // end function setMailBody

    /* Sets the current intercept
    * @param integer
    * @return void
    */
    function setInterceptID($intercept){
      $this->iInterceptID = $intercept;
    }

    /* Sets error reporting flag
    * @param boolean reportErrors
    */
    function setErrorReporting($reportErrors=true){
      $this->bEchoErrors = is_bool($reportErrors) ? $reportErrors : false;
    }

    /* Send Email
    * @return void
    */
    function Send(){
      if(($this->bSendToClient || $this->bResendToClient || $this->bSendToAdmin || $this->bResendToAdmin) && $this->sMailBody != ''){
        if($this->bTextAdmin || $this->bTextClient){ $this->_formatAsText(); } // we need a text-only version
        if($this->bShowAndStop){
          if($this->bHtmlAdmin || $this->bHtmlClient){ echo $this->sMailBody; }
          if($this->bTextAdmin || $this->bTextClient){ echo $this->sMailAltBody; }
          exit();
        }
      }
      // Only send to client/customer if there is something to send and somewhere to send it to ...
      if(($this->bSendToClient || $this->bResendToClient) && $this->sMailBody != '' && $this->sTo != ''){
        $this->IsHTML($this->bHtmlClient);
        $this->Body = $this->bHtmlClient ? $this->sMailBody : $this->sMailAltBody;
        $this->AltBody = ($this->bHtmlClient && $this->bTextClient) ? $this->sMailAltBody : '';
        $this->Subject = $this->sSubjectClient;
        $this->AddAddress($this->sTo, $this->sToName);
        if(!parent::Send()){
          if($this->bEchoErrors){ echo $this->ErrorInfo; }
        }
        $this->ClearAddresses();
      }
      // Only send to admin if there is something to send ...
      if(($this->bSendToAdmin || $this->bResendToAdmin) && $this->sMailBody != ''){
        $this->IsHTML($this->bHtmlAdmin);
        $this->Body = $this->bHtmlAdmin ? $this->sMailBody : $this->sMailAltBody;
        $this->AltBody = ($this->bHtmlAdmin && $this->bTextAdmin) ? $this->sMailAltBody : '';
        $this->Subject = $this->sSubjectAdmin;
        $this->AddAddress(EMAIL, $this->sAdministrator);
        if(!parent::Send()){
          if($this->bEchoErrors){ echo $this->ErrorInfo; }
        }
      }
      $this->setMailBody(); $this->setSendTo(); $this->sMailAltBody = ''; // make sure we can't send previous data
    } // end function Send

    /* (Re)sends emails
    * @param integer order number
    * @param boolean toClient
    * @param boolean toAdmin
    * @return void
    */
    function reSend($order, $toClient=null, $toAdmin=null){
      $this->bResendToAdmin = is_null($toAdmin) ? $this->bSendToAdmin : (is_bool($toAdmin) ? $toAdmin : false);
      $this->bResendToClient = is_null($toClient) ? $this->bSendToClient : (is_bool($toClient) ? $toClient : false);
      // if neither HTML nor Text formats are enabled, can't send ...
      if(!$this->bHtmlAdmin && !$this->bTextAdmin){ $this->bResendToAdmin = false; }
      if(!$this->bHtmlClient && !$this->bTextClient){ $this->bResendToClient = false; }
      // are we resending to someone? ...
      if($this->bResendToAdmin || $this->bResendToClient){
/* Not available yet!
        resendHtmlMailDetails($order);
        $this->Send();
*/
        $this->bResendToAdmin = $this->bResendToClient = false;
      }
    } // end function reSend
    
    /* Format an HTML page as text-only
    */
    function _formatAsText(){
      // chop everything above BODY tag ...
      $this->sMailAltBody = (($pos = strpos(strtolower($this->sMailBody),'<body')) !== false) ? substr($this->sMailBody, $pos) : $this->sMailBody;
      // Strip out javascript ...
      $this->sMailAltBody = preg_replace('@<script[^>]*?>.*?</script>@si', '', $this->sMailAltBody);
      // convert TRs to one line, ie. containing no newlines or carriage returns ...
      $this->sMailAltBody = preg_replace_callback( '@<tr.*\/tr@isU'
                                                 , create_function( '$match'
                                                                  , 'return preg_replace("/[\r\n]/", "", $match[0]);'
                                                                  )
                                                 , $this->sMailAltBody
                                                 );
      $search = array( '@<[\/\!]*?[^<>]*?>@si'          // Strip out HTML tags
                     , '@([\r\n])[\s]+@'                // Strip out white space
                     , '@&(quot|#34);@i'                // Replace HTML entities ...
                     , '@&(amp|#38);@i'
                     , '@&(lt|#60);@i'
                     , '@&(gt|#62);@i'
                     , '@&(nbsp|#160);@i'
                     , '@&#36;@i'
                     , '@&(iexcl|#161);@i'
                     , '@&(cent|#162);@i'
                     , '@&(pound|#163);@i'
                     , '@&(copy|#169);@i'
                     );
      $replace = array( ''
                      , '\1'
                      , '"'
                      , '&'
                      , '<'
                      , '>'
                      , ' '
                      , '$'
                      , chr(161)
                      , chr(162)
                      , chr(163)
                      , chr(169)
                      );
      $this->sMailAltBody = preg_replace($search, $replace, $this->sMailAltBody);
      // clear multiple spaces, except where contained within a set of double quotes ...
      $this->sMailAltBody = preg_replace_callback( '@([^"]*)("[^"]*")?@'
                                                 , create_function( '$match'
                                                                  , 'return preg_replace("/[ ]{2,}/", " ", $match[1]).(isset($match[2])?$match[2]:"");'
                                                                  )
                                                 , $this->sMailAltBody
                                                 );
    } // end function _formatAsText

  } // end class qcMailer
}
?>
