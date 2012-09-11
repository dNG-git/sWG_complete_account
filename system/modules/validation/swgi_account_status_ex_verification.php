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
* validation/swgi_account_registration.php
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

$direct_cachedata['validation_error'] = true;
$direct_cachedata['validation_remove_vid'] = false;

/*
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGaccountVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");

if (USE_debug_reporting) { direct_debug (2,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

if (direct_local_integration ("account"))
{
	$g_uuid_storage_array = direct_tmp_storage_get ("evars",$direct_cachedata['validation_data']['account_uuid'],"","task_cache");

	if (($g_uuid_storage_array)&&(isset ($g_uuid_storage_array['account_status_ex_type'],$g_uuid_storage_array['account_status_ex_verified'])))
	{
		$g_uuid_storage_array['account_status_ex_verified'] = 1;

		if (!direct_tmp_storage_write ($g_uuid_storage_array,$direct_cachedata['validation_data']['account_uuid'],$g_uuid_storage_array['core_sid'],"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_inactivity'])))
		{
			$direct_cachedata['validation_error'] = array ("core_database_error","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)");
			$direct_cachedata['validation_remove_vid'] = false;
		}
	}
	else
	{
		$direct_cachedata['validation_error'] = array ("account_status_ex_verification_expired","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)");
		$direct_cachedata['validation_remove_vid'] = false;
	}
}
else
{
	$direct_cachedata['validation_error'] = true;
	$direct_cachedata['validation_remove_vid'] = false;
}
*/

//j// EOF
?>