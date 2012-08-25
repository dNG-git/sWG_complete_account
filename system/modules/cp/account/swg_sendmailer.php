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
* cp/account/swg_sendmailer.php
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
* @subpackage cp_account
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/*#use(direct_use) */
use dNG\sWG\directSendmailerFormtags,
    dNG\sWG\web\directHttpJsonrpc;
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
if (!isset ($direct_settings['swg_pyhelper_password'])) { $direct_settings['swg_pyhelper_password'] = NULL; }

//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "sendmail")
case "sendmail":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=sendmail_ (#echo(__LINE__)#)"); }

/*i// LICENSE_WARNING
 ----------------------------------------------------------------------------
The sWG Web Service implementation has been published under the General
Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

	if (($direct_globals['kernel']->serviceInitDefault ())&&($direct_settings['ohandler'] == "jsonrpc"))
	{
	$direct_globals['basic_functions']->requireClass ('dNG\sWG\web\directHttpJsonrpc');

	if (($direct_settings['swg_pyhelper'])&&($direct_globals['input']->userGet () == $direct_settings['swg_id']))
	{
	//j// BOA
	$direct_globals['basic_functions']->requireClass ('dNG\sWG\directSendmailerFormtags');

	$g_data = $direct_globals['basic_functions']->inputfilterBasic ($direct_globals['input']->getParams (0));
	$g_data_array = ($g_data ? direct_evars_get ($g_data) : NULL);

	if ((is_array ($g_data_array))&&(isset ($g_data_array['account_sendmail_message'],$g_data_array['account_sendmail_recipient_email'],$g_data_array['account_sendmail_title'])))
	{
		$g_sendmailer_object = new directSendmailerFormtags ();

		if (isset ($g_data_array['account_sendmail_recipient_name'])) { $g_sendmailer_object->recipientsDefine (array ($g_data_array['account_sendmail_recipient_email'] => $g_data_array['account_sendmail_recipient_name'])); }
		else { $g_sendmailer_object->recipientsDefine ($g_data_array['account_sendmail_recipient_email']); }

		$g_sendmailer_object->messageSet ($g_data_array['account_sendmail_message']);
		$g_continue_check = $g_sendmailer_object->send ("single",(((isset ($g_data_array['account_sendmail_sender']))&&(strlen ($g_data_array['account_sendmail_sender']))) ? $g_data_array['account_sendmail_sender'] : $direct_settings['administration_email_out']),$direct_settings['swg_title_txt']." - ".$g_data_array['account_sendmail_title']);

		if ($g_continue_check)
		{
			$direct_globals['output']->set (true);
			$direct_globals['output']->outputSend ();
		}
		else { $direct_globals['output']->outputSendError (directHttpJsonrpc::$RESULT_504); }
	}
	else { $direct_globals['output']->outputSendError (directHttpJsonrpc::$RESULT_400); }
	//j// EOA
	}
	else { $direct_globals['output']->outputSendError (directHttpJsonrpc::$RESULT_403); }

	$direct_cachedata['core_service_activated'] = true;
	}

	break 1;
}
//j// EOS
}

//j// EOF
?>