class SideBar extends HTMLElement {
	constructor() {
		super();
	}

	connectedCallback() {
		// this.innerHTML = html`
		this.innerHTML = String.raw`
			<aside class="side-bar">
				<a href="./" class="">
					<h1 class="rubikEBold">SREX</h1>
				</a>
				<nav>
					<ul>
						<li>
							<a href="./home">
								<img src="./assets/images/dashboard.svg" alt="" color="red" />
								Dashboard
							</a>
						</li>
						<li>
							<a href="./shipments">
								<img src="./assets/images/shipments.svg" alt="" />
								My shipments
							</a>
						</li>
						<li>
							<a href="./orders">
								<img src="./assets/images/orders.svg" alt="" />
								My orders
							</a>
						</li>
						<li>
							<a href="./wallet">
								<img src="./assets/images/wallet.svg" alt="" />
								Wallet
							</a>
						</li>
						<li>
							<a href="./charges">
								<img src="./assets/images/wallet.svg" alt="" />
								Pending charges
							</a>
						</li>
						<li>
							<a href="./address">
								<img src="./assets/images/address.svg" alt="" />
								My addresses
							</a>
						</li>
						<li>
							<a href="./invite">
								<img src="./assets/images/money.svg" alt="" />
								Invite & Earn
							</a>
						</li>
						<li>
							<a href="./faq">
								<img src="./assets/images/faqs.svg" alt="" />
								FAQs
							</a>
						</li>
					</ul>
				</nav>
				<div class="logout">
					<li>
						<a href="./login">
							<img src="./assets/images/logout.svg" alt="" />
							Log out
						</a>
					</li>
				</div>
			</aside>
		`;
	}
}

customElements.define('side-bar', SideBar);

// const sideLinks = document.querySelectorAll('.side-bar nav a');
// let activeLink;
// sideLinks.forEach(link => {
// 	if (link.href.split('/').slice(-1)[0].includes(location.pathname.slice(1))) {
// 		activeLink = link;
// 	}
// });
// activeLink.classList.add('active');

const firstNameLetter = 'T';

class Header extends HTMLElement {
	constructor() {
		super();
	}
	notificationLength = 5;
	// <h3>${activeLink.innerText}</h3>
	connectedCallback() {
		// this.innerHTML = html`
		this.innerHTML = String.raw`
			<header class="top-bar">
				<h3>Dashboard</h3>
				<div class="bell">
					<span>
						<img src="./assets/images/bell.svg" alt="" />
						<small>
							${this.notificationLength}
						</small>
					</span>
					<div onclick="handleProfile()">${firstNameLetter}</div>
				</div>
			</header>
		`;
	}
}

customElements.define('header-bar', Header);

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

const handleOverlay = () => {
	const overlay = document.querySelector('.overlay');
	overlay.remove();
};

const handleProfile = () => {
	const body = document.querySelector('.main-body');
	body.innerHTML += String.raw` <section class="overlay">
		<aside class="right-bar">
			<div class="icon-container">
				<h2>Profile</h2>
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

			<div class="icon-container">
				<span class="icon"> ${firstNameLetter} </span>
				<h4>FirstName LastName</h4>
			</div>
			<form action="">
				<label htmlFor="email">Email address</label>
				<input
					type="email"
					name="email"
					id="email"
					placeholder="srexuser@gmail.com"
				/>
				<label htmlFor="email">Phone number</label>
				<input
					type="tel"
					name="phone"
					id="phone"
					placeholder="+2349087392038"
				/>
				<label>Account type</label>
				<div>
					<span>
						<label htmlFor="personal">
							<input type="radio" name="accountType" id="personal" />
							Personal</label
						>
					</span>
					<span>
						<label htmlFor="business">
							<input type="radio" name="accountType" id="business" />
							Business</label
						>
					</span>
				</div>
				<label htmlFor="email">Password</label>
				<input type="password" name="password" id="password" placeholder="****************" />
				<span>Change Password</span>

				<button class="button">Save</button>
			</form>
			<div></div>
		</aside>
	</section>`;
};
