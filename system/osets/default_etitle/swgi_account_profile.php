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
* osets/default_etitle/swgi_account_profile.php
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
* Return a user information panel for horizontal views.
*
* @param  array $f_data User array
* @param  string $f_pageclass CSS class used for the (X)HTML panel
* @param  string $f_user_pageurl User page URL to be used for the link
* @param  string $f_user_ip Alternative user IP to be shown
* @param  string $f_prefix Key prefix
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_account_oset_parse_user_fullh ($f_data,$f_pageclass,$f_user_pageurl = "",$f_user_ip = "",$f_prefix = "")
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_account_oset_parse_user_fullh (+f_data,$f_pageclass,$f_user_pageurl,$f_user_ip,$f_prefix)- (#echo(__LINE__)#)"); }

	if ((is_array ($f_data))&&(!empty ($f_data)))
	{
		$f_return = "<div class='pageborder{$direct_settings['theme_css_corners']} {$f_pageclass}bg {$f_pageclass}content'><p>";
		if ($f_data[$f_prefix."avatar_small"]) { $f_return .= "<img src='".$f_data[$f_prefix."avatar_small"]."' border='0' alt=\"".$f_data[$f_prefix."name"]."\" title=\"".$f_data[$f_prefix."name"]."\" style='float:right;padding:5px'/>"; }
		$f_return .= "<strong>";

		if ($f_user_pageurl) { $f_return .= "<a href=".(((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))||(substr ($direct_settings['ohandler'],0,5) == "ajax_")) ? "\"javascript:djs_dialog(null,{url:'".(direct_linker ("url0","xhtml_embedded;".$f_user_pageurl))."'})\"" : "'".(direct_linker ("url0",$f_user_pageurl))."' target='_self'").">".$f_data[$f_prefix."name"]."</a>"; }
		elseif ($f_data[$f_prefix."pageurl"]) { $f_return .= "<a href=".(((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))||(substr ($direct_settings['ohandler'],0,5) == "ajax_")) ? "\"javascript:djs_dialog(null,{url:'".(direct_linker ("url0","xhtml_embedded;".$f_data[$f_prefix."pageurl"]))."'})\"" : "'".(direct_linker ("url0",$f_data[$f_prefix."pageurl"]))."' target='_self'").">".$f_data[$f_prefix."name"]."</a>"; }
		else { $f_return .= $f_data[$f_prefix."name"]; }

		$f_return .= "</strong>";
		if ($f_data[$f_prefix."title"]) { $f_return .= "<br />\n".$f_data[$f_prefix."title"]; }

		if ($f_user_ip) { $f_return .= "<br />\n<span style='font-size:10px'>($f_user_ip)</span>"; }
		elseif ($f_data[$f_prefix."ip"]) { $f_return .= "<br />\n<span style='font-size:10px'>(".$f_data[$f_prefix."ip"].")</span>"; }

		$f_return .= "</p>";
		if ($f_data[$f_prefix."type"]) { $f_return .= "\n<p style='font-size:10px'>".$f_data[$f_prefix."type"]."</p>"; }
		$f_return .= "</div>";
	}
	else { $f_return = "<p class='pageborder{$direct_settings['theme_css_corners']} {$f_pageclass}bg {$f_pageclass}content'><strong>".(direct_local_get ("core_unknown"))."</strong></p>"; }

	return $f_return;
}

/**
* Return user information for vertical views.
*
* @param  array $f_data User array
* @param  string $f_pageclass CSS class used for the (X)HTML panel
* @param  string $f_user_pageurl User page URL to be used for the link
* @param  string $f_user_ip Alternative user IP to be shown
* @param  string $f_prefix Key prefix
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_account_oset_parse_user_fullv ($f_data,$f_pageclass,$f_user_pageurl = "",$f_user_ip = "",$f_prefix = "")
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_account_oset_parse_user_fullv (+f_data,$f_pageclass,$f_user_pageurl,$f_user_ip,$f_prefix)- (#echo(__LINE__)#)"); }

	if ((is_array ($f_data))&&(!empty ($f_data)))
	{
		$f_return = "<div class='pageborder{$direct_settings['theme_css_corners']} {$f_pageclass}bg {$f_pageclass}content'>";
		if ($f_data[$f_prefix."avatar_small"]) { $f_return .= "<p><img src='".$f_data[$f_prefix."avatar_small"]."' border='0' alt=\"".$f_data[$f_prefix."name"]."\" title=\"".$f_data[$f_prefix."name"]."\" /></p>"; }
		$f_return .= "<p><b>";

		if ($f_user_pageurl) { $f_return .= "<a href=".(((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))||(substr ($direct_settings['ohandler'],0,5) == "ajax_")) ? "\"javascript:djs_dialog(null,{url:'".(direct_linker ("url0","xhtml_embedded;".$f_user_pageurl))."'})\"" : "'".(direct_linker ("url0",$f_user_pageurl))."' target='_self'").">".$f_data[$f_prefix."name"]."</a>"; }
		elseif ($f_data[$f_prefix."pageurl"]) { $f_return .= "<a href=".(((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))||(substr ($direct_settings['ohandler'],0,5) == "ajax_")) ? "\"javascript:djs_dialog(null,{url:'".(direct_linker ("url0","xhtml_embedded;".$f_data[$f_prefix."pageurl"]))."'})\"" : "'".(direct_linker ("url0",$f_data[$f_prefix."pageurl"]))."' target='_self'").">".$f_data[$f_prefix."name"]."</a>"; }
		else { $f_return .= $f_data[$f_prefix."name"]; }

		$f_return .= "</b>";
		if ($f_data[$f_prefix."title"]) { $f_return .= "<br />\n".$f_data[$f_prefix."title"]; }

		if ($f_user_ip) { $f_return .= "<br />\n<span style='font-size:10px'>($f_user_ip)</span>"; }
		elseif ($f_data[$f_prefix."ip"]) { $f_return .= "<br />\n<span style='font-size:10px'>(".$f_data[$f_prefix."ip"].")</span>"; }

		$f_return .= "</p>";
		if ($f_data[$f_prefix."type"]) { $f_return .= "<p class='$f_pageclass' style='font-size:10px'>".$f_data[$f_prefix."type"]."</p>"; }
		$f_return .= "</div>";
	}
	else { $f_return = "<p class='pageborder{$direct_settings['theme_css_corners']} {$f_pageclass}bg {$f_pageclass}content'><b>".(direct_local_get ("core_unknown"))."</b></p>"; }

	return $f_return;
}

//j// Script specific commands

if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>