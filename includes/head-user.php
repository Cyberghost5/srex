<?php
include 'include/session.php';

$css_file_name1 = pathinfo($_SERVER["SCRIPT_NAME"]);
$filename = $css_file_name1['filename'];
?>
<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<title><?php echo ucfirst($filename); ?> | <?php echo $settings['site_title']; ?></title>
			<link rel="stylesheet" href="./styles/fonts.css" />
			<link rel="stylesheet" href="./styles/style.css" />
			<link rel="stylesheet" href="./styles/login.css" />
			<link rel="stylesheet" href="./styles/dashboard.css" />
			<link rel="icon" href="./assets/images/favicon.png">
			<!-- <script src="./scripts/dashboard.js" type="text/javascript" defer></script> -->
			<script src="./scripts/dashboard1.js" type="text/javascript" defer></script>
			<script type="text/javascript">
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
			</script>
		</head>
