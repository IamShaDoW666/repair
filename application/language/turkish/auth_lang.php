<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - Turkish
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
* Turkish Translate: @gevv

* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  04.10.2020
*
* Description:  Turkish language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] 							= 'Bu form gönderisi güvenlik kontrollerimizden geçmedi';

// Login
$lang['login_heading']         					= 'Giriş';
$lang['login_subheading']      					= 'Oturumunuzu başlatmak için giriş yapın';
$lang['login_identity_label']  					= 'E-posta / Kullanıcı Adı';
$lang['login_password_label']  					= 'Şifre';
$lang['login_remember_label']  					= 'Beni Hatırla';
$lang['login_submit_btn']      					= 'Giriş';
$lang['login_forgot_password'] 					= 'Şifrenizi mi unuttunuz?';

// Index
$lang['index_heading']          		 		= 'Kullanıcılar';
$lang['index_subheading']        				= 'Aşağıda kullanıcıların listesi bulunmaktadır.';
$lang['index_fname_th']          				= 'Adı';
$lang['index_lname_th']          				= 'Soyadı';
$lang['index_email_th']          				= 'E-posta';
$lang['index_groups_th']         				= 'Gruplar';
$lang['index_status_th']         				= 'Durum';
$lang['index_action_th']         				= 'Eylem';
$lang['index_active_link']       				= 'Etkin';
$lang['index_inactive_link']     				= 'Etkin Değil';
$lang['index_create_user_link']  				= 'Yeni bir kullanıcı oluştur';
$lang['index_create_group_link'] 				= 'Yeni bir grup oluştur';

// Deactivate User
$lang['deactivate_heading']                  	= 'Kullanıcıyı Devre Dışı Bırak';
$lang['deactivate_subheading']               	= '\'%s\' kullanıcısını devre dışı bırakmak istediğinizden emin misiniz';
$lang['deactivate_confirm_y_label']          	= 'Evet:';
$lang['deactivate_confirm_n_label']          	= 'Hayır:';
$lang['deactivate_submit_btn']               	= 'Gönder';
$lang['deactivate_validation_confirm_label'] 	= 'onay';
$lang['deactivate_validation_user_id_label'] 	= 'kullanıcı ID';

// Create User
$lang['create_user_heading']                           = 'Kullanıcı Oluştur';
$lang['create_user_subheading']                        = 'Lütfen aşağıya kullanıcı bilgilerini girin.';
$lang['create_user_fname_label']                       = 'Adı:';
$lang['create_user_lname_label']                       = 'Soyadı:';
$lang['create_user_company_label']                     = 'Şirket Adı:';
$lang['create_user_identity_label']                    = 'Kimlik:';
$lang['create_user_email_label']                       = 'E-posta:';
$lang['create_user_phone_label']                       = 'Telefon:';
$lang['create_user_password_label']                    = 'Şifre:';
$lang['create_user_password_confirm_label']            = 'Şifreyi Onayla:';
$lang['create_user_submit_btn']                        = 'Kullanıcı Oluştur';
$lang['create_user_validation_fname_label']            = 'Adı';
$lang['create_user_validation_lname_label']            = 'Soyadı';
$lang['create_user_validation_identity_label']         = 'Kimlik';
$lang['create_user_validation_email_label']            = 'E-posta Adresi';
$lang['create_user_validation_phone_label']            = 'Telefon';
$lang['create_user_validation_company_label']          = 'Şirket Adı';
$lang['create_user_validation_password_label']         = 'Şifre';
$lang['create_user_validation_password_confirm_label'] = 'Şifreyi Onayı';

// Edit User
$lang['edit_user_heading']                           = 'Kullanıcıyı Düzenle';
$lang['edit_user_subheading']                        = 'Lütfen aşağıya kullanıcı bilgilerini girin.';
$lang['edit_user_fname_label']                       = 'Adı:';
$lang['edit_user_lname_label']                       = 'Soyadı:';
$lang['edit_user_company_label']                     = 'Şirket Adı:';
$lang['edit_user_email_label']                       = 'E-posta:';
$lang['edit_user_phone_label']                       = 'Telefon:';
$lang['edit_user_password_label']                    = 'Şifre: (şifre değiştiriliyorsa)';
$lang['edit_user_password_confirm_label']            = 'Şifreyi Onayla: (şifre değiştiriliyorsa)';
$lang['edit_user_groups_heading']                    = 'Grup Üyeleri';
$lang['edit_user_submit_btn']                        = 'Kullanıcıyı Kaydet';
$lang['edit_user_validation_fname_label']            = 'Adı';
$lang['edit_user_validation_lname_label']            = 'Soyadı';
$lang['edit_user_validation_email_label']            = 'E-posta Adresi';
$lang['edit_user_validation_phone_label']            = 'Telefon';
$lang['edit_user_validation_company_label']          = 'Şirket Adı';
$lang['edit_user_validation_groups_label']           = 'Gruplar';
$lang['edit_user_validation_password_label']         = 'Şifre';
$lang['edit_user_validation_password_confirm_label'] = 'Şifre Onayı';

// Create Group
$lang['create_group_title']                  = 'Grup Oluştur';
$lang['create_group_heading']                = 'Grup Oluştur';
$lang['create_group_subheading']             = 'Lütfen aşağıya grup bilgilerini girin.';
$lang['create_group_name_label']             = 'Grup Adı:';
$lang['create_group_desc_label']             = 'Açıklama:';
$lang['create_group_submit_btn']             = 'Grup Oluştur';
$lang['create_group_validation_name_label']  = 'Grup Adı';
$lang['create_group_validation_desc_label']  = 'Açıklama';

// Edit Group
$lang['edit_group_title']                  = 'Grubu Düzenle';
$lang['edit_group_saved']                  = 'Grup Kaydedildi';
$lang['edit_group_heading']                = 'Grubu Düzenle';
$lang['edit_group_subheading']             = 'Lütfen aşağıya grup bilgilerini girin.';
$lang['edit_group_name_label']             = 'Grup Adı:';
$lang['edit_group_desc_label']             = 'Açıklama:';
$lang['edit_group_submit_btn']             = 'Grubu Kaydet';
$lang['edit_group_validation_name_label']  = 'Grup Adı';
$lang['edit_group_validation_desc_label']  = 'Açıklama';

// Change Password
$lang['change_password_heading']                               = 'Şifre Değiştir';
$lang['change_password_old_password_label']                    = 'Eski Şifre:';
$lang['change_password_new_password_label']                    = 'Yeni Şifre (en az %s karakter uzunluğunda):';
$lang['change_password_new_password_confirm_label']            = 'Yeni Şifreyi Onaylayın:';
$lang['change_password_submit_btn']                            = 'Değiştir';
$lang['change_password_validation_old_password_label']         = 'Eski Şifre';
$lang['change_password_validation_new_password_label']         = 'Yeni Şifre';
$lang['change_password_validation_new_password_confirm_label'] = 'Yeni Parolayı Onayla';

// Forgot Password
$lang['forgot_password_heading']                 = 'Şifremi Unuttum';
$lang['forgot_password_subheading']              = 'Lütfen %s kodunuzu girin, böylece size şifrenizi sıfırlamanız için bir e-posta gönderebiliriz.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Gönder';
$lang['forgot_password_validation_email_label']  = 'E-posta Adresi';
$lang['forgot_password_identity_label'] 		 = 'Kimlik';
$lang['forgot_password_email_identity_label']    = 'E-posta';
$lang['forgot_password_email_not_found']         = 'Bu e-posta adresinin kaydı yok.';

// Reset Password
$lang['reset_password_heading']                               = 'Şifreyi Değiştir';
$lang['reset_password_new_password_label']                    = 'Yeni Şifre (en az %s karakter uzunluğunda):';
$lang['reset_password_new_password_confirm_label']            = 'Yeni Şifreyi Onaylayın:';
$lang['reset_password_submit_btn']                            = 'Değiştir';
$lang['reset_password_validation_new_password_label']         = 'Yeni Şifre';
$lang['reset_password_validation_new_password_confirm_label'] = 'Yeni Parolayı Onayla';