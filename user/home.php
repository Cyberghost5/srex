<?php include 'includes/head-user.php'; ?>
	<body class="main-dashboard">
		<side-bar><?php include 'includes/side-bar.php'; ?></side-bar>
		<section class="main-body">
			<header-bar><?php include 'includes/top-bar.php'; ?></header-bar>

			<div class="dashboard">
				<div class="grid">
					<div class="sub-grid wide">
						<div>
							<img src="<?php echo $settings['site_url']; ?>assets/images/scooter.png" />
						</div>
						<div class="sub-grid-content">
							<span> You have made </span>
							<h3>4 shipments</h3>
						</div>
						<div class="grid-right right1">
							May 2023
							<i class="fas fa-chevron-down"></i>
						</div>
					</div>
					<div class="sub-grid">
						<div class="sub-grid-content">
							<h4>Book Shipments</h4>
							<p>Send or receive items</p>
						</div>
						<i class="fas fa-chevron-right grid-right"></i>
					</div>
					<div class="sub-grid">
						<div class="sub-grid-content">
							<h4>Shop & Ship</h4>
							<p>Mail packages to our hub</p>
						</div>
						<i class="fas fa-chevron-right grid-right"></i>
					</div>
					<div class="sub-grid wide">
						<div>
							<img src="<?php echo $settings['site_url']; ?>assets/images/balance.svg" />
						</div>
						<div class="sub-grid-content">
							<span>Your balance is</span>
							<h3><?php echo $settings['currency']; ?> <?php echo number_format($user['balance']) ?></h3>
						</div>
						<div onclick="handleWalletFunding()" class="grid-right right2">Fund wallet</div>
					</div>
					<div class="sub-grid">
						<div class="sub-grid-content">
							<h4>Get pricing</h4>
							<p>Request quote</p>
						</div>
						<i class="fas fa-chevron-right grid-right"></i>
					</div>
					<div class="sub-grid">
						<div class="sub-grid-content">
							<h4>Track Shipments</h4>
							<p>Track your shipments</p>
						</div>
						<i class="fas fa-chevron-right grid-right"></i>
					</div>
				</div>
				<section class="gradient">
					<p>
						Meet the SREX mobile app now available on the Appstore and Playstore
					</p>
					<div>
						<button>
							<img src="<?php echo $settings['site_url']; ?>assets/images/playstore.svg" alt="" />
							Download on Playstore
						</button>
						<button>
							<img src="<?php echo $settings['site_url']; ?>assets/images/apple.svg" alt="" />
							Download on Appstore
						</button>
					</div>
				</section>
				<section>
					<div class="header">
						<h3>Recent shipments</h3>
						<span onclick="handleNavigate('shipments')"
							>See all <i class="fas fa-chevron-right"></i
						></span>
					</div>
					<div class="recents">
						<div class="list-header">
							<span>SENDER</span>
							<span>RECEIVER</span>
							<span>Tracking ID</span>
							<span>AMOUNT</span>
							<span>EST. DELIVERY DATE</span>
						</div>
						<?php

						$conn = $pdo->open();

						try{
						$stmt = $conn->prepare("SELECT * FROM shipments WHERE userid=:userid ORDER BY id DESC LIMIT 3");
						$stmt->execute(['userid'=>$user['id']]);
						$i = 0;
						foreach($stmt as $row){
							if ($row['status'] == 0) {
							$status = '<span class="failed">Failed</span>';
							}
							if ($row['status'] == 1) {
							$status = '<span class="success">Delivered</span>';
							}
							if ($row['status'] == 2) {
							$status = '<span class="pending">In Transit</span>';
							}

							$amount = $settings['currency'].''.number_format($row['amount'], 2);


							?>
							<?php
							echo"
							<div class='list-content'>
								<span>".$row['sender_name']." <span>".$row['sender_state']." ".$row['sender_country']."</span></span>
								<span>".$row['receiver_name']." <span>".$row['receiver_state']." ".$row['receiver_country']."</span></span>
								<span>".$row['tracking_id']."</span>
								<span>".$amount."</span>
								<span>".$row['date_delivered']." ".$status." </span>
							</div>
							";
							}
						}
						catch(PDOException $e){
							echo $e->getMessage();
						}

						$pdo->close();
						?>
					</div>
				</section>
			</div>
		</section>
	</body>
</html>
