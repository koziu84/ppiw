<!-- BEGIN FORM -->
<script type="text/javascript" src="$config[dir_js]/checkForm.js"> </script>
<form action="?p=$p" method="post" onsubmit="return checkForm( this, 
  Array(
    Array( 'sSender', 'email' )
    ,Array( 'sTopic', 'simple', '$lang[write_topic]' )
    ,Array( 'sMailContent', 'simple' )
  )
  );">
  <fieldset>
    <input type="hidden" name="sSend" value="true" />
    <table id="contact_table">
      <tr>
        <td>
          $lang[Your_email]:
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="sSender" />
        </td>
      </tr>
      <tr>
        <td>
          $lang[Topic]:
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="sTopic" />
        </td>
      </tr>
      <tr>
        <td>
          $lang[Content_mail]:
        </td>
      </tr>
      <tr>
        <td>
          <textarea cols="25" rows="8" name="sMailContent"></textarea>
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" value="$lang[send]" class="submit" />
        </td>
      </tr>
      <tr>
        <td>
          $lang[operation_especify_all_required_fields]
        </td>
      </tr>
    </table>
  </fieldset>
</form>
<!-- END FORM -->

<!-- BEGIN SEND_GOOD -->
<meta http-equiv="refresh" content="10 URL=javascript:history.back();" />
<div id="message">
  <div id="ok">
    $lang[Email_send] 
    <br /><br />
    $lang[Answer_soon]<br />
    <a href="javascript:history.back();">&laquo; $lang[operation_go_back]</a>
  </div>
</div>
<!-- END SEND_GOOD -->
<!-- BEGIN SEND_ALERT -->
<div id="message">
  <div id="error">
    $lang[Error_email_send]<br />
    <a href="javascript:history.back();">&laquo; $lang[operation_go_back]</a>
  </div>
</div>
<!-- END SEND_ALERT -->

<!-- BEGIN WRONG_WORD -->
<div id="message">
  <div id="error">
    $lang[cf_no_word]<br />
    <a href="javascript:history.back();">&laquo; $lang[operation_go_back]</a>
  </div>
</div>
<!-- END WRONG_WORD -->