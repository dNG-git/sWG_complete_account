<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

This work is distributed under the W3C (R) Software License, but without any
warranty; without even the implied warranty of merchantability or fitness
for a particular purpose.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;w3c
----------------------------------------------------------------------------
#echo(sWGaccountVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* account/swg_status.php
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
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Basic configuration

/* -------------------------------------------------------------------------
Direct calls will be honored with an "exit ()"
------------------------------------------------------------------------- */

if (!defined ("direct_product_iversion")) { exit (); }

//j// Script specific commands

if (!isset ($direct_settings['account_https_login'])) { $direct_settings['account_https_login'] = false; }
if (!isset ($direct_settings['account_status_mods_support'])) { $direct_settings['account_status_mods_support'] = false; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['users_min'])) { $direct_settings['users_min'] = 3; }
if (!isset ($direct_settings['users_password_min'])) { $direct_settings['users_password_min'] = 6; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGaccountVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "login"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "login")||($direct_settings['a'] == "login-save")
case "login":
case "login-save":
{
	$g_mode_ajax_dialog = false;
	$g_mode_save = false;

	if ($direct_settings['a'] == "login-save")
	{
		if ($direct_settings['ohandler'] == "ajax_dialog") { $g_mode_ajax_dialog = true; }
		$g_mode_save = true;
	}

	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "m=account;a=services[lang][theme]");

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	elseif (isset ($direct_settings["account_login_default_target_lang_".$direct_settings['lang']])) { $g_target_url = $direct_settings["account_login_default_target_lang_".$direct_settings['lang']]; }
	elseif (isset ($direct_settings['account_login_default_target'])) { $g_target_url = $direct_settings['account_login_default_target']; }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=account;s=status;a=login;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_homelink'] = str_replace (array ("[oid]","[lang]","[theme]"),"",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=account;s=status;a=login;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace (array ("[oid]","[lang]","[theme]"),"",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	//j// BOA
	$g_mode = ($g_mode_ajax_dialog ? "_ajax" : "");

	if ($g_mode_save) { $direct_globals['output']->relatedManager ("account_status_login_form_save","pre_module_service_action".$g_mode); }
	else
	{
		$direct_globals['output']->relatedManager ("account_status_login_form","pre_module_service_action".$g_mode);
		$direct_globals['kernel']->serviceHttps ($direct_settings['account_https_login'],$direct_cachedata['page_this']);
	}

	$direct_globals['basic_functions']->requireClass ('dNG\sWG\directFormbuilder');
	if ($g_mode_save) { $direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_log_storager.php"); }
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_mods_support.php");
	direct_local_integration ("account");

	direct_class_init ("formbuilder");
	$direct_globals['output']->servicemenu ("account");
	$direct_globals['output']->optionsInsert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	if ($g_mode_save)
	{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

		$direct_cachedata['i_ausername'] = (isset ($GLOBALS['i_ausername']) ? ($direct_globals['basic_functions']->inputfilterBasic ($GLOBALS['i_ausername'])) : "");
		$direct_cachedata['i_apassword'] = (isset ($GLOBALS['i_apassword']) ? ($direct_globals['basic_functions']->inputfilterBasic ($GLOBALS['i_apassword'])) : "");

		if (USE_cookies)
		{
			$direct_cachedata['i_acookie'] = (isset ($GLOBALS['i_acookie']) ? (str_replace ("'","",$GLOBALS['i_acookie'])) : "");
			$direct_cachedata['i_acookie'] = str_replace ("<value value='$direct_cachedata[i_acookie]' />","<value value='$direct_cachedata[i_acookie]' /><selected value='1' />","<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>");
		}

		$direct_cachedata['i_atimeoffset'] = (isset ($GLOBALS['i_atimeoffset']) ? ($direct_globals['basic_functions']->inputfilterNumber ($GLOBALS['i_atimeoffset'])) : NULL);
	}
	else
	{
		if (USE_cookies) { $direct_cachedata['i_acookie'] = "<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>"; }
		$direct_cachedata['i_atimeoffset'] = $direct_settings['user']['timezone'];
	}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

	$direct_globals['formbuilder']->entryAddText (array ("name" => "ausername","title" => (direct_local_get ("core_username")),"required" => true,"size" => "s","min" => $direct_settings['users_min'],"max" => 100,"helper_text" => (direct_local_get ("core_helper_username"))));
	$direct_globals['formbuilder']->entryAddPassword (array ("name" => "apassword","title" => (direct_local_get ("core_password")),"required" => true,"min" => $direct_settings['users_password_min']),NULL);
	if (USE_cookies) { $direct_globals['formbuilder']->entryAddRadio (array ("name" => "acookie","title" => (direct_local_get ("account_use_cookie")),"required" => true)); }

/* -------------------------------------------------------------------------
Call registered mods
------------------------------------------------------------------------- */

	if ($g_mode_save)
	{
		$g_continue_check = direct_mods_include ($direct_settings['account_status_mods_support'],"account_status","login_check");
		$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->formGet (true);
	}
	else
	{
		direct_mods_include ($direct_settings['account_status_mods_support'],"account_status","login");
		$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->formGet (false);
	}

	if (($g_mode_save)&&(($direct_globals['formbuilder']->check_result)||($g_continue_check)))
	{
/* -------------------------------------------------------------------------
Save data edited
------------------------------------------------------------------------- */

		$g_cookie = (((USE_cookies)&&($direct_cachedata['i_acookie'])) ? true : false);
		$g_user_array = $direct_globals['kernel']->vUserGet ("",$direct_cachedata['i_ausername'],true);

		if (direct_mods_include ($direct_settings['account_status_mods_support'],"account_status","test"))
		{
			$g_override_check = direct_mods_include (true,"account_status","login_process",$g_user_array);
			if ($g_override_check) { $g_user_array = $direct_globals['kernel']->vUserGet ("",$direct_cachedata['i_ausername'],true); }
		}
		else { $g_override_check = false; }

		if (is_array ($g_user_array))
		{
			if ($g_user_array['ddbusers_banned']) { $direct_globals['output']->outputSendError ("standard","account_username_banned","SECURITY ERROR: &quot;$direct_cachedata[i_ausername]&quot; has been banned","sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
			elseif ($g_user_array['ddbusers_deleted']) { $direct_globals['output']->outputSendError ("standard","core_username_unknown","SECURITY ERROR: &quot;$direct_cachedata[i_ausername]&quot; was deleted","sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
			elseif ($g_user_array['ddbusers_locked']) { $direct_globals['output']->outputSendError ("standard","account_username_locked","SECURITY ERROR: &quot;$direct_cachedata[i_ausername]&quot; has been locked by the administration or the system","sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
			elseif ((($g_user_array['ddbusers_type'] != "ex")&&($direct_globals['kernel']->vUserCheckPassword ($g_user_array['ddbusers_id'],$direct_cachedata['i_apassword'])))||($g_override_check))
			{
$g_uuid_array = array (
"userid" => $g_user_array['ddbusers_id'],
"username" => $g_user_array['ddbusers_name']
);

				if (direct_mods_include ($direct_settings['account_status_mods_support'],"account_status","test")) { $g_uuid_array = direct_mods_include (true,"account_status","login_save",$g_user_array,$g_uuid_array); }

				if (is_array ($g_uuid_array))
				{
					$direct_globals['kernel']->vUuidWrite ((direct_evars_write ($g_uuid_array)),$g_cookie);

					if (is_numeric ($direct_cachedata['i_atimeoffset'])) { $g_user_array['ddbusers_timezone'] = $direct_cachedata['i_atimeoffset']; }
					$direct_settings['user'] = array ("id" => $g_user_array['ddbusers_id'],"type" => $g_user_array['ddbusers_type'],"timezone" => $g_user_array['ddbusers_timezone']);
					$direct_globals['input']->userSet ($g_user_array['ddbusers_name']);

					$g_user_array['ddbusers_lastvisit_ip'] = $direct_settings['user_ip'];
					$g_user_array['ddbusers_lastvisit_time'] = $direct_cachedata['core_time'];
					$direct_globals['kernel']->vUserUpdate ($direct_settings['user']['id'],$g_user_array);
					if (direct_class_function_check ($direct_globals['kernel'],"vGroupUserGetRights")) { $direct_globals['kernel']->vGroupUserGetRights (); }
					$direct_globals['kernel']->vUuidCookieSave ();

					$g_lang = $g_user_array['ddbusers_lang'];
					$g_theme = $g_user_array['ddbusers_theme'];

$g_log_array = array (
"ddblog_source_user_id" => $g_user_array['ddbusers_id'],
"ddblog_source_user_ip" => $direct_settings['user_ip'],
"ddblog_sid" => "e268443e43d93dab7ebef303bbe9642f",
// md5 ("account")
"ddblog_identifier" => "account_login"
);

					direct_log_write ($g_log_array);

					$direct_cachedata['output_job'] = direct_local_get ("core_login");
					$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_login");

					if ($g_target_url)
					{
						$g_target_link = str_replace (array ("[oid]","[lang]","[theme]"),(array ("auid_d+{$g_user_array['ddbusers_id']}++",";lang=".$g_lang,";theme=".$g_theme)),$g_target_url);

						$direct_cachedata['output_jsjump'] = 2000;
						$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link)));
						$direct_globals['output']->optionsFlush (true);
					}
					else { $direct_cachedata['output_jsjump'] = 0; }

					$direct_globals['output']->relatedManager ("account_status_login_form_save","post_module_service_action".$g_mode);
					$direct_globals['output']->oset ("default","done");

					if ($g_mode_ajax_dialog)
					{
						$direct_globals['output']->header (false,true);
						$direct_globals['output']->outputSend (direct_local_get ("core_done").": ".$direct_cachedata['output_job']);
					}
					else
					{
						$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
						$direct_globals['output']->outputSend ($direct_cachedata['output_job']);
					}
				}
				elseif (is_bool ($g_override_check)) { $direct_globals['output']->outputSendError ("standard","core_unknown_error","","sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
			}
			else
			{
$g_log_array = array (
"ddblog_source_user_id" => $g_user_array['ddbusers_id'],
"ddblog_source_user_ip" => $direct_settings['user_ip'],
"ddblog_sid" => "e268443e43d93dab7ebef303bbe9642f",
// md5 ("account")
"ddblog_identifier" => "account_password_invalid"
);

				direct_log_write ($g_log_array);
				$direct_globals['output']->outputSendError ("standard","account_password_invalid","","sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)");
			}
		}
		else { $direct_globals['output']->outputSendError ("standard","core_username_unknown","","sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
	}
	elseif ($g_mode_ajax_dialog)
	{
		$direct_globals['output']->header (false,true);
		$direct_globals['output']->relatedManager ("account_status_login_form_save","post_module_service_action".$g_mode);
		$direct_globals['output']->oset ("default","form_results");
		$direct_globals['output']->outputSend (direct_local_get ("formbuilder_error"));
	}
	else
	{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

		$direct_cachedata['output_formbutton'] = direct_local_get ("core_login");
		$direct_cachedata['output_formsupport_ajax_dialog'] = true;
		$direct_cachedata['output_formtarget'] = "m=account;s=status;a=login-save;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['output_formtitle'] = direct_local_get ("core_login");

		$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_globals['output']->relatedManager ("account_status_login_form","post_module_service_action".$g_mode);
		$direct_globals['output']->oset ("account","login");
		$direct_globals['output']->outputSend ($direct_cachedata['output_formtitle']);
	}
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "lvreset"
case "lvreset":
{
	$g_mode_ajax_dialog = (($direct_settings['ohandler'] == "ajax_dialog") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=lvreset_ (#echo(__LINE__)#)"); }

	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "m=account;a=services");

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	$direct_cachedata['page_this'] = "";
	$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_source_url);
	$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	//j// BOA
	$g_mode = ($g_mode_ajax_dialog ? "_ajax" : "");
	$direct_globals['output']->relatedManager ("account_status_lvreset","pre_module_service_action".$g_mode);

	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_mods_support.php");
	direct_local_integration ("account");

	$g_cookie_data = urlencode ($direct_cachedata['core_time']."|".$direct_cachedata['core_time']);
	$g_cookie_expires = (gmdate ("D, d-M-y H:i:s",($direct_cachedata['core_time'] + 31536000)))." GMT";

	$g_cookie_options = "";
	if ($direct_settings['swg_cookie_path']) { $g_cookie_options .= " PATH=$direct_settings[swg_cookie_path];"; }
	if ($direct_settings['swg_cookie_server']) { $g_cookie_options .= " DOMAIN=$direct_settings[swg_cookie_server];"; }

	$g_cookie_name = $direct_settings['swg_cookie_name']."_lastvisit";

	$direct_cachedata['core_cookies'][$g_cookie_name] = $g_cookie_name."=$g_cookie_data;$g_cookie_options EXPIRES=$g_cookie_expires; HTTPONLY";
	$direct_cachedata['kernel_lastvisit'] = $direct_cachedata['core_time'];

	$direct_cachedata['output_job'] = direct_local_get ("core_lastvisit_reset");
	$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_lastvisit_reset");

	if ($g_target_url)
	{
		$g_target_link = str_replace ("[oid]","auid+{$direct_settings['user']['id']}++",$g_target_url);

		$direct_cachedata['output_jsjump'] = 2000;
		$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link)));
		$direct_globals['output']->optionsFlush (true);
	}
	else { $direct_cachedata['output_jsjump'] = 0; }

	direct_mods_include ($direct_settings['account_status_mods_support'],"account_status","lvreset");

	$direct_globals['output']->relatedManager ("account_status_lvreset","post_module_service_action".$g_mode);
	$direct_globals['output']->oset ("default","done");

	if ($g_mode_ajax_dialog)
	{
		$direct_globals['output']->header (false,true);
		$direct_globals['output']->outputSend (direct_local_get ("core_done").": ".$direct_cachedata['output_job']);
	}
	else
	{
		$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_globals['output']->outputSend ($direct_cachedata['output_job']);
	}
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "logout"
case "logout":
{
	$g_mode_ajax_dialog = (($direct_settings['ohandler'] == "ajax_dialog") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=logout_ (#echo(__LINE__)#)"); }

	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "m=account;a=services");

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	elseif (isset ($direct_settings["account_logout_default_target_lang_".$direct_settings['lang']])) { $g_target_url = $direct_settings["account_logout_default_target_lang_".$direct_settings['lang']]; }
	elseif (isset ($direct_settings['account_logout_default_target'])) { $g_target_url = $direct_settings['account_logout_default_target']; }
	else { $g_target_url = "m=default;s=index;a=index"; }

	$direct_cachedata['page_this'] = "";
	$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_source_url);
	$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	//j// BOA
	$g_mode = ($g_mode_ajax_dialog ? "_ajax" : "");
	$direct_globals['output']->relatedManager ("account_status_logout","pre_module_service_action".$g_mode);

	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_log_storager.php");
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_mods_support.php");
	direct_local_integration ("account");

	$direct_globals['output']->servicemenu ("account");
	$direct_globals['output']->optionsInsert (2,"servicemenu","m=account;a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	$g_output_check = direct_mods_include ($direct_settings['account_status_mods_support'],"account_status","logout");

	if ($direct_settings['user']['type'] != "gt")
	{
$g_log_array = array (
"ddblog_source_user_id" => $direct_settings['user']['id'],
"ddblog_source_user_ip" => $direct_settings['user_ip'],
"ddblog_sid" => "e268443e43d93dab7ebef303bbe9642f",
// md5 ("account")
"ddblog_identifier" => "account_logout"
);

		direct_log_write ($g_log_array);
	}

	$direct_globals['kernel']->vUuidWrite ("");
	$direct_globals['kernel']->vUuidCookieSave ();

	$g_userid = $direct_settings['user']['id'];
	$direct_globals['input']->userSet (NULL);
	$direct_settings['user'] = array ("id" => "","type" => "gt","timezone" => (int)(date ("Z") / 3600));

	if (!$g_output_check)
	{
		$direct_cachedata['output_job'] = direct_local_get ("core_logout");
		$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_logout");

		if ($g_target_url)
		{
			$g_target_link = str_replace ("[oid]","auid_d+{$g_userid}++",$g_target_url);

			$direct_cachedata['output_jsjump'] = 2000;
			$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link)));
			$direct_globals['output']->optionsFlush (true);
		}
		else { $direct_cachedata['output_jsjump'] = 0; }

		$direct_globals['output']->relatedManager ("account_status_logout","post_module_service_action".$g_mode);
		$direct_globals['output']->oset ("default","done");

		if ($g_mode_ajax_dialog)
		{
			$direct_globals['output']->header (false,true);
			$direct_globals['output']->outputSend (direct_local_get ("core_done").": ".$direct_cachedata['output_job']);
		}
		else
		{
			$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_globals['output']->outputSend ($direct_cachedata['output_job']);
		}
	}
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>