<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - Russian (UTF-8)
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
* Translation:  Petrosyan R.
*             for@petrosyan.rv.ua
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.26.2010
*
* Description:  Russian language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Account creato con successo';
$lang['account_creation_unsuccessful'] 	 	 = 'Impossibile creare un account';
$lang['account_creation_duplicate_email'] 	 = 'Email usata o errata';
$lang['account_creation_duplicate_username'] 	 = 'Il nome utente esiste o è errato';
$lang['account_creation_missing_default_group'] = 'Il gruppo predefinito non è impostato.';
$lang['account_creation_invalid_default_group'] = 'Il gruppo predefinito non è corretto';

// Password
$lang['password_change_successful'] 	 	 = 'Password cambiata con successo';
$lang['password_change_unsuccessful'] 	  	 = 'La password non può essere cambiata';
$lang['forgot_password_successful'] 	 	 = 'Reimpostazione della password. Email inviata messaggio';
$lang['forgot_password_unsuccessful'] 	 	 = 'Impossibile reimpostare la password';

// Activation
$lang['activate_successful'] 		  	 = 'Account attivato';
$lang['activate_unsuccessful'] 		 	 = 'Impossibile attivare l\'account';
$lang['deactivate_successful'] 		  	 = 'Account disattivato';
$lang['deactivate_unsuccessful'] 	  	 = 'Impossibile disattivare l\'account';
$lang['activation_email_successful'] 	  	 = 'Messaggio di attivazione inviato';
$lang['activation_email_unsuccessful']   	 = 'Non è stato possibile inviare il messaggio di attivazione';
$lang['deactivate_current_user_unsuccessful']= 'You cannot De-Activate your self.';

// Login / Logout
$lang['login_successful'] 		  	 = 'Login riuscito';
$lang['login_unsuccessful'] 		  	 = 'Login/password non corretti';
$lang['login_unsuccessful_not_active'] 		 = 'Account non attivo';
$lang['login_timeout']                       = 'Per motivi di sicurezza, l\'accesso è temporaneamente disabilitato. Riprova più tardi.';
$lang['logout_successful'] 		 	 = 'Logout riuscito';

// Account Changes
$lang['update_successful'] 		 	 = 'Account aggiornato con successo';
$lang['update_unsuccessful'] 		 	 = 'Impossibile aggiornare l\'account';
$lang['delete_successful'] 		 	 = 'Account cancellato';
$lang['delete_unsuccessful'] 		 	 = 'Impossibile eliminare l\'account';

// Groups
$lang['group_creation_successful']  = 'Gruppo creato con successo';
$lang['group_already_exists']       = 'Esiste già un gruppo con lo stesso nome.';
$lang['group_update_successful']    = 'Dati di gruppo aggiornati correttamente';
$lang['group_delete_successful']    = 'Gruppo eliminato';
$lang['group_delete_unsuccessful'] 	= 'Impossibile eliminare il gruppo';
$lang['group_delete_notallowed']    = 'Impossibile eliminare il gruppo di amministrazione';
$lang['group_name_required'] 		= 'Il nome del gruppo è richiesto';
// Activation Email
$lang['email_activation_subject']            = 'Attivazione dell\'account';
$lang['email_activate_heading']    = 'Attiva account con nome  %s';
$lang['email_activate_subheading'] = 'Clicca sul link %s.';
$lang['email_activate_link']       = 'Attiva il tuo account';
// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Password dimenticata';
$lang['email_forgot_password_heading']    = 'Reimposta la password dell\'utente %s';
$lang['email_forgot_password_subheading'] = 'Clicca sul link per %s.';
$lang['email_forgot_password_link']       = 'Recupero della password';
// New Password Email
$lang['email_new_password_subject']          = 'Nuova password';
$lang['email_new_password_heading']    = 'Nuova password per %s';
$lang['email_new_password_subheading'] = 'Password modificata in: %s';
