<?php include 'includes/head.php'; 

$conn = $pdo->open();
try{
	$stmt = $conn->prepare("SELECT * FROM settings WHERE id = 1");
	$stmt->execute();
	$settings = $stmt->fetch();
}
catch(PDOException $e){
	echo "There is some problem in connection: " . $e->getMessage();
}
$pdo->close();
?>
<?php
$conn = $pdo->open();
try{
	$stmt = $conn->prepare("SELECT * FROM about WHERE id = 1");
	$stmt->execute();
	$about = $stmt->fetch();
}
catch(PDOException $e){
	echo "There is some problem in connection: " . $e->getMessage();
}
$pdo->close();
$now = date('d F, Y');
?>
	<body class="login">
	<?php
	if(isset($_SESSION['user'])){
		echo "<script>window.location.assign('user/home')</script>";
	}
	elseif(isset($_SESSION['admin'])){
		echo "<script>window.location.assign('admin/home')</script>";
	}
	?>
		<h1 class="rubikEBold">SREX</h1>
		<section>
			<h3>Create a SREX account</h3>
			<span>Already have an account? <a href="./login"> Sign in </a></span>

			<form action="_register" method="post">
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
				<div class="inputContainer">
					<div>
						<label for="name" class="label">Full Name</label>
						<input type="text" name="fullname"	id="name"	class="input" placeholder="srexuser" required />
					</div>
					<div>
						<label for="phone" class="label">Phone number</label>
						<input type="tel" name="phone" class="phone" class="input" placeholder="018237392" required />
					</div>
				</div>
				<div>
					<label for="email" class="label">Email address</label>
					<input type="email" name="email" id="email" class="input"	placeholder="srexuser@gmail.com" required />
				</div>
				<div>
					<label for="password" class="label">Password</label>
					<input type="password" name="password"	id="password"	class="input"	placeholder="Minimum 8 characters" required />
				</div>
				<button type="submit" name="index" class="button">Sign Up</button>
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
