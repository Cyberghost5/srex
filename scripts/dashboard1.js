const firstNameLetter = 'T';

const handleNavigate = route => {
	switch (route) {
		case 'shipments':
			location.href = './shipments';
			break;

		default:
			break;
	}
};

const handleActiveShipment = selected => {
	const tabs = document.querySelectorAll('.shipment header button');
	tabs.forEach(
		tab => tab.classList.contains('active') && tab.classList.remove('active')
	);
	event.target.classList.add('active');
};

const handleActiveTransactions = selected => {
	const tabs = document.querySelectorAll('.wallet header button');
	tabs.forEach(
		tab => tab.classList.contains('active') && tab.classList.remove('active')
	);
	event.target.classList.add('active');
};

const preventDefault = () => {
	event.preventDefault();
	console.log(event.target);
};

const handleDateFocus = () => {
	event.target.nextElementSibling.showPicker();
};

const handleModal = () => {
	const body = document.querySelector('.main-body');
	body.innerHTML += String.raw`<section class="overlay" onclick="handleOverlay()">
		<div class="modal">
			<div class="modalHeader">
				<svg
					width="24"
					height="24"
					viewBox="0 0 24 24"
					fill="none"
					xmlns="http://www.w3.org/2000/svg"
				>
					<path
						d="M13 1L2 12L13 23"
						stroke="black"
						stroke-width="2"
						stroke-miterlimit="10"
						stroke-linecap="round"
						stroke-linejoin="round"
					/>
				</svg>
				<span class="modalTitle"></span>
				<svg
					width="24"
					height="24"
					viewBox="0 0 24 24"
					fill="none"
					xmlns="http://www.w3.org/2000/svg"
					onclick="handleOverlay()"
				>
					<g clip-path="url(#clip0_457_474)">
						<path
							d="M0 0L24 24M0 24L24 0"
							stroke="black"
							stroke-width="1.5"
							stroke-linecap="round"
							stroke-linejoin="round"
						/>
					</g>
					<defs>
						<clipPath id="clip0_457_474">
							<rect width="24" height="24" fill="white" />
						</clipPath>
					</defs>
				</svg>
			</div>
			<div class="modalBody"></div>
		</div>
	</section>`;
};

const handleShipmentBook = () => {
	handleModal();
	const modalTitle = document.querySelector('.modalTitle');
	const modalBody = document.querySelector('.modalBody');

	modalTitle.textContent = 'Book a shipment';
	modalBody.innerHTML = String.raw`
		<button>
			<h4>Book a delivery</h4>
			<p>Send out a parcel locally or internationally</p>
		</button>
		<button>
			<h4>Book an import</h4>
			<p>Receive your packages from anywhere in the world</p>
		</button>
		<button>
			<h4>Shop and ship</h4>
			<p>Shop and ship from our US and UK addresses</p>
		</button>
	`;
};

const handleWalletFunding = () => {
	const body = document.querySelector('.main-body');
	body.innerHTML += String.raw` <section class="overlay">
		<aside class="right-bar">
			<div class="icon-container">
				<h2>Wallet Funding</h2>
				<svg
					width="24"
					height="24"
					viewBox="0 0 24 24"
					fill="none"
					xmlns="http://www.w3.org/2000/svg"
					onclick="handleOverlay()"
				>
					<g clip-path="url(#clip0_457_474)">
						<path
							d="M0 0L24 24M0 24L24 0"
							stroke="black"
							stroke-width="1.5"
							stroke-linecap="round"
							stroke-linejoin="round"
						/>
					</g>
					<defs>
						<clipPath id="clip0_457_474">
							<rect width="24" height="24" fill="white" />
						</clipPath>
					</defs>
				</svg>
			</div>

			<form action="">
				<label htmlFor="amount">Amount</label>
				<input type="number" name="amount" id="amount" placeholder="Enter amount to fund wallet with" />

				<span>1.5% charge is included.</span>

				<button class="button">Fund</button>
			</form>
			<div></div>
		</aside>
	</section>`;
};

const handleOverlay = () => {
	const overlay = document.querySelector('.overlay');
	overlay.remove();
};
