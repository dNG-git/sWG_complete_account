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
* osets/default/swg_account_embedded.php
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

//j// Functions and classes

/**
* direct_output_oset_account_embedded_ajax_selector ()
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_embedded_ajax_selector ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_embedded_ajax_selector ()- (#echo(__LINE__)#)"); }

	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_default_filter.php");

	$f_return = "<div><p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_selection_title']}</p>\n";
	if ($direct_cachedata['output_pages'] > 1) { $f_return .= "<p class='pageborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent' style='text-align:center;font-size:10px'>".($direct_globals['output']->pagesGenerator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</p>\n"; }

$f_return .= (direct_output_oset_default_filter_content (false,"swg_filter_{$direct_cachedata['output_tid']}_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text'])."<script type='text/javascript'><![CDATA[
djs_load_functions({ file:'swg_filter.php.js' }).done (function () { djs_default_filter_init ({ ajax_id:'swgAJAX_embed_{$direct_cachedata['output_tid']}_point',ajax_url0:'ajax_content;s=filter;dsd=dfid+account_selector++dftext+[text]++tid+{$direct_cachedata['output_tid']}++source+{$direct_cachedata['output_filter_source']}',id:'swg_filter_{$direct_cachedata['output_tid']}_point' }); });
]]></script>");

	if (empty ($direct_cachedata['output_users_list'])) { $f_return .= "\n<p><strong>".(direct_local_get ("account_user_selector_empty"))."</strong></p>"; }
	else
	{
		$f_return .= direct_account_oset_selector_users_parse ($direct_cachedata['output_users_list']);
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent' style='text-align:center;font-size:10px'>".($direct_globals['output']->pagesGenerator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</p>"; }
	}

	$f_return .= "</div>";
	return $f_return;
}

/**
* direct_output_oset_account_embedded_ajax_status_ex ()
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_embedded_ajax_status_ex ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_embedded_ajax_status_ex ()- (#echo(__LINE__)#)"); }

	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");

return ("<div id='swgAJAX_account_status_ex_point' style='text-align:left'><p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("account_status_ex"))."</p>
<table class='pagetable' style='width:100%;table-layout:auto'>
<tbody>".(direct_account_oset_status_ex_view ())."</tbody>
</table></div>");
}

/**
* direct_output_oset_account_embedded_selector ()
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_embedded_selector ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_embedded_selector ()- (#echo(__LINE__)#)"); }

	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_default_filter.php");

	$f_filter_url = direct_linker_dynamic ("url1","s=filter;dsd=dfid+account_selector++dftext+[text]++tid+{$direct_cachedata['output_tid']}++source+".$direct_cachedata['output_filter_source'],false);

	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_selection_title']}</h1>";
	if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent' style='text-align:center;font-size:10px'>".($direct_globals['output']->pagesGenerator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</p>"; }

	if (isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))
	{
$f_return .= (direct_output_oset_default_filter_content (false,"swg_filter_{$direct_cachedata['output_tid']}_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text'])."<script type='text/javascript'><![CDATA[
jQuery (function ()
{
	djs_default_filter_init ({ id:'swg_filter_{$direct_cachedata['output_tid']}_point',url:'$f_filter_url' });");
	}
	else
	{
$f_return .= ("<span id='swg_filter_{$direct_cachedata['output_tid']}_point' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
jQuery (function ()
{
	djs_DOM_replace ({ animate: false,data: (".(direct_output_oset_default_filter_content (true,"swg_filter_{$direct_cachedata['output_tid']}_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text']))."),id: 'swg_filter_{$direct_cachedata['output_tid']}_point',onReplace: { func: 'djs_default_filter_init',params: { id: 'swg_filter_{$direct_cachedata['output_tid']}_point',url: '$f_filter_url' } } });");
	}

$f_return .= ("
	djs_load_functions({ file:'swg_basic_functions.php.js',block:'djs_tid_keepalive' }).done (function () { djs_tid_keepalive ('{$direct_cachedata['output_tid']}'); });
});]]></script>");

	if (empty ($direct_cachedata['output_users_list'])) { $f_return .= "\n<p><strong>".(direct_local_get ("account_user_selector_empty"))."</strong></p>"; }
	else
	{
		$f_return .= direct_account_oset_selector_users_parse ($direct_cachedata['output_users_list']);
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent' style='text-align:center;font-size:10px'>".($direct_globals['output']->pagesGenerator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</p>"; }
	}

	return $f_return;
}

/**
* direct_output_oset_account_embedded_status_ex ()
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_embedded_status_ex ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_embedded_status_ex ()- (#echo(__LINE__)#)"); }

	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");

return ("<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("account_status_ex"))."</h1>
<table class='pagetable' style='width:100%;table-layout:auto'>
<tbody>".(direct_account_oset_status_ex_view ())."</tbody>
</table>");
}

/**
* direct_output_oset_account_embedded_view ()
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_embedded_view ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_embedded_view ()- (#echo(__LINE__)#)"); }

	if ($direct_settings['account_profile_mods_support']) { $direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/mods/swgi_mods_support.php"); }

$f_return = ("<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("account_profile_view"))."</h1>
<table class='pagetable' style='width:100%;table-layout:auto'>
<thead><tr>
<th colspan='2' class='pagetitlecell'>{$direct_cachedata['output_username']}</th>
</tr></thead><tbody><tr>
<td colspan='2' class='pagebg pagecontent' style='padding:$direct_settings[theme_td_padding];text-align:left'>");

	if ($direct_cachedata['output_useravatar_large']) { $f_return .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='margin-left:$direct_settings[theme_td_padding];float:right;clear:right'><img src='{$direct_cachedata['output_useravatar_large']}' border='0' alt='' title='' /></div>"; }
	elseif ($direct_cachedata['output_useravatar_small']) { $f_return .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='margin-left:$direct_settings[theme_td_padding];float:right;clear:right'><img src='{$direct_cachedata['output_useravatar_small']}' border='0' alt='' title='' /></div>"; }

	$f_return .= "<div class='pageborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent' style='padding:$direct_settings[theme_td_padding]'><p><strong>".(direct_local_get ("core_usertype")).":</strong> ".$direct_cachedata['output_usertype'];
	if ($direct_cachedata['output_usertitle']) { $f_return .= "<br />\n".$direct_cachedata['output_usertitle']; }

$f_return .= ("</p>
<p style='font-size:10px'><strong>".(direct_local_get ("account_registered")).":</strong> ".$direct_cachedata['output_registration_time'].($direct_cachedata['output_registration_ip'] ? " ({$direct_cachedata['output_registration_ip']})" : "")."<br />
<strong>".(direct_local_get ("account_lastvisit")).":</strong> ".$direct_cachedata['output_lastvisit_time'].($direct_cachedata['output_lastvisit_ip'] ? " ({$direct_cachedata['output_lastvisit_ip']})" : "")."</p></div></td>
</tr>");

	if ($direct_cachedata['output_pageurl_email'])
	{
$f_return .= ("\n<tr>
<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:middle'><strong>".(direct_local_get ("account_email")).":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><a href='".(direct_linker ("url0",$direct_settings['ohandler'].";".$direct_cachedata['output_pageurl_email']))."' target='_self'>");

		$f_return .= ($direct_cachedata['output_email'] ? $direct_cachedata['output_email'] : direct_local_get ("account_email_user"));
		$f_return .= "</a></td>\n</tr>";
	}

	if ($direct_cachedata['output_signature'])
	{
$f_return .= ("\n<tr>
<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>".(direct_local_get ("account_signature")).":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>{$direct_cachedata['output_signature']}</td>
</tr>");
	}

$f_return .= ("\n<tr>
<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:middle'><strong>".(direct_local_get ("account_rating")).":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>{$direct_cachedata['output_rating']}</td>
</tr></tbody>
</table>");

	if ($direct_settings['account_profile_mods_support']) { $f_return .= direct_oset_mods_include ("account_profile",$direct_cachedata['output_modstoview']); }

	return $f_return;
}

//j// Script specific commands

$direct_settings['theme_css_corners'] = (isset ($direct_settings['theme_css_corners_class']) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }
if (!isset ($direct_settings['theme_form_td_padding'])) { $direct_settings['theme_form_td_padding'] = "3px"; }

//j// EOF
?>