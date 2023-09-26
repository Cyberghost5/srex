<?php include 'includes/head.php'; ?>
	<body class="login">
		<h1 class="rubikEBold">SREX</h1>
		<section>
			<h3>Create a SREX account</h3>
			<span>Already have an account? <a href="./login"> Sign in </a></span>

			<form>
				<div class="inputContainer">
					<div>
						<label for="name" class="label">Name</label>
						<input type="text" name="name"	id="name"	class="input" placeholder="srexuser"/>
					</div>
					<div>
						<label for="phone" class="label">Phone number</label>
						<input type="tel"	name="phone" class="phone" class="input" placeholder="018237392"/>
					</div>
				</div>
				<div>
					<label for="email" class="label">Email address</label>
					<input type="email" name="email" id="email" class="input"	placeholder="srexuser@gmail.com"/>
				</div>
				<div>
					<label for="password" class="label">Password</label>
					<input type="password" name="password"	id="password"	class="input"	placeholder="Minimum 8 characters"/>
				</div>
				<button type="submit" class="button">Sign Up</button>
				<span class="dont">
					By creating an account, you agree to our
					<a href="./dashboard"> Privacy Policy </a>and<a>
						Terms of Service
					</a>
				</span>
			</form>
		</section>
	</body>
</html>
