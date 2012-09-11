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
* osets/default/swg_account.php
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
* direct_output_oset_account_actives ()
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_actives ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_actives ()- (#echo(__LINE__)#)"); }

	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account_profile.php");
	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("account_actives_1")).$direct_cachedata['output_minutes'].(direct_local_get ("account_actives_2"))."</h1>";

	if (empty ($direct_cachedata['output_users'])) { $f_return .= "\n<p>".(direct_local_get ("account_actives_empty"))."</p>"; }
	else
	{
$f_return .= ("<table class='pagetable' style='width:100%;table-layout:auto'>
<tbody>");

		$f_users_count = count ($direct_cachedata['output_users']);

		foreach ($direct_cachedata['output_users'] as $f_user_array)
		{
			if ($f_users_count > 1)
			{
				if (isset ($f_right_switch))
				{
					if ($f_right_switch)
					{
						$f_return .= "</td>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
						$f_right_switch = false;
					}
					else
					{
						$f_return .= "</td>\n</tr><tr>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
						$f_right_switch = true;
					}
				}
				else
				{
					$f_return .= "<tr>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
					$f_right_switch = true;
				}
			}
			else
			{
				$f_return .= "<tr>\n<td colspan='2' class='pagebg' style='padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
				$f_right_switch = false;
			}

			$f_return .= direct_account_oset_parse_user_fullh ($f_user_array,"page");
		}

		$f_return .= ($f_right_switch ? "</td>\n<td class='pagebg' style='width:50%;font-size:8px'>&#0160;</td>\n</tr></tbody>\n</table>" : "</td>\n</tr></tbody>\n</table>");
	}

	return $f_return;
}

if ($direct_globals['@names']['output_formbuilder'])
{
/**
	* direct_output_oset_account_login ()
	*
	* @return string Valid XHTML code
	* @since  v0.1.00
*/
	function direct_output_oset_account_login ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_login ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['output_oset_formbuilder'])) { direct_class_init ("output_formbuilder"); }
		$f_form_id = uniqid ("swg");

		$f_return = $direct_settings['iscript_form']." name='$f_form_id' id='$f_form_id'>".(direct_linker ("form",$direct_cachedata['output_formtarget']));

		if (isset ($direct_cachedata['i_atimeoffset']))
		{
$f_return .= ("<script type='text/javascript'><![CDATA[
jQuery (function () { djs_DOM_insert_append ({ data:\"<input type='hidden' name='atimeoffset' value=\\\"\" + (new Date().getTimezoneOffset () / -60) + \"\\\" />\",hide:true,id:'$f_form_id' }); });
]]></script>");
		}

$f_return .= ($direct_globals['output_formbuilder']->formGet ($direct_cachedata['output_formelements'])."
<p style='text-align:center'><input type='submit' id='{$f_form_id}b' value='{$direct_cachedata['output_formbutton']}' class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
jQuery (function ()
{
	djs_formbuilder_init ({ id:'{$f_form_id}b',type:'button' });\n");

		if (isset ($direct_cachedata['output_formsupport_ajax_dialog'])) { $f_return .= "\tdjs_formbuilder_init ({ id:'$f_form_id',id_button:'{$f_form_id}b',type:'form' });\n"; }
		$f_return .= "});\n]]></script></p></form>";

		return $f_return;
	}
}

/**
* direct_output_oset_account_otp_list ()
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_otp_list ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_otp_list ()- (#echo(__LINE__)#)"); }

$f_return = ("<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("account_otp_list"))."</h1>
<table class='pagetable' style='width:100%;table-layout:auto'>
<tbody>");

	$f_otp_count = count ($direct_cachedata['output_otp_list']);

	foreach ($direct_cachedata['output_otp_list'] as $f_position => $f_password)
	{
		if ($f_otp_count > 1)
		{
			if (isset ($f_right_switch))
			{
				if ($f_right_switch)
				{
					$f_return .= "</td>\n<td class='pagebg pagecontent' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'>";
					$f_right_switch = false;
				}
				else
				{
					$f_return .= "</td>\n</tr><tr>\n<td class='pagebg pagecontent' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'>";
					$f_right_switch = true;
				}
			}
			else
			{
				$f_return .= "<tr>\n<td class='pagebg pagecontent' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'>";
				$f_right_switch = true;
			}
		}
		else
		{
			$f_return .= "<tr>\n<td colspan='2' class='pagebg pagecontent' style='padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
			$f_right_switch = false;
		}

		$f_return .= "<strong>$f_position</strong><br />\n$f_password";
	}

	$f_return .= ($f_right_switch ? "</td>\n<td class='pagebg' style='width:50%;font-size:8px'>&#0160;</td>\n</tr></tbody>\n</table>" : "</td>\n</tr></tbody>\n</table>");
	$f_return .= "\n<p class='pagehighlightborder{$direct_settings['theme_css_corners']} pagehighlightbg pageextracontent' style='text-align:left'><strong>".(direct_local_get ("account_otp_list_not_viewable_again"))."</strong></p>";

	return $f_return;
}

/**
* direct_output_oset_account_selector ()
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_selector ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_selector ()- (#echo(__LINE__)#)"); }

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
	djs_DOM_replace ({ animate: false,data: (".(direct_output_oset_default_filter_content (true,"swg_filter_{$direct_cachedata['output_tid']}_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text']))."),id: 'swg_filter_{$direct_cachedata['output_tid']}_point',onReplace: { func: 'djs_default_filter_init',params: { id: 'swg_filter_{$direct_cachedata['output_tid']}_point',url: '$f_filter_url' } } }); });");
	}

$f_return .= ("
	djs_load_functions({ file:'swg_basic_functions.php.js',block:'djs_tid_keepalive' }).done (function () { djs_tid_keepalive ('{$direct_cachedata['output_tid']}'); });
});
]]></script>");

	if (empty ($direct_cachedata['output_users_list'])) { $f_return .= "\n<p><strong>".(direct_local_get ("account_user_selector_empty"))."</strong></p>"; }
	else
	{
		$f_return .= direct_account_oset_selector_users_parse ($direct_cachedata['output_users_list']);
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent' style='text-align:center;font-size:10px'>".($direct_globals['output']->pagesGenerator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</p>"; }
	}

	return $f_return;
}

/**
* direct_output_oset_account_status_ex ()
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_status_ex ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_status_ex ()- (#echo(__LINE__)#)"); }

	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");

return ("<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("account_status_ex"))."</h1>
<table class='pagetable' style='width:100%;table-layout:auto'>
<tbody>".(direct_account_oset_status_ex_view ())."</tbody>
</table>");
}

/**
* direct_output_oset_account_view ()
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_view ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_view ()- (#echo(__LINE__)#)"); }

	if ($direct_settings['account_profile_mods_support']) { $direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/mods/swgi_mods_support.php"); }

$f_return = ("<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("account_profile_view"))."</h1>
<table class='pagetable' style='width:100%;table-layout:auto'>
<thead><tr>
<th colspan='2' class='pagetitlecell'>{$direct_cachedata['output_username']}</th>
</tr></thead><tbody><tr>
<td colspan='2' class='pagebg pagecontent' style='padding:$direct_settings[theme_td_padding];text-align:left'>");

	if ($direct_cachedata['output_useravatar_large']) { $f_return .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='margin-left:$direct_settings[theme_td_padding];float:right;clear:right'><img src='{$direct_cachedata['output_useravatar_large']}' border='0' alt='' title='' /></div>"; }
	elseif ($direct_cachedata['output_useravatar_small']) { $f_return .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='margin-left:$direct_settings[theme_td_padding];float:right;clear:right'><img src='{$direct_cachedata['output_useravatar_small']}' border='0' alt='' title='' /></div>"; }

	$f_return .= "<div class='pageborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent' style='padding:$direct_settings[theme_td_padding]'><p><b>".(direct_local_get ("core_usertype")).":</b> ".$direct_cachedata['output_usertype'];
	if ($direct_cachedata['output_usertitle']) { $f_return .= "<br />\n".$direct_cachedata['output_usertitle']; }

$f_return .= ("</p>
<p style='font-size:10px'><strong>".(direct_local_get ("account_registered")).":</strong> ".$direct_cachedata['output_registration_time'].($direct_cachedata['output_registration_ip'] ? " ({$direct_cachedata['output_registration_ip']})" : "")."<br />
<strong>".(direct_local_get ("account_lastvisit")).":</strong> ".$direct_cachedata['output_lastvisit_time'].($direct_cachedata['output_lastvisit_ip'] ? " ({$direct_cachedata['output_lastvisit_ip']})" : "")."</p></div></td>
</tr>");

	if ($direct_cachedata['output_pageurl_email'])
	{
$f_return .= ("\n<tr>
<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:middle'><strong>".(direct_local_get ("account_email")).":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><a href='".(direct_linker ("url0",$direct_cachedata['output_pageurl_email']))."' target='_self'>");

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