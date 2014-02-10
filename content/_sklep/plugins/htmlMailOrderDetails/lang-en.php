<?php
/*
* htmlMailOderDetails plugin - English language file
*/
$lang['hmodSubjectAdmin'] = 'New order. Further details may be available from the Administration Panel';
$lang['hmodSubjectClient'] = 'Thank you for your order. It will be processed as soon as possible.';
$lang['hmodHtml'] = 'HTML';
$lang['hmodText'] = 'Text';

$lang['PMCI']['hmod__adminName']['name'] = $lang['PMCI']['hmod__adminName']['alt'] = 'Administrator\'s Name';
$lang['PMCI']['hmod__adminName']['text'] = 'This is the name of the Shop Administrator, that will be used when addressing Admin emails.';
$lang['PMCI']['hmod__sendAdmin']['name'] = 'Email Order to Admin';
$lang['PMCI']['hmod__sendAdmin']['alt'] = 'Enable/Disable Email of Order to Admin';
$lang['PMCI']['hmod__sendAdmin']['text'] = 'This controls the sending of the order details by email to Admin. Unless you want to receive 2 emails, <span style="text-decoration:underline;">don\'t forget</span> to disable \''.$lang['Mail_informing'].'\' in Admin-Configuration.';
$lang['PMCI']['hmod__sendClient']['name'] = 'Email Order to Client';
$lang['PMCI']['hmod__sendClient']['alt'] = 'Enable/Disable Email of Order to Client';
$lang['PMCI']['hmod__sendClient']['text'] = 'This controls the sending of the order details by email to the Client.';
$lang['PMCI']['hmod__reportErrors']['name'] = $lang['PMCI']['hmod__reportErrors']['alt'] = 'Report Errors';
$lang['PMCI']['hmod__reportErrors']['text'] = 'Echo to the screen any errors that occur when Sending an email.';
$lang['PMCI']['hmod__showAndStop']['name'] = $lang['PMCI']['hmod__showAndStop']['alt'] = 'Show Email Body and Stop';
$lang['PMCI']['hmod__showAndStop']['text'] = 'Display on the screen the body of the email that would be sent, and stop any further processing (at all). Used for debugging without having to actually send the email.';
$lang['PMCI']['hmod__formatAdmin']['name'] = $lang['PMCI']['hmod__formatAdmin']['alt'] = 'Message Format: Admin';
$lang['PMCI']['hmod__formatAdmin']['text'] = 'Select whether to send the message to Admin in HTML format, Text format, or HTML with alternate Text.';
$lang['PMCI']['hmod__formatClient']['name'] = $lang['PMCI']['hmod__formatClient']['alt'] = 'Message Format: Client';
$lang['PMCI']['hmod__formatClient']['text'] = 'Select whether to send the message to the Client in HTML format, Text format, or HTML with alternate Text.';
$lang['PMCI']['hmod__method']['name'] = $lang['PMCI']['hmod__method']['alt'] = 'Method';
$lang['PMCI']['hmod__method']['text'] = 'Choose the method used to send the emails.';
$lang['PMCI']['hmod__sendmailPath']['name'] = 'Sendmail: Path';
$lang['PMCI']['hmod__sendmailPath']['alt'] = 'Path to sendmail';
$lang['PMCI']['hmod__sendmailPath']['text'] = 'Path to sendmail program, if using sendmail method.';
$lang['PMCI']['hmod__qmailPath']['name'] = 'Qmail: Path';
$lang['PMCI']['hmod__qmailPath']['alt'] = 'Path to qmail';
$lang['PMCI']['hmod__qmailPath']['text'] = 'Path to qmail program, if using qmail method.';
$lang['PMCI']['hmod__smtpHosts']['name'] = 'SMTP: Hosts';
$lang['PMCI']['hmod__smtpHosts']['alt'] = 'SMTP Server(s)';
$lang['PMCI']['hmod__smtpHosts']['text'] = 'If using SMTP, enter your SMTP Server address. Mulitple addresses can be entered by separating them with a semi-colon (;). You can override the default port (below) by appending a port number to an address with a colon separator (eg. address1.com:25;address2.com:26).';
$lang['PMCI']['hmod__smtpPort']['name'] = 'SMTP: Port';
$lang['PMCI']['hmod__smtpPort']['alt'] = 'Default SMTP Port';
$lang['PMCI']['hmod__smtpPort']['text'] = 'This is the default port for the SMTP method.';
$lang['PMCI']['hmod__smtpAuth']['name'] = 'SMTP: Auth';
$lang['PMCI']['hmod__smtpAuth']['alt'] = 'Use Authorised SMTP';
$lang['PMCI']['hmod__smtpAuth']['text'] = 'Specifies Authorised SMTP, using Username and Password from below.';
$lang['PMCI']['hmod__smtpUser']['name'] = 'SMTP: Username';
$lang['PMCI']['hmod__smtpUser']['alt'] = 'Authorisation Username';
$lang['PMCI']['hmod__smtpUser']['text'] = 'Required if using Authorised SMTP';
$lang['PMCI']['hmod__smtpPword']['name'] = 'SMTP: Password';
$lang['PMCI']['hmod__smtpPword']['alt'] = 'Authorisation Password';
$lang['PMCI']['hmod__smtpPword']['text'] = 'Required if using Authorised SMTP';
?>
