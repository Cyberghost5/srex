<?php include 'includes/head-user.php'; ?>
	<body class="main-dashboard">
		<side-bar><?php include 'includes/side-bar.php'; ?></side-bar>
		<section class="main-body">
			<header-bar><?php include 'includes/top-bar.php'; ?></header-bar>

			<div class="wallet">
			<?php
			if(isset($_SESSION['error'])){
				echo "
				<div class='alert alert-danger fade show'>
				<strong>Oops! 😕</strong> <br>".$_SESSION['error']."
				</div>
				";
				unset($_SESSION['error']);
			}
			if(isset($_SESSION['block'])){
				echo "
				<div class='alert alert-warning fade show'>
				<strong>Oh-Uh! 😒</strong> <br>".$_SESSION['block']."
				</div>
				";
				unset($_SESSION['block']);
			}
			if(isset($_SESSION['warning'])){
				echo "
				<div class='alert alert-warning fade show'>
				<strong>Hugh 😒</strong><br>".$_SESSION['warning']."
				</div>
				";
				unset($_SESSION['warning']);
			}
			if(isset($_SESSION['success'])){
				echo "
				<div class='alert alert-success fade show'>
				<strong>Hurray 🥳</strong><br>".$_SESSION['success']."
				</div>
				";
				unset($_SESSION['success']);
			}
			?>
				<div class="card">
					<div>
						<img src="<?php echo $settings['site_url']; ?>assets/images/balance.svg" />
					</div>
					<div class="sub-grid-content">
						<span>Your balance is</span>
						<h3><?php echo $settings['currency'] ?> <?php echo number_format($user['balance'], 2, '.', ',') ?></h3>
					</div>
					<div onclick="handleWalletFunding()" class="grid-right right">Fund wallet</div>
				</div>
				<header>
					<button onclick="handleActiveTransactions('all')" class="active">
						All transactions
					</button>
					<button onclick="handleActiveTransactions('credit')">
						Credit transactions
					</button>
					<button onclick="handleActiveTransactions('debit')">
						Debit transactions
					</button>
					<button></button>
				</header>
				<div class="list-header">
					<span>AMOUNT</span>
					<span>TYPE</span>
					<span>Tracking ID</span>
					<span>DATE</span>
					<span>STATUS</span>
				</div>
			</div>
		</section>
	</body>
</html>
