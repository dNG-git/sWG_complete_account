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
* validation/swgi_account_password_change.php
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
elseif (!$direct_globals['kernel']->vUserSetPassword ($direct_cachedata['validation_data']['account_userid'],$direct_cachedata['validation_data']['account_password']))
{
	$direct_cachedata['validation_error'] = array ("core_database_error","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)");
	$direct_cachedata['validation_remove_vid'] = false;
}

//j// EOF
?>