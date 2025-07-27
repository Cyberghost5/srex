<?php
namespace Srex\Api;

class User {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function userExists($email) {
        $query = "SELECT id FROM users WHERE email = ? LIMIT 1";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }

    public function createUser($username, $firstname, $lastname, $email, $password, $verificationCode) {
    	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    	$query = "INSERT INTO users (username, firstname, lastname, email, password, activate_code, type, status) VALUES (?, ?, ?, ?, ?, ?, 0, 0)";
    
    	$stmt = $this->db->prepare($query);
    	$stmt->bind_param("ssssss", $username, $firstname, $lastname, $email, $hashedPassword, $verificationCode);
    
    	if ($stmt->execute()) {
        	// After successful insertion, return the last inserted ID
        	return $this->db->insert_id;
    	} else {
        	// If insertion failed, return null or false
        	return null;
    	}
	}

    public function resendOTP($userId, $otp) {
        $query = "UPDATE users SET activate_code = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $otp, $userId);
        return $stmt->execute();
    }

 	public function getUserInfoByEmail($email) {
        $query = "SELECT `id`, `google_id`, `username`, `email`, `password`, `type`, `firstname`, `lastname`, `gender`, `balance`, `bank_name`, `account_number`, `main_account_number`, `main_bank_name`, `main_bank_code`, `name_on_account`, `user_mode`, `order_ref`, `address`, `contact_info`, `photo`, `status`, `bvn`, `dob`, `verification`, `activate_code`, `reset_code`, `referredby_userid`, `referrals`, `created_on`, `date_created` FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row; // Returns an associative array of user info
        }
        return null;
    }

    public function verifyUser($userId) {
        $query = "UPDATE users SET status = 1 WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId['id']);
        
        return $stmt->execute();
    }

    public function getUserOTP($userId) {
        $query = "SELECT activate_code FROM users WHERE id = ? LIMIT 1";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['activate_code'];
        }
        return null;
    }

    public function getUserInfoById($userId) {
        $query = "SELECT `id`, `google_id`, `username`, `email`, `password`, `type`, `firstname`, `lastname`, `gender`, `balance`, `bank_name`, `account_number`, `main_account_number`, `main_bank_name`, `main_bank_code`, `name_on_account`, `user_mode`, `order_ref`, `address`, `contact_info`, `photo`, `status`, `bvn`, `dob`, `verification`, `activate_code`, `reset_code`, `referredby_userid`, `referrals`, `created_on`, `date_created` FROM users WHERE id = ? LIMIT 1";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row; // Returns an associative array of user info
        }
        return null;
    }

    // You can add additional methods as needed for your application
}
