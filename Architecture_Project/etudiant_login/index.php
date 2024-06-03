<html>
	<link rel="stylesheet" href="style.css"> 
    <body>
		<form action="../etudiant/index.php" method="post">
            <div class="login">
			<div class="logo">
				<img src="../images/logo.jpg" alt="logo" class="logo"> 
				
			</div>
			<p></p>
			<div class="container">
				<label for="uname"> <b class="texte"> Identifiant : </b> </label> <br>
				<input type="text" placeholder="Enter Username" name="uname" class="input" required> <br> <br>

				<label for="psw"><b>Mot de passe : </b></label> <br>
				<input type="password" placeholder="Enter Password" name="psw" class="input" required> <br> <br>

				<button type="submit" class="button">se connecter</button> <br>
				<span class="psw"> <a href="#">mot de passe oublié ? </a></span>
			</div>
			</div>
		</form>
	</body>
</html>
