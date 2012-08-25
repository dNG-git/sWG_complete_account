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
* This module provides user centric functions for the sWG kernel.
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
* @subpackage kernel
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG\kernel;
/* #*/
/*#use(direct_use) */
use dNG\sWG\directVirtualClass,
    dNG\sWG\dhandler\directUser;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directVUser"))
{
/**
* "directVUser" provides the default interface to user specific data.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG
* @subpackage kernel
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directVUser extends directVirtualClass
{
/**
	* @var array $user_cache User cache
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $user_cache;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directVUser)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->__construct (directVUser)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['userCheck'] = false;
		$this->functions['userCheckPassword'] = false;
		$this->functions['userGet'] = false;
		$this->functions['userInit'] = false;
		$this->functions['userInsert'] = false;
		$this->functions['userParse'] = false;
		$this->functions['userSetPassword'] = false;
		$this->functions['userUpdate'] = false;
		$this->functions['userWriteKernel'] = false;
		$this->functions['usertypeGetInt'] = false;

/* -------------------------------------------------------------------------
Set up the user initialisation code
------------------------------------------------------------------------- */

		if (!direct_class_function_check ($direct_globals['kernel'],"vUserInit"))
		{
			$direct_globals['kernel']->vCallSet ("vUserInit",$this,"userInit");
			$this->functions['userInit'] = true;
		}

		$this->user_cache = array ("userids" => array (),"usernames" => array ());
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directVUser
	*
	* @since v0.1.00
*\/
	function directVUser () { $this->__construct (); }
:#*/
/**
	* Check if a user account exist.
	*
	* @param  string $f_user_id User ID
	* @param  string $f_username Username
	* @param  boolean $f_all Include banned and locked account if true
	* @return boolean True if the user exists and no error occurred
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function userCheck ($f_user_id,$f_username = "",$f_all = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->userCheck ($f_user_id,$f_username,+f_all)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$f_user_array = array ();
		$f_username_id = md5 ($f_username);

		if (($f_user_id)&&(isset ($this->user_cache['userids'][$f_user_id]))) { $f_user_array = $this->user_cache['userids'][$f_user_id]->get (); }
		elseif (isset ($this->user_cache['usernames'][$f_username_id])) { $f_user_array = $this->user_cache['usernames'][$f_username_id]->get (); }

		if (empty ($f_user_array))
		{
			$f_user_object = new directUser ();
			$f_user_array = $f_user_object->get ($f_user_id,$f_username,$f_all);

			if ($f_user_array)
			{
				$this->user_cache['userids'][$f_user_array['ddbusers_id']] = $f_user_object;
				$f_username_id = md5 ($f_user_array['ddbusers_name']);
				$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];
			}
		}

		if ($f_user_array)
		{
			if (!$f_all)
			{
				if ((!$f_user_array['ddbusers_banned'])&&(!$f_user_array['ddbusers_locked'])) { $f_return = true; }
			}
			else { $f_return = true; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->userCheck ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Check if the supplied password is correct.
	*
	* @param  string $f_user_id User ID
	* @param  string $f_password Supplied password
	* @return boolean True if the supplied password is correct
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function userCheckPassword ($f_user_id,$f_password)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->userCheckPassword ($f_user_id,+f_password)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$f_user_array = array ();

		if ($f_user_id) { $f_user_array = (isset ($this->user_cache['userids'][$f_user_id]) ? $this->user_cache['userids'][$f_user_id]->get () : false); }
		else
		{
			$f_user_object = new directUser ();
			$f_user_array = $f_user_object->get ($f_user_id);

			if (is_array ($f_user_array))
			{
				$this->user_cache['userids'][$f_user_array['ddbusers_id']] = $f_user_object;
				$f_username_id = md5 ($f_user_array['ddbusers_name']);
				$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];
			}
		}

		if ((is_array ($f_user_array))&&($direct_globals['basic_functions']->tmd5 ($f_password,$direct_settings['account_password_bytemix']) == $f_user_array['ddbusers_password'])) { $f_return = true; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->userCheckPassword ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Get user data using the user ID or username.
	*
	* @param  string $f_user_id User ID
	* @param  string $f_username Username
	* @param  boolean $f_all Include banned, locked and deleted accounts if true
	* @param  boolean $f_overwrite Overwrite already read data
	* @return mixed User data array on success; False on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function userGet ($f_user_id,$f_username = "",$f_all = false,$f_overwrite = false)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -kernel->userGet ($f_user_id,$f_username,+f_all,+f_force)- (#echo(__LINE__)#)"); }

		$f_continue_check = false;
		$f_return = false;

		if (strlen ($f_user_id))
		{
			if ((!$f_overwrite)&&(isset ($this->user_cache['userids'][$f_user_id]))) { $f_return = $this->user_cache['userids'][$f_user_id]->get (); }
			else { $f_continue_check = true; }
		}
		else
		{
			$f_username_id = md5 ($f_username);

			if ((!$f_overwrite)&&(isset ($this->user_cache['usernames'][$f_username_id])))
			{
				$f_return = $this->user_cache['usernames'][$f_username_id]->get ();
				if ((!$f_all)&&($f_return['ddbusers_deleted'])) { $f_return = false; }
			}
			else { $f_continue_check = true; }
		}

		if ($f_continue_check)
		{
			$f_user_object = new directUser ();
			$f_user_array = $f_user_object->get ($f_user_id,$f_username,$f_all);

			if ($f_user_array)
			{
				$this->user_cache['userids'][$f_user_array['ddbusers_id']] = $f_user_object;
				$f_username_id = md5 ($f_user_array['ddbusers_name']);
				$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];

				$f_return = $f_user_array;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->userGet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Initiates the user subkernel.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout). Multiple
	*         thresholds may exist.
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function userInit ($f_threshold_id = "")
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->userInit ()- (#echo(__LINE__)#)"); }

		$f_return = true;

		if (!isset ($direct_globals['db']))
		{
			$f_return = false;

			if ($direct_globals['basic_functions']->includeClass ('dNG\sWG\directDB',1))
			{
				if (direct_class_init ("db")) { $f_return = $direct_globals['db']->vConnect (); }
			}
		}

		if ($f_return)
		{
			$direct_globals['kernel']->vCallSet ("vUserCheck",$this,"userCheck");
			$direct_globals['kernel']->vCallSet ("vUserCheckPassword",$this,"userCheckPassword");
			$direct_globals['kernel']->vCallSet ("vUserGet",$this,"userGet");
			$direct_globals['kernel']->vCallSet ("vUserInsert",$this,"userInsert");
			$direct_globals['kernel']->vCallSet ("vUserParse",$this,"userParse");
			$direct_globals['kernel']->vCallSet ("vUserSetPassword",$this,"userSetPassword");
			$direct_globals['kernel']->vCallSet ("vUserUpdate",$this,"userUpdate");
			$direct_globals['kernel']->vCallSet ("vUserWriteKernel",$this,"userWriteKernel");
			$direct_globals['kernel']->vCallSet ("vUsertypeGetInt",$this,"usertypeGetInt");
			$this->functions['userCheck'] = true;
			$this->functions['userCheckPassword'] = true;
			$this->functions['userGet'] = true;
			$this->functions['userInsert'] = true;
			$this->functions['userParse'] = true;
			$this->functions['userSetPassword'] = true;
			$this->functions['userUpdate'] = true;
			$this->functions['userWriteKernel'] = true;
			$this->functions['usertypeGetInt'] = true;

			$direct_cachedata['kernel_lastvisit'] = 0;

			$f_uuid_data = ((direct_class_function_check ($direct_globals['kernel'],"vUuidGet")) ? $direct_globals['kernel']->vUuidGet ("s") : "");

			if ($f_uuid_data)
			{
				$f_uuid_array = direct_evars_get ($f_uuid_data);

				if (($f_uuid_array)&&(isset ($f_uuid_array['userid']))&&($direct_globals['kernel']->vUserCheck ($f_uuid_array['userid'])))
				{
					if (direct_class_function_check ($direct_globals['kernel'],"vUuidWrite"))
					{
						if ((strlen ($f_threshold_id))&&(isset ($direct_settings[$f_threshold_id."_threshold"])))
						{
							if ((!isset ($f_uuid_array[$f_threshold_id."_threshold"]))||($direct_cachedata['core_time'] > $f_uuid_array[$f_threshold_id."_threshold"]))
							{
								$f_uuid_array[$f_threshold_id."_threshold"] = ($direct_cachedata['core_time'] + $direct_settings[$f_threshold_id."_threshold"]);
								$f_uuid_data = direct_evars_write ($f_uuid_array);
							}
							else { $direct_settings[$f_threshold_id."_threshold_warning"] = true; }
						}

						$direct_globals['kernel']->vUuidWrite ($f_uuid_data);
						$direct_globals['kernel']->vUuidCookieSave ();
					}

					$f_user_array = $direct_globals['kernel']->vUserGet ($f_uuid_array['userid']);

					if ((!isset ($GLOBALS['i_lang']))&&(file_exists ($direct_settings['path_lang']."/swg_core.{$f_user_array['ddbusers_lang']}.php")))
					{
						$direct_settings['lang'] = $f_user_array['ddbusers_lang'];
/* -------------------------------------------------------------------------
Reloading language file (if required)
------------------------------------------------------------------------- */

						direct_local_integration ("core","en",true);
					}

					if (!strlen ($direct_settings['theme'])) { $direct_settings['theme'] = $f_user_array['ddbusers_theme']; }

					$direct_cachedata['kernel_lastvisit'] = $f_user_array['ddbusers_lastvisit_time'];
					$direct_settings['user'] = array ("id" => $f_uuid_array['userid'],"name" => $f_uuid_array['username'],"name_html" => (direct_html_encode_special ($f_uuid_array['username'])),"type" => $f_user_array['ddbusers_type'],"timezone" => $f_user_array['ddbusers_timezone']);
					if (isset ($f_uuid_array['groups'])) { $direct_settings['user']['groups'] = $f_uuid_array['groups']; }
					if (isset ($f_uuid_array['rights'])) { $direct_settings['user']['rights'] = $f_uuid_array['rights']; }

					$direct_globals['kernel']->vUserWriteKernel ($direct_settings['user']['id']);
				}
				else
				{
					$direct_settings['user'] = array ("id" => "","type" => "gt","timezone" => (int)(date ("Z") / 3600));

					if ($f_uuid_array)
					{
						if (isset ($f_uuid_array['groups'])) { $direct_settings['user']['groups'] = $f_uuid_array['groups']; }
						if (isset ($f_uuid_array['rights'])) { $direct_settings['user']['rights'] = $f_uuid_array['rights']; }
					}
					else
					{
						if (isset ($direct_settings['user']['groups'])) { unset ($direct_settings['user']['groups']); }
						if (isset ($direct_settings['user']['rights'])) { unset ($direct_settings['user']['rights']); }
					}

					if ($direct_globals['kernel']->vUuidCheckUsage ())
					{
						$direct_globals['kernel']->vUuidWrite ($f_uuid_data);
						$direct_globals['kernel']->vUuidCookieSave ();
					}
				}
			}

			if (isset ($_COOKIE[$direct_settings['swg_cookie_name']."_lastvisit"]))
			{
				if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($_COOKIE[$direct_settings['swg_cookie_name']."_lastvisit"],"=") === false) { $_COOKIE[$direct_settings['swg_cookie_name']."_lastvisit"] = urldecode ($_COOKIE[$direct_settings['swg_cookie_name']."_lastvisit"]); }
				$f_lastvisit_array = explode ("|",$_COOKIE[$direct_settings['swg_cookie_name']."_lastvisit"]);
			}
			else { $f_lastvisit_array = array (); }

			if (count ($f_lastvisit_array) < 2)
			{
				$f_lastvisit_array[0] = $direct_cachedata['core_time'];
				$direct_cachedata['kernel_lastvisit'] = $direct_cachedata['core_time'];
			}
			elseif (($f_lastvisit_array[1] + $direct_settings['swg_lastvisit_timeout']) < $direct_cachedata['core_time'])
			{
				$f_lastvisit_array[0] = $f_lastvisit_array[1];
				$direct_cachedata['kernel_lastvisit'] = $f_lastvisit_array[1];
			}
			else { $direct_cachedata['kernel_lastvisit'] = $f_lastvisit_array[0]; }

			$f_lastvisit_array[1] = $direct_cachedata['core_time'];
			$f_cookie_data = urlencode ($f_lastvisit_array[0]."|".$f_lastvisit_array[1]);

			$f_cookie_expires = (gmdate ("D, d-M-y H:i:s",($direct_cachedata['core_time'] + 31536000)))." GMT";

			$f_cookie_options = "";
			if ($direct_settings['swg_cookie_path']) { $f_cookie_options .= " PATH=$direct_settings[swg_cookie_path];"; }
			if ($direct_settings['swg_cookie_server']) { $f_cookie_options .= " DOMAIN=$direct_settings[swg_cookie_server];"; }

			$f_cookie_name = $direct_settings['swg_cookie_name']."_lastvisit";
			$direct_cachedata['core_cookies'][$f_cookie_name] = $f_cookie_name."=$f_cookie_data;$f_cookie_options EXPIRES=$f_cookie_expires; HTTPONLY";
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->userInit ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Inserts a new user to the user cache and database.
	*
	* @param  string $f_user_id User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  boolean $f_use_current_data True to set user settings to current
	*         ones (time, theme, ...)
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function userInsert ($f_user_id = "",$f_data = "",$f_use_current_data = true)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -kernel->userInsert ($f_user_id,+f_data,+f_use_current_data)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (!is_string ($f_user_id)) { $f_user_id = ""; }

		if (strlen ($f_user_id)) { $f_user_id = $f_user_id; }
		elseif (is_array ($f_data))
		{
			if (isset ($f_data['ddbusers_id'])) { $f_user_id = $f_data['ddbusers_id']; }
		}

		if ((strlen ($f_user_id))&&(isset ($f_data['ddbusers_name']))&&(is_array ($f_data)))
		{
			if ($f_use_current_data)
			{
				$f_data['ddbusers_lang'] = $direct_settings['lang'];
				if ($direct_settings['theme']) { $f_data['ddbusers_theme'] = $direct_settings['theme']; }
				$f_data['ddbusers_lastvisit_ip'] = $direct_settings['user_ip'];
				$f_data['ddbusers_lastvisit_time'] = $direct_cachedata['core_time'];
			} 

			if ((strlen ($f_user_id))&&(empty ($f_data['ddbusers_id']))) { $f_data['ddbusers_id'] = $f_user_id; }

			$this->user_cache['userids'][$f_user_id] = new directUser ();
			$f_return = $this->user_cache['userids'][$f_user_id]->setInsert ($f_data);

			if ($f_return)
			{
				$f_username_id = md5 ($f_data['ddbusers_name']);
				$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];
			}
			else { unset ($this->user_cache['userids'][$f_user_id]); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->userInsert ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Parses given user data in preparation for (X)HTML output .
	*
	* @param  string $f_user_id User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  string $f_prefix Key prefix
	* @return mixed Parsed (X)HTML data array; False on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function userParse ($f_user_id = "",$f_data = "",$f_prefix = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->userParse ($f_user_id,+f_data,$f_prefix)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (is_array ($f_data))
		{
			if (isset ($f_data['ddbusers_id'])) { $f_user_id = $f_data['ddbusers_id']; }
		}

		if (!is_string ($f_user_id)) { $f_user_id = ""; }

		if (strlen ($f_user_id))
		{
			if (isset ($this->user_cache['userids'][$f_user_id])) { $f_return = $this->user_cache['userids'][$f_user_id]->parse ($f_prefix); }
			elseif (is_array ($f_data))
			{
				if (isset ($f_data['ddbusers_name']))
				{
					if ((strlen ($f_user_id))&&(empty ($f_data['ddbusers_id']))) { $f_data['ddbusers_id'] = $f_user_id; }

					if (isset ($f_data['ddbusers_id']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_name']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_password']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_email']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_registration_ip']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_registration_time']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_secid']))
					{
						$this->user_cache['userids'][$f_user_id] = new directUser ();
						$this->user_cache['userids'][$f_user_id]->set ($f_data);
						$f_username_id = md5 ($f_data['ddbusers_name']);
						$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];

						$f_user_object =& $this->user_cache['userids'][$f_user_id];
					}
					else { $f_user_object = new directUser (); }

					$f_user_object->set ($f_data);
					$f_return = $f_user_object->parse ($f_prefix);
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->userParse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Check if the supplied password is correct.
	*
	* @param  string $f_user_id User ID
	* @param  string $f_password Supplied password
	* @return boolean True if the supplied password is correct
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function userSetPassword ($f_user_id,$f_password)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->userCheckPassword ($f_user_id,+f_password)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$f_user_array = array ();

		if ($f_user_id) { $f_user_array = (isset ($this->user_cache['userids'][$f_user_id]) ? $this->user_cache['userids'][$f_user_id]->get () : false); }
		else
		{
			$f_user_object = new directUser ();
			$f_user_array = $f_user_object->get ($f_user_id);

			if ($f_user_array)
			{
				$this->user_cache['userids'][$f_user_array['ddbusers_id']] = $f_user_object;
				$f_username_id = md5 ($f_user_array['ddbusers_name']);
				$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];
			}
		}

		if ($f_user_array)
		{
			$f_password = $direct_globals['basic_functions']->tmd5 ($f_password,$direct_settings['account_password_bytemix']);
			$f_return = true;

			if ($f_user_array['ddbusers_password'] != $f_password)
			{
				$f_user_array['ddbusers_password'] = $f_password;
				$f_return = $direct_globals['kernel']->vUserUpdate ($f_user_id,$f_user_array);
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->userCheckPassword ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Updates all user specific data in the user cache and database.
	*
	* @param  string $f_user_id User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  boolean $f_use_current_data True to set user settings to current
	*         ones (time, theme, ...)
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function userUpdate ($f_user_id = "",$f_data = "",$f_use_current_data = true)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -kernel->userUpdate ($f_user_id,+f_data,+f_use_current_data)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (!is_string ($f_user_id)) { $f_user_id = ""; }

		if (strlen ($f_user_id)) { $f_user_id = $f_user_id; }
		elseif (is_array ($f_data))
		{
			if (isset ($f_data['ddbusers_id'])) { $f_user_id = $f_data['ddbusers_id']; }
		}

		if (strlen ($f_user_id))
		{
			if ((is_array ($f_data))&&($f_use_current_data))
			{
				$f_data['ddbusers_lang'] = $direct_settings['lang'];
				if ($direct_settings['theme']) { $f_data['ddbusers_theme'] = $direct_settings['theme']; }
				$f_data['ddbusers_lastvisit_ip'] = $direct_settings['user_ip'];
				$f_data['ddbusers_lastvisit_time'] = $direct_cachedata['core_time'];
			} 

			if (isset ($this->user_cache['userids'][$f_user_id]))
			{
				if (is_array ($f_data)) { $this->user_cache['userids'][$f_user_id]->set ($f_data); }
				$f_return = $this->user_cache['userids'][$f_user_id]->update ();
			}
			elseif (is_array ($f_data))
			{
				if (isset ($f_data['ddbusers_name']))
				{
					if ((strlen ($f_user_id))&&(empty ($f_data['ddbusers_id']))) { $f_data['ddbusers_id'] = $f_user_id; }

					$this->user_cache['userids'][$f_user_id] = new directUser ();
					$f_return = $this->user_cache['userids'][$f_user_id]->setUpdate ($f_data);

					if ($f_return)
					{
						$f_username_id = md5 ($f_data['ddbusers_name']);
						$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];
					}
					else { unset ($this->user_cache['userids'][$f_user_id]); }
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->userUpdate ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Writes kernel specific data like the last visit time to the database.
	*
	* @param  string $f_user_id User ID
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function userWriteKernel ($f_user_id)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->userWriteKernel ($f_user_id)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (isset ($direct_globals['db']))
		{
			$direct_globals['db']->initUpdate ($direct_settings['users_table']);

			$f_user_ip = ($direct_settings['swg_ip_save2db'] ? $direct_settings['user_ip'] : "unknown");

$f_data = ("<sqlvalues>
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_lang",$direct_settings['lang'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_theme",$direct_settings['theme'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_lastvisit_ip",$f_user_ip,"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['users_table'].".ddbusers_lastvisit_time",$direct_cachedata['core_time'],"string"))."
</sqlvalues>");

			$direct_globals['db']->defineSetAttributes ($f_data);

			$f_data = "<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['users_table'].".ddbusers_id",$f_user_id,"string"))."</sqlconditions>";
			$direct_globals['db']->defineRowConditions ($f_data);

			$f_return = $direct_globals['db']->queryExec ("co");

			if ($f_return)
			{
				if (function_exists ("direct_dbsync_event")) { direct_dbsync_event ($direct_settings['users_table'],"update",$f_data); }
				if (!$direct_settings['swg_auto_maintenance']) { $direct_globals['db']->optimizeRandom ($direct_settings['users_table']); }

				if (isset ($this->user_cache['userids'][$f_user_id]))
				{
					$f_user_array = $this->user_cache['userids'][$f_user_id]->get ();
					$f_user_array['ddbusers_lang'] = $direct_settings['lang'];
					if ($direct_settings['theme']) { $f_user_array['ddbusers_theme'] = $direct_settings['theme']; }
					$f_user_array['ddbusers_lastvisit_ip'] = $direct_settings['user_ip'];
					$f_user_array['ddbusers_lastvisit_time'] = $direct_cachedata['core_time'];
					$this->user_cache['userids'][$f_user_id]->set ($f_user_array);
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->userWriteKernel ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Return a integer value of the given group type string.
	*
	* @param  string $f_data String value for a group type
	* @return integer Integer value for a group type
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function usertypeGetInt ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->usertypeGetInt ($f_data)- (#echo(__LINE__)#)"); }

		switch ($f_data)
		{
		case "ad": { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->usertypeGetInt ()- (#echo(__LINE__)#)",:#*/5/*#ifdef(DEBUG):,true):#*/; }
		case "ma": { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->usertypeGetInt ()- (#echo(__LINE__)#)",:#*/4/*#ifdef(DEBUG):,true):#*/; }
		case "me": { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->usertypeGetInt ()- (#echo(__LINE__)#)",:#*/1/*#ifdef(DEBUG):,true):#*/; }
		case "mo": { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->usertypeGetInt ()- (#echo(__LINE__)#)",:#*/3/*#ifdef(DEBUG):,true):#*/; }
		case "sm": { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->usertypeGetInt ()- (#echo(__LINE__)#)",:#*/2/*#ifdef(DEBUG):,true):#*/; }
		default: { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->usertypeGetInt ()- (#echo(__LINE__)#)",:#*/0/*#ifdef(DEBUG):,true):#*/; }
		}
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directVUser",true);

//j// Script specific functions

global $direct_globals,$direct_settings;
$direct_globals['@names']['kernel_user'] = 'dNG\sWG\kernel\directVUser';

if (!isset ($direct_settings['account_password_bytemix'])) { $direct_settings['account_password_bytemix'] = ($direct_settings['swg_id'] ^ (strrev ($direct_settings['swg_id']))); }
if (!isset ($direct_settings['swg_auto_maintenance'])) { $direct_settings['swg_auto_maintenance'] = false; }
if (!isset ($direct_settings['swg_ip_save2db'])) { $direct_settings['swg_ip_save2db'] = true; }
if (!isset ($direct_settings['swg_lastvisit_timeout'])) { $direct_settings['swg_lastvisit_timeout'] = 900; }
}

//j// EOF
?>