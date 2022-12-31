<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Auth Lang - Russian
 *
 * Author: Ben Edmunds
 * 		  ben.edmunds@gmail.com
 *         @benedmunds
 *
 * Author: Daniel Davis
 *         @ourmaninjapan
 *
 * Translation: Ievgen Sentiabov
 *         @joni-jones
 *
 * Location: http://github.com/benedmunds/ion_auth/
 *
 * Created:  03.09.2013
 *
 * Description:  Russian language file for Ion Auth views
 *
 */

// Errors
$lang['error_csrf'] = 'Форма не прошла проверку безопасности.';

// Login
$lang['login_heading']         = 'Accedi';
$lang['login_subheading']      = 'Accedi per iniziare la sessione';
$lang['login_identity_label']  = 'Email/Utente:';
$lang['login_password_label']  = 'Password';
$lang['login_remember_label']  = 'Ricorda Password';
$lang['login_submit_btn']      = 'Accedi';
$lang['login_forgot_password'] = 'Password dimenticata?';

// Index
$lang['index_heading']           = 'Utenti';
$lang['index_subheading']        = 'Sotto si trova lista dei utenti.';
$lang['index_fname_th']          = 'Nome';
$lang['index_lname_th']          = 'Cognome';
$lang['index_email_th']          = 'Email';
$lang['index_groups_th']         = 'Gruppi';
$lang['index_status_th']         = 'Stato';
$lang['index_action_th']         = 'Azione';
$lang['index_active_link']       = 'Attivo';
$lang['index_inactive_link']     = 'Inattivo';
$lang['index_create_user_link']  = 'Сrea un nuovo utente';
$lang['index_create_group_link'] = 'Сrea un nuovo gruppo';

// Deactivate User
$lang['deactivate_heading']                  = 'Disattiva Utente';
$lang['deactivate_subheading']               = 'Sei sicuro di voler disattivare l\'utente \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Si:';
$lang['deactivate_confirm_n_label']          = 'No:';
$lang['deactivate_submit_btn']               = 'Invio';
$lang['deactivate_validation_confirm_label'] = 'Conferma';
$lang['deactivate_validation_user_id_label'] = 'ID utente';

// Create User
$lang['create_user_heading']                           = 'Crea Utente';
$lang['create_user_subheading']                        = 'Inserire le informazioni del utente.';
$lang['create_user_fname_label']                       = 'Nome:';
$lang['create_user_lname_label']                       = 'Cognome:';
$lang['create_user_identity_label']                    = 'Identita:';
$lang['create_user_company_label']                     = 'Nome Azienda:';
$lang['create_user_email_label']                       = 'Email:';
$lang['create_user_phone_label']                       = 'Теlefono:';
$lang['create_user_password_label']                    = 'Password:';
$lang['create_user_password_confirm_label']            = 'Conferma Password:';
$lang['create_user_submit_btn']                        = 'Сrea Utente';
$lang['create_user_validation_fname_label']            = 'Nome';
$lang['create_user_validation_lname_label']            = 'Cognome';
$lang['create_user_validation_identity_label']         = 'Identita';
$lang['create_user_validation_email_label']            = 'Email';
$lang['create_user_validation_phone1_label']           = 'Telefono';
$lang['create_user_validation_phone2_label']           = 'Telefono';
$lang['create_user_validation_phone3_label']           = 'Тelefono';
$lang['create_user_validation_company_label']          = 'Nome Azienda';
$lang['create_user_validation_password_label']         = 'Password';
$lang['create_user_validation_password_confirm_label'] = 'Conferma Password';

// Edit User
$lang['edit_user_heading']                           = 'Modifica Utente';
$lang['edit_user_subheading']                        = 'Inserire le informazioni del utente.';
$lang['edit_user_fname_label']                       = 'Nome:';
$lang['edit_user_lname_label']                       = 'Cognome:';
$lang['edit_user_company_label']                     = 'Nome Azienda:';
$lang['edit_user_email_label']                       = 'Email:';
$lang['edit_user_phone_label']                       = 'Telefono:';
$lang['edit_user_password_label']                    = 'Password: (se si cambia password)';
$lang['edit_user_password_confirm_label']            = 'Conferma Password: (Se si cambia la password)';
$lang['edit_user_groups_heading']                    = 'Utenti del gruppo';
$lang['edit_user_submit_btn']                        = 'Salva Utente';
$lang['edit_user_validation_fname_label']            = 'Nome';
$lang['edit_user_validation_lname_label']            = 'Cognome';
$lang['edit_user_validation_email_label']            = 'Email';
$lang['edit_user_validation_phone1_label']           = 'Telefono';
$lang['edit_user_validation_phone2_label']           = 'Telefono';
$lang['edit_user_validation_phone3_label']           = 'Тelefono';
$lang['edit_user_validation_company_label']          = 'Nome Azienda';
$lang['edit_user_validation_groups_label']           = 'Gruppi';
$lang['edit_user_validation_password_label']         = 'Password';
$lang['edit_user_validation_password_confirm_label'] = 'Conferma Password';

// Create Group
$lang['create_group_title']                  = 'Сrea Gruppo';
$lang['create_group_heading']                = 'Сrea Gruppo';
$lang['create_group_subheading']             = 'Inserire le informazioni del gruppo.';
$lang['create_group_name_label']             = 'Nome Gruppo:';
$lang['create_group_desc_label']             = 'Descrizione:';
$lang['create_group_submit_btn']             = 'Сrea Gruppo';
$lang['create_group_validation_name_label']  = 'Nome Gruppo';
$lang['create_group_validation_desc_label']  = 'Descrizione';

// Edit Group
$lang['edit_group_title']                  = 'Modifica Gruppo';
$lang['edit_group_saved']                  = 'Gruppo Salvato';
$lang['edit_group_heading']                = 'Modifica Gruppo';
$lang['edit_group_subheading']             = 'Inserire le informazioni del gruppo.';
$lang['edit_group_name_label']             = 'Nome Gruppo:';
$lang['edit_group_desc_label']             = 'Descrizione:';
$lang['edit_group_submit_btn']             = 'Salva Gruppo';
$lang['edit_group_validation_name_label']  = 'Nome Gruppo';
$lang['edit_group_validation_desc_label']  = 'Descrizione';

// Change Password
$lang['change_password_heading']                               = 'Cambia Password';
$lang['change_password_old_password_label']                    = 'Password Precedente:';
$lang['change_password_new_password_label']                    = 'Nuova Password (minimo %s caratteri):';
$lang['change_password_new_password_confirm_label']            = 'Conferma nuova password:';
$lang['change_password_submit_btn']                            = 'Cambia';
$lang['change_password_validation_old_password_label']         = 'Password Precedente';
$lang['change_password_validation_new_password_label']         = 'Nuova Password';
$lang['change_password_validation_new_password_confirm_label'] = 'Conferma Nuova Password';

// Forgot Password
$lang['forgot_password_heading']                 = 'Password dimenticata';
$lang['forgot_password_subheading']              = 'Inserire l\'indirizzo email per inviare la procedura del ripristino password.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Sottoscrivi';
$lang['forgot_password_validation_email_label']  = 'Email';
$lang['forgot_password_username_identity_label'] = 'Accesso';
$lang['forgot_password_email_identity_label']    = 'Email';
$lang['forgot_password_back']    = 'Ritorno';

// Reset Password
$lang['reset_password_heading']                               = 'Cambia Password';
$lang['reset_password_new_password_label']                    = 'Nuova password (minimo 8 сaratteri):';
$lang['reset_password_new_password_confirm_label']            = 'Conferma password:';
$lang['reset_password_submit_btn']                            = 'Cambia';
$lang['reset_password_validation_new_password_label']         = 'Nuova Password';
$lang['reset_password_validation_new_password_confirm_label'] = 'Conferma password';

// Activation Email
$lang['email_activate_heading']    = 'Аttiva account per%s';
$lang['email_activate_subheading'] = 'Si prega di seguire il link per %s.';
$lang['email_activate_link']       = 'Attiva account';

// Forgot Password Email
$lang['email_forgot_password_heading']    = 'Reimposta password per %s';
$lang['email_forgot_password_subheading'] = 'Si prega di seguire il link per %s.';
$lang['email_forgot_password_link']       = 'Reimposta password';

// New Password Email
$lang['email_new_password_heading']    = 'Nuova password per %s';
$lang['email_new_password_subheading'] = 'La password è stata ripristinata per: %s';
