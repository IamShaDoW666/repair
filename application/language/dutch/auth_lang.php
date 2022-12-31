<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Feodor Vidu
* 		  feodor.vidu@gmail.com
*        
*
* Created:  03.11.2018
*
* Description:  Dutch language file for Repairer example views
*
*/

// Errors
$lang['error_csrf'] = 'This form post did not pass our security checks.';

// Login
$lang['login_heading']         = 'Aanmelden';
$lang['login_subheading']      = 'Meld u aan om een nieuwe sessie te starten';
$lang['login_identity_label']  = 'E-mail/Gebruikersnaam';
$lang['login_password_label']  = 'Wachtwoord';
$lang['login_remember_label']  = 'Gegevens onthouden';
$lang['login_submit_btn']      = 'Aanmelden';
$lang['login_forgot_password'] = 'Wachtwoord vergeten?';

// Index
$lang['index_heading']           = 'Gebruikers';
$lang['index_subheading']        = 'Hieronder vindt u de gebruikerslijst.';
$lang['index_fname_th']          = 'Voornaam';
$lang['index_lname_th']          = 'Achternaam';
$lang['index_email_th']          = 'E-mail';
$lang['index_groups_th']         = 'Groepen';
$lang['index_status_th']         = 'Status';
$lang['index_action_th']         = 'Actie';
$lang['index_active_link']       = 'Werkzaam';
$lang['index_inactive_link']     = 'Inactief';
$lang['index_create_user_link']  = 'Een nieuw gebruikersaccount aanmaken';
$lang['index_create_group_link'] = 'Een nieuwe groep aanmaken';

// Deactivate User
$lang['deactivate_heading']                  = 'Deactiveer Gebruiker';
$lang['deactivate_subheading']               = 'Bent u zeker dat u deze gebruiker wilt deactiveren \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Ja:';
$lang['deactivate_confirm_n_label']          = 'Nee:';
$lang['deactivate_submit_btn']               = 'Verzenden';
$lang['deactivate_validation_confirm_label'] = 'Bevestiging';
$lang['deactivate_validation_user_id_label'] = 'Gebruikers-id';

// Create User
$lang['create_user_heading']                           = 'Gebruiker Aanmaken';
$lang['create_user_subheading']                        = 'Voer hieronder de gebruikersgegevens in.';
$lang['create_user_fname_label']                       = 'Voornaam:';
$lang['create_user_lname_label']                       = 'Achternaam:';
$lang['create_user_company_label']                     = 'Bedrijfsnaam:';
$lang['create_user_identity_label']                    = 'Identiteit:';
$lang['create_user_email_label']                       = 'E-mail:';
$lang['create_user_phone_label']                       = 'Telefoonnummer:';
$lang['create_user_password_label']                    = 'Wachtwoord:';
$lang['create_user_password_confirm_label']            = 'Wachtwoord Bevestigen:';
$lang['create_user_submit_btn']                        = 'Gebruiker Aanmaken';
$lang['create_user_validation_fname_label']            = 'Voornaam';
$lang['create_user_validation_lname_label']            = 'Achternaam';
$lang['create_user_validation_identity_label']         = 'Identiteit';
$lang['create_user_validation_email_label']            = 'E-mailadres';
$lang['create_user_validation_phone_label']            = 'Telefoonnummer';
$lang['create_user_validation_company_label']          = 'Bedrijfsnaam';
$lang['create_user_validation_password_label']         = 'Wachtwoord';
$lang['create_user_validation_password_confirm_label'] = 'Wachtwoord bevestiging';

// Edit User
$lang['edit_user_heading']                           = 'Bewerk Gebruiker';
$lang['edit_user_subheading']                        = 'Voer hieronder de gebruikersgegevens in.';
$lang['edit_user_fname_label']                       = 'Voornaam:';
$lang['edit_user_lname_label']                       = 'Achternaam:';
$lang['edit_user_company_label']                     = 'Bedrijfsnaam:';
$lang['edit_user_email_label']                       = 'E-mail:';
$lang['edit_user_phone_label']                       = 'Telefoonnummer:';
$lang['edit_user_password_label']                    = 'Wachtwoord: (indien wachtwoord gewijzigd wordt)';
$lang['edit_user_password_confirm_label']            = 'Bevestig Wachtwoord: (indien wachtwoord gewijzigd wordt)';
$lang['edit_user_groups_heading']                    = 'Lid van groepen';
$lang['edit_user_submit_btn']                        = 'Bewaar Deze Gebruiker';
$lang['edit_user_validation_fname_label']            = 'Voornaam';
$lang['edit_user_validation_lname_label']            = 'Achternaam';
$lang['edit_user_validation_email_label']            = 'E-mailadres';
$lang['edit_user_validation_phone_label']            = 'Telefoonnummer';
$lang['edit_user_validation_company_label']          = 'Bedrijfsnaam';
$lang['edit_user_validation_groups_label']           = 'Groepen';
$lang['edit_user_validation_password_label']         = 'Wachtwoord';
$lang['edit_user_validation_password_confirm_label'] = 'Wachtwoord Bevestiging';

// Create Group
$lang['create_group_title']                  = 'Groep Aanmaken';
$lang['create_group_heading']                = 'Groep Aanmaken';
$lang['create_group_subheading']             = 'Voer hieronder de groepsgegevens in.';
$lang['create_group_name_label']             = 'Groepsnaam:';
$lang['create_group_desc_label']             = 'Beschrijving:';
$lang['create_group_submit_btn']             = 'Groep Aanmaken';
$lang['create_group_validation_name_label']  = 'Groepsnaam';
$lang['create_group_validation_desc_label']  = 'Beschrijving';

// Edit Group
$lang['edit_group_title']                  = 'Bewerk Groep';
$lang['edit_group_saved']                  = 'Groep Is Opgeslaan';
$lang['edit_group_heading']                = 'Bewerk Groep';
$lang['edit_group_subheading']             = 'Voer hieronder de groepsgegevens in.';
$lang['edit_group_name_label']             = 'Groepsnaam:';
$lang['edit_group_desc_label']             = 'Beschrijving:';
$lang['edit_group_submit_btn']             = 'Groep opslaan';
$lang['edit_group_validation_name_label']  = 'Groepsnaam';
$lang['edit_group_validation_desc_label']  = 'Beschrijving';

// Change Password
$lang['change_password_heading']                               = 'Wijzig Wachtwoord';
$lang['change_password_old_password_label']                    = 'Huidig Wachtwoord:';
$lang['change_password_new_password_label']                    = 'Nieuw wachtwoord (minstens %s tekens lang):';
$lang['change_password_new_password_confirm_label']            = 'Bevestig nieuw wachtwoord:';
$lang['change_password_submit_btn']                            = 'Wijzig';
$lang['change_password_validation_old_password_label']         = 'Huidig Wachtwoord';
$lang['change_password_validation_new_password_label']         = 'Nieuw Wachtwoord';
$lang['change_password_validation_new_password_confirm_label'] = 'Bevestig nieuw wachtwoord';

// Forgot Password
$lang['forgot_password_heading']                 = 'Wachtwoord Vergeten';
$lang['forgot_password_subheading']              = 'Gelieve uw %s in te geven zodat we u een e-mail kunnen sturen om uw wachtwoord opnieuw in te stellen.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Verzenden';
$lang['forgot_password_validation_email_label']  = 'E-mailadres';
$lang['forgot_password_identity_label'] = 'Identity';
$lang['forgot_password_email_identity_label']    = 'E-mail';
$lang['forgot_password_email_not_found']         = 'Geen gegevens beschikbaar voor dit e-mailadres.';

// Reset Password
$lang['reset_password_heading']                               = 'Wijzig Wachtwoord';
$lang['reset_password_new_password_label']                    = 'Nieuw Wachtwoord (Minstens %s tekens lang):';
$lang['reset_password_new_password_confirm_label']            = 'Bevestig Nieuw Wachtwoord:';
$lang['reset_password_submit_btn']                            = 'Wijzig';
$lang['reset_password_validation_new_password_label']         = 'Nieuw wachtwoord';
$lang['reset_password_validation_new_password_confirm_label'] = 'Bevestig Nieuw Wachtwoord';
