<?php include 'includes/head-user.php'; ?>
	<body class="main-dashboard">
		<side-bar><?php include 'includes/side-bar.php'; ?></side-bar>
		<section class="main-body">
			<header-bar><?php include 'includes/top-bar.php'; ?></header-bar>

			<div class="shipment">
				<header>
					<button onclick="handleActiveShipment('all')" class="active">
						All shipments
					</button>
					<button onclick="handleActiveShipment('pending')">
						In progress shipments
					</button>
					<button onclick="handleActiveShipment('delivered')">
						Delivered shipments
					</button>
					<button onclick="handleActiveShipment('cancelled')">
						Cancelled shipments
					</button>
					<button onclick="handleShipmentBook()">Book Shipment</button>
				</header>
				<section>
					<div class="search">
						<svg
							width="28"
							height="28"
							viewBox="0 0 28 28"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<g clip-path="url(#clip0_432_65)">
								<path
									d="M12.701 3.92745C14.3857 3.92591 16.0331 4.4241 17.4347 5.35899C18.8363 6.29387 19.9291 7.62346 20.5749 9.17954C21.2207 10.7356 21.3904 12.4483 21.0627 14.1009C20.735 15.7534 19.9244 17.2717 18.7337 18.4636C17.5429 19.6554 16.0254 20.4673 14.3731 20.7966C12.7208 21.1258 11.008 20.9576 9.45135 20.3132C7.89468 19.6689 6.5641 18.5773 5.62793 17.1765C4.69176 15.7758 4.19207 14.1289 4.19207 12.4441C4.20228 10.1899 5.10179 8.03071 6.69508 6.43595C8.28838 4.8412 10.4467 3.93973 12.701 3.92745ZM12.701 2.33301C10.7012 2.33301 8.74629 2.92601 7.08353 4.03704C5.42076 5.14806 4.1248 6.7272 3.35951 8.57476C2.59422 10.4223 2.39399 12.4553 2.78413 14.4167C3.17427 16.3781 4.13726 18.1797 5.55132 19.5938C6.96539 21.0078 8.76702 21.9708 10.7284 22.3609C12.6897 22.7511 14.7227 22.5509 16.5703 21.7856C18.4179 21.0203 19.997 19.7243 21.108 18.0616C22.2191 16.3988 22.8121 14.4439 22.8121 12.4441C22.8121 9.76249 21.7468 7.19069 19.8506 5.29448C17.9544 3.39828 15.3826 2.33301 12.701 2.33301Z"
									fill="#7F8687"
								/>
								<path
									d="M27.2224 25.8922L21.4902 20.1211L20.3857 21.2178L26.118 26.9889C26.19 27.0614 26.2756 27.119 26.3698 27.1585C26.4641 27.1979 26.5652 27.2184 26.6674 27.2187C26.7696 27.2191 26.8709 27.1993 26.9655 27.1606C27.06 27.1218 27.146 27.0648 27.2185 26.9928C27.291 26.9208 27.3487 26.8352 27.3881 26.7409C27.4275 26.6466 27.448 26.5455 27.4484 26.4433C27.4488 26.3411 27.429 26.2398 27.3902 26.1453C27.3514 26.0507 27.2944 25.9647 27.2224 25.8922Z"
									fill="#7F8687"
								/>
							</g>
							<defs>
								<clipPath id="clip0_432_65">
									<rect width="28" height="28" fill="white" />
								</clipPath>
							</defs>
						</svg>
						<input type="search" placeholder="Search by Tracking number" />
						<div>
							Shipment type:
							<select name="type" id="type">
								<option value="import">Import</option>
								<option value="export">Export</option>
							</select>
						</div>
						<div>
							Date:
							<span>
								<label for="date" onclick="handleDateFocus()"
									>18 Jul - 24 Aug</label
								>
								<input type="date" name="date" id="date" />
								<i class="fas fa-chevron-down"></i>
							</span>
						</div>
					</div>
					<div class="list-header">
						<span>SENDER</span>
						<span>RECEIVER</span>
						<span>Tracking ID</span>
						<span>AMOUNT</span>
						<span>EST. DELIVERY DATE</span>
					</div>
					<div class="list-content">
						<span>Name Surname <span>State country</span></span>
						<span>Name Surname <span>State country</span></span>
						<span>TrackingID</span>
						<span>₦Amount</span>
						<span>new Date() <span class="success">Delivered</span> </span>
					</div>
					<div class="list-content">
						<span>Name Surname <span>State country</span></span>
						<span>Name Surname <span>State country</span></span>
						<span>TrackingID</span>
						<span>₦Amount</span>
						<span>new Date() <span class="pending">In transit</span> </span>
					</div>
					<div class="list-content">
						<span>Name Surname <span>State country</span></span>
						<span>Name Surname <span>State country</span></span>
						<span>TrackingID</span>
						<span>₦Amount</span>
						<span>new Date() <span class="failed">Failed</span> </span>
					</div>
				</section>
				<div class="paginate">
					<span> Showing 1-5 of 5 results </span>
					<i class="fas fa-chevron-left"></i>
					<i class="fas fa-chevron-right"></i>
				</div>
			</div>
		</section>
	</body>
</html>
