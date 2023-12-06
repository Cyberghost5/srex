<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function get_parcel_heistory(){
		extract($_POST);
		$data = array();
		$parcel = $this->db->query("SELECT * FROM parcels where reference_number = '$ref_no'");
		if($parcel->num_rows <=0){
			return 2;
		}else{
			$parcel = $parcel->fetch_array();
			$data[] = array('status'=>'Item accepted by Courier','comment'=>$parcel['comment'],'date_created'=>date("M d, Y h:i A",strtotime($parcel['date_created'])));
			$history = $this->db->query("SELECT * FROM parcel_tracks where parcel_id = {$parcel['id']}");
			$status_arr = array("Item Accepted by Courier","Collected","Shipped","In-Transit","Arrived At Destination","Out for Delivery","Ready to Pickup","Delivered","Picked-up","Unsuccessfull Delivery Attempt");
			while($row = $history->fetch_assoc()){
				$row['date_created'] = date("M d, Y h:i A",strtotime($row['date_created']));
				$row['status'] = $status_arr[$row['status']];
				$data[] = $row;
			}
			return json_encode($data);
		}
	}
	
	function get_report(){
		extract($_POST);
		$data = array();
		$get = $this->db->query("SELECT * FROM parcels where date(date_created) BETWEEN '$date_from' and '$date_to' ".($status != 'all' ? " and status = $status " : "")." order by unix_timestamp(date_created) asc");
		$status_arr = array("Item Accepted by Courier","Collected","Shipped","In-Transit","Arrived At Destination","Out for Delivery","Ready to Pickup","Delivered","Picked-up","Unsuccessfull Delivery Attempt");
		while($row=$get->fetch_assoc()){
			$row['sender_name'] = ucwords($row['sender_name']);
			$row['recipient_name'] = ucwords($row['recipient_name']);
			$row['date_created'] = date("M d, Y",strtotime($row['date_created']));
			$row['status'] = $status_arr[$row['status']];
			$row['price'] = number_format($row['price'],2);
			$data[] = $row;
		}
		return json_encode($data);
	}

	function get_user_balance(){
		extract($_POST);
		// $data = array();
		$get = $this->db->query("SELECT * FROM users where username = '$username'");
		$row = $get->fetch_assoc();
		// while($row=$get->fetch_assoc()){
		// 	$row['balance'] = number_format($row['balance'],2);
		// 	$data = $row['balance'];
		// }
		return $row['balance'];
		// return $username;
	}

	function shipping_prepare(){
		// extract($_POST);
		// $data = array();
		// $get = $this->db->query("SELECT * FROM parcels where date(date_created) BETWEEN '$date_from' and '$date_to' ".($status != 'all' ? " and status = $status " : "")." order by unix_timestamp(date_created) asc");
		// // $status_arr = array("Item Accepted by Courier","Collected","Shipped","In-Transit","Arrived At Destination","Out for Delivery","Ready to Pickup","Delivered","Picked-up","Unsuccessfull Delivery Attempt");
		// while($row = $get->fetch_assoc()){
		// 	$row['sender_name'] = ucwords($row['sender_name']);
		// 	$row['recipient_name'] = ucwords($row['recipient_name']);
		// 	$row['date_created'] = date("M d, Y",strtotime($row['date_created']));
		// 	$row['status'] = $status_arr[$row['status']];
		// 	$row['price'] = number_format($row['price'],2);
		// 	$data[] = $row;
		// }
		// return json_encode($data);
		extract($_POST);

		// Assuming you have all the necessary POST variables needed for insertion
		$sender_name = mysqli_real_escape_string($this->db, "John Doe");
		$recipient_name = mysqli_real_escape_string($this->db, "Jane Doe");
		$status = mysqli_real_escape_string($this->db, "Shipped");
		$price = mysqli_real_escape_string($this->db, 50.75);
	
		$insert_query = "INSERT INTO parcels (sender_name, recipient_name, status, price) VALUES ('$sender_name', '$recipient_name', '$status', '$price')";
		
		if ($this->db->query($insert_query)) {
			$response = array('status' => 'success', 'message' => 'Parcel inserted successfully.');
		} else {
			$response = array('status' => 'error', 'message' => 'Error inserting parcel: ' . $this->db->error);
		}
	
		return json_encode($response);
	}

	function get_shipping_plans(){
		extract($_POST);
		$data = array();
		$get = $this->db->query("SELECT * FROM shipping_plan ORDER BY id ASC");
		while($row = $get->fetch_assoc()){
			$row['name'] = ucwords($row['name']);
			$row['recipient_name'] = ucwords($row['recipient_name']);
			$row['date_created'] = date("M d, Y",strtotime($row['date_created']));
			$row['price'] = number_format($row['price'],2);
			$data[] = $row;
		}
		return json_encode($data);

		// $get_shipping_plan = "SELECT * FROM shipping_plan ORDER BY id ASC";
		// $get = $this->db->query("SELECT * FROM shipping_plan ORDER BY id ASC");
		
		// if ($this->db->query($get_shipping_plan)) {
		// 	$row = $get->fetch_assoc();
		// 	$response = array('type' => $row['name'], 'amount' => $row['price'], 'periodInDays' => $row['days_delivery']);
		// } else {
		// 	$response = array('status' => 'error', 'message' => 'Error inserting parcel: ' . $this->db->error);
		// }
	
		// return json_encode($response);
	}
}