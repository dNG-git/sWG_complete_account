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
* OOP (Object Oriented Programming) requires an abstract data
* handling. The sWG is OO (where it makes sense).
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
* @subpackage kernel_user
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG\dhandler;
/* #*/
/*#use(direct_use) */
use dNG\sWG\directDataHandler;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directUser"))
{
/**
* This abstraction layer provides user specific parsing functions.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG
* @subpackage kernel_user
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directUser extends directDataHandler
{
/**
	* @var boolean $data_subs_allowed True if the next "update ()" call
	*      is an insert - the code is the same.
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $data_insert_mode;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directUser)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -user->__construct (directUser)- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['@names']['formtags'])) { $direct_globals['basic_functions']->includeClass ('dNG\sWG\directFormtags',2); }
		if (!isset ($direct_globals['formtags'])) { direct_class_init ("formtags"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['getAid'] = true;
		$this->functions['parse'] = isset ($direct_globals['formtags']);
		$this->functions['setInsert'] = true;
		$this->functions['setUpdate'] = true;
		$this->functions['update'] = true;

/* -------------------------------------------------------------------------
Set up an additional variables :)
------------------------------------------------------------------------- */

		$this->data = array ();
		$this->data_insert_mode = false;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directUser
	*
	* @since v0.1.00
*\/
	function directUser () { $this->__construct (); }
:#*/
/**
	* Request and load user data.
	*
	* @param  string $f_userid User ID
	* @param  string $f_username Username
	* @param  boolean $f_all Include banned and locked account if true
	* @param  boolean $f_load Load right data from the database
	* @return mixed User data; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function get ($f_userid = "",$f_username = "",$f_all = false,$f_load = true)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -user->get ($f_userid,$f_username,+f_all,+f_load)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (strlen ($f_userid))
		{
			if ($f_load)
			{
				if ($f_all)
				{
					$f_attributes = array ();
					$f_values = array ();
				}
				else
				{
					$f_attributes = array ($direct_settings['users_table'].".ddbusers_banned",$direct_settings['users_table'].".ddbusers_locked");
					$f_values = array (0,0);
				}

				$f_attributes[] = $direct_settings['users_table'].".ddbusers_id";
				$f_values[] = $f_userid;
				$f_return = $this->getAid ($f_attributes,$f_values);
			}
			else
			{
				$this->data = array ("ddbusers_id" => $f_userid);
				$f_return = $this->data;
			}
		}
		elseif (strlen ($f_username))
		{
			if ($f_all)
			{
				$f_attributes = array ($direct_settings['users_table'].".ddbusers_deleted");
				$f_values = array (0);
			}
			else
			{
				$f_attributes = array ($direct_settings['users_table'].".ddbusers_banned",$direct_settings['users_table'].".ddbusers_deleted",$direct_settings['users_table'].".ddbusers_locked");
				$f_values = array (0,0,0);
			}

			$f_attributes[] = $direct_settings['users_table'].".ddbusers_name";
			$f_values[] = $f_username;
			$f_return = $this->getAid ($f_attributes,$f_values);
		}
		elseif ($this->data) { $f_return = $this->data; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -user->get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Reads in a user entry with custom attribute. Please note that only
	* attributes of type "string" are supported.
	*
	* @param  mixed $f_attributes Attribute name(s) (array or string)
	* @param  mixed $f_values Attribute value(s) (array or string)
	* @return mixed User data; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function getAid ($f_attributes = NULL,$f_values = "")
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -user->getAid (+f_attributes,+f_values)- (#echo(__LINE__)#)"); }

		if (!isset ($f_attributes)) { $f_attributes = $direct_settings['users_table'].".ddbusers_id"; }
		$f_return = false;

		if ((is_string ($f_attributes))&&(is_string ($f_values)))
		{
			$f_attributes = array ($f_attributes);
			$f_values = array ($f_values);
		}
		elseif ((!is_array ($f_attributes))||(!is_array ($f_values))||(count ($f_attributes) != (count ($f_values)))) { $f_attributes = NULL; }

		if (isset ($f_attributes))
		{
			if (count ($this->data) > 1) { $f_return = $this->data; }
			elseif ((($f_values == NULL)&&(!empty ($this->data_extra_conditions)))||(isset ($f_attributes)))
			{
				$direct_globals['db']->initSelect ($direct_settings['users_table']);

				$direct_globals['db']->defineAttributes (array ($direct_settings['users_table'].".*",$direct_settings['evars_archive_table'].".ddbevars_archive_data AS ddbusers_avatar_data"));
				$direct_globals['db']->defineJoin ("left-outer-join",$direct_settings['evars_archive_table'],"<sqlconditions><element1 attribute='{$direct_settings['evars_archive_table']}.ddbevars_archive_id' value='{$direct_settings['users_table']}.ddbusers_avatar' type='attribute' /></sqlconditions>");

				$f_select_criteria = "<sqlconditions>";

				if (isset ($f_attributes,$f_values))
				{
					foreach ($f_values as $f_value)
					{
						$f_attribute = array_shift ($f_attributes);
						$f_select_criteria .= $direct_globals['db']->defineRowConditionsEncode ($f_attribute,$f_value,"string");
					}
				}

				$f_select_criteria .= "</sqlconditions>";

				$direct_globals['db']->defineRowConditions ($f_select_criteria);

				$direct_globals['db']->defineLimit (1);
				$this->data = $direct_globals['db']->queryExec ("sa");

				if ($this->data) { $f_return = $this->data; }
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -user->getAid ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Request and load user data.
	*
	* @param  string $f_prefix Key prefix
	* @return mixed User data; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function parse ($f_prefix = "")
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -user->parse ($f_prefix)- (#echo(__LINE__)#)"); }

		$f_return = array ();

		if (count ($this->data) > 1)
		{
			$f_return[$f_prefix."id"] = "swgdhandleruser".$this->data['ddbusers_id'];
			$f_return[$f_prefix."oid"] = $this->data['ddbusers_id'];

			if (($this->data['ddbusers_banned'])||($this->data['ddbusers_deleted']))
			{
				$f_return[$f_prefix."pageurl"] = "";
				$f_return[$f_prefix."type"] = (($this->data['ddbusers_banned']) ? direct_local_get ("core_usertype_banned") : direct_local_get ("core_usertype_deleted"));
			}
			else
			{
				$f_return[$f_prefix."pageurl"] = (($this->data['ddbusers_id']) ? "m=account;s=profile;a=view;dsd=auid+".$this->data['ddbusers_id'] : "");

				switch ($this->data['ddbusers_type'])
				{
				case "ad":
				{
					$f_return[$f_prefix."type"] = direct_local_get ("core_usertype_administrator");
					break 1;
				}
				case "ex":
				{
					$f_return[$f_prefix."type"] = direct_local_get ("core_usertype_external");
					break 1;
				}
				case "ma":
				{
					$f_return[$f_prefix."type"] = direct_local_get ("core_usertype_main_moderator");
					break 1;
				}
				case "mo":
				{
					$f_return[$f_prefix."type"] = direct_local_get ("core_usertype_moderator");
					break 1;
				}
				case "sm":
				{
					$f_return[$f_prefix."type"] = direct_local_get ("core_usertype_member_special");
					break 1;
				}
				default: { $f_return[$f_prefix."type"] = direct_local_get ("core_usertype_member"); }
				}
			}

			$f_return[$f_prefix."name"] = direct_html_encode_special ($this->data['ddbusers_name']);
			$f_return[$f_prefix."email"] = "";
			$f_return[$f_prefix."pageurl_email"] = "";

			if ($direct_globals['kernel']->vUsertypeGetInt ($direct_settings['user']['type']) > 3)
			{
				$f_return[$f_prefix."email"] = ((isset ($this->data['ddbusers_email'])) ? direct_html_encode_special ($this->data['ddbusers_email']) : NULL);
				if ($this->data['ddbusers_id']) { $f_return[$f_prefix."pageurl_email"] = "m=account;s=email;dsd=auid+".$this->data['ddbusers_id']; }
			}
			elseif ($this->data['ddbusers_email_public'])
			{
				$f_return[$f_prefix."email"] = "";
				if ($this->data['ddbusers_id']) { $f_return[$f_prefix."pageurl_email"] = "m=account;s=email;dsd=auid+".$this->data['ddbusers_id']; }
			}

			$f_return[$f_prefix."title"] = $direct_globals['formtags']->decode ($this->data['ddbusers_title']);
			$f_return[$f_prefix."avatar"] = "";
			$f_return[$f_prefix."avatar_small"] = "";
			$f_return[$f_prefix."avatar_large"] = "";

			if ((isset ($this->data['ddbusers_avatar']))&&($this->data['ddbusers_avatar']))
			{
				$f_return[$f_prefix."avatar"] = $this->data['ddbusers_avatar'];
				$f_return[$f_prefix."avatar_small"] = direct_linker_dynamic ("url1","m=account;s=avatar;a=transfer;dsd=atype+small++aeid+".$this->data['ddbusers_avatar'],true,false);
				$f_return[$f_prefix."avatar_large"] = direct_linker_dynamic ("url1","m=account;s=avatar;a=transfer;dsd=atype+large++aeid+".$this->data['ddbusers_avatar'],true,false);

				if (!empty ($this->data['ddbusers_avatar_data']))
				{
					$f_avatar_array = direct_evars_get ($this->data['ddbusers_avatar_data']);

					if ($f_avatar_array)
					{
						$f_return[$f_prefix."avatar_small"] = (((isset ($f_avatar_array['avatar_small']))&&($f_avatar_array['avatar_small'])) ? direct_linker_dynamic ("url1","m=account;s=avatar;a=transfer;dsd=atype+small++aoid+".$f_avatar_array['avatar_small'],true,false) : "");
						$f_return[$f_prefix."avatar_large"] = (((isset ($f_avatar_array['avatar_large']))&&($f_avatar_array['avatar_large'])) ? direct_linker_dynamic ("url1","m=account;s=avatar;a=transfer;dsd=atype+large++aoid+".$f_avatar_array['avatar_large'],true,false) : "");
					}
				}
			}

			$f_return[$f_prefix."signature"] = ((isset ($this->data['ddbusers_signature'])) ? $direct_globals['formtags']->decode ($this->data['ddbusers_signature']) : NULL);
			$f_return[$f_prefix."rating"] = (((isset ($this->data['ddbusers_rating']))&&($this->data['ddbusers_rating'])) ? $this->data['ddbusers_rating']." / ".$direct_settings['rating_max'] : direct_local_get ("core_unknown"));
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -user->parse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Sets (and overwrites) the given data for this object.
	*
	* @param  array $f_data User data array
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function set ($f_data)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -user->set (+f_data)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
By default, the "*_set" method should check for all needed data. In the case
of "directUser", this check is placed in "update ()". That way we
can use our "parse ()" method to parse even incomplete user data.
------------------------------------------------------------------------- */

		$f_continue_check = isset ($f_data['ddbusers_name']);
		$f_deleted = (((isset ($f_data['ddbusers_type']))&&($f_data['ddbusers_type'] == "ex")) ? 1 : 0);

		if ($f_continue_check)
		{
			$f_return = true;

			$this->data['ddbusers_id'] = (((isset ($f_data['ddbusers_id']))&&(strlen ($f_data['ddbusers_id']))) ? $f_data['ddbusers_id'] : (uniqid ("")));
			$this->data['ddbusers_type'] = (isset ($f_data['ddbusers_type']) ? $f_data['ddbusers_type'] : "me");
			$this->data['ddbusers_type_ex'] = (isset ($f_data['ddbusers_type_ex']) ? $f_data['ddbusers_type_ex'] : "");
			$this->data['ddbusers_banned'] = (isset ($f_data['ddbusers_banned']) ? $f_data['ddbusers_banned'] : 0);
			$this->data['ddbusers_deleted'] = (isset ($f_data['ddbusers_deleted']) ? $f_data['ddbusers_deleted'] : $f_deleted);
			$this->data['ddbusers_locked'] = (isset ($f_data['ddbusers_locked']) ? $f_data['ddbusers_locked'] : 0);
			if (isset ($f_data['ddbusers_name'])) { $this->data['ddbusers_name'] = $f_data['ddbusers_name']; }
			if (isset ($f_data['ddbusers_password'])) { $this->data['ddbusers_password'] = $f_data['ddbusers_password']; }
			$this->data['ddbusers_lang'] = (((isset ($f_data['ddbusers_lang']))&&(strlen ($f_data['ddbusers_lang']))) ? $f_data['ddbusers_lang'] : $direct_settings['lang']);
			$this->data['ddbusers_theme'] = (((isset ($f_data['ddbusers_theme']))&&(strlen ($f_data['ddbusers_theme']))) ? $f_data['ddbusers_theme'] : $direct_settings['theme']);
			if (isset ($f_data['ddbusers_email'])) { $this->data['ddbusers_email'] = $f_data['ddbusers_email']; }
			$this->data['ddbusers_email_public'] = (isset ($f_data['ddbusers_email_public']) ? $f_data['ddbusers_email_public'] : 0);
			$this->data['ddbusers_credits'] = (isset ($f_data['ddbusers_credits']) ? $f_data['ddbusers_credits'] : 0);
			$this->data['ddbusers_title'] = (isset ($f_data['ddbusers_title']) ? $f_data['ddbusers_title'] : "");
			$this->data['ddbusers_avatar'] = (isset ($f_data['ddbusers_avatar']) ? $f_data['ddbusers_avatar'] : "");
			$this->data['ddbusers_signature'] = (isset ($f_data['ddbusers_signature']) ? $f_data['ddbusers_signature'] : "");
			if (isset ($f_data['ddbusers_registration_ip'])) { $this->data['ddbusers_registration_ip'] = $f_data['ddbusers_registration_ip']; }
			if (isset ($f_data['ddbusers_registration_time'])) { $this->data['ddbusers_registration_time'] = $f_data['ddbusers_registration_time']; }
			if (isset ($f_data['ddbusers_secid'])) { $this->data['ddbusers_secid'] = $f_data['ddbusers_secid']; }

			if ($direct_settings['swg_ip_save2db']) { $this->data['ddbusers_lastvisit_ip'] = (((isset ($f_data['ddbusers_lastvisit_ip']))&&(strlen ($f_data['ddbusers_lastvisit_ip']))) ? $f_data['ddbusers_lastvisit_ip'] : $direct_settings['user_ip']); }
			else { $this->data['ddbusers_lastvisit_ip'] = "unknown"; }

			$this->data['ddbusers_lastvisit_time'] = (isset ($f_data['ddbusers_lastvisit_time']) ? $f_data['ddbusers_lastvisit_time'] : $direct_cachedata['core_time']);
			$this->data['ddbusers_lastactivity_time'] = (isset ($f_data['ddbusers_lastactivity_time']) ? $f_data['ddbusers_lastactivity_time'] : $direct_cachedata['core_time']);
			$this->data['ddbusers_rating'] = (isset ($f_data['ddbusers_rating']) ? $f_data['ddbusers_rating'] : 0);
			$this->data['ddbusers_timezone'] = (isset ($f_data['ddbusers_timezone']) ? $f_data['ddbusers_timezone'] : 0);
			$this->data['ddbusers_avatar_data'] = (isset ($f_data['ddbusers_avatar_data']) ? $f_data['ddbusers_avatar_data'] : "");

/* -------------------------------------------------------------------------
Additional tablecells will be added without testing. Extend this class or
test for missing values in the "action" sections.
------------------------------------------------------------------------- */

			if ((is_array ($direct_settings['users_tablecells_extras']))&&(!empty ($direct_settings['users_tablecells_extras'])))
			{
				foreach ($direct_settings['users_tablecells_extras'] as $f_extra_attribute) { $this->data[$f_extra_attribute] = ((isset ($f_data[$f_extra_attribute])) ? $f_data[$f_extra_attribute] : ""); }
			}
		}
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -user->set ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Add the given data to this object and save them in the database.
	*
	* @param  array $f_data User data array
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function setInsert ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -user->setInsert (+f_data)- (#echo(__LINE__)#)"); }

		if ($this->set ($f_data))
		{
			$this->data_insert_mode = true;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -user->setInsert ()- (#echo(__LINE__)#)",(:#*/$this->update ()/*#ifdef(DEBUG):),true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -user->setInsert ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Update the given data in this object and save them in the database.
	*
	* @param  array $f_data User data array
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function setUpdate ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -user->setUpdate (+f_data)- (#echo(__LINE__)#)"); }

		if ($this->set ($f_data))
		{
			$this->data_insert_mode = false;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -user->setUpdate ()- (#echo(__LINE__)#)",(:#*/$this->update ()/*#ifdef(DEBUG):),true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -user->setUpdate ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Writes all object data to the database.
	*
	* @param  boolean $f_insert_mode_deactivate Deactive insert mode after calling
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function update ($f_insert_mode_deactivate = true)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -user->update ()- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (count ($this->data) > 1)
		{
			$f_continue_check = isset ($this->data['ddbusers_type']);
			if (($f_continue_check)&&($this->data['ddbusers_type'] == "ex")&&((!isset ($this->data['ddbusers_type_ex'])||(!strlen ($this->data['ddbusers_type_ex']))))) { $f_continue_check = false; }

			if (($f_continue_check)&&(isset ($this->data['ddbusers_name']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$this->data['ddbusers_password']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$this->data['ddbusers_email']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$this->data['ddbusers_registration_ip']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$this->data['ddbusers_registration_time']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$this->data['ddbusers_secid']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$this->data['ddbusers_lastactivity_time'])))
			{
				if ($this->data_insert_mode) { $direct_globals['db']->initInsert ($direct_settings['users_table']); }
				else { $direct_globals['db']->initUpdate ($direct_settings['users_table']); }

$f_data_values = ("<sqlvalues>
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_id",$this->data['ddbusers_id'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_type",$this->data['ddbusers_type'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_type_ex",$this->data['ddbusers_type_ex'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_banned",$this->data['ddbusers_banned'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_deleted",$this->data['ddbusers_deleted'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_locked",$this->data['ddbusers_locked'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_name",$this->data['ddbusers_name'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_password",$this->data['ddbusers_password'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_lang",$this->data['ddbusers_lang'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_theme",$this->data['ddbusers_theme'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_email",$this->data['ddbusers_email'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_email_public",$this->data['ddbusers_email_public'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_credits",$this->data['ddbusers_credits'],"number"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_title",$this->data['ddbusers_title'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_avatar",$this->data['ddbusers_avatar'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_signature",$this->data['ddbusers_signature'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_registration_ip",$this->data['ddbusers_registration_ip'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_registration_time",$this->data['ddbusers_registration_time'],"number"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_secid",$this->data['ddbusers_secid'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_lastvisit_ip",$this->data['ddbusers_lastvisit_ip'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_lastvisit_time",$this->data['ddbusers_lastvisit_time'],"number"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_lastactivity_time",$this->data['ddbusers_lastactivity_time'],"number"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_rating",$this->data['ddbusers_rating'],"number"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_timezone",$this->data['ddbusers_timezone'],"number")));

				if ((is_array ($direct_settings['users_tablecells_extras']))&&(!empty ($direct_settings['users_tablecells_extras'])))
				{
					foreach ($direct_settings['users_tablecells_extras'] as $f_extra_attribute) { $f_data_values .= $direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".".$f_extra_attribute,$this->data[$f_extra_attribute],"string"); }
				}

				$f_data_values .= "</sqlvalues>";

				$direct_globals['db']->defineSetAttributes ($f_data_values);
				if (!$this->data_insert_mode) { $direct_globals['db']->defineRowConditions ("<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['users_table'].".ddbusers_id",$this->data['ddbusers_id'],"string"))."</sqlconditions>"); }
				$f_return = $direct_globals['db']->queryExec ("co");

				if ($f_return)
				{
					if (function_exists ("direct_dbsync_event")) { direct_dbsync_event ($direct_settings['users_table'],($this->data_insert_mode ? "insert" : "update"),("<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['users_table'].".ddbusers_id",$this->data['ddbusers_id'],"string"))."</sqlconditions>")); }
					if (!$direct_settings['swg_auto_maintenance']) { $direct_globals['db']->optimizeRandom ($direct_settings['users_table']); }
				}
			}
		}

		if (($f_insert_mode_deactivate)&&($this->data_insert_mode)) { $this->data_insert_mode = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -user->update ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directUser",true);

//j// Script specific functions

global $direct_settings;
if (!isset ($direct_settings['swg_auto_maintenance'])) { $direct_settings['swg_auto_maintenance'] = false; }
if (!isset ($direct_settings['swg_ip_save2db'])) { $direct_settings['swg_ip_save2db'] = true; }
if (!isset ($direct_settings['users_tablecells_extras'])) { $direct_settings['users_tablecells_extras'] = array (); }
}

//j// EOF
?>