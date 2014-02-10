<?
session_start();
    $message="";

    if($_GET["wyloguj"]=="tak"){ 
	session_destroy();
	session_start();
	$go=$_GET["go"];
	
  header("location:index.php"); // Przekierowanie do index.php
	};
$login=$_POST['login'];
if($login) {


  $uzytkownik=strip_tags($_POST['uzytkownik']);
  $md5_haslo=strip_tags($_POST['haslo']);
 $uzytkownik=strtolower($uzytkownik);

    if($uzytkownik=='edit' && $md5_haslo=='admin'){
	$_SESSION['uzytkownik'] = $uzytkownik;
	$data = date("Y-m-d");
	
    header("location:index.php"); // Przekierowanie do strony main.php
  exit;
  }else {
  $message="Nieprawidłowa nazwa użytkownika lub hasło";
  }
} // Koniec sprawdzania autoryzacji.
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
<title>Panel administracyjny</title>
<style>
html{
width:100%;
height:100%;

background:url(img/bg2.jpg) #e9e6e6 top center repeat-x;
}
.error, .alert, .notice, .success, .info {padding:0.8em;margin-bottom:1em;border:2px solid #ddd;text-align:center;}
.error, .alert {background:#fbe3e4;color:#8a1f11;border-color:#fbc2c4;}
.notice {background:#fff6bf;color:#514721;border-color:#ffd324;}
.success {background:#e6efc2;color:#264409;border-color:#c6d880;}
.info {background:#d5edf8;color:#205791;border-color:#92cae4;}
.error a, .alert a {color:#8a1f11;}
.notice a {color:#514721;}
.success a {color:#264409;}
.info a {color:#205791;}


body,h1,h2,h3,p,td,quote,small,form,input,ul,li,ol,label{
	margin:0px;
	padding:0px;
	font-family:Arial, Helvetica, sans-serif;
	font-family:"Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Helvetica, Arial, sans-serif, "Bitstream Vera Sans";	
}
textarea {
    resize: none;
}

body{
	color:#555555;
	font-size:13px;
}		
		
		p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}

#stylized label{
display:block;
font-weight:bold;
text-align:right;
width:125px;
float:left;
padding-top:2px;
margin-right:6px;
}
input,
textarea,
select {
  font-size: 12px;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-weight: normal;
  padding: 3px;
  color: #777;
  width:136px;
  background: url('img/bg-input.png') repeat-x 0px 0px;
  border-top: solid 1px #aaa;
  border-left: solid 1px #aaa;
  border-bottom: solid 1px #ccc;
  border-right: solid 1px #ccc;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  outline: 0;
}

input:focus,
textarea:focus,
select:focus {
  -webkit-box-shadow: 0px 0px 4px rgba(0,0,0,0.3);
  -moz-box-shadow: 0px 0px 4px rgba(0,0,0,0.3);
  box-shadow: 0px 0px 4px rgba(0,0,0,0.3);
  border-color: #999;
  background: url('img/bg-input-focus.png') repeat-x 0px 0px;
}
input { background-color:#fff;}
</style>
</head>
  <body>
  <center><br/>
<? if($message!="") { ?><div class="notice"><? echo $message; ?></div> <? }; ?>
<br/>

<form id="form1" name="form1" method="post" action="<? echo $PHP_SELF; ?>">
  <table>
    <tr>
      <td>Użytkownik: </td>
      <td><input name="uzytkownik" type="text" id="uzytkownik" /></td>
    </tr>
    <tr>
      <td>Hasło: </td>
      <td><input name="haslo" type="password" id="haslo" /></td>
    </tr>
	<tr>
		<td colspan="2"><center><input name="login" type="submit" id="login" value="Zaloguj" /></center></td>
	</tr>
  </table>
</center>
</form>
</body>
</html>