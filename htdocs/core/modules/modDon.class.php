<?php
/* Copyright (C) 2003-2005	Rodolphe Quiedeville	<rodolphe@quiedeville.org>
 * Copyright (C) 2004-2010	Laurent Destailleur		<eldy@users.sourceforge.net>
 * Copyright (C) 2005-2011	Regis Houssin			<regis.houssin@capnetworks.com>
 * Copyright (C) 2015		Alexandre Spangaro		<alexandre.spangaro@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *	\defgroup   don     Module donations
 *	\brief      Module to manage the follow-up of the donations
 *	\file       htdocs/core/modules/modDon.class.php
 *	\ingroup    donations
 *	\brief      Description and activation file for module Donation
 */

include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';


/**
 *	Class to describe and enable module Donation
 */
class modDon  extends DolibarrModules
{

	/**
	 *   Constructor. Define names, constants, directories, boxes, permissions
	 *
	 *   @param      DoliDB		$db      Database handler
	 */
	function __construct($db)
	{
		$this->db = $db;
		$this->numero = 700;

		$this->family = "financial";
		// Module label (no space allowed), used if translation string 'ModuleXXXName' not found (where XXX is value of numeric property 'numero' of module)
		$this->name = preg_replace('/^mod/i','',get_class($this));
		$this->description = "Gestion des dons";
		$this->version = 'dolibarr';    // 'experimental' or 'dolibarr' or version
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		$this->special = 0;
		// Name of png file (without png) used for this module.
		// Png file must be in theme/yourtheme/img directory under name object_pictovalue.png.
		$this->picto='bill';

		// Data directories to create when module is enabled
		$this->dirs = array("/dons/temp");

		// Dependancies
		$this->depends = array();
		$this->requiredby = array();

		// Config pages
		$this->config_page_url = array("donation.php@don");

		// Constants
		$this->const = array ();

		$this->const[0] = array (
				"DON_ADDON_MODEL",
				"chaine",
				"html_cerfafr",
				"Nom du gestionnaire de generation de recu de dons",
				"0"
		);
		$this->const[1] = array (
				"DONATION_ART200",
				"yesno",
				"0",
				"Option Française - Eligibilité Art200 du CGI",
				"0"
		);
		$this->const[2] = array (
				"DONATION_ART238",
				"yesno",
				"0",
				"Option Française - Eligibilité Art238 bis du CGI",
				"0"
		);
		$this->const[3] = array (
				"DONATION_ART885",
				"yesno",
				"0",
				"Option Française - Eligibilité Art885-0 V bis du CGI",
				"0"
		);
		$this->const[4] = array (
				"DONATION_MESSAGE",
				"chaine",
				"Thank you",
				"Message affiché sur le récépissé de versements ou dons",
				"0"
		);
		$this->const[5] = array (
				"DONATION_ACCOUNTINGACCOUNT",
				"chaine",
				"7581",
				"Compte comptable de remise des versements ou dons",
				"0"
		);

		// Boxes
		$this->boxes = array();

		// Permissions
		$this->rights = array();
		$this->rights_class = 'don';

		$this->rights[1][0] = 701;
		$this->rights[1][1] = 'Lire les dons';
		$this->rights[1][2] = 'r';
		$this->rights[1][3] = 1;
		$this->rights[1][4] = 'lire';

		$this->rights[2][0] = 702;
		$this->rights[2][1] = 'Creer/modifier les dons';
		$this->rights[2][2] = 'w';
		$this->rights[2][3] = 0;
		$this->rights[2][4] = 'creer';

		$this->rights[3][0] = 703;
		$this->rights[3][1] = 'Supprimer les dons';
		$this->rights[3][2] = 'd';
		$this->rights[3][3] = 0;
		$this->rights[3][4] = 'supprimer';

	}


	/**
	 *		Function called when module is enabled.
	 *		The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *		It also creates data directories
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
	 */
	function init($options='')
	{
		global $conf;

		$sql = array(
			 "DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = '".$this->const[0][4]."' AND entity = ".$conf->entity,
			 "INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('".$this->const[0][4]."','donation',".$conf->entity.")",
		);

		return $this->_init($sql,$options);
	}

    /**
	 *		Function called when module is disabled.
	 *      Remove from database constants, boxes and permissions from Dolibarr database.
	 *		Data directories are not deleted
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
     */
    function remove($options='')
    {
		$sql = array();

		return $this->_remove($sql,$options);
    }

}