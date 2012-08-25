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
* osets/atom/swg_account.php
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
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
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

$f_return = ("<subtitle type='xhtml'>".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "div","value" => (direct_local_get ("account_actives_1","text")).$direct_cachedata['output_minutes'].(direct_local_get ("account_actives_2","text")),"attributes" => array ("xmlns" => "http://www.w3.org/1999/xhtml"))))."</subtitle>
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "link","attributes" => array ("href" => (direct_linker_dynamic ("url1","atom;m=account;a=actives;dsd=aminutes+".$direct_cachedata['output_minutes'],false,false)),"rel" => "self","type" => "application/atom+xml"))))."
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "link","attributes" => array ("href" => (direct_linker_dynamic ("url1","m=account;a=actives;dsd=aminutes+".$direct_cachedata['output_minutes'],false,false)),"rel" => "alternate","type" => "application/xhtml+xml"))))."
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "updated","value" => gmdate ("c",$direct_cachedata['core_time']))))."
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "id","value" => "urn:de-direct-netware-xmlns:atom.parameters:m=account;a=actives;dsd=aminutes+".$direct_cachedata['output_minutes']))));

	if (!empty ($direct_cachedata['output_users']))
	{
		foreach ($direct_cachedata['output_users'] as $f_user_array)
		{
			$f_user_parsed_name = $direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "div","value" => $f_user_array['name'],"attributes" => array ("xmlns" => "http://www.w3.org/1999/xhtml")));

$f_return .= ("\n<entry>
<title type='xhtml'>$f_user_parsed_name</title>
<author><name>$f_user_parsed_name</name>
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "uri","value" => direct_linker_dynamic ("url1","m=account;s=profile;a=view;dsd=auid+".$f_user_array['oid'],false,false))))."
</author>
<content type='application/xml'>
<person xmlns='http://ns.opensocial.org/2008/opensocial'>
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "id","value" => $f_user_array['oid'])))."
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "nickname","value" => $f_user_array['name'])))."
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "profile_url","value" => direct_linker_dynamic ("url1","m=account;s=profile;a=view;dsd=auid+".$f_user_array['oid'],false,false))))."
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "network_presence","value" => (direct_local_get ("account_online","text")),"attributes" => array ("key" => "ONLINE"))))."
</person>
</content>
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "updated","value" => gmdate ("c",$f_user_array['lastvisit_time']))))."
".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "id","value" => "urn:de-direct-netware-xmlns:atom.id:".$f_user_array['oid'])))."
</entry>");
		}
	}

	return $f_return;
}

//j// EOF
?>