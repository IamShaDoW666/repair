<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - German
*
* Author: Shark
* 		  info@shark-webdesign.com
*
* Created:  06.01.2019
*
* Description:  German language file for Ion Auth example views
*
*/

// Account Creation
$lang['account_creation_successful']            = 'Konto erfolgreich erstellt';
$lang['account_creation_unsuccessful']          = 'Kann Konto nicht erstellen';
$lang['account_creation_duplicate_email']       = 'Email ung&uuml;ltig oder bereits in Benutzung';
$lang['account_creation_duplicate_identity']    = 'Identität ung&uuml;ltig oder bereits in Benutzung';
$lang['account_creation_missing_default_group'] = 'Standard-Gruppe nicht festgelegt';
$lang['account_creation_invalid_default_group'] = 'Ung&uuml;ltiger Standard-Gruppenname';


// Password
$lang['password_change_successful']          = 'Passwort erfolgreich ge&auml;ndert';
$lang['password_change_unsuccessful']        = 'Passwort-&Auml;nderung nicht m&ouml;glich';
$lang['forgot_password_successful']          = 'Passwort-Reset eMail gesendet';
$lang['forgot_password_unsuccessful']        = 'Passwort-Reset nicht m&ouml;glich';

// Activation
$lang['activate_successful']                 = 'Konto aktiviert';
$lang['activate_unsuccessful']               = 'Aktivierung Konto nicht m&ouml;glich';
$lang['deactivate_successful']               = 'Konto deaktiviert';
$lang['deactivate_unsuccessful']             = 'Deaktivierung Konto nicht m&ouml;glich';
$lang['activation_email_successful']         = 'Aktivierungs Email gesendet';
$lang['activation_email_unsuccessful']       = 'Versendung Aktivierungs Email nicht m&ouml;glich';

// Login / Logout
$lang['login_successful']                    = 'Erfolgreich eingeloggt';
$lang['login_unsuccessful']                  = 'Falsches Login';
$lang['login_unsuccessful_not_active']       = 'Konto ist inaktiv';
$lang['login_timeout']                       = 'Zeitweise deaktiviert.  Bitte probieren Sie es sp&auml;ter.';
$lang['logout_successful']                   = 'Erfolgreich ausgeloggt';

// Account Changes
$lang['update_successful']                   = 'Konto-Information erfolgreich aktualisiert';
$lang['update_unsuccessful']                 = 'Konto-Information konte nicht aktualisiert werden';
$lang['delete_successful']                   = 'Benutzer gel&ouml;scht';
$lang['delete_unsuccessful']                 = 'L&ouml;schen Benutzer nicht m&ouml;glich';

// Groups
$lang['group_creation_successful']           = 'Gruppe erfolgreich erstellt';
$lang['group_already_exists']                = 'Gruppen-Name exisitert bereits';
$lang['group_update_successful']             = 'Gruppen Deteils erfolgreich aktualisiert';
$lang['group_delete_successful']             = 'Gruppe gel&ouml;scht';
$lang['group_delete_unsuccessful']           = 'L&ouml;schen Gruppe nicht m&ouml;glich';
$lang['group_delete_notallowed']             = 'Admin-Gruppe kann nicht gel&ouml;scht werden';
$lang['group_name_required']                 = 'Gruppen-Name ist ein Pflichtfeld';
$lang['group_name_admin_not_alter']          = 'Admin-Gruppe kann nicht ge&auml;ndert werden';

// Activation Email
$lang['email_activation_subject']            = 'Konto Aktivierung';
$lang['email_activate_heading']              = 'Aktivies Konto f&uuml;r %s';
$lang['email_activate_subheading']           = 'Bitte diesen Link klicken %s.';
$lang['email_activate_link']                 = 'Dein Konto aktivieren';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Passwort vergessen Pr&uuml;fung';
$lang['email_forgot_password_heading']       = 'Passwort zur&uuml;cksetzten f&uuml;r %s';
$lang['email_forgot_password_subheading']    = 'Bitte diesen Link klicken %s.';
$lang['email_forgot_password_link']          = 'Dein Passwort zur&uuml;cksetzten';

// New Password Email
$lang['email_new_password_subject']          = 'Neues Passwort';
$lang['email_new_password_heading']          = 'Neues Passwort f&uuml; %s';
$lang['email_new_password_subheading']       = 'Dein Passwort wurde zur&uuml;ckgesetzt f&uuml;r: %s';
