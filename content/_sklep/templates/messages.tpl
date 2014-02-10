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

<!-- BEGIN FORM_ERROR -->
<div id="message">
  <div id="error">
    $lang[operation_especify_all_required_fields]<br />
    <a href="javascript:history.back();">&laquo; $lang[operation_go_back]</a>
  </div>
</div>
<!-- END FORM_ERROR -->

<!-- BEGIN NOT_EXISTS -->
<div id="message">
  <div id="error">
    $lang[operation_not_found]<br />
    <a href="javascript:history.back();">&laquo; $lang[operation_go_back]</a>
  </div>
</div>
<!-- END NOT_EXISTS -->

<!-- BEGIN ORDER_SAVED -->
<div id="message">
  <div id="ok">
    $lang[Order_finished]<br />
    <a href="javascript:windowNew( '?p=ordersWindowPrint&amp;iOrder=$iOrder' );">&raquo; $lang[Order_print]</a><br />
    <a href="?p=">$lang[Homepage]</a>
  </div>
</div>
<!-- END ORDER_SAVED -->