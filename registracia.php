
<!DOCTYPE HTML>  
<html>
<head>
<style>
    
    *{margin: 0; padding: 0;}
        body{background: #ecf1f4; font-family: sans-serif;}
        
        .form-wrap{ width: 320px; background: #3e3d3d; padding: 40px 20px; box-sizing: border-box; position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%);}
        h1{text-align: center; color: #fff; font-weight: normal; margin-bottom: 20px;}
        
        input{width: 100%; background: none; border: 1px solid #fff; border-radius: 3px; padding: 6px 15px; box-sizing: border-box; margin-bottom: 20px; font-size: 16px; color: #fff;}
        
        input[type="button"]{ background: #bac675; border: 0; cursor: pointer; color: #3e3d3d;}
        input[type="button"]:hover{ background: #a4b15c; transition: .6s;}
        
        ::placeholder{color: #fff;}
    
    </style>

    <body>
    
        <!-- <div class="form-wrap">
        
            <form>
            
                <h1>Sign Up</h1>
                <input type="text" placeholder="Name">
                <input type="text" placeholder="Username">
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Password">
                <input type="password" placeholder="Confirm Password">
                <input type="button" value="Sign Up">
            
            </form>
        
        </div> -->
    
    
    
    </body>



</html>  
<?php
$usernameErr = $emailErr = $firstnameErr = $lastnameErr = $passwordErr = $passwordrepeatErr ="";
$username = $email = $firstname = $lastname = $password = $passwordrepeat = "";
$erru=0; $err = 0; $nice =0;
require "marie.php";
if (isset($_POST["submit"])) {
  if (empty($_POST["username"])) {
    $usernameErr = "Username is required";
  } else {
    $username = $_POST["username"];
    $lowcase = strtolower($username);
    if ($username != $lowcase){
      $usernameErr = $usernameErr . " Small letters only. ";
      $erru++;
    }
    if (strlen($username)<5 || strlen($username)>10) {
      $usernameErr = $usernameErr . " Min 5 and Max 10 Characters";
      $erru++;
    } 
    if ($erru == 0) $nice++; 
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = $_POST["email"];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
      $nice++;
    }
    else $emailErr ="$email is not valid email";
  }
    
  if (empty($_POST["firstname"])) {
    $firstnameErr = "First name is required";
  } else {
    $firstname = $_POST["firstname"];
    $nice++;
  }

  if (empty($_POST["lastname"])) {
    $lastnameErr = "Last name is required";
  } else {
    $lastname = $_POST["lastname"];
    $nice++;;
  }

  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = $_POST["password"];
    if (strlen($password)<8 || strlen($password)>16){
      $passwordErr = $passwordErr . " Min 8 and Max 16 Characters.";
      $err++;
    }
    if (!preg_match("#[a-z]+#", $password)) {
      $passwordErr = $passwordErr . " Use alphabetical and number symbols";
      $err++;
    }
      elseif( !preg_match("#[0-9]+#", $password)){
        $passwordErr = $passwordErr . " You need alphabet and number symbols";
        $err++;
      }
    if ($err == 0) $nice++;
  }

  if (empty($_POST["passwordrepeat"])) {
    $passwordrepeatErr = "Password repeat is required";
  } else {
    $passwordrepeat = $_POST["passwordrepeat"];
    if ($passwordrepeat != $password) {
      $passwordrepeatErr = "Password repeat is wrong";
    }
      else $nice++;
  }
  if ($nice==6){
      $user=R::dispense('users');
      $user->username=$_POST['username'];
      $user->firstname=$_POST['firstname'];
      $user->lastname=$_POST['lastname'];
      $user->email=$_POST['email'];
      $user->password=password_hash($_POST['password'],PASSWORD_DEFAULT);
      R::store($user);
      echo "Successfully registered";
      header('Location:authorisation.php');
  }

}
?>
<h2><br>Registration</h2>
<div class="form-wrap">
  <form method="post" action="registracia.php">  

     <input type="text" name="username" placeholder="Username">
    <span class="error"><b><?php echo $usernameErr;?></b></span>

     <input type="text" name="email" placeholder="Email">
    <span class="error"><b><?php echo $emailErr;?></b></span>

     <input type="text" name="firstname" placeholder="Firstname">
    <span class="error"><b><?php echo $firstnameErr;?></b></span>

     <input type="text" name="lastname" placeholder="lastname">
    <span class="error"><b><?php echo $lastnameErr;?></b></span>

     <input type="password" name="password" placeholder="password">
    <span class="error"><b><?php echo $passwordErr;?></b></span>

     <input type="password" name="passwordrepeat" placeholder="Confirm password">
    <span class="error"><b><?php echo $passwordrepeatErr;?></b></span>
    
    <input type="submit" name="submit" value="Registration" class="button">  
    
  </form>
</div>

</body>
</html>