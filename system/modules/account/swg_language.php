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
* account/swg_language.php
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

//j// Basic configuration

/* -------------------------------------------------------------------------
Direct calls will be honored with an "exit ()"
------------------------------------------------------------------------- */

if (!defined ("direct_product_iversion")) { exit (); }

//j// Script specific commands

if (!isset ($direct_settings['account_https_language'])) { $direct_settings['account_https_language'] = false; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGaccountVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "select"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "select")||($direct_settings['a'] == "select-save")
case "select":
case "select-save":
{
	$g_mode_ajax_dialog = false;
	$g_mode_save = false;

	if ($direct_settings['a'] == "select-save")
	{
		if ($direct_settings['ohandler'] == "ajax_dialog") { $g_mode_ajax_dialog = true; }
		$g_mode_save = true;
	}

	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "m=account;a=services[lang]");

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
		$direct_cachedata['page_homelink'] = str_replace (array ("[oid]","[lang]"),"",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=account;s=forgotten_password;a=form;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace (array ("[oid]","[lang]"),"",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	//j// BOA
	$g_mode = ($g_mode_ajax_dialog ? "_ajax" : "");

	if ($g_mode_save) { $direct_globals['output']->relatedManager ("account_language_select_save","pre_module_service_action".$g_mode); }
	else
	{
		$direct_globals['output']->relatedManager ("account_language_select","pre_module_service_action".$g_mode);
		$direct_globals['kernel']->serviceHttps ($direct_settings['account_https_language'],$direct_cachedata['page_this']);
	}

	$direct_globals['basic_functions']->requireClass ('dNG\sWG\directFormbuilder');
	direct_local_integration ("account");

	direct_class_init ("formbuilder");
	$direct_globals['output']->servicemenu ("account");
	$direct_globals['output']->optionsInsert (2,"servicemenu","m=account;a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	if (!$g_mode_save)
	{
		$g_languages_installed_array = array ();
		$g_languages_array = array ();

		if (file_exists ($direct_settings['path_data']."/lang/swg_languages_installed.xml"))
		{
			$g_file_data = direct_file_get ("s0",$direct_settings['path_data']."/lang/swg_languages_installed.xml");
			if ($g_file_data) { $g_languages_installed_array = direct_evars_get ($g_file_data); }
		}

		if (($g_languages_installed_array)&&(file_exists ($direct_settings['path_data']."/lang/swg_language_table.xml")))
		{
			$g_file_data = direct_file_get ("s0",$direct_settings['path_data']."/lang/swg_language_table.xml");
			if ($g_file_data) { $g_languages_array = direct_evars_get ($g_file_data); }
		}

		if ($g_languages_array)
		{
			$direct_cachedata['i_alang'] = "<evars>";

			foreach ($g_languages_installed_array as $g_language)
			{
				$direct_cachedata['i_alang'] .= (($g_language == $direct_settings['lang']) ? "<$g_language><value value='$g_language' /><selected value='1' />" : "<$g_language><value value='$g_language' />");
				if (isset ($g_languages_array[$g_language])) { $direct_cachedata['i_alang'] .= "<text><![CDATA[".(direct_html_encode_special ($g_languages_array[$g_language]['national']))."]]></text>"; }
				$direct_cachedata['i_alang'] .= "</$g_language>";
			}

			$direct_cachedata['i_alang'] .= "</evars>";
		}
		else { $direct_cachedata['i_alang'] = "<evars><$direct_settings[lang]><value value='$direct_settings[lang]' /><selected value='1' /></$direct_settings[lang]></evars>"; }

		$direct_globals['formbuilder']->entryAddRadio (array ("name" => "alang","title" => (direct_local_get ("account_language")),"required" => true));
		$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->formGet (false);
	}

	if ($g_mode_save)
	{
		$g_language = preg_replace ("#\W+#i","",$GLOBALS['i_alang']);
		if (file_exists ($direct_settings['path_lang']."/swg_account.$g_language.xml")) { $direct_settings['lang'] = $g_language; }

		direct_local_integration ("core",$direct_settings['lang'],true);
		direct_local_integration ("account",$direct_settings['lang'],true);

		$direct_cachedata['output_job'] = direct_local_get ("account_language_select");
		$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_language_select");

		if ($g_target_url)
		{
			$g_target_link = str_replace (array ("[oid]","[lang]"),(array ("",";lang=".$direct_settings['lang'])),$g_target_url);

			$direct_cachedata['output_jsjump'] = 2000;
			$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link)));
			$direct_globals['output']->optionsFlush (true);
		}
		else { $direct_cachedata['output_jsjump'] = 0; }

		$direct_globals['output']->relatedManager ("account_language_select_save","post_module_service_action".$g_mode);
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
	else
	{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

		$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
		$direct_cachedata['output_formsupport_ajax_dialog'] = true;
		$direct_cachedata['output_formtarget'] = "m=account;s=language;a=select-save;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['output_formtitle'] = direct_local_get ("account_language_select");

		$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_globals['output']->relatedManager ("account_language_select","post_module_service_action".$g_mode);
		$direct_globals['output']->oset ("default","form");
		$direct_globals['output']->outputSend ($direct_cachedata['output_formtitle']);
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