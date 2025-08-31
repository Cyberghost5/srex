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
		$parcel = $this->db->query("SELECT * FROM shippments where ref_id = '$ref_no' AND status != 0");
		if($parcel->num_rows <=0){
			return 2;
		}else{
			$parcel = $parcel->fetch_array();
			$data[] = array('status'=>'Item accepted by Courier','comment'=>$parcel['comment'],'date_assigned'=>date("M d, Y h:i A",strtotime($parcel['date_assigned'])));
			$history = $this->db->query("SELECT * FROM parcel_tracks where parcel_id = {$parcel['id']}");
			$status_arr = array("Item Accepted by Driver","Collected","Shipped","In-Transit","Arrived At Destination","Delivered","Return");
			while($row = $history->fetch_assoc()){
				$row['date_assigned'] = date("M d, Y h:i A",strtotime($row['date_assigned']));
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

	function shipping_prepare_old(){
		extract($_POST);
		// Access the 'backendata' value
        $backendataValue = $_POST['backendata'];

        // Decode the 'backendata' string
        $data = json_decode(stripslashes($backendataValue), true);

        // Sanitize input data
		$type = mysqli_real_escape_string($this->db, $data['type']);
		$method = mysqli_real_escape_string($this->db, $data['method']);
		$destinationOption = mysqli_real_escape_string($this->db, $data['destinationOption']);

		// Sender Details
		$senderName = mysqli_real_escape_string($this->db, $data['senderDetails']['name']);
		$senderEmail = mysqli_real_escape_string($this->db, $data['senderDetails']['email']);
		$senderPhone = mysqli_real_escape_string($this->db, $data['senderDetails']['phone']);
		$senderAddress = mysqli_real_escape_string($this->db, $data['senderDetails']['address']);
		$senderPostalCode = mysqli_real_escape_string($this->db, $data['senderDetails']['postal']);
		$senderCity = mysqli_real_escape_string($this->db, $data['senderDetails']['city']);
		$senderState = mysqli_real_escape_string($this->db, $data['senderDetails']['state']);
		$senderCountry = mysqli_real_escape_string($this->db, $data['senderDetails']['country']);
		$saveSenderDetails = mysqli_real_escape_string($this->db, $data['senderDetails']['save']);

		// Receiver Details
		$receiverName = mysqli_real_escape_string($this->db, $data['receiverDetails']['name']);
		$receiverEmail = mysqli_real_escape_string($this->db, $data['receiverDetails']['email']);
		$receiverPhone = mysqli_real_escape_string($this->db, $data['receiverDetails']['phone']);
		$receiverAddress = mysqli_real_escape_string($this->db, $data['receiverDetails']['address']);
		$receiverPostalCode = mysqli_real_escape_string($this->db, $data['receiverDetails']['postal']);
		$receiverCity = mysqli_real_escape_string($this->db, $data['receiverDetails']['city']);
		$receiverState = mysqli_real_escape_string($this->db, $data['receiverDetails']['state']);
		$receiverCountry = mysqli_real_escape_string($this->db, $data['receiverDetails']['country']);
		$saveReceiverDetails = mysqli_real_escape_string($this->db, $data['receiverDetails']['save']);

		// Item Details
		$itemCategory = mysqli_real_escape_string($this->db, $data['item']['category']);
		$itemValue = mysqli_real_escape_string($this->db, $data['item']['value']);
		$itemDesc = mysqli_real_escape_string($this->db, $data['item']['desc']);
		$itemQuantity = mysqli_real_escape_string($this->db, $data['item']['quantity']);
		$itemWeight = mysqli_real_escape_string($this->db, $data['item']['weight']);

		// Delivery and Payment Details
		$paymentMethod = mysqli_real_escape_string($this->db, $data['paymentMethod']);
		$shippingRateType = mysqli_real_escape_string($this->db, $data['shippingRate']['type']);
		$shippingRateAmount = mysqli_real_escape_string($this->db, $data['shippingRate']['amount']);
		$shippingRatePeriod = mysqli_real_escape_string($this->db, $data['shippingRate']['periodInDays']);

		$num = '123456789';
		$upp = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$set1 = substr(str_shuffle($upp), 0, 3);
		$set2 = substr(str_shuffle($upp), 0, 1);
		$set3 = substr(str_shuffle($num), 0, 3);
		$set4 = substr(str_shuffle($upp), 0, 1);

		$ref_id = 'O'.$set1.'-'.$set2.$set3.$set4.'-'.time();
		$trx_id = "TRX".time();
		$pay_type = "Shipments";
		$userid = 184; // Change later
		$amountPaid = 5000; // Change later 


		// Things to do here
		// 1. Deduct user balance and also throw error if the balance is insufficient
		// 2. Create a new shipment record
		// 3. Create a new transaction record
		// 4. Send a confirmation email to the user
		// 5. Verify that the address is not the same

		// Check if parcel already exists
		$check_query = "SELECT COUNT(*) as count FROM shippments WHERE sender_name = '$senderName' AND receiver_name = '$receiverName'";
		$check_result = $this->db->query($check_query);
		
		if ($check_result) {
			$count = $check_result->fetch_assoc()['count'];
			
			if ($count > 0) {
				// Parcel already exists, return an error response
				$response = array('status' => 'error', 'message' => 'Shippment already exist.', 'fullResponse' => $data);
			} else {
				// Parcel does not exist, proceed with the insert query
				// $insert_query = "INSERT INTO parcels (sender_name, recipient_name, status, price) VALUES ('$sender_name', '$recipient_name', '$status', '$price')";
				$insert_query = "INSERT INTO shippments (userid, trx_id, ref_id, delivery_type, delivery_method, destination_option, sender_name, sender_email, sender_phone, sender_address, sender_postal_code, sender_city, sender_state, sender_country, save_sender_details, receiver_name, receiver_email, receiver_phone, receiver_address, receiver_postal_code, receiver_city, receiver_state, receiver_country, save_receiver_details, item_category, item_value, item_description, item_quantity, item_weight, payment_method, shipping_rate_type, shipping_rate_amount, shipping_rate_period) 
				VALUES ('$userid', '$trx_id', '$ref_id', '$type', '$method', '$destinationOption', '$senderName', '$senderEmail', '$senderPhone', '$senderAddress', '$senderPostalCode', '$senderCity', '$senderState', '$senderCountry', '$saveSenderDetails', '$receiverName', '$receiverEmail', '$receiverPhone', '$receiverAddress', '$receiverPostalCode', '$receiverCity', '$receiverState', '$receiverCountry', '$saveReceiverDetails', '$itemCategory', '$itemValue', '$itemDesc', '$itemQuantity', '$itemWeight', '$paymentMethod', '$shippingRateType', '$shippingRateAmount', '$shippingRatePeriod')";

				$stmt = "INSERT INTO transaction_all (userid, trxid, amount, type, status)
				VALUES ('$userid', '$trx_id', '$amountPaid', '$pay_type', '1')";
				if ($this->db->query($insert_query)) {
					$response = array('status' => 'success', 'message' => 'Parcel inserted successfully.');
				} else {
					$response = array('status' => 'error', 'message' => 'Error inserting parcel: ' . $this->db->error);
				}
			}
		} else {
			// Handle query error
			$response = array('status' => 'error', 'message' => 'Error checking parcel existence: ' . $this->db->error);
		}
	
		return json_encode($response);
		exit;
	}

	function shipping_prepare()
{
    // Check if data is present and correctly structured
    if (!isset($_POST['backendata'])) {
        return json_encode(['status' => 'error', 'message' => 'Invalid request data.']);
    }

    // Decode the JSON data
    $data = json_decode(stripslashes($_POST['backendata']), true);

    if ($data === null) {
        return json_encode(['status' => 'error', 'message' => 'Invalid JSON format.']);
    }

    // --- 1. Sanitize and Extract Input Data Safely ---
    // It's safer to extract variables one by one rather than using extract()
    $type = $data['type'] ?? null;
    $method = $data['method'] ?? null;
    $destinationOption = $data['destinationOption'] ?? null;

    $senderDetails = $data['senderDetails'] ?? [];
    $receiverDetails = $data['receiverDetails'] ?? [];
    $item = $data['item'] ?? [];
    $shippingRate = $data['shippingRate'] ?? [];
    $paymentMethod = $data['paymentMethod'] ?? null;
    $userid = $data['username'] ?? null; // Assuming userid is passed from the front end

    // Check for essential data
    if (!$userid || empty($senderDetails) || empty($receiverDetails) || empty($item) || empty($shippingRate) || empty($paymentMethod)) {
        return json_encode(['status' => 'error', 'message' => 'Incomplete shipment data.']);
    }

    // --- 2. Verify that the address is not the same ---
    if (
        ($senderDetails['address'] === $receiverDetails['address']) &&
        ($senderDetails['city'] === $receiverDetails['city']) &&
        ($senderDetails['state'] === $receiverDetails['state']) &&
        ($senderDetails['country'] === $receiverDetails['country'])
    ) {
        return json_encode(['status' => 'error', 'message' => 'Sender and receiver addresses cannot be the same.']);
    }

    // --- 3. Generate Unique IDs ---
    $num = '123456789';
    $upp = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $set1 = substr(str_shuffle($upp), 0, 3);
    $set2 = substr(str_shuffle($upp), 0, 1);
    $set3 = substr(str_shuffle($num), 0, 3);
    $set4 = substr(str_shuffle($upp), 0, 1);

    $ref_id = 'O' . $set1 . '-' . $set2 . $set3 . $set4 . '-' . time();
    $trx_id = "TRX" . time();
    $pay_type = "Shipments";
    $amountPaid = $shippingRate['amount'];

    // --- 4. Begin Database Transaction ---
    $this->db->begin_transaction();

    try {
        // --- 5. Deduct user balance and check for insufficiency ---
        $stmt_balance_check = $this->db->prepare("SELECT balance FROM users WHERE username = ?");
        $stmt_balance_check->bind_param("s", $userid);
        $stmt_balance_check->execute();
        $result = $stmt_balance_check->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("User not found.");
        }

        $user = $result->fetch_assoc();
        $currentBalance = $user['balance'];
        $stmt_balance_check->close();

        if ($currentBalance < $amountPaid) {
            throw new Exception("Insufficient balance to complete this transaction.");
        }

        $stmt_balance_update = $this->db->prepare("UPDATE users SET balance = balance - ? WHERE username = ?");
        $stmt_balance_update->bind_param("ds", $amountPaid, $userid);
        if (!$stmt_balance_update->execute()) {
            throw new Exception("Failed to update user balance.");
        }
        $stmt_balance_update->close();

        // --- 6. Create a new shipment record (using prepared statements) ---
        $insert_shipment_query = "INSERT INTO shippments (userid, trx_id, ref_id, delivery_type, delivery_method, destination_option, sender_name, sender_email, sender_phone, sender_address, sender_postal_code, sender_city, sender_state, sender_country, save_sender_details, receiver_name, receiver_email, receiver_phone, receiver_address, receiver_postal_code, receiver_city, receiver_state, receiver_country, save_receiver_details, item_category, item_value, item_description, item_quantity, item_weight, payment_method, shipping_rate_type, shipping_rate_amount, shipping_rate_period) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt_shipment = $this->db->prepare($insert_shipment_query);
        $stmt_shipment->bind_param(
            "sssssssssssssssssssssssssssssssss",
            $userid,
            $trx_id,
            $ref_id,
            $type,
            $method,
            $destinationOption,
            $senderDetails['name'],
            $senderDetails['email'],
            $senderDetails['phone'],
            $senderDetails['address'],
            $senderDetails['postal'],
            $senderDetails['city'],
            $senderDetails['state'],
            $senderDetails['country'],
            $senderDetails['save'],
            $receiverDetails['name'],
            $receiverDetails['email'],
            $receiverDetails['phone'],
            $receiverDetails['address'],
            $receiverDetails['postal'],
            $receiverDetails['city'],
            $receiverDetails['state'],
            $receiverDetails['country'],
            $receiverDetails['save'],
            $item['category'],
            $item['value'],
            $item['desc'],
            $item['quantity'],
            $item['weight'],
            $paymentMethod,
            $shippingRate['type'],
            $amountPaid,
            $shippingRate['periodInDays']
        );
        
        if (!$stmt_shipment->execute()) {
            throw new Exception("Failed to create shipment record.");
        }
        $stmt_shipment->close();

        // --- 7. Create a new transaction record (using prepared statements) ---
        $insert_transaction_query = "INSERT INTO transaction_all (userid, trxid, amount, type, status) VALUES (?, ?, ?, ?, '1')";
        $stmt_transaction = $this->db->prepare($insert_transaction_query);
        $stmt_transaction->bind_param("ssds", $userid, $trx_id, $amountPaid, $pay_type);
        if (!$stmt_transaction->execute()) {
            throw new Exception("Failed to create transaction record.");
        }
        $stmt_transaction->close();

        // If all queries were successful, commit the transaction
        $this->db->commit();
        
        // --- 8. Send a confirmation email to the user ---
        $to = $senderDetails['email'];
        $subject = "Shipment Confirmation - Reference ID: " . $ref_id;
        $message = "
        <html>
        <head>
          <title>Shipment Confirmation</title>
        </head>
        <body>
          <h2>Dear " . $senderDetails['name'] . ",</h2>
          <p>Your shipment with Reference ID: <strong>" . $ref_id . "</strong> has been successfully booked.</p>
          <p><strong>Shipment Details:</strong></p>
          <ul>
            <li><strong>From:</strong> " . $senderDetails['address'] . ", " . $senderDetails['city'] . "</li>
            <li><strong>To:</strong> " . $receiverDetails['address'] . ", " . $receiverDetails['city'] . "</li>
            <li><strong>Item:</strong> " . $item['desc'] . " (" . $item['quantity'] . ")</li>
            <li><strong>Total Paid:</strong> NGN " . number_format($amountPaid) . "</li>
          </ul>
          <p>Thank you for using our service.</p>
        </body>
        </html>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@yourcompany.com" . "\r\n";

        // mail($to, $subject, $message, $headers); // Uncomment this line to enable email sending

        return json_encode(['status' => 'success', 'message' => 'Shipment booked successfully.', 'ref_id' => $ref_id]);
    } catch (Exception $e) {
        $this->db->rollback();
        return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
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

	function get_states(){
		$data = array();
		$get = $this->db->query("SELECT * FROM states WHERE country_code = 'NG' ORDER BY name ASC");
		while($row = $get->fetch_assoc()){
			$row['name'] = ucwords($row['name']);
			$data[] = $row;
		}
		return json_encode($data);
	}

	function get_delivery_options(){
		$data = array();
		$get = $this->db->query("SELECT * FROM shipping_plan ORDER BY name ASC");
		while($row = $get->fetch_assoc()){
			$row['type'] = ucwords($row['type']);
			$data[] = $row;
		}
		return json_encode($data);
	}

	function get_product_category(){
		$data = array();
		$get = $this->db->query("SELECT * FROM product_category ORDER BY id ASC");
		while($row = $get->fetch_assoc()){
			$row['name'] = ucwords($row['name']);
			$data[] = $row;
		}
		return json_encode($data);
	}
}