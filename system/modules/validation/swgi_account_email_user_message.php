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
* validation/swgi_account_email_user_message.php
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
use dNG\sWG\directSendmailerFormtags;
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

if (!isset ($direct_settings['swg_pyhelper'])) { $direct_settings['swg_pyhelper'] = false; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGaccountVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if (USE_debug_reporting) { direct_debug (2,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

$g_continue_check = $direct_globals['basic_functions']->includeClass ('dNG\sWG\directSendmailerFormtags');

if ($g_continue_check)
{
	direct_local_integration ("account");

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_user","text"))."

[font:bold]".(direct_local_get ("core_message_from","text")).":[/font] {$direct_cachedata['validation_data']['source_address']}
[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] {$direct_cachedata['validation_data']['recipient_name']} ({$direct_cachedata['validation_data']['recipient_address']})[/contentform]

[font:bold]".(direct_local_get ("core_message","text")).":[/font]

[hr]
".$direct_cachedata['validation_data']['message']);

	if (($direct_settings['swg_pyhelper'])&&(direct_autoload ('dNG\sWG\web\directPyHelper')))
	{
		$g_daemon_object = new directPyHelper ();

$g_entry_array = array (
"id" => uniqid (""),
"name" => "de.direct_netware.sWG.plugins.sendmail",
"identifier" => $direct_cachedata['validation_data']['recipient_address'],
"data" => direct_evars_write (array (
 "core_lang" => $g_user_array['ddbusers_lang'],
 "account_sendmail_message" => $g_message,
 "account_sendmail_recipient_email" => $direct_cachedata['validation_data']['recipient_address'],
 "account_sendmail_recipient_name" => $direct_cachedata['validation_data']['recipient_name'],
 "account_sendmail_title" => direct_local_get ("account_email_user_message","text")
 ))
);

		$g_continue_check = (((!$g_daemon_object->resourceCheck ())||(!$g_daemon_object->request ("de.direct_netware.psd.plugins.queue.addEntry",(array ($g_entry_array))))) ? false : true);
	}
	else
	{
		$g_sendmailer_object = new directSendmailerFormtags ();
		$g_sendmailer_object->recipientsDefine (array ($direct_cachedata['validation_data']['recipient_address'] => $direct_cachedata['validation_data']['recipient_name']));

		$g_sendmailer_object->messageSet ($g_message);
		$g_continue_check = $g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_email_user_message","text")));
	}
}

if (!$g_continue_check) { $direct_cachedata['validation_error'] = array ("core_unknown_error","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

//j// EOF
?>