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

// Грешки
$lang['error_csrf'] = 'Тази публикация във формуляра не премина нашите проверки за сигурност.';

// Влизам
$lang['login_heading'] = 'Вход';
$lang['login_subheading'] = 'Влезте, за да започнете сесията си';
$lang['login_identity_label'] = 'Имейл / потребителско име';
$lang['login_password_label'] = 'Парола';
$lang['login_remember_label'] = 'Запомни ме';
$lang['login_submit_btn'] = 'Вход';
$lang['login_forgot_password'] = 'Забравена парола?';

// Индекс
$lang['index_heading'] = 'Потребители';
$lang['index_subheading'] = 'По-долу е списък на потребителите.';
$lang['index_fname_th'] = 'Име';
$lang['index_lname_th'] = 'Фамилия';
$lang['index_email_th'] = 'Имейл';
$lang['index_groups_th'] = 'Групи';
$lang['index_status_th'] = 'Състояние';
$lang['indexgery_th'] = 'Действие';
$lang['index_active_link'] = 'Активен';
$lang['index_inactive_link'] = 'Неактивен';
$lang['index_create_user_link'] = 'Създаване на нов потребител';
$lang['index_create_group_link'] = 'Създаване на нова група';

// Деактивиране на потребителя
$lang['deactivate_heading'] = 'Деактивиране на потребителя';
$lang['deactivate_subheading'] = 'Сигурни ли сте, че искате да деактивирате потребителя \'% s \ ';
$lang['deactivate_confirm_y_label'] = 'Да:';
$lang['deactivate_confirm_n_label'] = 'Не:';
$lang['deactivate_submit_btn'] = 'Изпращане';
$lang['deactivate_validation_confirm_label'] = 'потвърждение';
$lang['deactivate_validation_user_id_label'] = 'идентификационен номер на потребителя';

// Създаване на потребител
$lang['create_user_heading'] = 'Създаване на потребител';
$lang['create_user_subheading'] = 'Моля, въведете по-долу информацията на потребителя.';
$lang['create_user_fname_label'] = 'Име:';
$lang['create_user_lname_label'] = 'Фамилия:';
$lang['create_user_company_label'] = 'Име на компанията:';
$lang['create_user_identity_label'] = 'Идентичност:';
$lang['create_user_email_label'] = 'Имейл:';
$lang['create_user_phone_label'] = 'Телефон:';
$lang['create_user_password_label'] = 'Парола:';
$lang['create_user_password_confirm_label'] = 'Потвърждаване на парола:';
$lang['create_user_submit_btn'] = 'Създаване на потребител';
$lang['create_user_validation_fname_label'] = 'Име';
$lang['create_user_validation_lname_label'] = 'Фамилия';
$lang['create_user_validation_identity_label'] = 'Идентичност';
$lang['create_user_validation_email_label'] = 'Имейл адрес';
$lang['create_user_validation_phone_label'] = 'Телефон';
$lang['create_user_validation_company_label'] = 'Име на компанията';
$lang['create_user_validation_password_label'] = 'Парола';
$lang['create_user_validation_password_confirm_label'] = 'Потвърждение на паролата';

// Редактиране на потребител
$lang['edit_user_heading'] = 'Редактиране на потребител';
$lang['edit_user_subheading'] = 'Моля, въведете по-долу информацията на потребителя.';
$lang['edit_user_fname_label'] = 'Име:';
$lang['edit_user_lname_label'] = 'Фамилия:';
$lang['edit_user_company_label'] = 'Име на компанията:';
$lang['edit_user_email_label'] = 'Имейл:';
$lang['edit_user_phone_label'] = 'Телефон:';
$lang['edit_user_password_label'] = 'Парола: (ако променяте паролата)';
$lang['edit_user_password_confirm_label'] = 'Потвърдете паролата: (ако промените паролата)';
$lang['edit_user_groups_heading'] = 'Член на групи';
$lang['edit_user_submit_btn'] = 'Запазване на потребителя';
$lang['edit_user_validation_fname_label'] = 'Име';
$lang['edit_user_validation_lname_label'] = 'Фамилия';
$lang['edit_user_validation_email_label'] = 'Имейл адрес';
$lang['edit_user_validation_phone_label'] = 'Телефон';
$lang['edit_user_validation_company_label'] = 'Име на компанията';
$lang['edit_user_validation_groups_label'] = 'Групи';
$lang['edit_user_validation_password_label'] = 'Парола';
$lang['edit_user_validation_password_confirm_label'] = 'Потвърждение на паролата';

// Създай група
$lang['create_group_title'] = 'Създаване на група';
$lang['create_group_heading'] = 'Създаване на група';
$lang['create_group_subheading'] = 'Моля, въведете информацията за групата по-долу.';
$lang['create_group_name_label'] = 'Име на групата:';
$lang['create_group_desc_label'] = 'Описание:';
$lang['create_group_submit_btn'] = 'Създаване на група';
$lang['create_group_validation_name_label'] = 'Име на групата';
$lang['create_group_validation_desc_label'] = 'Описание';

// Редактиране на група
$lang['edit_group_title'] = 'Редактиране на група';
$lang['edit_group_saved'] = 'Групата е запазена';
$lang['edit_group_heading'] = 'Редактиране на група';
$lang['edit_group_subheading'] = 'Моля, въведете информацията за групата по-долу.';
$lang['edit_group_name_label'] = 'Име на групата:';
$lang['edit_group_desc_label'] = 'Описание:';
$lang['edit_group_submit_btn'] = 'Запазване на групата';
$lang['edit_group_validation_name_label'] = 'Име на групата';
$lang['edit_group_validation_desc_label'] = 'Описание';

// Промяна на паролата
$lang['change_password_heading'] = 'Промяна на паролата';
$lang['change_password_old_password_label'] = 'Стара парола:';
$lang['change_password_new_password_label'] = 'Нова парола (най-малко% s знака):';
$lang['change_password_new_password_confirm_label'] = 'Потвърждаване на нова парола:';
$lang['change_password_submit_btn'] = 'Промяна';
$lang['change_password_validation_old_password_label'] = 'Стара парола';
$lang['change_password_validation_new_password_label'] = 'Нова парола';
$lang['change_password_validation_new_password_confirm_label'] = 'Потвърждаване на нова парола';

// Забравена парола
$lang['Forgot_password_heading'] = 'Забравена парола';
$lang['Forgot_password_subheading'] = 'Моля, въведете% s, за да можем да ви изпратим имейл, за да нулирате паролата си.';
$lang['Forgot_password_email_label'] = '% s:';
$lang['Forgot_password_submit_btn'] = 'Изпращане';
$lang['borav_password_validation_email_label '] =' Адрес на имейл ';
$lang['borav_password_identity_label '] =' Идентичност ';
$lang['borav_password_email_identity_label '] =' Имейл ';
$lang['borav_password_email_not_found '] =' Няма запис на този имейл адрес. ';

// Възстановяване на парола
$lang['reset_password_heading'] = 'Промяна на паролата';
$lang['reset_password_new_password_label'] = 'Нова парола (най-малко% s символа):';
$lang['reset_password_new_password_confirm_label'] = 'Потвърждаване на нова парола:';
$lang['reset_password_submit_btn'] = 'Промяна';
$lang['reset_password_validation_new_password_label'] = 'Нова парола';
$lang['reset_password_validation_new_password_confirm_label'] = 'Потвърждаване на нова парола';