<!-- BEGIN SAVED -->
<div id="message">
  <div id="ok">
    $lang[operation_saved]<br />
    <a href="?p=$link">&laquo; $lang[operation_go_back]</a>
  </div>
</div>
<!-- END SAVED -->

<!-- BEGIN SAVED_SHORT -->
<div id="message">
	<div id="ok">
      $lang[operation_changed]
  </div>
</div>
<!-- END SAVED_SHORT -->

<!-- BEGIN DELETED_SHORT -->
<div id="message">
	<div id="ok">
    $lang[operation_deleted]
  </div>
</div>
<!-- END DELETED_SHORT -->

<!-- BEGIN DELETED -->
<div id="message">
  <div id="ok">
    $lang[operation_deleted]<br />
    <a href="?p=$link">&laquo; $lang[operation_go_back]</a>
  </div>
</div>
<!-- END DELETED -->

<!-- BEGIN DONE -->
<div id="message">
  <div id="ok">
    $lang[operation_completed]<br />
    <a href="?p=$link">&laquo; $lang[operation_go_back]</a>
  </div>
</div>
<!-- END DONE -->

<!-- BEGIN ERROR -->
<div id="message">
  <div id="error">
    $lang[operation_not_completed]<br />
    <a href="?p=$link">&laquo; $lang[operation_go_back]</a>
  </div>
</div>
<!-- END ERROR -->

<!-- BEGIN NOT_EXISTS -->
<div id="message">
  <div id="error">
    $lang[operation_not_found]<br />
    <a href="?p=$link">&laquo; $lang[operation_go_back]</a>
  </div>
</div>
<!-- END NOT_EXISTS -->

<!-- BEGIN WARNING_HEAD -->
<br />
<div id="validate_title">$lang[Validate]</div>
<div id="warning">
<!-- END WARNING_HEAD -->

<!-- BEGIN WARNING_INFO -->
<div id="validate">
  <div id="validate_error">
    <img src="$config[dir_files]img/admin_error.gif" class="error_image"><span class="title">$aWarning[sTitle]</span><br />
    $aWarning[sInfo]
    <div style="clear: both;"></div>
  </div>
</div>
<!-- END WARNING_INFO -->

<!-- BEGIN WARNING_FOOTER -->
$lang[msg_more_info]: <a href="http://opensolution.org/forum/">http://opensolution.org/forum/</a>
</div>
<!-- END WARNING_FOOTER -->