<?php include 'includes/head.php'; ?>
	<body class="login">
		<h1 class="rubikEBold">SREX</h1>
		<section>
			<h3>Welcome Back</h3>
			<p>Sign in to your account</p>

			<form action="dashboard" method="post">
				<div>
					<label for="email" class="label">Email address</label>
					<input type="email" name="email" id="email" class="input" 	placeholder="srexuser@gmail.com"/>
				</div>
				<div>
					<label for="password" class="label">Password</label>
					<input type="password" name="password" id="password"	class="input" placeholder="Enter a password"/>
				</div>
				<div class="remember">
					<span>
						<input type="checkbox" id="remember" />
						<label for="remember">Remember me</label>
					</span>
					<a href="./forget">Forgot password?</a>
				</div>

				<button type="submit" class="button">Login</button>
				<span class="dont">
					Don’t have an account?
					<a href="./register"> Sign up </a>
				</span>
			</form>
		</section>
	</body>
</html>
