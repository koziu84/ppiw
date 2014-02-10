<?php
$config['hmod']['adminName'] = 'Administrator';
$config['hmod']['sendAdmin'] = true;
$config['hmod']['formatAdmin'] = 'html';
$config['hmod']['sendClient'] = true;
$config['hmod']['formatClient'] = 'html';
$config['hmod']['method'] = 'sendmail';
$config['hmod']['sendmailPath'] = '/usr/sbin/sendmail';
$config['hmod']['qmailPath'] = '/var/qmail/bin/sendmail';
$config['hmod']['smtpHosts'] = 'localhost';
$config['hmod']['smtpPort'] = 25;
$config['hmod']['smtpAuth'] = false;
$config['hmod']['smtpUser'] = '';
$config['hmod']['smtpPword'] = '';
$config['hmod']['reportErrors'] = true;
$config['hmod']['showAndStop'] = false;

/* Plugin Manager Configuration Instructions */
$PMCI['hmod']['adminName']['type'] = 'input(32)';
$PMCI['hmod']['formatAdmin']['type'] = $PMCI['hmod']['formatClient']['type'] = 'radio(html='.$lang['hmodHtml'].',text='.$lang['hmodText'].',both='.$lang['hmodHtml'].'+'.$lang['hmodText'].')';
$PMCI['hmod']['method']['type'] = 'select(mail=mail,sendmail=sendmail,qmail=qmail,smtp=smtp)';
$PMCI['hmod']['smtpPort']['type'] = 'input(3)';
$PMCI['hmod']['smtpUser']['type'] = 'input(32)';
$PMCI['hmod']['smtpPword']['type'] = 'input(32)';
?>
