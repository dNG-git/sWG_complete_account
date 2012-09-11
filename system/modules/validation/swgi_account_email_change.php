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
* validation/swgi_account_email_change.php
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

$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGaccountVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if (USE_debug_reporting) { direct_debug (2,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

if (!$direct_globals['basic_functions']->settingsGet ($direct_settings['path_data']."/settings/swg_account.php")) { $direct_cachedata['validation_error'] = array ("core_required_object_not_found","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
elseif ((isset ($direct_settings['account_email_change_default_supported']))&&(!$direct_settings['account_email_change_default_supported'])) { $direct_cachedata['validation_error'] = array ("core_service_inactive","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
else
{
	$g_user_array = $direct_globals['kernel']->vUserGet ($direct_cachedata['validation_data']['account_userid']);

	if ($g_user_array)
	{
		$direct_globals['db']->initSelect ($direct_settings['users_table']);
		$direct_globals['db']->defineAttributes (array ($direct_settings['users_table'].".ddbusers_email"));

$g_select_criteria = ("<sqlconditions>
<attribute value='{$direct_settings['users_table']}.ddbusers_email' />
".($direct_globals['db']->defineSearchConditionsTerm ($direct_cachedata['validation_data']['account_email']))."
</sqlconditions>");

		$direct_globals['db']->defineSearchConditions ($g_select_criteria);
		$direct_globals['db']->defineRowConditions ("<sqlconditions><element1 attribute='{$direct_settings['users_table']}.ddbusers_deleted' value='0' type='string' /></sqlconditions>");
		$direct_globals['db']->defineLimit (1);

		if ($direct_globals['db']->queryExec ("nr")) { $direct_cachedata['validation_error'] = array ("validation_email_exists","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
		elseif ($direct_cachedata['validation_data']['account_email'] != $g_user_array['ddbusers_email'])
		{
			$g_user_array['ddbusers_email'] = $direct_cachedata['validation_data']['account_email'];

			if (!$direct_globals['kernel']->vUserUpdate ($direct_cachedata['validation_data']['account_userid'],$g_user_array))
			{
				$direct_cachedata['validation_error'] = array ("core_database_error","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)");
				$direct_cachedata['validation_remove_vid'] = false;
			}
		}
	}
	else { $direct_cachedata['validation_error'] = array ("core_username_unknown","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
}

//j// EOF
?>