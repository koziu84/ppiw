<!-- BEGIN LOGIN_TABLE -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$config[language]" lang="$config[language]">
<head>
  <title>$config[title] &#8211; $lang[Log_in_administration]</title>
  <meta http-equiv="Content-Type" content="text/html; charset=$config[charset]" />
  <meta name="Description" content="$config[description]" />
  <meta name="Keywords" content="$config[keywords]" />
  <meta name="Author" content="OpenSolution.org" />
  <style type="text/css">
  body{margin:0;padding:0;background-color:#ffffff;font-family:verdana;font-size:11px;font-weight:normal;color:#000000;text-decoration:none;}
  .txt10{font-size:10px;}
  .txt12{font-size:12px;}

  .alert{font-size:14px;font-weight:bold;color:red;font-family:tahoma;}
  .good{font-size:14px;font-weight:bold;color:navy;font-family:tahoma;}

  a{text-decoration:none;font-weight:normal;color:#000000;}
  a:hover{text-decoration:underline;}

  .input {border:1px solid gray;font-family:verdana;font-size:11px;background-color:#ffffff;width:130px;}
  .submit {font-family:verdana;font-size:9px;}
  </style>

</head>
<body>
<table align="center" style="border:0; margin-top: 220px;" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <table align="center" style="width:300px;border: 1px solid black;" cellpadding="0" cellspacing="0">
        <tr style="background-color:#f3f3f3;">
          <td style="height:20px;border-bottom:1px solid black;" class="txt10">
            &nbsp;&nbsp;$lang[Log_in_administration]
          </td>
          <td style="text-align:right;border-bottom:1px solid black;" class="txt10">
            $lang[version]: <b>$config[version]</b>&nbsp;&nbsp;
          </td>
        </tr>
        $sLoginInfo
        <tr>
          <td style="text-align:center;background-color:#f3f3f3;height:20px;border-top:1px solid black;" colspan="2" class="txt10">
            <a href="index.php">$lang[homepage]</a>
            &nbsp;
            |
            &nbsp;
            <a href="$_SERVER[PHP_SELF]">$lang[administration]</a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<!-- END LOGIN_TABLE -->

<!-- BEGIN LOGIN_CORRECT -->
  <tr>
    <td colspan="2" style="height:89px;text-align:center;" class="good">
      <meta http-equiv="refresh" content="1 URL=$_POST[sLoginPageNext]" />
      $lang[Logged_in]
    </td>
  </tr>
<!-- END LOGIN_CORRECT -->

<!-- BEGIN LOGIN_ERROR -->
  <tr>
    <td colspan="2" style="height:89px;text-align:center;" class="alert">
      <meta http-equiv="refresh" content="1 URL=$sLoginPage" />
      $lang[Error_login_or_pass]
    </td>
  </tr>
<!-- END LOGIN_ERROR -->

<!-- BEGIN LOGOUT -->
  <tr>
    <td colspan="2" style="height:89px;text-align:center;" class="good">
      <meta http-equiv="refresh" content="1 URL=$sLoginPage" />
      $lang[Logged_out]
    </td>
  </tr>
<!-- END LOGOUT -->

<!-- BEGIN LOGIN_NOT_ACTIVE -->
<!-- END LOGIN_NOT_ACTIVE -->

<!-- BEGIN LOGIN_FORM -->
  <tr>
    <td colspan="2" style="height:89px;text-align:center;">
      <script language="JavaScript" type="text/javascript">
      <!--
      function cursor( ){
        if( document.form.sLogin.value == "" ){
          document.form.sLogin.focus( );
        }
        else{
          document.form.sPass.focus( );        
        }
      }
      window.onload = cursor;
      //-->
      </script>
      <form action="$sLoginPage" method="post" name="form" style="margin: 0px;">
        <input type="hidden" name="sLoginPageNext" value="$_SERVER[REQUEST_URI]" />
        <table align="center" style="border:0;width:100%;" cellpadding="3" cellspacing="0" class="txt12">
          <tr>
            <td style="text-align:right;width:30%;">
              $lang[Login]:
            </td>
            <td style="text-align:left;">
              <input type="text" name="sLogin" class="input" value="$_COOKIE[sLogin]" />
            </td>
          </tr>
          <tr>
            <td style="text-align:right;">
              $lang[Password]:
            </td>
            <td style="text-align:left;">
              <input type="password" name="sPass" class="input" value="" />
            </td>
          </tr>
          <tr>
            <td style="text-align:left;">
              &nbsp;&nbsp;
              <input type="button" onclick="window.location='javascript:history.back()';" class="submit" value="&laquo; $lang[back]" /> 
            </td>
            <td style="text-align:right;">
              <input type="submit" class="submit" value="$lang[log_in] &raquo;" />
              &nbsp;&nbsp;
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
<!-- END LOGIN_FORM -->
