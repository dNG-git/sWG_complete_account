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
* account/swg_forgotten_password.php
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

//j// Script specific commands

if (!isset ($direct_settings['account_https_forgotten_password'])) { $direct_settings['account_https_forgotten_password'] = false; }
if (!isset ($direct_settings['account_password_bytemix'])) { $direct_settings['account_password_bytemix'] = ($direct_settings['swg_id'] ^ (strrev ($direct_settings['swg_id']))); }
if (!isset ($direct_settings['account_password_default_forgotten_supported'])) { $direct_settings['account_password_default_forgotten_supported'] = true; }
if (!isset ($direct_settings['account_secid_bytemix'])) { $direct_settings['account_secid_bytemix'] = $direct_settings['account_password_bytemix']; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['swg_pyhelper'])) { $direct_settings['swg_pyhelper'] = false; }
if (!isset ($direct_settings['users_min'])) { $direct_settings['users_min'] = 3; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGaccountVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "form"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "form")||($direct_settings['a'] == "form-save")
case "form":
case "form-save":
{
	$g_mode_ajax_dialog = false;
	$g_mode_save = false;

	if ($direct_settings['a'] == "form-save")
	{
		if ($direct_settings['ohandler'] == "ajax_dialog") { $g_mode_ajax_dialog = true; }
		$g_mode_save = true;
	}

	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "m=account;a=services");

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=account;s=forgotten_password;a=form;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=account;s=forgotten_password;a=form;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	if ($direct_settings['account_password_default_forgotten_supported'])
	{
	//j// BOA
	if ($direct_settings['user']['type'] == "gt")
	{
		$g_mode = ($g_mode_ajax_dialog ? "_ajax" : "");

		if ($g_mode_save) { $direct_globals['output']->relatedManager ("account_forgotten_password_form_save","pre_module_service_action".$g_mode); }
		else
		{
			$direct_globals['output']->relatedManager ("account_forgotten_password_form","pre_module_service_action".$g_mode);
			$direct_globals['kernel']->serviceHttps ($direct_settings['account_https_forgotten_password'],$direct_cachedata['page_this']);
		}

		$direct_globals['basic_functions']->requireClass ('dNG\sWG\directFormbuilder');
		direct_local_integration ("account");

		if ($g_mode_save)
		{
			$direct_globals['basic_functions']->requireClass ('dNG\sWG\directSendmailerFormtags');
			$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
		}

		direct_class_init ("formbuilder");
		$direct_globals['output']->servicemenu ("account");
		$direct_globals['output']->optionsInsert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

		if ($g_mode_save)
		{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

			$direct_cachedata['i_ausername'] = (isset ($GLOBALS['i_ausername']) ? ($direct_globals['basic_functions']->inputfilterBasic ($GLOBALS['i_ausername'])) : "");
			$direct_cachedata['i_asecid'] = (isset ($GLOBALS['i_asecid']) ? ($direct_globals['basic_functions']->inputfilterBasic ($GLOBALS['i_asecid'])) : "");
		}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

		$direct_globals['formbuilder']->entryAddText (array ("name" => "ausername","title" => (direct_local_get ("core_username")),"required" => true,"size" => "s","min" => $direct_settings['users_min'],"max" => 100,"helper_text" => (direct_local_get ("account_helper_username"))));
		$direct_globals['formbuilder']->entryAddPassword (array ("name" => "asecid","title" => (direct_local_get ("account_secid")),"required" => true,"min" => 96,"max" => 96,"helper_text" => (direct_local_get ("account_helper_secid")),"helper_closing" => false));

		$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->formGet ($g_mode_save);

		if (($g_mode_save)&&($direct_globals['formbuilder']->check_result))
		{
			$g_user_array = $direct_globals['kernel']->vUserGet ("",$direct_cachedata['i_ausername']);

			if ($g_user_array)
			{
				if ($g_user_array['ddbusers_banned']) { $direct_globals['output']->outputSendError ("standard","account_username_banned","SECURITY ERROR: &quot;$direct_cachedata[i_ausername]&quot; has been banned","sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
				elseif ($g_user_array['ddbusers_deleted']) { $direct_globals['output']->outputSendError ("standard","core_username_unknown","SECURITY ERROR: &quot;$direct_cachedata[i_ausername]&quot; was deleted","sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
				elseif ($g_user_array['ddbusers_locked']) { $direct_globals['output']->outputSendError ("standard","account_username_locked","SECURITY ERROR: &quot;$direct_cachedata[i_ausername]&quot; has been locked by the administration or the system","sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
				elseif (($g_user_array['ddbusers_secid'])&&($direct_cachedata['i_asecid'] == $g_user_array['ddbusers_secid']))
				{
					$g_continue_check = false;
					$g_password_base = md5 (uniqid (""));
					$g_password_offset = mt_rand (0,21);
					$g_password = substr ($g_password_base,$g_password_offset,10);
					$g_user_array['ddbusers_password'] = $direct_globals['basic_functions']->tmd5 ($g_password,$direct_settings['account_password_bytemix']);
					$g_user_array['ddbusers_secid'] = $direct_globals['basic_functions']->tmd5 ($g_password_base."_{$direct_cachedata['core_time']}_{$direct_cachedata['i_ausername']}_{$g_user_array['ddbusers_email']}_".$g_password,$direct_settings['account_secid_bytemix']);

					if ($direct_globals['kernel']->vUserUpdate ($g_user_array['ddbusers_id'],$g_user_array))
					{
$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_request","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $direct_cachedata[i_ausername] ({$g_user_array['ddbusers_email']})[/contentform]

".(direct_local_get ("account_forgotten_password","text"))."

".(direct_local_get ("core_username","text")).": {$g_user_array['ddbusers_name']}
".(direct_local_get ("core_password","text")).": $g_password

".(direct_local_get ("account_password_reset_recommendation","text"))."

".(direct_local_get ("account_secid_howto","text"))."

".(direct_local_get ("account_secid","text")).":
".(wordwrap ($g_user_array['ddbusers_secid'],32,"\n",1)));

						if (($direct_settings['swg_pyhelper'])&&(direct_autoload ('dNG\sWG\web\directPyHelper')))
						{
							$g_daemon_object = new directPyHelper ();

$g_entry_array = array (
"id" => uniqid (""),
"name" => "de.direct_netware.sWG.plugins.sendmail",
"identifier" => $g_user_array['ddbusers_email'],
"data" => direct_evars_write (array (
 "core_lang" => $direct_settings['lang'],
 "account_sendmail_message" => $g_message,
 "account_sendmail_recipient_email" => $g_user_array['ddbusers_email'],
 "account_sendmail_recipient_name" => $direct_cachedata['i_ausername'],
 "account_sendmail_title" => direct_local_get ("account_title_secid","text")
 ))
);

							$g_continue_check = $g_daemon_object->resourceCheck ();

							if ($g_continue_check) { $g_daemon_object->request ("de.direct_netware.psd.plugins.queue.addEntry",(array ($g_entry_array))); }
							else { $direct_globals['output']->outputSendError ("standard","core_daemon_unavailable","","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
						}
						else
						{
							$g_continue_check = true;
							$g_sendmailer_object = new directSendmailerFormtags ();
							$g_sendmailer_object->recipientsDefine (array ($g_user_array['ddbusers_email'] => $direct_cachedata['i_ausername']));

							$g_sendmailer_object->messageSet ($g_message);
							$g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_title_secid","text")));
						}
					}
					else { $direct_globals['output']->outputSendError ("fatal","core_database_error","","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }

					if ($g_continue_check)
					{
$g_log_array = array (
"ddblog_source_user_id" => $g_user_array['ddbusers_id'],
"ddblog_source_user_ip" => $direct_settings['user_ip'],
"ddblog_sid" => "e268443e43d93dab7ebef303bbe9642f",
// md5 ("account")
"ddblog_identifier" => "account_secid"
);

						direct_log_write ($g_log_array);

						$direct_cachedata['output_job'] = direct_local_get ("core_forgotten_password");
						$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_forgotten_password");
						$direct_cachedata['output_jsjump'] = 0;

						if ($g_target_url)
						{
							$direct_cachedata['output_pagetarget'] = str_replace ("[oid]","",$g_target_url);
							$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$direct_cachedata['output_pagetarget'])));
						}

						$direct_globals['output']->relatedManager ("account_forgotten_password_form_save","post_module_service_action".$g_mode);
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
				}
				else { $direct_globals['output']->outputSendError ("standard","account_secid_invalid","","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
			}
			else { $direct_globals['output']->outputSendError ("standard","core_username_unknown","","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
		}
		elseif ($g_mode_ajax_dialog)
		{
			$direct_globals['output']->header (false,true);
			$direct_globals['output']->relatedManager ("account_forgotten_password_form_save","post_module_service_action".$g_mode);
			$direct_globals['output']->oset ("default","form_results");
			$direct_globals['output']->outputSend (direct_local_get ("formbuilder_error"));
		}
		else
		{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

			$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
			$direct_cachedata['output_formsupport_ajax_dialog'] = true;
			$direct_cachedata['output_formtarget'] = "m=account;s=forgotten_password;a=form-save;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
			$direct_cachedata['output_formtitle'] = direct_local_get ("core_forgotten_password");

			$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_globals['output']->relatedManager ("account_forgotten_password_form","post_module_service_action".$g_mode);
			$direct_globals['output']->oset ("default","form");
			$direct_globals['output']->outputSend ($direct_cachedata['output_formtitle']);
		}
	}
	else { $direct_globals['output']->redirect (direct_linker ("url1",$direct_cachedata['page_backlink'],false)); }
	//j// EOA
	}
	else { $direct_globals['output']->outputSendError ("standard","core_service_inactive","","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>