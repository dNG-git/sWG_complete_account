<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

This Source Code Form is subject to the terms of the Mozilla Public License,
v. 2.0. If a copy of the MPL was not distributed with this file, You can
obtain one at http://mozilla.org/MPL/2.0/.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;mpl2
----------------------------------------------------------------------------
#echo(sWGaccountVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* account_status_ex/swgi_email.php
*
* @internal   We are using phpDocumentor to automate the documentation process
*             for creating the Developer's Manual. All sections including
*             these special comments will be removed from the release source
*             code.
*             Use the following line to ensure 76 character sizes:
* ----------------------------------------------------------------------------
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG
* @subpackage account
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/*#use(direct_use) */
use dNG\sWG\directSendmailerFormtags,
    dNG\sWG\dhandler\directUser,
    dNG\sWG\web\directPyHelper;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Basic configuration

/* -------------------------------------------------------------------------
Direct calls will be honored with an "exit ()"
------------------------------------------------------------------------- */

if (!defined ("direct_product_iversion")) { exit (); }

//j// Functions and classes

/**
* Modification function called by:
* m = account
* s = status_ex
* a = login
*
* @param  array $f_data Array containing call specific data.
* @return boolean Always true
* @since  v0.1.00
*/
function direct_mods_account_status_ex_email_login ($f_data)
{
	global $direct_cachedata,$direct_globals;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login (+f_data)- (#echo(__LINE__)#)"); }

	if ($f_data[1] == "email") { $direct_globals['formbuilder']->entryAddEMail (array ("name" => "amods_account_status_ex_email","title" => (direct_local_get ("account_email")),"content" => "","required" => true,"size" => "l","min" => 5,"max" => 255,"helper_text" => (direct_local_get ("account_helper_email")))); }
	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Modification function called by:
* m = account
* s = status_ex
* a = login-save
*
* @param  array $f_data Array containing call specific data.
* @return boolean True if the modification is able to process the login
* @since  v0.1.00
*/
function direct_mods_account_status_ex_email_login_check ($f_data)
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_check (+f_data)- (#echo(__LINE__)#)"); }

	$f_return = ($f_data[0] ? $f_data[0] : false);

	if ($f_data[1] == "email")
	{
		$direct_cachedata['i_amods_account_status_ex_email'] = (isset ($GLOBALS['i_amods_account_status_ex_email']) ? ($direct_globals['basic_functions']->inputfilterBasic ($GLOBALS['i_amods_account_status_ex_email'])) : "");
		$direct_globals['formbuilder']->entryAddEMail (array ("name" => "amods_account_status_ex_email","title" => (direct_local_get ("account_email")),"required" => true,"size" => "l","min" => 5,"max" => 255,"helper_text" => (direct_local_get ("account_helper_email"))));
		$f_return = true;
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_check ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Modification function called by:
* m = account
* s = status_ex
* a = login-save
*
* @param  array $f_data Array containing call specific data.
* @return boolean True if modification login process was successful
* @since  v0.1.00
*/
function direct_mods_account_status_ex_email_login_process ($f_data)
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_process (+f_data)- (#echo(__LINE__)#)"); }

	$f_return = ($f_data[0] ? $f_data[0] : -1);

	if ($f_data[1] == "email")
	{
		$f_return = 1;
		$f_user_insert = false;

		if (is_array ($f_data[2]))
		{
			if ($f_data[2]['ddbusers_type'] != "ex")
			{
				$direct_globals['formbuilder']->entryErrorSet ("ausername",(direct_local_get ("errors_account_username_exists")),NULL,$direct_cachedata['output_formelements']);
				$f_return = -1;
			}
			elseif (($f_data[2]['ddbusers_type_ex'] != "email")||($f_data[2]['ddbusers_email'] != $direct_cachedata['i_amods_account_status_ex_email']))
			{
				$direct_globals['formbuilder']->entryErrorSet ("amods_account_status_ex_email",(direct_local_get ("errors_core_access_denied")),NULL,$direct_cachedata['output_formelements']);
				$f_return = -1;
			}
			else { $f_user_array = $f_data[2]; }
		}
		else
		{
			$f_user_object = new directUser ();

			if (($f_user_object)&&(direct_class_function_check ($f_user_object,"get_aid")))
			{
				$f_attributes = array ($direct_settings['users_table'].".ddbusers_banned",$direct_settings['users_table'].".ddbusers_deleted",$direct_settings['users_table'].".ddbusers_locked",$direct_settings['users_table'].".ddbusers_email");
				$f_values = array (0,0,0,$direct_cachedata['i_amods_account_status_ex_email']);
				$f_user_array = $f_user_object->getAid ($f_attributes,$f_values);

				if (!is_array ($f_user_array))
				{
$f_user_array = array (
"ddbusers_id" => uniqid (""),
"ddbusers_type" => "ex",
"ddbusers_type_ex" => "email",
"ddbusers_banned" => 0,
"ddbusers_deleted" => 0,
"ddbusers_locked" => 0,
"ddbusers_name" => $direct_cachedata['i_ausername'],
"ddbusers_password" => "",
"ddbusers_email" => $direct_cachedata['i_amods_account_status_ex_email'],
"ddbusers_email_public" => 0,
"ddbusers_credits" => 0,
"ddbusers_registration_ip" => $direct_settings['user_ip'],
"ddbusers_registration_time" => $direct_cachedata['core_time'],
"ddbusers_secid" => "",
"ddbusers_lastvisit_ip" => $direct_settings['user_ip'],
"ddbusers_lastvisit_time" => $direct_cachedata['core_time'],
"ddbusers_timezone" => 0
);

					if ($f_user_object->set ($f_user_array)) { $f_user_insert = true; }
					else { $f_user_array = array ("ddbusers_type" => "gt"); }
				}

				if ($f_user_array['ddbusers_type'] != "ex")
				{
					$direct_globals['formbuilder']->entryErrorSet ("ausername",(direct_local_get ("errors_core_access_denied")),NULL,$direct_cachedata['output_formelements']);
					$f_return = -1;
				}
				elseif ($f_user_array['ddbusers_type_ex'] != "email")
				{
					$direct_globals['formbuilder']->entryErrorSet ("amods_account_status_ex_email",(direct_local_get ("errors_core_access_denied")),NULL,$direct_cachedata['output_formelements']);
					$f_return = -1;
				}
				elseif ($f_user_array['ddbusers_deleted']) { $f_user_array['ddbusers_deleted'] = 0; }
			}
			else
			{
				$direct_globals['formbuilder']->entryErrorSet ("amods_account_status_ex_email",(direct_local_get ("errors_core_unknown_error")),NULL,$direct_cachedata['output_formelements']);
				$f_return = -1;
			}
		}

		if ($f_return > 0)
		{
			if ($f_user_insert) { $f_return = $direct_globals['kernel']->vUserInsert ($f_user_array['ddbusers_id'],$f_user_array); }
			else
			{
				if ($direct_cachedata['i_ausername'] != $f_user_array['ddbusers_name']) { $f_user_array['ddbusers_name'] = $direct_cachedata['i_ausername']; }
				$f_user_array['ddbusers_lastvisit_ip'] = $direct_settings['user_ip'];
				$f_user_array['ddbusers_lastvisit_time'] = $direct_cachedata['core_time'];
				$f_return = $direct_globals['kernel']->vUserUpdate ($f_user_array['ddbusers_id'],$f_user_array);
			}

			if ($f_return) { $f_return = 1; }
			else
			{
				$direct_globals['formbuilder']->entryErrorSet ("amods_account_status_ex_email",(direct_local_get ("errors_core_unknown_error")),NULL,$direct_cachedata['output_formelements']);
				$f_return = -1;
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_process ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Modification function called by:
* m = account
* s = status_ex
* a = login-save
*
* @param  array $f_data Array containing call specific data.
* @return boolean True if modification login process was successful
* @since  v0.1.00
*/
function direct_mods_account_status_ex_email_login_save ($f_data)
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_save (+f_data)- (#echo(__LINE__)#)"); }

	$f_return = ((is_array ($f_data[0])) ? $f_data[0] : $f_data[3]);
	if ((!$direct_globals['basic_functions']->includeClass ('dNG\sWG\directSendmailerFormtags'))||(!$direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php"))) { $f_return = array (); }

	if (($f_data[1] == "email")&&(isset ($f_return['userid'])))
	{
		$f_uuid = $direct_globals['input']->uuidGet ();

		$f_uuid_storage_array = direct_tmp_storage_get ("evars",$f_uuid,"","task_cache");
		if (!$f_uuid_storage_array) { $f_uuid_storage_array = array (); }

		$f_uuid_storage_array['account_status_ex_type'] = "email";
		$f_uuid_storage_array['account_status_ex_verified'] = 0;
		if (!isset ($f_uuid_storage_array['core_sid'])) { $f_uuid_storage_array['core_sid'] = "e268443e43d93dab7ebef303bbe9642f"; }
		// md5 ("account")
		if (!isset ($f_uuid_storage_array['uuid'])) { $f_uuid_storage_array['uuid'] = $f_uuid; }

		if (direct_tmp_storage_write ($f_uuid_storage_array,$f_uuid,$f_uuid_storage_array['core_sid'],"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_inactivity'])))
		{
			$f_vid = md5 (uniqid (""));
			$f_vid_timeout = ($direct_cachedata['core_time'] + $direct_settings['account_status_ex_email_validation_timeout']);

$f_vid_array = array (
"core_vid_module" => "account_status_ex_verification",
"account_username" => $direct_cachedata['i_ausername'],
"account_email" => $direct_cachedata['i_amods_account_status_ex_email'],
"account_uuid" => $f_uuid
);

			$direct_cachedata['i_ausername'] = addslashes ($direct_cachedata['i_ausername']);

			if (direct_tmp_storage_write ($f_vid_array,$f_vid,"a617908b172c473cb8e8cda059e55bf0","status_ex","evars",0,$f_vid_timeout))
			// md5 ("validation")
			{
				$f_redirect_url = ((isset ($direct_settings['swg_redirect_url'])) ? $direct_settings['swg_redirect_url'] : $direct_settings['iscript_req']."?redirect;");

$f_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_request","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $direct_cachedata[i_ausername] ($direct_cachedata[i_amods_account_status_ex_email])[/contentform]

".(direct_local_get ("core_validation_required","text"))."

".(direct_local_get ("account_status_ex_validation","text"))."

[url]{$f_redirect_url}validation;{$f_vid}[/url]

".(direct_local_get ("core_one_line_link","text"))."

[hr]
(C) $direct_settings[swg_title_txt] ([url]{$direct_settings['home_url']}[/url])
All rights reserved");

				if (($direct_settings['swg_pyhelper'])&&(direct_autoload ('dNG\sWG\web\directPyHelper')))
				{
					$f_daemon_object = new directPyHelper ();

$f_entry_array = array (
"id" => uniqid (""),
"name" => "de.direct_netware.sWG.plugins.sendmail",
"identifier" => $direct_cachedata['i_amods_account_status_ex_email'],
"data" => direct_evars_write (array (
 "core_lang" => $direct_settings['lang'],
 "account_sendmail_message" => $f_message,
 "account_sendmail_recipient_email" => $direct_cachedata['i_amods_account_status_ex_email'],
 "account_sendmail_recipient_name" => $direct_cachedata['i_ausername'],
 "account_sendmail_title" => direct_local_get ("account_title_status_ex","text")
 ))
);

					$f_continue_check = $f_daemon_object->resourceCheck ();
					if ($f_continue_check) { $f_continue_check = $f_daemon_object->request ("de.direct_netware.psd.plugins.queue.addEntry",(array ($f_entry_array))); }
				}
				else
				{
					$f_sendmailer_object = new directSendmailerFormtags ();
					$f_sendmailer_object->recipientsDefine (array ($direct_cachedata['i_amods_account_status_ex_email'] => $direct_cachedata['i_ausername']));

					$f_sendmailer_object->messageSet ($f_message);
					$f_continue_check = $f_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_title_status_ex","text")));
				}

				if (!$f_continue_check) { $f_return = array (); }
			}
			else { $f_return = array (); }
		}
		else { $f_return = array (); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_save ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific functions

if (!isset ($direct_settings['account_status_ex_email_validation_timeout'])) { $direct_settings['account_status_ex_email_validation_timeout'] = 18000; }
if (!isset ($direct_settings['swg_pyhelper'])) { $direct_settings['swg_pyhelper'] = false; }
if (!isset ($direct_settings['uuids_maxage_inactivity'])) { $direct_settings['uuids_maxage_inactivity'] = 604800; }

//j// EOF
?>