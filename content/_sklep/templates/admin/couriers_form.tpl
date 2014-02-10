<!-- BEGIN FORM -->
<script type="text/javascript" src="$config[dir_js]checkForm.js"> </script>
<div id="list_title">
  $lang[Courier_data]
</div>
<form action="?p=$p&amp;iCourier=$iCourier" method="post" onsubmit="return checkForm( this, 
  Array(
    Array( 'sName' )
    ,Array( 'fPrice', 'float' )
  )
);">
  <table cellspacing="0" id="form_table">
    <tr>
      <th>
        $lang[Name]
      </th>
      <td>
        <input type="text" name="sName" value="$aData[sName]" size="30" maxlength="50" />
      </td>
    </tr>
    <tr>
      <th>
        $lang[Price]
      </th>
      <td>
        <input type="text" name="fPrice" value="$aData[fPrice]" class="label" size="8" maxlength="8" />
        $config[currency_symbol]
      </td>
    </tr>
    <tr class="formsave">
      <td colspan="2">
        <input type="hidden" name="iCourier" value="$iCourier" />
        <input type="hidden" name="sOption" value="save" />
        <input type="submit" value="$lang[save] &raquo;" />
      </td>
    </tr>
	</table>
  <div id="form_back">
		&laquo; <a href="javascript:history.back();">$lang[go_back]</a>
	</div>
</form>
<!-- END FORM -->