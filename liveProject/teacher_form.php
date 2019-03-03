<?php
$page_title = 'Teacher form';
include('includes/header.html');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
require('mysqli_connect-wtia.php');
   $trimmed = array_map('trim', $_POST);//trim the incomming data
   $errors = []; // Initialize an error array.
  	
   // Assume invalid values for teacher table:
  	$sn = $sd = $g = $sj = $msg = FALSE;
   
    // Assume invalid values for user table:
  	$e = $fn = $ln = $p = $bio = FALSE;
    
      // Check for a first name:
     if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['first-name'])) {
      $fn = mysqli_real_escape_string($dbc, $trimmed['first-name']);
     } else {
      echo '<p class="error">Please enter your first name!</p>';
       $errors[] = "You forgot to enter your first name.";
     }
        
    	// Check for a last name:
    if (preg_match('/^[A-Z \'.-]{2,40}$/i', $trimmed['last-name'])) {
     $ln = mysqli_real_escape_string($dbc, $trimmed['last-name']);
    } else {
     $errors[] = 'You forgot to enter your last name!';
     echo '<p class="error">Please enter your last name!</p>';
    }
    
   // Check for a password and match against the confirmed password:
   if (strlen($trimmed['password1']) >= 10) {
    if ($trimmed['password1'] == $trimmed['password2']) {
     $p = password_hash($trimmed['password1'], PASSWORD_DEFAULT);
    } else {
     echo '<p>Your password did not match the confirmed password!</p>';
         $errors[] = "password did not match!";
    }
   } else {
    echo '<p>Please enter a valid password!</p>';
        $errors[] = "You forgot to enter your password";
   }
   
       // Check for an email address:
    if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
     $e = mysqli_real_escape_string($dbc, $trimmed['email']);
    } else {
     echo '<p class="error">Please enter a valid email address!</p>';
       $errors[] = "You forgot to enter your email!";
    }
   
   // Check for a biography:
   if ($trimmed['biography']!=null) {
    $bio = mysqli_real_escape_string($dbc, $trimmed['biography']);
   } else {
    echo '<p class="error">Please enter your biography!</p>';
     $errors[] = "You forgot to enter your biography!";
   }
   
   // Check for a school name:
   if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['school-name'])) {
    $sn = mysqli_real_escape_string($dbc, $trimmed['school-name']);
   } else {
    echo '<p class="error">Please enter your school name!</p>';
     $errors[] = "You forgot to enter your school name.";
   }
   
   // Check for a school district:
   if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['school-district'])) {
    $sd = mysqli_real_escape_string($dbc, $trimmed['school-district']);
   } else {
    echo '<p class="error">Please enter your school district!</p>';
     $errors[] = "You forgot to enter your school district.";
   }
   
    // Check for a school subject:
   if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['school-subject'])) {
    $sj = mysqli_real_escape_string($dbc, $trimmed['school-subject']);
   } else {
    echo '<p class="error">Please enter the subject!</p>';
     $errors[] = "You forgot to enter the subject.";
   }
   
   //Validate the grade level
   $option = isset($_POST['school-grade']) ? $_POST['school-grade'] : false;
   if ($option) {
       $walue = htmlentities($_POST['school-grade'], ENT_QUOTES, "UTF-8");
       if ($walue == 9 || $walue == 10 || $walue == 11 || $walue == 12) {
           $g  = mysqli_real_escape_string($dbc, trim($walue));
       }
   } else {
        echo '<p class="error">Please enter which grade level the speaker will be speaking at!</p>';
       $errors[] = 'You did not select a grade level.';
   }
   
       //Weekly message radio button validation
    if (isset($_REQUEST['wkly-msg'])) {
        $wklyMsg = $_REQUEST['wkly-msg'];
        if ($wklyMsg == 'yes') {
            $msg = mysqli_real_escape_string($dbc, '1');
           
        } elseif ($wklyMsg == 'no') {
            $msg = mysqli_real_escape_string($dbc, '0');
        }  else {
            $wklyMsg = NULL;

            $errors[] = 'Unacceptable value';
        }
    } else {
        $wklyMsg = NULL;
        echo 'You forgot to choose wheather or not you would like to recieve weekly updates.';
        $errors[] = 'You forgot to choose "yes" or "no" to your preference of recieving weekly updates.';
    }
    

    //If everything's check out okay....
    if(	$sn && $sd && $g && $sj &&	$e && $fn && $ln && $p && $bio ){

    $q = "SELECT user_id FROM users WHERE email='$e'";
    $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
    if (mysqli_num_rows($r) == 0) {
     		
     //insert data into 
     $q = "INSERT INTO users (email, first_name, last_name, password, user_type, bio, last_logon, weekly_msg) VALUES ('$e', '$fn', '$ln', '$p', 'Teacher', '$bio', NOW(),$msg )";
     $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
     		
     //insert data into teacher database
     $q = "SELECT user_id FROM users WHERE email='$e'";
     $r = mysqli_query($dbc, $q);
     $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
     $userid = $row['user_id'];
     
     $q = "INSERT INTO teachers (user_id, school, district, grade, subject) VALUES ('$userid', '$sn', '$sd', '$g', '$msg')";
     $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
     
     
     
  
     if (mysqli_affected_rows($dbc) == 1) {//the query ran ok.
     	
    
      // Finish the page:
				echo '<h3>Thank you for registering!</h3>';
				include('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
      }
      
    }else { // The email address is not available.
			echo '<p class="error">That email address has already been registered.</p>';
		}
     
    }else { // If one of the data tests failed.
		echo '<p class="error">Please try again.</p>';
	}
    mysqli_close($dbc);
}//End main of check form submission

?>
<form action ="teacher_form.php" method ="post">
<h1>Teacher Form</h1><br>
<div class="form container">
 
  <!-- These fields are stored in the Users table -->
  <p></p><strong>First name:</strong> <input type="text" name="first-name" value="<?php if (isset($trimmed['first-name'])) echo $trimmed['first-name']; ?>"></p>
  <p><strong>Last name:</strong>  <input type="text" name="last-name" value="<?php if (isset($trimmed['last-name'])) echo $trimmed['last-name']; ?>"></p>
  <p><strong>Password:</strong>   <input type="password" name="password1" size="20" value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>"> <small>At least 10 characters long.</small></p>
	 <p><strong>Confirm Password:</strong> <input type="password" name="password2" size="20" value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>"></p>
  <p><strong>Email:</strong> <input type="email" name="email" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>"></p>
  <p><strong>Biography:</strong>
  <div><textarea rows="4" cols ="50" maxlength="400" name="biography"><?php if(isset($_POST['biography'])){echo htmlentities($_POST['biography'], ENT_QUOTES);}?></textarea></p></div>
 
 <!-- These fields are stored in the Teacher table -->
 <p><strong>School name:</strong> <input type="text" name="school-name" value="<?php if (isset($trimmed['school-name'])) echo $trimmed['school-name']; ?>">
 <p><strong>School disctrict:</strong> <input type="text" name="school-district" value="<?php if (isset($trimmed['school-district'])) echo $trimmed['school-district']; ?>">
 <p><strong>School subject:</strong> <input type="text" name="school-subject" value="<?php if (isset($trimmed['school-subject'])) echo $trimmed['school-subject']; ?>">
 <p><strong>School website:</strong> <input type="url" name="school-webpage" value="<?php if (isset($trimmed['school-url'])) echo $trimmed['school-url']; ?>"><small> optional*</small><br><br>
 <select name="school-grade" class=form-control>
  <option value="">Grade level?</option>
  <option value="9"<?php if(isset($_POST['school-grade'])&& ($_POST['school-grade']== '9')) echo ' selected="selected"'; ?>>Freshman</option>
  <option value="10"<?php if(isset($_POST['school-grade'])&& ($_POST['school-grade']== '10')) echo ' selected="selected"'; ?>>Sophomore</option>
  <option value="11"<?php if(isset($_POST['school-grade'])&& ($_POST['school-grade']== '11')) echo ' selected="selected"'; ?>>Junior</option>
  <option value="12"<?php if(isset($_POST['school-grade'])&& ($_POST['school-grade']== '12')) echo ' selected="selected"'; ?>>Senior</option>    
 </select>
    <p><strong>Recieve weekly updates for possible IT matches?</strong></p>
 <span><input type ="radio" name = "wkly-msg" value="yes" <?php if (isset($_POST['wkly-msg']) && ($_POST['wkly-msg'] == 'yes')) echo'checked="checked" '; ?>>Yes</span>
 <span><input type ="radio" name = "wkly-msg" value="no" <?php if (isset($_POST['wkly-msg']) && ($_POST['wkly-msg'] == 'no')) echo'checked="checked" '; ?>>No</span>
 

<button type="submit" class=form-control>Submit</button> 
</div>
</form>
<?php include('includes/footer.html'); ?>