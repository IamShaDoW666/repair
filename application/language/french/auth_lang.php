<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  English language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'This form post did not pass our security checks.';

// Login
$lang['login_heading']         = 'Connexion';
$lang['login_subheading']      = 'Connectez vous';
$lang['login_identity_label']  = 'Email/Username';
$lang['login_password_label']  = 'Mot de passe';
$lang['login_remember_label']  = 'Se rappeler de moi';
$lang['login_submit_btn']      = 'Login';
$lang['login_forgot_password'] = 'Mot de passe oublié ?';

// Index
$lang['index_heading']           = 'Utilisateur';
$lang['index_subheading']        = 'Below is a list of the users.';
$lang['index_fname_th']          = 'Prénom';
$lang['index_lname_th']          = 'Nom';
$lang['index_email_th']          = 'E-mail';
$lang['index_groups_th']         = 'Groupe';
$lang['index_status_th']         = 'Statut';
$lang['index_action_th']         = 'Action';
$lang['index_active_link']       = 'Active';
$lang['index_inactive_link']     = 'Inactive';
$lang['index_create_user_link']  = 'Créer nouvel utilisateur';
$lang['index_create_group_link'] = 'Créer nouveau groupe';

// Deactivate User
$lang['deactivate_heading']                  = 'Desactiver utilisateur';
$lang['deactivate_subheading']               = 'Sur de désactiver l\'utilisateur \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Oui ';
$lang['deactivate_confirm_n_label']          = 'Non :';
$lang['deactivate_submit_btn']               = 'Confirmer';
$lang['deactivate_validation_confirm_label'] = 'Confirmation';
$lang['deactivate_validation_user_id_label'] = 'user ID';

// Create User
$lang['create_user_heading']                           = 'Créer utilisateur';
$lang['create_user_subheading']                        = 'Please enter the user\'s information below.';
$lang['create_user_fname_label']                       = 'Prénom :';
$lang['create_user_lname_label']                       = 'Nom :';
$lang['create_user_company_label']                     = 'Nom sté :';
$lang['create_user_identity_label']                    = 'Identité :';
$lang['create_user_email_label']                       = 'E-mail:';
$lang['create_user_phone_label']                       = 'Téléphone:';
$lang['create_user_password_label']                    = 'MDP :';
$lang['create_user_password_confirm_label']            = 'Confirmation MDP :';
$lang['create_user_submit_btn']                        = 'Creer utilisateur';
$lang['create_user_validation_fname_label']            = 'Prénom';
$lang['create_user_validation_lname_label']            = 'Nom';
$lang['create_user_validation_identity_label']         = 'Identité';
$lang['create_user_validation_email_label']            = 'E-mail';
$lang['create_user_validation_phone_label']            = 'Téléphone';
$lang['create_user_validation_company_label']          = 'Nom sté';
$lang['create_user_validation_password_label']         = 'MDP';
$lang['create_user_validation_password_confirm_label'] = 'Confirmation MDP';

// Edit User
$lang['edit_user_heading']                           = 'Editer utilisateur';
$lang['edit_user_subheading']                        = 'Please enter the user\'s information below.';
$lang['edit_user_fname_label']                       = 'Prénom :';
$lang['edit_user_lname_label']                       = 'Nom :';
$lang['edit_user_company_label']                     = 'Nom sté:';
$lang['edit_user_email_label']                       = 'E-mail:';
$lang['edit_user_phone_label']                       = 'Téléphone:';
$lang['edit_user_password_label']                    = 'MDP: (Si mot de passe changé)';
$lang['edit_user_password_confirm_label']            = 'Confirm MDP: (Si mot de passe changé)';
$lang['edit_user_groups_heading']                    = 'Membre du groupe';
$lang['edit_user_submit_btn']                        = 'Sauvegarder';
$lang['edit_user_validation_fname_label']            = 'Prénom';
$lang['edit_user_validation_lname_label']            = 'Nom';
$lang['edit_user_validation_email_label']            = 'E-mail';
$lang['edit_user_validation_phone_label']            = 'Téléphone';
$lang['edit_user_validation_company_label']          = 'Nom Sté';
$lang['edit_user_validation_groups_label']           = 'Groupe';
$lang['edit_user_validation_password_label']         = 'MDP';
$lang['edit_user_validation_password_confirm_label'] = 'Confirmation MDP';

// Create Group
$lang['create_group_title']                  = 'Créer groupe';
$lang['create_group_heading']                = 'Créer groupe';
$lang['create_group_subheading']             = 'Please enter the group information below.';
$lang['create_group_name_label']             = 'Nom groupe:';
$lang['create_group_desc_label']             = 'Description:';
$lang['create_group_submit_btn']             = 'Créer groupe';
$lang['create_group_validation_name_label']  = 'Nom groupe';
$lang['create_group_validation_desc_label']  = 'Description';

// Edit Group
$lang['edit_group_title']                  = 'Modifier Groupe';
$lang['edit_group_saved']                  = 'Groupe sauvé';
$lang['edit_group_heading']                = 'Modifier groupe';
$lang['edit_group_subheading']             = 'Please enter the group information below.';
$lang['edit_group_name_label']             = 'Nom groupe :';
$lang['edit_group_desc_label']             = 'Description:';
$lang['edit_group_submit_btn']             = 'Sauver Groupe';
$lang['edit_group_validation_name_label']  = 'Nom groupe ';
$lang['edit_group_validation_desc_label']  = 'Description';

// Change Password
$lang['change_password_heading']                               = 'Changeer MDP';
$lang['change_password_old_password_label']                    = 'Ancien MDP:';
$lang['change_password_new_password_label']                    = 'Nouveau MDP (au moins %s caractères):';
$lang['change_password_new_password_confirm_label']            = 'Confirmer :';
$lang['change_password_submit_btn']                            = 'Changer';
$lang['change_password_validation_old_password_label']         = 'Ancien MDP';
$lang['change_password_validation_new_password_label']         = 'Nouveau MDP';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirmer nouveau MDP';

// Forgot Password
$lang['forgot_password_heading']                 = 'MDP oublié';
$lang['forgot_password_subheading']              = 'Merci d\'entrer votre %s nous vous enverrons un mail pour reinitialiser votre MDP.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Entrer';
$lang['forgot_password_validation_email_label']  = 'E-mail';
$lang['forgot_password_identity_label'] = 'Identité';
$lang['forgot_password_email_identity_label']    = 'E-mail';
$lang['forgot_password_email_not_found']         = 'Pas d\'enregistrement sur ce mail.';

// Reset Password
$lang['reset_password_heading']                               = 'Changer MDP';
$lang['reset_password_new_password_label']                    = 'Nouveau MDP (au moins %s caractères):';
$lang['reset_password_new_password_confirm_label']            = 'Confirmer nouveau MDP :';
$lang['reset_password_submit_btn']                            = 'Changer';
$lang['reset_password_validation_new_password_label']         = 'Nouveau MDP';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirmer nouveau MDP';
