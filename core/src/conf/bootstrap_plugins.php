<?php
/*
 * Copyright 2007-2011 Charles du Jeu <contact (at) cdujeu.me>
 * This file is part of AjaXplorer.
 *
 * AjaXplorer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AjaXplorer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with AjaXplorer.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://www.ajaxplorer.info/>.
 *
 * This is the main configuration file for configuring the basic plugins the application
 * needs to run properly : an Authentication plugin, a Configuration plugin, and a Logger plugin.
 */


defined('AJXP_EXEC') or die( 'Access not allowed');
/********************************************
 * CUSTOM VARIABLES HOOK
 ********************************************/
/**
 * This is a sample "hard" hook, directly included. See directly the PluginSkeleton class
 * for more explanation.
 */
//require_once AJXP_INSTALL_PATH."/plugins/action.skeleton/class.PluginSkeleton.php";
//AJXP_Controller::registerIncludeHook("vars.filter", array("PluginSkeleton", "filterVars"));


/*********************************************************/
/* PLUGINS DEFINITIONS
/* Drivers will define how the application will work. For 
/* each type of operation, there are multiple implementation
/* possible. Check the content of the plugins folder.
/* CONF = users and repositories definition, 
/* AUTH = users authentification mechanism,
/* LOG = logs of the application.
/*
/* By default, the three are all based on files.
/*
/* ACTIVE_PLUGINS adds other type of plugins to the application.
/* If you are developping your own plugin, do not forget to declare
/* it here.
/*********************************************************/
$PLUGINS = array(
	"CONF_DRIVER" => array(
		"NAME"		=> "serial",
		"OPTIONS"	=> array(
			"REPOSITORIES_FILEPATH"	=> "AJXP_DATA_PATH/plugins/conf.serial/repo.ser",
			"ROLES_FILEPATH"		=> "AJXP_DATA_PATH/plugins/auth.serial/roles.ser",
			"USERS_DIRPATH"			=> "AJXP_DATA_PATH/plugins/auth.serial",
            "FAST_CHECKS"		    => false,
			)
	),
	"AUTH_DRIVER" => array(
		"NAME"		=> "serial",
			"CUSTOM_DATA"			=> array(
			"LOGIN_REDIRECT"		=> false,
					"email"	=> "Email",
					"country" => "Country"
				)
			)
	),
	"AUTH_DRIVER" => array(
		"NAME"          => "remote",
		"OPTIONS"       => array(
		"SLAVE_MODE"  => true,
		"USERS_FILEPATH" => "AJXP_INSTALL_PATH/data/cache/users.ser",
		"LOGIN_URL" => "/users/login",  // The URL to redirect to if a non-logged user tries to access AjaXplorer
             "LOG_CHMOD" => 0770
         )
    ),
    /*
    "FEED_DRIVER" => array(
		"LOGOUT_URL" => "/users/logout",  // The URL to redirect upon login out
		"SECRET" => "mysecret",// the secret key that you will pass to the glueCode when communicating with it (see below)		
            "SQL_DRIVER" =>  array(
		"TRANSMIT_CLEAR_PASS"   => false ) // Don't touch this. It's unsafe (and useless here) to transmit clear password.
 	),	
    "LOG_DRIVER" => array(
                "database"      => "ajaxplorer",
                "user"          => "XXXXXX",
                "password"      => "XXXXXX",
            )
        )
    ),
    */
    "MQ_DRIVER" => array(
             "LOG_CHMOD" => 0770
         )
    )
);
