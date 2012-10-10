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
* account/swg_selector.php
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

if (!isset ($direct_settings['account_https_selector'])) { $direct_settings['account_https_selector'] = false; }
if (!isset ($direct_settings['account_selector_users_per_page'])) { $direct_settings['account_selector_users_per_page'] = 40; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['serviceicon_account_selector'])) { $direct_settings['serviceicon_account_selector'] = "mini_default_option.png"; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGaccountVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "list"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "list"
case "list":
{
	$g_mode_ajax_content = (($direct_settings['ohandler'] == "ajax_content") ? true : false);
	$g_mode_embedded = (($direct_settings['ohandler'] == "xhtml_embedded") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=list_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_tid'] = (isset ($direct_settings['dsd']['tid']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['tid'])) : "");
	$direct_cachedata['output_page'] = (isset ($direct_settings['dsd']['page']) ? ($direct_globals['basic_functions']->inputfilterNumber ($direct_settings['dsd']['page'])) : 1);

	$direct_cachedata['page_this'] = "m=account;s=selector;a=list;dsd=tid+{$direct_cachedata['output_tid']}++page+".$direct_cachedata['output_page'];
	$direct_cachedata['page_backlink'] = "";
	$direct_cachedata['page_homelink'] = "";

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	//j// BOA
	$direct_globals['basic_functions']->requireClass ('dNG\sWG\directFormtags');
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php");

	$g_uuid = $direct_globals['input']->uuidGet ();
	if ($direct_cachedata['output_tid'] == "") { $direct_cachedata['output_tid'] = $g_uuid; }
	$g_task_array = direct_tmp_storage_get ("evars",$direct_cachedata['output_tid'],"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['account_selection_quantity']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['core_sid']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['uuid']))&&(!$g_task_array['account_selection_done'])&&($g_task_array['uuid'] == $g_uuid))
	{
		if ($g_mode_ajax_content) { $direct_globals['output']->relatedManager ("account_selector_list","pre_module_service_action_ajax"); }
		elseif ($g_mode_embedded) { $direct_globals['output']->relatedManager ("account_selector_list","pre_module_service_action_embedded"); }
		else { $direct_globals['output']->relatedManager ("account_selector_list","pre_module_service_action"); }

		$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

		$g_continue_check = true;
		if ((!isset ($g_task_array['account_users_marked']))||(!is_array ($g_task_array['account_users_marked']))) { $g_task_array['account_users_marked'] = array (); }
		if (!isset ($g_task_array['core_filter_account_selector'])) { $g_task_array['core_filter_account_selector'] = ""; }
	}
	else { $g_continue_check = false; }

	$direct_globals['kernel']->serviceHttps ($direct_settings['account_https_selector'],$direct_cachedata['page_this']);
	direct_local_integration ("account");
	if ((!$g_mode_ajax_content)&&($direct_cachedata['page_backlink'])) { $direct_globals['output']->optionsInsert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	if ($g_continue_check)
	{
		direct_class_init ("formtags");

		$direct_cachedata['output_filter_source'] = base64_encode ($direct_settings['ohandler'].";m=account;s=selector;a=list;dsd=tid+{$direct_cachedata['output_tid']}++page+".$direct_cachedata['output_page']);
		$direct_cachedata['output_filter_text'] = ((isset ($g_task_array['core_filter_account_selector'])) ? $direct_globals['formtags']->decode ($g_task_array['core_filter_account_selector']) : "");

		$direct_globals['db']->initSelect ($direct_settings['users_table']);
		$direct_globals['db']->defineAttributes ("count-rows($direct_settings[users_table].ddbusers_id)");

		if ($g_task_array['core_filter_account_selector'])
		{
$g_search_conditions = ("<sqlconditions searchtype='simple'>
<attribute value='$direct_settings[users_table].ddbusers_name' />
".($direct_globals['db']->defineSearchConditionsTerm ($g_task_array['core_filter_account_selector']))."
</sqlconditions>");

			$direct_globals['db']->defineSearchConditions ($g_search_conditions);
		}

		$direct_globals['db']->defineRowConditions ("<sqlconditions><element1 attribute='$direct_settings[users_table].ddbusers_deleted' value='0' type='string' /></sqlconditions>");
		$g_users_count = $direct_globals['db']->queryExec ("ss");

		if ((!$direct_cachedata['output_page'])||($direct_cachedata['output_page'] < 1)) { $direct_cachedata['output_page'] = 1; }
		$direct_cachedata['output_pages'] = ceil ($g_users_count / $direct_settings['account_selector_users_per_page']);
		if ($direct_cachedata['output_pages'] < 1) { $direct_cachedata['output_pages'] = 1; }
		if ($direct_cachedata['output_page'] > $direct_cachedata['output_pages']) { $direct_cachedata['output_page'] = $direct_cachedata['output_pages']; }

		$direct_globals['db']->initSelect ($direct_settings['users_table']);

		$g_select_attributes = array ($direct_settings['users_table'].".ddbusers_id",$direct_settings['users_table'].".ddbusers_type",$direct_settings['users_table'].".ddbusers_name",$direct_settings['users_table'].".ddbusers_password",$direct_settings['users_table'].".ddbusers_email",$direct_settings['users_table'].".ddbusers_registration_ip",$direct_settings['users_table'].".ddbusers_registration_time",$direct_settings['users_table'].".ddbusers_secid");
		$direct_globals['db']->defineAttributes ($g_select_attributes);

		if ($g_task_array['core_filter_account_selector']) { $direct_globals['db']->defineSearchConditions ($g_search_conditions); }

		$direct_globals['db']->defineRowConditions ("<sqlconditions><element1 attribute='$direct_settings[users_table].ddbusers_deleted' value='0' type='string' /></sqlconditions>");
		$direct_globals['db']->defineOrdering ("<sqlordering><element1 attribute='$direct_settings[users_table].ddbusers_name' type='asc' /></sqlordering>");
		$direct_globals['db']->defineLimit ($direct_settings['account_selector_users_per_page']);
		$direct_globals['db']->defineOffset (($direct_cachedata['output_page'] - 1) * $direct_settings['account_selector_users_per_page']);

		$g_users_array = $direct_globals['db']->queryExec ("ma");
		$direct_cachedata['output_users_list'] = array ();

		if ((is_array ($g_users_array))&&(!empty ($g_users_array)))
		{
			foreach ($g_users_array as $g_user_array)
			{
				$g_user_parsed = $direct_globals['kernel']->vUserParse ("",$g_user_array);

				if (in_array ($g_user_array['ddbusers_id'],$g_task_array['account_users_marked']))
				{
					$g_user_parsed['marked'] = true;
					$g_user_parsed['marker_title'] = ((isset ($g_task_array['account_marker_title_1'])) ? $g_task_array['account_marker_title_1'] : direct_local_get ("account_user_selector_unmark"));
				}
				else
				{
					$g_user_parsed['marked'] = false;
					$g_user_parsed['marker_title'] = ((isset ($g_task_array['account_marker_title_0'])) ? $g_task_array['account_marker_title_0'] : direct_local_get ("account_user_selector_mark"));
				}

				$g_user_parsed['marker_url'] = ($g_mode_ajax_content ? "javascript:djs_swgAJAX_replace_url0('swgAJAX_embed_{$direct_cachedata['output_tid']}_point','".(direct_linker ("asisuuid","ajax_content;m=account;s=selector;a=mark_switch;dsd=tid+{$direct_cachedata['output_tid']}++auid+{$g_user_array['ddbusers_id']}++page+{$direct_cachedata['output_page']};uuid=[uuid]"))."')" : direct_linker ("url0",$direct_settings['ohandler'].";m=account;s=selector;a=mark_switch;dsd=tid+{$direct_cachedata['output_tid']}++auid+{$g_user_array['ddbusers_id']}++page+".$direct_cachedata['output_page']));
				$direct_cachedata['output_users_list'][] = $g_user_parsed;
			}
		}

		$direct_cachedata['output_selection_title'] = (((isset ($g_task_array['account_selection_title']))&&($g_task_array['account_selection_title'])) ? $g_task_array['account_selection_title'] : direct_local_get ("account_user_selector"));

		if ($g_mode_ajax_content)
		{
			$direct_cachedata['output_page_url'] = "javascript:djs_swgAJAX_replace_url0('swgAJAX_embed_{$direct_cachedata['output_tid']}_point','ajax_content;m=account;s=selector;a=list;dsd=tid+{$direct_cachedata['output_tid']}++page+[page];uuid=[uuid]')";

			$direct_globals['output']->header (false,true);
			$direct_globals['output']->relatedManager ("account_selector_list","post_module_service_action_ajax");
			$direct_globals['output']->oset ("account_embedded","ajax_selector");
			$direct_globals['output']->outputSend ();
		}
		elseif ($g_mode_embedded)
		{
			$direct_cachedata['output_page_url'] = "xhtml_embedded;m=account;s=selector;a=list;dsd=tid+{$direct_cachedata['output_tid']}++";

			$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_globals['output']->relatedManager ("account_selector_list","post_module_service_action_embedded");
			$direct_globals['output']->oset ("account_embedded","selector");
			$direct_globals['output']->outputSend ($direct_cachedata['output_selection_title']);
		}
		else
		{
			$direct_cachedata['output_page_url'] = "m=account;s=selector;a=list;dsd=tid+{$direct_cachedata['output_tid']}++";

			$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_globals['output']->relatedManager ("account_selector_list","post_module_service_action");
			$direct_globals['output']->oset ("account","selector");
			$direct_globals['output']->outputSend ($direct_cachedata['output_selection_title']);
		}
	}
	else { $direct_globals['output']->outputSendError ("standard","core_tid_invalid","","sWG/#echo(__FILEPATH__)# _a=list_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "mark_switch"
case "mark_switch":
{
	$g_mode_ajax_content = (($direct_settings['ohandler'] == "ajax_content") ? true : false);
	$g_mode_embedded = (($direct_settings['ohandler'] == "xhtml_embedded") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }

	$g_uid = (isset ($direct_settings['dsd']['auid_d']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['auid_d'])) : "");
	$g_uid = (isset ($direct_settings['dsd']['auid']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['auid'])) : $g_uid);
	$g_tid = (isset ($direct_settings['dsd']['tid']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['tid'])) : "");
	$g_page = (isset ($direct_settings['dsd']['page']) ? ($direct_globals['basic_functions']->inputfilterNumber ($direct_settings['dsd']['page'])) : 1);

	$direct_cachedata['page_this'] = "";
	$direct_cachedata['page_backlink'] = "";
	$direct_cachedata['page_homelink'] = "";

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	//j// BOA
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php");

	$g_continue_check = false;
	$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");
	$g_uuid = $direct_globals['input']->uuidGet ();

	if (($g_task_array)&&(isset ($g_task_array['account_selection_quantity']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['core_sid']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['uuid']))&&(!$g_task_array['account_selection_done'])&&($g_task_array['uuid'] == $g_uuid))
	{
		$direct_cachedata['page_backlink'] = "m=account;s=selector;a=list;dsd=tid+{$g_tid}++page+".$g_page;
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);

		$g_continue_check = true;
		if ((!isset ($g_task_array['account_users_marked']))||(!is_array ($g_task_array['account_users_marked']))) { $g_task_array['account_users_marked'] = array (); }
	}

	direct_local_integration ("account");
	if ((!$g_mode_ajax_content)&&($direct_cachedata['page_backlink'])) { $direct_globals['output']->optionsInsert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	if ($g_continue_check)
	{
		$g_user_marked = (isset ($g_task_array['core_done_report']) ? $direct_globals['kernel']->vUserGet ($g_uid,"",true) : $direct_globals['kernel']->vUserCheck ($g_uid,"",true));

		if ($g_user_marked)
		{
			if ((isset ($g_task_array['core_done_report']))&&(!is_array ($g_task_array['core_done_report']))) { $g_task_array['core_done_report'] = array (); }

			if (in_array ($g_uid,$g_task_array['account_users_marked']))
			{
				unset ($g_task_array['account_users_marked'][$g_uid]);
				if (isset ($g_task_array['core_done_report'])) { unset ($g_task_array['core_done_report'][$g_uid]); }
			}
			else
			{
				if (($g_task_array['account_selection_quantity'] > 0)&&(count ($g_task_array['account_users_marked']) >= $g_task_array['account_selection_quantity']))
				{
					$g_uid_removed = array_shift ($g_task_array['account_users_marked']);
					if (isset ($g_task_array['core_done_report'])) { unset ($g_task_array['core_done_report'][$g_uid_removed]); }
				}

				$g_task_array['account_users_marked'][$g_uid] = $g_uid;
				if (isset ($g_task_array['core_done_report'])) { $g_task_array['core_done_report'][$g_uid] = array ("name" => ((isset ($g_task_array['account_marker_title_0'])) ? $g_task_array['account_marker_title_0'] : direct_local_get ("account_user_selector_mark")),"id" => $g_uid,"identifier" => direct_html_encode_special ($g_user_marked['ddbusers_name']),"status" => "completed"); }
			}

			if ((isset ($g_task_array['account_marker_return']))&&($g_task_array['account_marker_return'])) { $g_task_array['account_selection_done'] = 1; }
			direct_tmp_storage_write ($g_task_array,$g_tid,$g_task_array['core_sid'],"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 3600));

			$g_back_link = (((isset ($g_task_array['account_marker_return']))&&($g_task_array['account_marker_return'])) ? str_replace ("[oid]","auid_d+$g_uid++",$g_task_array['account_marker_return']) : $direct_settings['ohandler'].";m=account;s=selector;a=list;dsd=tid+{$g_tid}++page+".$g_page);

			if ($g_mode_ajax_content) { $direct_globals['output']->redirect (direct_linker_dynamic ("url1",$g_back_link,false),true,false); }
			else { $direct_globals['output']->redirect (direct_linker ("url1",$g_back_link."#swgdhandleruser".$g_uid,false)); }
		}
		else { $direct_globals['output']->outputSendError ("standard","core_username_unknown","","sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }
	}
	else { $direct_globals['output']->outputSendError ("standard","core_tid_invalid","","sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "selection"
case "selection":
{
	$g_mode_ajax_content = (($direct_settings['ohandler'] == "ajax_content") ? true : false);
	$g_mode_embedded = (($direct_settings['ohandler'] == "xhtml_embedded") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=selection_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_tid'] = (isset ($direct_settings['dsd']['tid']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['tid'])) : "");

	$direct_cachedata['page_this'] = "m=account;s=selector;a=selection;dsd=tid+".$direct_cachedata['output_tid'];
	$direct_cachedata['page_backlink'] = "";
	$direct_cachedata['page_homelink'] = "";

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	//j// BOA
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php");

	$g_uuid = $direct_globals['input']->uuidGet ();
	if ($direct_cachedata['output_tid'] == "") { $direct_cachedata['output_tid'] = $g_uuid; }
	$g_task_array = direct_tmp_storage_get ("evars",$direct_cachedata['output_tid'],"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['account_selection_quantity']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['core_sid']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['uuid']))&&(!$g_task_array['account_selection_done'])&&($g_task_array['uuid'] == $g_uuid))
	{
		if ($g_mode_ajax_content) { $direct_globals['output']->relatedManager ("account_selector_selection","pre_module_service_action_ajax"); }
		elseif ($g_mode_embedded) { $direct_globals['output']->relatedManager ("account_selector_selection","pre_module_service_action_embedded"); }
		else { $direct_globals['output']->relatedManager ("account_selector_selection","pre_module_service_action"); }

		$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

		$g_continue_check = true;
		if ((!isset ($g_task_array['account_users_marked']))||(!is_array ($g_task_array['account_users_marked']))) { $g_task_array['account_users_marked'] = array (); }
	}
	else { $g_continue_check = false; }

	$direct_globals['kernel']->serviceHttps ($direct_settings['account_https_selector'],$direct_cachedata['page_this']);
	direct_local_integration ("account");
	if ((!$g_mode_ajax_content)&&($direct_cachedata['page_backlink'])) { $direct_globals['output']->optionsInsert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	if ($g_continue_check)
	{
		$direct_cachedata['output_selection_list'] = array ();

		foreach ($g_task_array['account_users_marked'] as $g_uid)
		{
			$g_user_array = $direct_globals['kernel']->vUserGet ($g_uid);
			if (is_array ($g_user_array)) { $direct_cachedata['output_selection_list'][$g_uid] = direct_html_encode_special ($g_user_array['ddbusers_name']); }
		}

		$direct_cachedata['output_selection_title_hidden'] = (((isset ($g_task_array['account_selection_title_hidden']))&&($g_task_array['account_selection_title_hidden'])) ? true : false);
		$direct_cachedata['output_selection_title'] = (((isset ($g_task_array['account_selection_title']))&&($g_task_array['account_selection_title'])) ? $g_task_array['account_selection_title'] : direct_local_get ("core_selection_list"));
		$direct_cachedata['output_selector_url'] = $direct_settings['ohandler'].";m=account;s=selector;a=list;dsd=tid+{$direct_cachedata['output_tid']}++";

		if ($g_mode_ajax_content)
		{
			$direct_globals['output']->header (false,true);
			$direct_globals['output']->relatedManager ("account_selector_selection","post_module_service_action_ajax");
			$direct_globals['output']->oset ("default_embedded","ajax_selection_list");
			$direct_globals['output']->outputSend ();
		}
		elseif ($g_mode_embedded)
		{
			$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_globals['output']->relatedManager ("account_selector_selection","post_module_service_action_embedded");
			$direct_globals['output']->oset ("default_embedded","selection_list");
			$direct_globals['output']->outputSend ($direct_cachedata['output_selection_title']);
		}
		else
		{
			$direct_globals['output']->optionsInsert (1,"servicemenu",$direct_cachedata['output_selector_url'],(direct_local_get ("core_selector")),$direct_settings['serviceicon_account_selector'],"url0");

			$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_globals['output']->relatedManager ("account_selector_selection","post_module_service_action");
			$direct_globals['output']->oset ("default","selection_list");
			$direct_globals['output']->outputSend ($direct_cachedata['output_selection_title']);
		}
	}
	else { $direct_globals['output']->outputSendError ("standard","core_tid_invalid","","sWG/#echo(__FILEPATH__)# _a=selection_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>