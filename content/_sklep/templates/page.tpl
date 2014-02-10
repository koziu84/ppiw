<!-- BEGIN HEAD -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$config[language]" lang="$config[language]">

<head>
  <title>$sTitleBefore $config[title]</title>
  <meta http-equiv="Content-Type" content="text/html; charset=$config[charset]" />
  <meta name="Description" content="$config[description]" />
  <meta name="Keywords" content="$config[keywords]" />
  <meta name="Author" content="OpenSolution.org" />
  
  <!-- Modyfied by Wieslaw Klimiuk (23.03.2006) -->
  <link rel="SHORTCUT ICON" href="../../_images/icon.gif" />
  <!-- Modyfied by Wieslaw Klimiuk (23.03.2006) -->
  
  <script type="text/javascript" src="$config[dir_js]standard.js"> </script>
  <script type="text/javascript">
    <!--
    var cfBorderColor     = "#c3c3c3";
    var cfLangNoWord      = "$lang[cf_no_word]";
    var cfLangMail        = "$lang[cf_mail]";
    var cfWrongValue      = "$lang[cf_wrong_value]";
    var cfToSmallValue    = "$lang[cf_to_small_value]";
    var cfTxtToShort      = "$lang[cf_txt_to_short]";
    //-->
  </script>
  
       <style type="text/css">@import "$config[dir_tpl]$config[template]";</style>
</head>

<body>
       <h1>$config[title]</h1>
  <div id="container">
    
    <div id="header_logo">
      <a href="?p="><img src="$config[dir_files]img/$config[logo_img]" alt="" /></a>
    </div>

    <div id="navi" class="clearFix">

      <form action="" method="get">
        <fieldset>
          <input type="hidden" name="p" value="productsList" />
          <input type="text" id="searchinput" name="sWord" value="$sWord" />
          <input type="submit" value="$lang[Search] &raquo;" id="searchbutton" />
        </fieldset>
      </form>

      <ul>
      <!-- Modyfied by Wieslaw Klimiuk (24.03.2006) -->
        <li><a href="?p=productsList">$lang[offert]</a></li>
      <!-- Modyfied by Wieslaw Klimiuk (24.03.2006) -->
        <li><a href="?p=ordersBasket">$lang[basket]$sBasketSummary</a></li>
                            $sContentsMenu
      </ul>

    </div>
    <div class="clear"></div>
    <div id="content">
      $sCategoriesMenu
      <div id="main">
<!-- END HEAD -->

<!-- BEGIN HEAD_PRINT -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$config[language]" lang="$config[language]">

<head>
  <title>$sTitleBefore $config[title]</title>
  <meta http-equiv="content-Type" content="text/html; charset=$config[charset];" />
  <meta name="Description" content="$config[description]" />
  <meta name="Keywords" content="$config[keywords]" />
  <meta name="Author" content="OpenSolution.org" />

  <style type="text/css">@import "$config[dir_tpl]$config[template]";</style>

</head>

<body onload="window.print( );">
  <div id="container_print">
    
    <!-- Modyfied by Wieslaw Klimiuk (30.03.2006)
    <div id="header">
      <img src="$config[dir_files]img/$config[logo_img]" alt="" />
    </div>
    Modyfied by Wieslaw Klimiuk (30.03.2006) -->
              <div>
<!-- END HEAD_PRINT -->

<!-- BEGIN HEAD_GALLERY -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$config[language]" lang="$config[language]">

<head>
  <title>$sTitleBefore $config[title]</title>
  <meta http-equiv="content-Type" content="text/html; charset=$config[charset]" />
  <meta name="Description" content="$config[description]" />
  <meta name="Keywords" content="$config[keywords]" />
  <meta name="Author" content="OpenSolution.org" />
  <script type="text/javascript" src="$config[dir_js]standard.js"> </script>
  <link rel="stylesheet" href="$config[dir_tpl]$config[template]" type="text/css" />
  <style type="text/css">
  <!--
  body { margin:0; padding:0; }
  -->
  </style>
</head>

<body>
<!-- END HEAD_GALLERY -->

<!-- BEGIN FOOTER -->
         <div class="clear"></div>
  </div>
  </div>
       <div class="clear"></div>
  <div id="footer">
    <!-- dont erase "powered by Quick.Cart" -->
    <h1>powered by <a href="http://qc.opensolution.org">Quick.Cart</a></h1>

    <!-- Modyfied by Wieslaw Klimiuk (24.03.2006) -->          
              <!--<div>
      <img src="$config[dir_tpl]img/xhtml.gif" alt="Valid XHTML 1.0!" />
      <img src="$config[dir_tpl]img/css.gif" alt="Valid CSS!" />
      <img src="$config[dir_tpl]img/php-powered.gif" alt="" />
      <img src="$config[dir_tpl]img/no-database.gif" alt="" />
              </div>-->
    <!-- Modyfied by Wieslaw Klimiuk (24.03.2006) -->
    
  </div>
</div>

</body>
</html>
<!-- END FOOTER -->

<!-- BEGIN FOOTER_PRINT -->
 </div>
       <div class="clear"></div>
  <div id="footer">
    <!-- dont erase "powered by Quick.Cart" -->
    <div id="powered">powered by <a href="http://qc.opensolution.org">Quick.Cart</a></div>
  </div>
</div>

</body>
</html>
<!-- END FOOTER_PRINT -->

<!-- BEGIN FOOTER_GALLERY -->
</body>
</html>
<!-- END FOOTER_GALLERY -->
