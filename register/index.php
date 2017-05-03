<?php

 include '../includes/Authenticate.php';
 include '../classes/User.php';
//  include '../include/Database.php';


if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit']))
	{
		$status = '';
		$name = htmlspecialchars(trim($_POST['name']));
		$department = htmlspecialchars(trim($_POST['department']));
		$emailid = htmlspecialchars(trim($_POST['emailid']));
		$password = htmlspecialchars(trim($_POST['password']));
		$secureid = htmlspecialchars(trim($_POST['secureid']));
		$contactnumber = htmlspecialchars(trim($_POST['contactnumber']));

		$fields = array($name,$department,$emailid,$password,$secureid,$contactnumber);
        // check if the secure id entered is "14300" if yes then set the user type to student else admin
		if (Authenticate::areFieldsFilled($fields))
		{

			if (User::isValidUser($secureid))
			{

				$type = User::getUserType($secureid);
				//register the user
				$isRegistrationSuccessful = User::register($name,$emailid,$department,$contactnumber,$type,$password);

				if ($isRegistrationSuccessful === DatabaseManager::PRIMARY_KEY_VIOLATED)
					$status = "Email Id already Exists!";
				elseif ($isRegistrationSuccessful === DatabaseManager::INSERT_SUCCESS)
				{
					if (Authenticate::login($emailid,$password))
							Authenticate::redirect();
				}

				else
					$status =$isRegistrationSuccessful;
			}
			else
				$status = 'Invalid secure Id';
		}
		else
		   $status = 'Please fill up the form correctly!';


	}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CodeX: Register</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/main.css">

</head>
<body class="gatekeeper">

	<div class="container-fluid">

	   <form method="post" class="form-horizontal col-xs-5 center-block register-form pull-none entry-form">
		  <h1 class="page-header"><a href="../index.php">CodeX</a></h1>
		  
		  <h3>Register with an account. <br><small>Its free!</small></h3>
            <?php if(isset($status) && isset($_POST['submit'])): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <p><?php echo $status; ?></p>
                </div>
            <?php endif; ?>
		  <div class="form-group">
		    <label for="input-name" class="col-sm-4 control-label">Full Name</label>
		    <div class="col-sm-8">
		      <input required type="text" class="form-control" name="name" id="input-name" placeholder="What is your full name?">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input-email" class="col-sm-4 control-label">Email</label>
		    <div class="col-sm-8">
		      <input required type="email" class="form-control" name="emailid" id="input-email" placeholder="Your email address?">
			  
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input-tel" class="col-sm-4 control-label">Contact Number</label>
		    <div class="col-sm-8">
		      <input required type="tel" class="form-control" name="contactnumber" id="input-tel" placeholder="Your contact number?">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input-dept" class="col-sm-4 control-label">Department</label>
		    <div class="col-sm-8">
		    	<select required name="department" id="input-dept" class="form-control">
		    			<option value="SE">Software Engineering</option>
							<option value="CSE">Computer Science</option>              
							<option value="IT">Information Technology</option>
		    	</select>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input-password" class="col-sm-4 control-label">Password</label>
		    <div class="col-sm-8">
		      <input required type="password" class="form-control" name="password" id="input-password" placeholder="Password">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input-secureid" class="col-sm-4 control-label">Secure ID</label>
		    <div class="col-sm-8">
		      <input required type="password" class="form-control" name="secureid" id="input-secureid" placeholder="Secure ID" >
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <div class="col-sm-offset-4 col-sm-8">
		      <button type="submit" name="submit" class="btn btn-success pull-right">Register</button>
		    </div>
			<a style="padding-left:20px;" href="../login/" class="link pull-left">I already have an account..</a>
			
		  </div>

		</form>
	</div>
    <br>

	<footer class="footer text-center">
      <div class="container-fluid">
         <h3>We are still in Aplha and growing fast.</h3>
         <p>As we're still in Aplha, you might run into bugs occasionally. Please report any bugs to us immediately.</p>
         <p>Got any feedback? Suggestions? Criticisms? We want to hear from you. <a href="mailto:vpenugonda@student.fairfield.edu">Send us a mail</a></p>

      </div>
      <div class="founders">
         <ul class="text-center list-unstyled list-inline">
            <li>Built by: </li>
            <li><a href="#/">Mr. Raja Sai</a></li>
            <li><a href="#/">Talloju Nikhil</a></li>
            <li><a href="http://vpenugonda.github.io/">Sid</a></li>
         </ul>
         <ul class="text-center list-unstyled list-inline">
            <li> In love with - </li>
            <li> HTML5, CSS, JavaScript, bootstrap, <strong>Functional Programming </strong></li>
         </ul>
      </div>
   </footer>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>