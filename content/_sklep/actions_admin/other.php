<?php
require_once DIR_CORE.'categories-'.$config['db_type'].'.php';
require_once DIR_CORE.'categories.php';

if( $a == 'Config' ){
  if( isset( $sOption ) && $sOption == 'save' ){
    saveConfig( $_POST );
    $link = $aActions['g'].'Config';

    $content .= $tpl->tbHtml( 'messages.tpl', 'SAVED' );
  }
  else{
    $sLangSelect =        throwLangSelect( $config['language'] );
    $sTemplateSelect =    throwTemplatesSelect( $config['template'] );
    $sStartPageSelect =   throwPagesSelect( $config['start_page'] );
    $sInfoMailSelect =    throwTrueFalseSelect( $config['mail_informing'] );
    $sContactPageSelect = listCategories( 'categories_contact_select.tpl', 2, null, Array( $config['contact_page'] ) );

    $content .= $tpl->tbHtml( 'config_form.tpl', 'FORM' );
  }
}
elseif( $a == 'About' ){
  $content .= $tpl->tHtml( 'about.tpl' );
}
elseif( $a == 'Validate' ){
  $content .= throwWarnings( 'messages.tpl' );
}
?>