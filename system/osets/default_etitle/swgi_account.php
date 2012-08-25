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
* osets/default_etitle/swgi_account.php
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

//j// Functions and classes

/**
* Create a view with the current login status.
*
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_account_oset_status_ex_view ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_account_oset_status_ex_view ()- (#echo(__LINE__)#)"); }

$f_return = ("<tr>
<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>".(direct_local_get ("core_user_current")).":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>{$direct_cachedata['output_current_user']}</td>
</tr><tr>
<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>".(direct_local_get ("account_status_ex_verification_type")).":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>{$direct_cachedata['output_current_verification']}</td>
</tr>");

	if (isset ($direct_cachedata['output_current_verification_status']))
	{
$f_return .= ("<tr>
<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>".(direct_local_get ("account_status_ex_verification_status")).":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>{$direct_cachedata['output_current_verification_status']}</td>
</tr>");
	}

	if (isset ($direct_cachedata['output_link_login']))
	{
		if ($direct_cachedata['output_dtheme_mode']) { $f_url_target = "_self"; }
		else { $f_url_target = "_top"; }

$f_return .= ("<tr>
<td colspan='2' class='pagebg pagecontent' style='padding:$direct_settings[theme_td_padding];text-align:center'><a href=\"{$direct_cachedata['output_link_login']}\" target='$f_url_target'>".(direct_local_get ("core_login"))."</a></td>
</tr>");
	}

	return $f_return;
}

/**
* Generate the selector list for the given user array.
*
* @param  array $f_users_array Users to output
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_account_oset_selector_users_parse ($f_users_array)
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_account_oset_selector_users_parse (+f_users_array)- (#echo(__LINE__)#)"); }

	$f_return = "";

	if (!empty ($f_users_array))
	{
$f_return = ("<table class='pagetable' style='width:100%;table-layout:auto'>
<tbody>");

		$f_users_count = count ($f_users_array);
		$f_user_view = direct_local_get ("account_profile_view");

		foreach ($f_users_array as $f_user_array)
		{
			if ($f_user_array['marked']) { $f_css_class = "extra"; }
			else { $f_css_class = ""; }

			if ($f_users_count > 1)
			{
				if (isset ($f_right_switch))
				{
					if ($f_right_switch)
					{
						$f_return .= "</td>\n<td class='page{$f_css_class}bg page{$f_css_class}content' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
						$f_right_switch = false;
					}
					else
					{
						$f_return .= "</td>\n</tr><tr>\n<td class='page{$f_css_class}bg page{$f_css_class}content' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
						$f_right_switch = true;
					}
				}
				else
				{
					$f_return .= "<tr>\n<td class='page{$f_css_class}bg page{$f_css_class}content' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
					$f_right_switch = true;
				}
			}
			else
			{
				$f_return .= "<tr>\n<td colspan='2' class='page{$f_css_class}bg page{$f_css_class}content' style='padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
				$f_right_switch = false;
			}

			$f_user_pageurl = (((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))||(substr ($direct_settings['ohandler'],0,5) == "ajax_")) ? "\"javascript:djs_dialog(null,{url:'".(direct_linker ("url0","xhtml_embedded;".$f_user_array['pageurl']))."'})\"" : "'".(direct_linker ("url0",$f_user_array['pageurl']))."' target='_blank'");

$f_return .= ("<a id=\"{$f_user_array['id']}\" name=\"{$f_user_array['id']}\"></a><span style='padding:0px 0px $direct_settings[theme_td_padding] $direct_settings[theme_td_padding];float:right;font-size:10px'><a href=\"{$f_user_array['marker_url']}\" target='_self' class='pagehoveropacity'>{$f_user_array['marker_title']}</a><br />
<a href=$f_user_pageurl class='pagehoveropacity'>$f_user_view</a></span><strong><a href=\"{$f_user_array['marker_url']}\" target='_self'>{$f_user_array['name']}</a></strong><br />
<span style='font-size:10px'>{$f_user_array['type']}</span>");
		}

		$f_return .= ($f_right_switch ? "</td>\n<td class='pageemptycell' style='width:50%;font-size:8px'>&#0160;</td>\n</tr></tbody>\n</table>" : "</td>\n</tr></tbody>\n</table>");
	}

	return $f_return;
}

//j// Script specific commands

if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>