<!-- BEGIN HEAD -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$config[language]" lang="$config[language]">
<head>
  <title>$config[title]</title>
  <meta http-equiv="Content-Type" content="text/html; charset=$config[charset]" />
  <meta name="Description" content="$config[description]" />
  <meta name="Keywords" content="$config[keywords]" />
  <meta name="Author" content="OpenSolution.org" />
  <script type='text/javascript' src='$config[dir_js]standard.js'> </script>
  <script type="text/javascript" src="$config[dir_js]adminGlobals.js"> </script>
  <script type="text/javascript">
    <!--
    var cfBorderColor     = "#76779B";
    var cfLangNoWord      = "$lang[cf_no_word]";
    var cfLangMail        = "$lang[cf_mail]";
    var cfWrongValue      = "$lang[cf_wrong_value]";
    var cfToSmallValue    = "$lang[cf_to_small_value]";
    var cfTxtToShort      = "$lang[cf_txt_to_short]";

    var delShure = "$lang[operation_sure_delete]?";
    //-->
  </script>

  <link rel="stylesheet" href="$config[dir_tpl]admin/style.css" type="text/css" />
  <link rel="stylesheet" href="$config[dir_tpl]admin/menu.css" type="text/css" />
</head>

<body>
  <div id="container">
    
    <div id="header">
      <div id="links">
        <a href="?p=otherAbout">informacje o sklepie</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://quickcart.pl/" target="_blank">forum o sklepie</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://opensolution.org/sklep/" target="_blank">dodatki do sklepu</a>
      </div>
      <a href="index.php"><img src="$config[dir_files]img/logo_os.jpg" alt="OpenSolution.org" /></a>
    </div>


<div class="menuBar">
  <a class="menuButton" href="?p=productsList" onmouseover="return buttonClick(event, 'products'); buttonMouseover(event, 'products');">$lang[products]</a>
  <a class="menuButton" href="?p=categoriesList" onmouseover="return buttonClick(event,'categories'); buttonMouseover(event, 'categories');">$lang[categories]</a>
  <a class="menuButton" href="?p=attributesList" onmouseover="return buttonClick(event, 'attributes'); buttonMouseover(event, 'attributes');">$lang[attributes]</a>
  <a class="menuButton" href="?p=couriersList" onmouseover="return buttonClick(event, 'couriers'); buttonMouseover(event, 'couriers');">$lang[couriers]</a>
  <a class="menuButton" href="?p=ordersList" onmouseover="return buttonClick(event, 'orders'); buttonMouseover(event, 'orders');">$lang[orders]</a>
  <a class="menuButton" href="?p=otherConfig" onmouseover="return buttonClick(event, 'configuration'); buttonMouseover(event, 'configuration');">$lang[configuration]</a>
  <a class="menuButton" onmouseover="return buttonClick(event, 'tools'); buttonMouseover(event, 'tools');">$lang[tools]</a>
  <a class="menuButton" href="?p=logout" >$lang[logout]</a>
</div>

<div id="attributes" class="menu" onmouseover="menuMouseover( event );">
   <a class="menuItem" href="?p=attributesForm"><span class="menuItemText">$lang[Add_attribute]</span></a>
</div> 

<div id="configuration" class="menu" onmouseover="menuMouseover( event );">
   <a class="menuItem" href="?p=pluginsEdit"><span class="menuItemText">$lang[plugins]</span></a>
</div>

<div id="products" class="menu" onmouseover="menuMouseover( event );">
  <a class="menuItem" href="?p=productsForm&amp;iCategory=$iCategory"><span class="menuItemText">$lang[Add_product]</span></a>
</div>

<div id="categories" class="menu" onmouseover="menuMouseover( event );">
  <a class="menuItem" href="?p=categoriesForm"><span class="menuItemText">$lang[Add_category]</span></a>
</div>

<div id="orders" class="menu" onmouseover="menuMouseover( event );">
  <a class="menuItem" href="?p=ordersList&amp;iStatus=1"><span class="menuItemText">$lang[Pendings]</span></a>
</div>

<div id="couriers" class="menu" onmouseover="menuMouseover( event );">
  <a class="menuItem" href="?p=couriersForm"><span class="menuItemText">$lang[Add_courier]</span></a>
</div>

<div id="tools" class="menu" onmouseover="menuMouseover( event );">
  <a class="menuItem" href="?p=otherValidate"><span class="menuItemText">$lang[Validate]</span></a>
</div>
<!-- END HEAD -->
<!-- BEGIN HEAD_PRINT -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$config[language]" lang="$config[language]">
<head>
  <title>$config[title]</title>
  <meta http-equiv="Content-Type" content="text/html; charset=$config[charset]" />
  <meta name="Description" content="$config[description]" />
  <meta name="Keywords" content="$config[keywords]" />
  <meta name="Author" content="www.OpenSolution.org" />
  <link rel="stylesheet" href="$config[dir_tpl]admin/style.css" type="text/css" />
</head>
<body onload="window.print( );">
  <div id="container_print">
    <div>
<!-- END HEAD_PRINT -->

<!-- BEGIN FOOTER_PRINT -->
    </div>
  </div>
</body>
</html>
<!-- END FOOTER_PRINT -->
<!-- BEGIN FOOTER -->
  </div>
</body>
</html>
<!-- END FOOTER -->
