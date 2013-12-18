<?php
require_once '../module/assetModule.php';
class AssetObject{
	private $id;
	private $name;
	private $type;
	private $status;
	private $labID;
	private $dayB4alert;
	private $arrayOfTimetable;
	public function __construct(){
		
	}
	public static function withID($id){
		$instance = new self();
		$assetInfoArray = getAssetsByID($id);
		return $instance;
	}
	public static function withRow(array $row){
		$instance = new self();
		return $instance;
	}
	public function addAsset(){
		
	}
        public function getID(){
            return $this->id;
        }
        public function setID($aID){
            $this->id=$aID;
        }
        public function getName(){
            return $this->name;
        }
        public function setName($aName){
            $this->name=$aName;
        }
        public function getType(){
            return $this->type;
        }
        public function setType($aType){
            $this->type=$aType;
        }
}