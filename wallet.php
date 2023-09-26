<?php include 'includes/head-user.php'; ?>
	<body class="main-dashboard">
		<side-bar><?php include 'includes/side-bar.php'; ?></side-bar>
		<section class="main-body">
			<header-bar><?php include 'includes/top-bar.php'; ?></header-bar>

			<div class="wallet">
				<div class="card">
					<div>
						<img src="./assets/images/balance.svg" />
					</div>
					<div class="sub-grid-content">
						<span>Your balance is</span>
						<h3>₦ 10,000</h3>
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
