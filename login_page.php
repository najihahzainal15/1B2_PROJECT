<?php
// Initialize the session
session_start();

// Include config file (make sure $link is your DB connection)
require_once "config.php";

// Define variables
$email = $password = $selected_role = "";
$email_err = $password_err = $selected_role_err = $login_err = "";

// When form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	$email = trim($_POST["email"]);
	$password = trim($_POST["password"]);
	$selected_role = trim($_POST["role"]);
	
    // Email validation
    if(empty($email)){
        $email_err = "Please enter your email.";
    }

    // Password validation
    if(empty($password)){
        $password_err = "Please enter your password.";
    }

    // Role validation
    if(empty($selected_role)){
        $selected_role_err = "Please select a role.";
    }
		
    // If no errors, proceed
    if(empty($email_err) && empty($password_err) && empty($selected_role_err)){
		// Prepare a select statement
        $sql = "SELECT email, password, role FROM user WHERE email = ?";
        $param_email = $email;
        if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);	
			// Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				// Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){   
					// Bind result variables
                    mysqli_stmt_bind_result($stmt, $db_email, $hashed_password, $db_role);
                    if(mysqli_stmt_fetch($stmt)){
                            if($password === $hashed_password){  
								if(strcasecmp($selected_role, $db_role) == 0) {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["email"] = $db_email;
                                $_SESSION["role"] = $db_role;
								header("location: welcome.php");
								exit;
                                }
							} else {
                                $login_err = "Selected role does not match your account.";
                            }
                        } else {
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else {
                    $login_err = "No account found with that email.";
                }
            } else {
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>LOGIN PAGE</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  
  <style>
		*{
			padding: 0;
			margin: 0;
			box-sizing: border-box;
		}
		
		body {
		  margin: 0;
		  font-family: 'Poppins', sans-serif;
		}

		.container {
		  display: grid;
		  width: 100vw;
		  height: 100vh;
		  grid-template-columns: repeat(2, 1fr);
		  grid-gap: 7rem;
		  padding: 0.2 rem;
		}

		.left {
		  background-color: #0074e4;
		  color: white;
		  flex: 1;
		  display: flex;
		  justify-content: center;
		  align-items: center;
		  gap: 20px;
		  flex-direction: row;
		}

		.logo {
		  height: 200px;
		}

		.login-container{
			display: flex;
			align-items: center;
			text-align: center;
			margin-left: 80px;
		}
		
		form{
			width: 360px;
		}
		
		.input-div{
			position: relative;
			display: grid;
			grid-template-columns: 7% 93%;
			margin: 25px 0;
			padding: 5px 0;
			border-bottom: 2px solid #d9d9d9;
		}
		
		.input-div:after, .input-div:before{
			content: '';
			position: absolute;
			bottom: -2px;
			width: 0;
			height: 2px;
			background-color: #38d39f;
			transition: 0.3s;
		}
		
		.input-div:after{
			right: 50%;
		}
		
		.input-div:before{
			left: 50%;
		}
		
		.input-div.focus .i i{
			color: #38d39f;
		}
		
		.input-div.focus div h5{
			display: none;
		}
		
		.input-div.focus:after, .input-div.focus:before{
			width: 50%;
		}
		
		.input-div.one{
			margin-top: 0;
		}
		
		.input-div.two{
			margin-bottom: 4px;
		}
		
		.icon{
			display:flex;
			justify-content: center;
			align-items: center;
		}
		
		.icon i{
			color: black;
			transition: 0.3s;
		}
		
		.input-div > div{
			position: relative;
			position: relative;
			display: flex;
			flex-direction: column;
			justify-content: center;
			height: 45px;
		}
		
		.input-div h5{
			position: absolute;
			left: 15px;
			top: 50%;
			transform: translateY(-50%);
			color: #999;
			font-size: 16px;
			transition: 0.3s;
		}
		
		.input{
			position: absolute;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			border: none;
			outline: none;
			background: none;
			padding: 8px 12px;
			font-size: 18px;
			font-family: 'Poppins', sans-serif;
			color: #555;
		}
		
		.forgot{
			display: block;
			text-align: right;
			text-decoration: none;
			color: #999;
			font-size: 0.9rem;
			transition: all 0.3s ease;
			margin: 10px;
		}
		
		.forgot:hover{
			color: #0074e4;
		}
		
		.login-button{
			display: block;
			width: 100%;
			height: 40px;
			border-radius: 10px;
			margin: 25px;
			margin-left: 5px;
			font-size: 14px;
			outline: none;
			border: none;
			background-color: #0074e4;
			cursor: pointer;
			color: white;
			font-family: 'Poppins', sans-serif;
			background-size: 200%;
			transition: 0.3s;
		}
		
		.login-button:hover {
		  background-color: #005bb5;
		}
		
		h2 {
		  margin-bottom: 60px;
		  font-size: 30px;
		}
		
		.select{
			font-family: 'Poppins', sans-serif;
			padding: 6px 122px;
			margin-left: 4px;
			color: black;
			background-color: white;
			border: 2px solid black;
			cursor: pointer;
			border-radius: 10px;
		}
		
		p{
			font-size: 14px;
		}
		
		.error-message {
			background-color: #f8d7da;  /* light red background */
			color: #721c24;             /* dark red text */
			padding: 6px;
			margin-bottom: 20px;
			border: 1px solid #f5c6cb;
			border-radius: 5px;
			font-size: 12px;
		  }
		  
		  .error-message1 {
			color: #ff0000;
			margin-bottom: 55px;
			font-size: 12px;
		  }
		  
		  .error-message2 {
			color: #ff0000;             
			margin: 10px 20px;
			font-size: 12px;
		  }
		
	</style>
</head>
<body>
  <div class="container">
    <div class="left">
      <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo" />
      <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo" />
    </div>
	
    <div class="login-container">

	  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	  <h2>Welcome to MyPetakom!</h2> 
	  
	  <?php if($login_err): ?>
		<div class="error-message"><?= $login_err; ?></div>
	  <?php endif; ?>

		<div class="input-div one">
			<div class="icon">
				<i class="fas fa-user-alt"></i>
			</div>
			<div>
				<h5>Email</h5>
				<input class="input" type="text" name="email">
				<?php if ($email_err): ?>
				  <div align="left" class="error-message1"><?= $email_err; ?></div>
				<?php endif; ?>
			</div>
		</div>
		
		
		<div class="input-div two">
			<div class="icon">
				<i class="fas fa-lock"></i>
			</div>
			<div>
				<h5>Password</h5>
				<input class="input" type="password" name="password">
				<?php if ($password_err): ?>
				  <div align="left" class="error-message1"><?= $password_err; ?></div>
				<?php endif; ?>
			</div>
		</div>
		

          <a href="#" class="forgot">Forgot password?</a>
		  
		 <select name = "role" class="select">
			<option value="">Select role</option>
				 <option value="Student">Student</option>
				<option value="Coordinator">Coordinator</option>
				<option value="Event Advisor">Event Advisor</option>	
		 </select>
		 <?php if ($selected_role_err): ?>
		  <div align="left" class="error-message2"><?= $selected_role_err; ?></div>
		<?php endif; ?>
				  <input type="submit" class="login-button" value="Login">
		  <p>Not registered yet? <a href="register_page.php"> Sign up.</a></p>
      </form>
	  </div>
  </div>

  <script>
	  const inputs = document.querySelectorAll('.input');

	  inputs.forEach(input => {
		input.addEventListener('focus', () => {
		  input.parentNode.parentNode.classList.add('focus');
		});

		input.addEventListener('blur', () => {
		  if (input.value.trim() === "") {
			input.parentNode.parentNode.classList.remove('focus');
		  }
		});
	  });
	</script>
</body>
</html>
