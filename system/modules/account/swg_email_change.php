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
* account/swg_email_change.php
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

if (!isset ($direct_settings['account_email_change_time'])) { $direct_settings['account_email_change_time'] = 432000; }
if (!isset ($direct_settings['account_email_change_default_supported'])) { $direct_settings['account_email_change_default_supported'] = true; }
if (!isset ($direct_settings['account_https_email_change'])) { $direct_settings['account_https_email_change'] = false; }
if (!isset ($direct_settings['serviceicon_account_profile_edit'])) { $direct_settings['serviceicon_account_profile_edit'] = "mini_default_option.png"; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['swg_pyhelper'])) { $direct_settings['swg_pyhelper'] = false; }
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
	$g_target_url = ($g_target ? base64_decode ($g_target) : "m=account;s=profile;a=view;dsd=[oid]");

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=account;s=email_change;a=form;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=account;s=email_change;a=form;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	if (($direct_settings['user']['type'] == "ex")||($direct_settings['user']['type'] == "gt")) { $direct_globals['output']->outputSendError ("login","core_access_denied","","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	elseif ($direct_settings['account_email_change_default_supported'])
	{
	//j// BOA
	$g_mode = ($g_mode_ajax_dialog ? "_ajax" : "");

	if ($g_mode_save) { $direct_globals['output']->relatedManager ("account_email_change_form_save","pre_module_service_action".$g_mode); }
	else
	{
		$direct_globals['output']->relatedManager ("account_email_change_form","pre_module_service_action".$g_mode);
		$direct_globals['kernel']->serviceHttps ($direct_settings['account_https_email_change'],$direct_cachedata['page_this']);
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
	$direct_globals['output']->optionsInsert (1,"servicemenu","m=account;s=profile;a=edit",(direct_local_get ("account_profile_edit")),$direct_settings['serviceicon_account_profile_edit'],"url0");
	$direct_globals['output']->optionsInsert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	if ($g_mode_save) { $direct_cachedata['i_aemail'] = (isset ($GLOBALS['i_aemail']) ? ($direct_globals['basic_functions']->inputfilterBasic ($GLOBALS['i_aemail'])) : ""); }
	else
	{
		$g_user_array = $direct_globals['kernel']->vUserGet ($direct_settings['user']['id'],"",true);
		$direct_cachedata['i_aemail'] = $g_user_array['ddbusers_email'];
	}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

	$direct_globals['formbuilder']->entryAddEMail (array ("name" => "aemail","title" => (direct_local_get ("account_email")),"required" => true,"size" => "l","min" => 5,"max" => 255,"helper_text" => (direct_local_get ("account_helper_email"))));
	$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->formGet (true);

	if (($g_mode_save)&&($direct_globals['formbuilder']->check_result))
	{
		$g_user_array = $direct_globals['kernel']->vUserGet ($direct_settings['user']['id'],"",true);

		if ($direct_cachedata['i_aemail'] == $g_user_array['ddbusers_email'])
		{
			if ($g_target_url) { $direct_globals['output']->redirect (direct_linker ("url1",(str_replace ("[oid]","auid_d+{$direct_settings['user']['id']}++",$g_target_url)),false)); }
			else { $direct_globals['output']->redirect (direct_linker ("url1",$direct_cachedata['page_backlink'],false)); }
		}
		else
		{
			$direct_globals['db']->initSelect ($direct_settings['users_table']);
			$direct_globals['db']->defineAttributes (array ($direct_settings['users_table'].".ddbusers_email"));

$g_select_criteria = ("<sqlconditions>
<attribute value='{$direct_settings['users_table']}.ddbusers_email' />
".($direct_globals['db']->defineSearchConditionsTerm ($direct_cachedata['i_aemail']))."
</sqlconditions>");

			$direct_globals['db']->defineSearchConditions ($g_select_criteria);
			$direct_globals['db']->defineRowConditions ("<sqlconditions><element1 attribute='{$direct_settings['users_table']}.ddbusers_deleted' value='0' type='string' /></sqlconditions>");
			$direct_globals['db']->defineLimit (1);

			if ($direct_globals['db']->queryExec ("nr")) { $direct_globals['output']->outputSendError ("standard","account_email_exists","","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
			else
			{
$g_vid_array = array (
"core_vid_module" => "account_email_change",
"account_userid" => $direct_settings['user']['id'],
"account_email" => $direct_cachedata['i_aemail']
);

				$g_vid = md5 (uniqid (""));
				$g_vid_timeout = ($direct_cachedata['core_time'] + $direct_settings['account_email_change_time']);
				$g_continue_check = direct_tmp_storage_write ($g_vid_array,$g_vid,"a617908b172c473cb8e8cda059e55bf0","email_change","evars",0,$g_vid_timeout);
				// md5 ("validation")

				if ($g_continue_check)
				{
					$g_redirect_url = ((isset ($direct_settings['swg_redirect_url'])) ? $direct_settings['swg_redirect_url'] : $direct_settings['iscript_req']."?redirect;");

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_request","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] {$g_user_array['ddbusers_name']} ($direct_cachedata[i_aemail])[/contentform]

".(direct_local_get ("core_validation_required","text"))."

".(direct_local_get ("account_validation_for_email_change","text"))."

[url]{$g_redirect_url}validation;{$g_vid}[/url]

".(direct_local_get ("core_one_line_link","text")));

					if (($direct_settings['swg_pyhelper'])&&(direct_autoload ('dNG\sWG\web\directPyHelper')))
					{
						$g_daemon_object = new directPyHelper ();

$g_entry_array = array (
"id" => uniqid (""),
"name" => "de.direct_netware.sWG.plugins.sendmail",
"identifier" => $direct_cachedata['i_aemail'],
"data" => direct_evars_write (array (
 "core_lang" => $direct_settings['lang'],
 "account_sendmail_message" => $g_message,
 "account_sendmail_recipient_email" => $direct_cachedata['i_aemail'],
 "account_sendmail_recipient_name" => $g_user_array['ddbusers_name'],
 "account_sendmail_title" => direct_local_get ("account_title_email_change","text")
 ))
);

						$g_continue_check = $g_daemon_object->resourceCheck ();

						if ($g_continue_check) { $g_daemon_object->request ("de.direct_netware.psd.plugins.queue.addEntry",(array ($g_entry_array))); }
						else { $direct_globals['output']->outputSendError ("standard","core_daemon_unavailable","","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
					}
					else
					{
						$g_sendmailer_object = new directSendmailerFormtags ();
						$g_sendmailer_object->recipientsDefine (array ($direct_cachedata['i_aemail'] => $g_user_array['ddbusers_name']));

						$g_sendmailer_object->messageSet ($g_message);
						$g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_title_email_change","text")));
					}
				}
				else { $direct_globals['output']->outputSendError ("fatal","core_database_error","FATAL ERROR: tmpStorager has reported an error","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }

				if ($g_continue_check)
				{
					$direct_cachedata['output_job'] = direct_local_get ("account_email_change");
					$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_email_change_1");
					$direct_cachedata['output_jsjump'] = 0;

					if ($g_target_url)
					{
						$direct_cachedata['output_pagetarget'] = str_replace ("[oid]","auid_d+{$direct_settings['user']['id']}++",$g_target_url);
						$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$direct_cachedata['output_pagetarget'])));
					}

					$direct_globals['output']->relatedManager ("account_email_change_form_save","post_module_service_action".$g_mode);
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
		}
	}
	elseif ($g_mode_ajax_dialog)
	{
		$direct_globals['output']->header (false,true);
		$direct_globals['output']->relatedManager ("account_email_change_form_save","post_module_service_action".$g_mode);
		$direct_globals['output']->oset ("default","form_results");
		$direct_globals['output']->outputSend (direct_local_get ("formbuilder_error"));
	}
	else
	{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

		$direct_cachedata['output_formbutton'] = direct_local_get ("account_email_change");
		$direct_cachedata['output_formsupport_ajax_dialog'] = true;
		$direct_cachedata['output_formtarget'] = "m=account;s=email_change;a=form-save;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['output_formtitle'] = direct_local_get ("account_email_change");

		$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_globals['output']->relatedManager ("account_email_change_form","post_module_service_action".$g_mode);
		$direct_globals['output']->oset ("default","form");
		$direct_globals['output']->outputSend ($direct_cachedata['output_formtitle']);
	}
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