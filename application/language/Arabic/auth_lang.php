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
$lang['error_csrf'] = 'لم يتم تجاوز فحصوصات الأمان الخاصة بنا.';

// Login
$lang['login_heading']         = 'دخول';
$lang['login_subheading']      = 'تسجيل الدخول لبدء الجلسة';
$lang['login_identity_label']  = 'البريد\إسم المستخدم';
$lang['login_password_label']  = 'كلمة المرور';
$lang['login_remember_label']  = 'تذكرني';
$lang['login_submit_btn']      = 'دخول';
$lang['login_forgot_password'] = 'هل نسيت كلمة المرور؟';

// Index
$lang['index_heading']           = 'المستخدمون';
$lang['index_subheading']        = 'أدناه قائمة المستخدمين.';
$lang['index_fname_th']          = 'الاسم';
$lang['index_lname_th']          = 'اسم العائلة';
$lang['index_email_th']          = 'البريد';
$lang['index_groups_th']         = 'مجموعات';
$lang['index_status_th']         = 'الحالة';
$lang['index_action_th']         = 'إجراء';
$lang['index_active_link']       = 'نشط';
$lang['index_inactive_link']     = 'غير نشط';
$lang['index_create_user_link']  = 'قم بإنشاء مستخدم جديد';
$lang['index_create_group_link'] = 'أنشئ مجموعة جديدة';

// Deactivate User
$lang['deactivate_heading']                  = 'قم بإلغاء تنشيط المستخدم';
$lang['deactivate_subheading']               = 'هل أنت متأكد أنك تريد إلغاء تنشيط المستخدم \'%s\'';
$lang['deactivate_confirm_y_label']          = 'نعم:';
$lang['deactivate_confirm_n_label']          = 'لا:';
$lang['deactivate_submit_btn']               = 'إرسال';
$lang['deactivate_validation_confirm_label'] = 'التأكيد';
$lang['deactivate_validation_user_id_label'] = 'معرف المستخدم';

// Create User
$lang['create_user_heading']                           = 'انشاء مستخدم جديد ';
$lang['create_user_subheading']                        = 'الرجاء إدخال معلومات المستخدم أدناه.';
$lang['create_user_fname_label']                       = 'الاسم الاول:';
$lang['create_user_lname_label']                       = 'الاسم الاخير:';
$lang['create_user_company_label']                     = 'اسم الشركة:';
$lang['create_user_identity_label']                    = 'الهوية:';
$lang['create_user_email_label']                       = 'البريد الالكتروني';
$lang['create_user_phone_label']                       = 'رقم الهاتف:';
$lang['create_user_password_label']                    = 'كلمة السر:';
$lang['create_user_password_confirm_label']            = 'تأكيد كلمة السر:';
$lang['create_user_submit_btn']                        = 'انشاء مستخدم جديد';
$lang['create_user_validation_fname_label']            = 'الاسم الاول';
$lang['create_user_validation_lname_label']            = 'الاسم الاخير';
$lang['create_user_validation_identity_label']         = 'الهوية';
$lang['create_user_validation_email_label']            = 'عنوان البريد الالكتروني';
$lang['create_user_validation_phone_label']            = 'رقم الهاتف';
$lang['create_user_validation_company_label']          = 'اسم الشركة';
$lang['create_user_validation_password_label']         = 'كلمة السر';
$lang['create_user_validation_password_confirm_label'] = 'تاكيد كلمة السر';

// Edit User
$lang['edit_user_heading']                           = 'تحرير العضو';
$lang['edit_user_subheading']                        = 'الرجاء إدخال معلومات المستخدم أدناه.';
$lang['edit_user_fname_label']                       = 'الاسم الاول:';
$lang['edit_user_lname_label']                       = 'الكنية:';
$lang['edit_user_company_label']                     = 'اسم الشركة:';
$lang['edit_user_email_label']                       = 'بريد إلكتروني:';
$lang['edit_user_phone_label']                       = 'هاتف:';
$lang['edit_user_password_label']                    = 'كلمة المرور: (في حالة تغيير كلمة المرور)';
$lang['edit_user_password_confirm_label']            = 'تأكيد كلمة المرور: (في حالة تغيير كلمة المرور)';
$lang['edit_user_groups_heading']                    = 'عضو في المجموعات';
$lang['edit_user_submit_btn']                        = 'حفظ المستخدم';
$lang['edit_user_validation_fname_label']            = 'الاسم الاول';
$lang['edit_user_validation_lname_label']            = 'اسم العائلة';
$lang['edit_user_validation_email_label']            = 'عنوان البريد الإلكتروني';
$lang['edit_user_validation_phone_label']            = 'هاتف';
$lang['edit_user_validation_company_label']          = 'اسم الشركة';
$lang['edit_user_validation_groups_label']           = 'مجموعات';
$lang['edit_user_validation_password_label']         = 'كلمة المرور';
$lang['edit_user_validation_password_confirm_label'] = 'تأكيد كلمة المرور';

// Create Group
$lang['create_group_title']                  = 'إنشاء مجموعة';
$lang['create_group_heading']                = 'إنشاء مجموعة';
$lang['create_group_subheading']             = 'الرجاء إدخال معلومات المجموعة أدناه.';
$lang['create_group_name_label']             = 'اسم المجموعة:';
$lang['create_group_desc_label']             = 'الوصف:';
$lang['create_group_submit_btn']             = 'إنشاء مجموعة';
$lang['create_group_validation_name_label']  = 'اسم المجموعة';
$lang['create_group_validation_desc_label']  = 'الوصف';

// Edit Group
$lang['edit_group_title']                  = 'تحرير المجموعة';
$lang['edit_group_saved']                  = 'تم حفظ المجموعة';
$lang['edit_group_heading']                = 'تحرير المجموعة';
$lang['edit_group_subheading']             = 'الرجاء إدخال معلومات المجموعة أدناه.';
$lang['edit_group_name_label']             = 'اسم المجموعة:';
$lang['edit_group_desc_label']             = 'الوصف:';
$lang['edit_group_submit_btn']             = 'حفظ المجموعة';
$lang['edit_group_validation_name_label']  = 'اسم المجموعة';
$lang['edit_group_validation_desc_label']  = 'الوصف';

// Change Password
$lang['change_password_heading']                               = 'تغيير كلمة المرور';
$lang['change_password_old_password_label']                    = 'كلمة المرور القديمة:';
$lang['change_password_new_password_label']                    = 'كلمة مرور جديدة (بطول %s من الأحرف على الأقل):';
$lang['change_password_new_password_confirm_label']            = 'تأكيد كلمة المرور الجديدة:';
$lang['change_password_submit_btn']                            = 'تغيير';
$lang['change_password_validation_old_password_label']         = 'كلمة المرور القديمة';
$lang['change_password_validation_new_password_label']         = 'كلمة المرور الجديدة';
$lang['change_password_validation_new_password_confirm_label'] = 'تأكيد كلمة المرور الجديدة';

// Forgot Password
$lang['forgot_password_heading']                 = 'هل نسيت كلمة المرور';
$lang['forgot_password_subheading']              = 'الرجاء إدخال %s الخاص بك حتى نتمكن من إرسال بريد إلكتروني لك لإعادة تعيين كلمة المرور الخاصة بك.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'إرسال';
$lang['forgot_password_validation_email_label']  = 'عنوان البريد الإلكتروني';
$lang['forgot_password_identity_label'] = 'الهوية';
$lang['forgot_password_email_identity_label']    = 'بريد إلكتروني';
$lang['forgot_password_email_not_found']         = 'لا يوجد سجل لهذا البريد الإلكتروني.';

// Reset Password
$lang['reset_password_heading']                               = 'تغيير كلمة المرور';
$lang['reset_password_new_password_label']                    = 'كلمة مرور جديدة (بطول %s من الأحرف على الأقل):';
$lang['reset_password_new_password_confirm_label']            = 'تأكيد كلمة المرور الجديدة:';
$lang['reset_password_submit_btn']                            = 'تغيير';
$lang['reset_password_validation_new_password_label']         = 'كلمة المرور الجديدة';
$lang['reset_password_validation_new_password_confirm_label'] = 'تأكيد كلمة المرور الجديدة';
