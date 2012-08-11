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
 */

defined('AJXP_EXEC') or die( 'Access not allowed');
/**
 * @package info.ajaxplorer.plugins
 * AJXP_Plugin to access a webdav enabled server
 */
class hpcAccessDriver extends fsAccessDriver
{
	/**
	* @var Repository
	*/
	public $repository;
	public $driverConf;
	protected $wrapperClassName;
	protected $urlBase;

    public function performChecks(){
        // Check CURL, OPENSSL & AWS LIBRARY
   	}

		
	function initRepository(){

        require_once($this->getBaseDir()."/HPCloud/Bootstrap.php");
        \HPCloud\Bootstrap::useAutoloader();
        \HPCloud\Bootstrap::useStreamWrappers();

        \HPCloud\Bootstrap::setConfiguration(array(
            'username' => $this->repository->getOption("USERNAME"),
            'password' => $this->repository->getOption("PASSWORD"),
            'tenantid' => $this->repository->getOption("TENANT_ID"),
            'endpoint' => $this->repository->getOption("ENDPOINT"),
            'transport.ssl.verify' => false
        ));

		if(is_array($this->pluginConf)){
			$this->driverConf = $this->pluginConf;
		}else{
			$this->driverConf = array();
		}

		$path = $this->repository->getOption("PATH");
		$recycle = $this->repository->getOption("RECYCLE_BIN");
        ConfService::setConf("PROBE_REAL_SIZE", false);
		$wrapperData = $this->detectStreamWrapper(true);
		$this->wrapperClassName = $wrapperData["classname"];
		$this->urlBase = $wrapperData["protocol"]."://".$this->repository->getId();
		if($recycle != ""){
			RecycleBinManager::init($this->urlBase, "/".$recycle);
		}
	}
	
	/**
	 * Parse 
	 * @param DOMNode $contribNode
	 */
	protected function parseSpecificContributions(&$contribNode){
		parent::parseSpecificContributions($contribNode);
		if($contribNode->nodeName != "actions") return ;
		$this->disableArchiveBrowsingContributions($contribNode);
	}	

    function isWriteable($dir, $type="dir"){
        return true;
    }

    function loadNodeInfo(AJXP_Node &$node, $parentNode = false, $details = false){
        parent::loadNodeInfo($node, $parentNode, $details);
        if(!$node->isLeaf()){
            $node->setLabel(rtrim($node->getLabel(), "/"));
        }
    }

    function filesystemFileSize($filePath){
        $bytesize = filesize($filePath);
        return $bytesize;
    }

    function isRemote(){
        return true;
    }

}	

?>