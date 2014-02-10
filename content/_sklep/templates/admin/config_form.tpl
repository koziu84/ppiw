<!-- BEGIN FORM -->
<script type="text/javascript" src="$config[dir_js]/checkForm.js"> </script>
<div id="list_title">
  $lang[Config_page]
</div>

<form action="?p=$p&amp;sOption=save" method="post" id="form" enctype="multipart/form-data" onsubmit="return checkForm( this, 
  Array(
    Array( 'login', 'simple', '$lang[Fill_login]' )
    ,Array( 'pass', 'simple', '$lang[Fill_password]' )
    ,Array( 'products_list',  'int', '0', '$lang[Fill_product_list]', '>' )
    ,Array( 'admin_list',    'int', '0', '$lang[Fill_admin_list]', '>' )
    ,Array( 'products_photo_size',   'int', '0', '$lang[Fill_products_photo_size]', '>' )
    ,Array( 'categories_photo_size', 'int', '0', '$lang[Fill_categories_photo_size]', '>' )
    ,Array( 'email', 'email' )
  )
);">
<table cellspacing="0" id="form_table">
  <tr>
    <th>
      $lang[Template]
    </th>
    <td>
      <select name="template">
        $sTemplateSelect
      </select>
    </td>
  </tr>
  <tr>
    <th>
      $lang[Logo]
    </th>
    <td>
      <input type="file" name="logo" size="30" />
    </td>
  </tr>
  <tr>
    <th>
      $lang[Title]
    </th>
    <td>
      <input type="text" name="title" value="$config[title]" size="50" maxlength="200" />
    </td>
  </tr>
  <tr>
    <th>
      $lang[Description]
    </th>
    <td>
      <textarea name="description" cols="50" rows="3">$config[description]</textarea>
    </td>
  </tr>
  <tr>
    <th>
      $lang[Keywords]
    </th>
    <td>
      <input type="text" name="keywords" value="$config[keywords]" size="60" maxlength="255" />
    </td>
  </tr>
  <tr>
    <th>
      $lang[Language]
    </th>
    <td>
      <select name="language">
        $sLangSelect
      </select>
    </td>
  </tr>
  <tr>
    <th>
      $lang[Login]
    </th>
    <td>
      <input type="text" name="login" value="$config[login]" size="20" />
    </td>
  </tr>
  <tr>
    <th>
      $lang[Password]
    </th>
    <td>
      <input type="text" name="pass" value="$config[pass]" size="20" />
    </td>
  </tr>
  <tr>
    <th>
      $lang[Products_on_page]
    </th>
    <td>
      <input type="text" name="products_list" value="$config[products_list]" size="3" maxlength="3" class="label" />
    </td>
  </tr>
  <tr>
    <th>
      $lang[Admin_items_on_page]
    </th>
    <td>
      <input type="text" name="admin_list" value="$config[admin_list]" size="3" maxlength="3" class="label" />
    </td>
  </tr>
  <tr>
    <th>
      $lang[Products_image_size]
    </th>
    <td>
      <input type="text" name="products_photo_size" value="$config[products_photo_size]" size="3"  maxlength="3" class="label" /> px
    </td>
  </tr>
  <tr>
    <th>
      $lang[Categories_image_size]
    </th>
    <td>
      <input type="text" name="categories_photo_size" value="$config[categories_photo_size]" size="3"  maxlength="3" class="label" /> px
    </td>
  </tr>
  <tr>
    <th>
      $lang[Email]
    </th>
    <td>
      <input type="text" name="email" value="$config[email]" size="35" />
    </td>
  </tr>
  <tr>
    <th>
      $lang[Start_page]
    </th>
    <td>
      <select name="start_page">
        $sStartPageSelect
      </select>      
    </td>
  </tr>
  <tr>
    <th>
      $lang[Contact_page]
    </th>
    <td>
      <select name="contact_page">
        $sContactPageSelect
      </select>      
    </td>
  </tr>
  <tr>
    <th>
      $lang[Currency_symbol]
    </th>
    <td>
      <input type="text" name="currency_symbol" value="$config[currency_symbol]" size="5" maxlength="5" />
    </td>
  </tr>  
  <tr>
    <th>
      $lang[Mail_informing]
    </th>
    <td>
      <select name="mail_informing">
        $sInfoMailSelect
      </select>
    </td>
  </tr>
  <tr class="formsave">
    <td colspan="2">
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