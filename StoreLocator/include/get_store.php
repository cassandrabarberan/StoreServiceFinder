<?php 
	
	class Get_Store	{
		private $id;
		private $name;
		private $address;
		private $contact;
		private $lat;
		private $lng;
		private $conn;
		private $tableName = "tblstore";

		function setId($id) { $this->StoreID = $id; }
		function getId() { return $this->StoreID; }
		function setName($name) { $this->StoreName = $name; }
		function getName() { return $this->StoreName; }
		function setAddress($address) { $this->StoreAddress = $address; }
		function getAddress() { return $this->StoreAddress; }
		function setType($contact) { $this->ContactNo = $contact; }
		function getType() { return $this->ContactNo; }
		function setLat($lat) { $this->lat = $lat; }
		function getLat() { return $this->lat; }
		function setLng($lng) { $this->lng = $lng; }
		function getLng() { return $this->lng; }

		function dbfields () {
			global $mydb;
			return $mydb->getfieldsononetable(self::$tblname);

		}

		public function getCollegesBlankLatLng() {
			$sql = "SELECT * FROM $this->tableName WHERE lat IS NULL AND lng IS NULL";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getAllColleges() {  
			$mydb->setQuery("SELECT * FROM ".self::$tblname);
			return $cur;
		}

		public function updateCollegesWithLatLng() {
			$sql = "UPDATE $this->tableName SET lat = :lat, lng = :lng WHERE id = :id";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':lat', $this->lat);
			$stmt->bindParam(':lng', $this->lng);
			$stmt->bindParam(':id', $this->id);

			if($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		}
	}

?>