<!-- BEGIN PLUGINS_FORM_HEAD -->
<script type='text/javascript' src='$config[dir_plugins]pluginManager/domLib_071.stripped.js'></script>
<script type='text/javascript' src='$config[dir_plugins]pluginManager/domTT_071.stripped.js'></script>
<div id="list_title">
  $lang[Config_page]
</div>
<form action='?p=pluginsEdit&amp;sOption=save' method='post' id='form'>
<table id="list_table" cellspacing="0">
  <tr class="listhead">
    <td colspan='3' style='text-align:center;'>
      <span style='float:right;'>$aPlugin[config]</span>
      <span style='float:right;padding-right:10px;'><a href='$config[dir_plugins]pluginManager/AboutThisPlugin.html' target='_blank'><img src='$config[dir_plugins]pluginManager/about.gif' alt='$lang[PMabout] pluginManager' title='$lang[PMabout] pluginManager' /></a></span>
      <b>$lang[Plugin_manager] $aPlugin[version]</b>
    </td>
  </tr>
  <tr class='listhead'>
    <td colspan='2' style='width:50%;'>
      &nbsp;
    </td>
    <td style='width: 50%;'>
      <table style='width:auto; padding:0px; margin:0px; border:0px;'>
        <tr style='height:auto; background-color:transparent; text-align:center; font-style:italic;'>
          <td style='padding:0px; border:0px; width:40px;'>$lang[operation_yes]</td>
          <td style='padding:0px; border:0px; width:40px;'>$lang[operation_no]</td>
          <td style='padding:0px; border:0px; width:60px;'>&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
<!-- END PLUGINS_FORM_HEAD -->
<!-- BEGIN PLUGINS_FORM_LIST -->
  <tr class='listbody_$aPlugin[iStyle]' $aPlugin[rowColor]>
    <td style='text-align:right; width:48%;'>
      <span style='float:right; padding-left:10px; padding-right:2px;'>$aPlugin[version]</span>
      <span style='cursor:default;' onmouseout="domTT_mouseout(this, event);" onmouseover="domTT_activate(this, event, 'content', '$aPlugin[tooltip]', 'trail', true, 'delay', 0);">$aPlugin[name]</span>
    </td>
    <td style='text-align:right;'>
      $aPlugin[about]
    </td>
    <td>
      <table style='width:100%; padding:0px; margin:0px; border:0px;'>
        <tr style='height:auto; background-color:transparent; text-align:center;'>
          <td style='padding:0px; border:0px; width: 40px;'>$aPlugin[on]</td>
          <td style='padding:0px; border:0px; width: 40px;'>$aPlugin[off]</td>
          <td style='padding:0px; border:0px; width: 60px;'>$aPlugin[config]</td>
          <td style='padding:0px 2px 0px 10px; border:0px; text-align:right; font-size:10px;'>$aPlugin[message]</td>
        </tr>
      </table>
    </td>
  </tr>
<!-- END PLUGINS_FORM_LIST -->

<!-- BEGIN PLUGINS_FORM_TOOLTIP -->
<table style='font-size:11px; border:1px solid #333366; padding:0px;' cellspacing='0'>
  <tr style='background-color:#333366; color:#ffffff;'><td colspan='2'>$lang[PMsetupInformation]</td><td style='text-align:right;' nowrap='nowrap'>$aPluginInfo[name]&nbsp;$aPluginInfo[version]</td></tr>
  <tr style='background-color:#f1f1ff; color:#333366; vertical-align:top;'>
    <td style='width:140px;'>$lang[PMprerequisites]</td><td style='width:10px;'>: </td><td nowrap='nowrap'>$aPluginInfo[prerequisites]</td></tr>
  <tr style='background-color:#f1f1ff; color:#333366;'>
    <td>$lang[PMpreloadLang]</td><td>: </td><td>$aPluginInfo[preloadLang]</td></tr>
  <tr style='background-color:#f1f1ff; color:#333366; border-top:1px solid #333366;'>
    <td>$lang[PMrequiredFiles]</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    $aPluginInfo[includes]
</table>
<!-- END PLUGINS_FORM_TOOLTIP -->
<!-- BEGIN PLUGINS_FORM_TOOLTIP_INCL -->
  <tr style='background-color:#f1f1ff; color:#333366; vertical-align:top;'>
    <td style='padding-left:18px;'>$aPluginInfo[file]</td><td>: </td><td nowrap='nowrap'>$aPluginInfo[list]</td></tr>
<!-- END PLUGINS_FORM_TOOLTIP_INCL -->

<!-- BEGIN PLUGINS_FORM_RADIO_BUTTON -->
          <input class='borderless' type='radio' name='$aPlugin[name]' value='$aPlugin[value]' $aPlugin[checked] $aPlugin[disabled] />
<!-- END PLUGINS_FORM_RADIO_BUTTON -->
<!-- BEGIN PLUGINS_FORM_LINK_CONFIG -->
<a href='?p=pluginsConfig&amp;sPlgn=$aPlugin[name]'><img src='$config[dir_files]img/edit.gif' alt='$aPlugin[name] $lang[Config_page]' title='$aPlugin[name] $lang[Config_page]' /></a>
<!-- END PLUGINS_FORM_LINK_CONFIG -->
<!-- BEGIN PLUGINS_FORM_NO_LINK_CONFIG -->
<img src='$config[dir_plugins]pluginManager/editDisabled.gif' alt='$aPlugin[name] $lang[Config_page]' title='$aPlugin[name] $lang[Config_page]' />
<!-- END PLUGINS_FORM_NO_LINK_CONFIG -->
<!-- BEGIN PLUGINS_FORM_LINK_ABOUT -->
<a href='$config[dir_plugins]$aPlugin[name]/AboutThisPlugin.html' target='_blank'><img src='$config[dir_plugins]pluginManager/about.gif' alt='$lang[PMabout] $aPlugin[name]' title='$lang[PMabout] $aPlugin[name]' /></a>
<!-- END PLUGINS_FORM_LINK_ABOUT -->
<!-- BEGIN PLUGINS_FORM_FOOTER -->
  <tr style='background-color:#777777; text-align:center;'>
    <td colspan='3'>
      <input type='submit' value='$lang[save] &raquo;' />
    </td>
  </tr>
</table>
</form>
<!-- END PLUGINS_FORM_FOOTER -->

<!-- BEGIN PLUGINS_FORM_PROBLEM -->
style='color:#FF0000;'
<!-- END PLUGINS_FORM_PROBLEM -->
<!-- BEGIN PLUGINS_FORM_BAD_VERSION -->
<a style='float:right;padding-left:4px;' href='?p=pluginsSetup&amp;sPlgn=$aPlugin[name]'><img src='$config[dir_plugins]pluginManager/reload.gif' alt='$lang[PMreloadSetup]' title='$lang[PMreloadSetup]' /></a>
$lang[PMversionMismatch]
<!-- END PLUGINS_FORM_BAD_VERSION -->

<!-- BEGIN PLUGINS_CONFIG_HEAD -->
<script type='text/javascript' src='$config[dir_plugins]pluginManager/domLib_071.stripped.js'></script>
<script type='text/javascript' src='$config[dir_plugins]pluginManager/domTT_071.stripped.js'></script>
<script type='text/javascript' src='$config[dir_plugins]pluginManager/checkForm.js'> </script>
<div id="list_title">
  $lang[Config_page]
</div>
<form action='?p=pluginsConfig&amp;sOption=save' method='post' id='form' $aPMConfig[sCheckForm]>
<table cellspacing="0" id="form_table">
  <tr style='background-color:#bbbbbb; text-align:center;'>
    <td colspan='2'><span style='float:left; cursor:default; border:1px solid #dddddd; padding:2px;' onmouseout="domTT_mouseout(this, event);" onmouseover="domTT_activate(this, event, 'content', '$aPMConfig[sHelp]', 'trail', true, 'delay', 0);">$lang[PMhelp]</span>
      <b>$lang[Plugin_manager]</b> : $aPMConfig[sPlugin] $aPMConfig[sVersion] $lang[Config_page]
    </td>
  </tr>
<!-- END PLUGINS_CONFIG_HEAD -->
<!-- BEGIN PLUGINS_CONFIG_LIST -->
  <tr>
    <th style='vertical-align:top; width:30%;'>
      $aPMConfig[sHidden]<span style='cursor:default;' onmouseout="domTT_mouseout(this, event);" onmouseover="domTT_activate(this, event, 'content', '$aPMConfig[sTooltip]', 'trail', true, 'delay', 0);">$aPMConfig[sName]</span>
    </th>
    <td style='width:70%;'><div style='float:left;'>$aPMConfig[sField]</div>
      $aPMConfig[sHint]
    </td>
  </tr>
<!-- END PLUGINS_CONFIG_LIST -->
<!-- BEGIN PLUGINS_CONFIG_LIST_HIDDEN -->
<input type='hidden' name='sConfig[]' value='$aPMConfig[sConfig]' />
<input type='hidden' name='sFormat[]' value='$aPMConfig[sFormat]' />
<!-- END PLUGINS_CONFIG_LIST_HIDDEN -->
<!-- BEGIN PLUGINS_CONFIG_LIST_HINT -->
<div style='color:#888888; font-style:italic; font-size:10px; text-align:right;'>$aPMConfig[sText]</div>
<!-- END PLUGINS_CONFIG_LIST_HINT -->
<!-- BEGIN PLUGINS_CONFIG_LIST_TOOLTIP -->
<table style='font-size:11px; border: 1px solid #333366; padding:0px; background-color:#f1f1ff; color: #333366;' cellspacing='0'>
  <tr><td style='width:50px;'>$lang[PMvariable]</td><td nowrap='nowrap'>:&nbsp;$aPMConfig[sConfigTip]</td></tr>
  <tr><td>$lang[PMformat]</td><td nowrap='nowrap'>:&nbsp;$aPMConfig[sFormatTip]</td></tr>
</table>
<!-- END PLUGINS_CONFIG_LIST_TOOLTIP -->
<!-- BEGIN PLUGINS_CONFIG_FOOTER_SAVE -->
      <input type='submit' value='$lang[save] &raquo;' />
<!-- END PLUGINS_CONFIG_FOOTER_SAVE -->
<!-- BEGIN PLUGINS_CONFIG_FOOTER_NO_SAVE -->
      <span style='color:#ff0000;font-weight:bold;float:right;'>$lang[PMunwritable]</span>
<!-- END PLUGINS_CONFIG_FOOTER_NO_SAVE -->
<!-- BEGIN PLUGINS_CONFIG_FOOTER -->
  <tr class='formsave'>
    <td colspan='2'>$aPMConfig[sSave]
      <input type='hidden' name='sPlgn' value='$aPMConfig[sPlugin]' />
    </td>
  </tr>
</table>
<div id="form_back">
	&laquo; <a href="?p=pluginsEdit">$lang[go_back]</a>
</div>
</form>
<!-- END PLUGINS_CONFIG_FOOTER -->
<!-- BEGIN PLUGINS_CONFIG_HELP_TOOLTIP -->
<div style='width: 400px; font-size:11px; border: 1px solid #333366; margin:1px; background-color:#f1f1ff; color: #333366;'>$lang[PMconfigHelp]</div>
<!-- END PLUGINS_CONFIG_HELP_TOOLTIP -->

<!-- BEGIN PLUGINS_CONFIG_CHECKBOX -->
$aPMConfig[sLabel]<input class='borderless' type='checkbox' name='$aPMConfig[sFid]' title='$aPMConfig[sAlt]' value='$aPMConfig[sValue]' $aPMConfig[sPicked] $aPMConfig[sDisabled] />&nbsp;
<!-- END PLUGINS_CONFIG_CHECKBOX -->
<!-- BEGIN PLUGINS_CONFIG_RADIO -->
$aPMConfig[sLabel]<input class='borderless' type='radio' name='$aPMConfig[sFid]' title='$aPMConfig[sAlt]' value='$aPMConfig[sValue]' $aPMConfig[sPicked] $aPMConfig[sDisabled] />&nbsp;
<!-- END PLUGINS_CONFIG_RADIO -->
<!-- BEGIN PLUGINS_CONFIG_SELECT_START -->
<select name='$aPMConfig[sFid]' id='$aPMConfig[sFid]' title='$aPMConfig[sAlt]' $aPMConfig[sDisabled]>
<!-- END PLUGINS_CONFIG_SELECT_START -->
<!-- BEGIN PLUGINS_CONFIG_SELECT_OPTION -->
<option value='$aPMConfig[sValue]' $aPMConfig[sPicked]>$aPMConfig[sLabel]</option>
<!-- END PLUGINS_CONFIG_SELECT_OPTION -->
<!-- BEGIN PLUGINS_CONFIG_SELECT_END -->
</select>
<!-- END PLUGINS_CONFIG_SELECT_END -->
<!-- BEGIN PLUGINS_CONFIG_TEXTAREA -->
<textarea name='$aPMConfig[sFid]' id='$aPMConfig[sFid]' title='$aPMConfig[sAlt]' rows='$aPMConfig[sRows]' cols='$aPMConfig[sCols]' $aPMConfig[sDisabled]>$aPMConfig[sValue]</textarea>
<!-- END PLUGINS_CONFIG_TEXTAREA -->
<!-- BEGIN PLUGINS_CONFIG_INPUT -->
<input type='text' name='$aPMConfig[sFid]' id='$aPMConfig[sFid]' title='$aPMConfig[sAlt]' size='$aPMConfig[sSize]' value='$aPMConfig[sValue]' $aPMConfig[sDisabled] />
<!-- END PLUGINS_CONFIG_INPUT -->

<!-- BEGIN HIDE_MESSAGE_ON_CLICK -->
<script type='text/javascript'>
<!--
if(document.getElementById('ok')){document.getElementById('ok').onclick=new Function("if(document.getElementById('message')){document.getElementById('message').style.position='absolute';document.getElementById('message').style.visibility='hidden';}");document.getElementById('ok').title='$lang[PMclickToHide]';}
//-->
</script>
<!-- END HIDE_MESSAGE_ON_CLICK -->
<!-- BEGIN PLUGIN_DISABLED_MESSAGE -->
<div id="message">
	<div id="error" onclick="if(document.getElementById('message')){document.getElementById('message').style.position='absolute';document.getElementById('message').style.visibility='hidden';}">
      $lang[PMdisabledMissing]
  </div>
</div>
<!-- END PLUGIN_DISABLED_MESSAGE -->
