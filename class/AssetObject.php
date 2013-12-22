<?php
//require_once (__DIR__.'/../module/assetModule.php');
require_once ('/../module/assetModule.php');
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
                if($assetInfoArray != null){
                    setID($assetInfoArray[0]['asset_id']);
                    setName($assetInfoArray[0]['name']);
                    setType($assetInfoArray[0]['type']);
                    setStatus($assetInfoArray[0]['status']);
                    setLabID($assetInfoArray[0]['lab_id']);
                    setDayB4alert($assetInfoArray[0]['days_b4_alert']);
                    return $instance;
                }
	}
	public static function withRow(array $row){
		$instance = new self();
                $this->id=$row['assetID'];
                $this->name=$row['name'];
                $this->type=$row['type'];
                $this->status=$row['status'];
                $this->labID=$row['labID'];
                $this->dayB4alert=$row['daysB4Alert'];
		return $instance;
	}
	public function addAssetToDB(){
		addAssets($this->id,$this->type,$this->status,$this->name,$this->dayB4alert,$this->labID);
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
        public function getLabID(){
            return $this->labID;
        }
        public function setLabID($aLabid){
            $this->labID=$aLabid;
        }
        public function getStatus(){
            return $this->status;
        }
        public function setStatus($aStatus){
            $this->status = $aStatus;
        }
        public function getDayB4alert(){
            return $this->dayB4alert;
        }
        public function setDayB4alert($db4){
            $this->dayB4alert = $db4;
        }
}