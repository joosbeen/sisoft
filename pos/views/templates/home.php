<!DOCTYPE html>
<html>
	<head>
		<title>Si Soft - POS</title>
		<link rel="shortcut icon" href="views/img/logo.png" />
		<?php include_once 'views/fragmentos/vendor.php'; ?>
		
	</head>
	<body>
		<div class="jumbotron-fluid text-center bg-primary mb-0 text-white">
			<h1>SI-SOFT POS</h1>
			<p>descripcion....</p>
			<br>
			
			<nav class="navbar navbar-expand bg-dark navbar-dark justify-content-center mt-0">
				<ul class="navbar-nav">
					<li class="nav-item text-white">
						<a class="nav-link active" href="#">Home</a>
					</li>
					<li class="nav-item text-white">
						<a class="nav-link" href="registrarse">Registrarse</a>
					</li>
					<li class="nav-item text-white">
						<a class="nav-link" href="login">Login</a>
					</li>
				</ul>
			</nav>
		</div>
		<div class="row">
			<div class="mx-auto bg-warning col-xl-6">
				<form action="/action_page.php">
					<div class="form-group">
						<label for="email">Email address:</label>
						<input type="email" class="form-control" placeholder="Enter email" id="email">
					</div>
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" class="form-control" placeholder="Enter password" id="pwd">
					</div>
					<div class="form-group form-check">
						<label class="form-check-label">
							<input class="form-check-input" type="checkbox"> Remember me
						</label>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</body>
</html>