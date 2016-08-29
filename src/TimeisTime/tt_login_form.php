<?php
add_shortcode( 'tt_sc_login_form', 'tt_scf_login_form' );
add_shortcode( 'tt_sc_forgetpassword', 'tt_scf_forgetpassword' );
add_shortcode( 'tt_sc_register', 'tt_scf_register' );

function tt_scf_login_form() {
?>
<script type="text/javascript">
	function open_register_win()
	{
		window.open("register","_blank","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no")
	}
	function open_forgetpassword_win()
	{
		window.open("forgetpassword","_blank","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no")
	}
</script>
	<p id="tt_login_title">TIME Action Tracking System</p>
	<p id="tt_login_intro"><b>T</b>ime, <b>i</b>s ti<b>m</b>e its<b>e</b>lf. Each second is unique and will never come back after it passed. <br><br>By the way, this site provides a service of action tracking, which may be helpful for your time management. <br><br>@<a href="http://journal.ethanshub.com">Ethan</a>(Author) on <a href="https://github.com/wfgydbu/timeistime">GitHub</a>. Powered by Wordpress.</p>
	
<?php
	echo '<form id="tt_login" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
?>
	<fieldset id="inputs"> 
        <input id="username" name="login_txt_username" type="text" placeholder="username" autofocus required> 
        <input id="password" name="login_txt_password" type="password" placeholder="password" required> 
    </fieldset> 
    <fieldset id="actions"> 
        <input type="submit" id="submit"  name="login_bt_login" value="Login"> 
        <a onclick="open_forgetpassword_win()">Forgot password</a><a onclick="open_register_win()">Register|</a> 
    </fieldset> 

<?php
	if(isset($_POST['login_bt_login'])) {
		$name=$_POST['login_txt_username'];
		$password=$_POST['login_txt_password'];
		$name_password = $name.$password;
		
		
		global $wpdb;
		$tablename = $wpdb->prefix."tt_user";
		$sql = "select username_password_md5 from $tablename where username = '$name';";
		$username_password_md5_inDB = $wpdb->get_var($sql);
		
		if(!strcmp($username_password_md5_inDB, md5($name_password))){
			$url = '<script>window.location = "action?id='.md5($name_password).'";</script>';
			echo $url;
		}
		else{
			echo '<p id="tt_errmsg">The username and password entered do not match.</p>';
		}
		
	}
}	

function tt_scf_register() { 
	echo '<div id="tt_form" style="width: 420px;height: 505px;">';//545px
	echo '<form  action="'.esc_url( $_SERVER['REQUEST_URI'] ).'" method="post">';
?>
    <h1>Sign Up</h1>
	<P>Please fill all feilds below:</p>
	<input id="tt_input" type="text" name="tt_register_username"  pattern="^[a-zA-Z0-9]{1}[a-zA-Z0-9|_|.|-]{1,13}[a-zA-Z0-9]{1}$" required title="Your username must be 3 to 15 characters as well as contain numbers, letters, or one of '.-_', special characters cannot occur at the start or end of the username." placeholder=" " />
	<label id="tt_label" for="tt_register_username">Username</label>
	<br>
	<!--
	<div id="tt_bt_area" style="margin-top: 12px;">
			<div id="tt_button" >
				<input type="button" id="submit"  style="width:250px; margin-left: -20px;" name="tt_register_verify_username" value="Verify Username" onClick="verifyusername()"> 
			</div>
	</div>
	-->
	<input id="tt_input" type="password" name="tt_register_password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.*!@#$%^&+=])(?=\S+$).{8,20}$" required title="Your password must be at least 8 characters to 20 characters as well as contain at least one uppercase, one lowercase, one number and one general special character." placeholder=" " />
	<label id="tt_label" for="tt_register_password">Password</label>
	<br>
	
	<input id="tt_input" type="password" name="tt_register_repassword" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.*!@#$%^&+=])(?=\S+$).{8,20}$" required title="Your password must be at least 6 characters to 20 characters as well as contain at least one uppercase, one lowercase, one number and one general special character. And must be exactly same as the feild above." placeholder=" " />
	<label id="tt_label" for="tt_register_repassword">Re-password</label>
	<br>
	
	<input id="tt_input" type="text" name="tt_register_firstname" pattern="^[a-zA-Z]{1,15}$" title="Your first name must be a set of letters." required placeholder=" " />
	<label id="tt_label" for="tt_register_firstname">First Name</label>
	<br>
	
	<input id="tt_input" type="text" name="tt_register_lastname" pattern="^[a-zA-Z]{1,15}$" title="Your last name must be a set of letters" required placeholder=" " />
	<label id="tt_label" for="tt_register_lastname">Last Name</label>
	<br>
	
	<input id="tt_input" type="email" name="tt_register_email" required placeholder=" " />
	<label id="tt_label" for="tt_register_email">Email</label>
	<br>
	
	<input id="tt_input" type="text" name="tt_register_phone" pattern="\d\d\d-\d\d\d-\d\d\d\d" title="Sample: 555-555-5555." required placeholder=" " />
	<label id="tt_label" for="tt_register_phone">Phone</label>
	<br>
		<div id="tt_bt_area" style="margin-top: 12px;">
			<div id="tt_button">
				<input type="submit" id="submit"  name="tt_register_register" value="Register"> 
				<input type="reset" id="submit" value="Reset"> 
				<input type="button" id="submit"  name="tt_register_cancel" value="Cancel" onClick="window.close();"> 
			</div>
		</div>
		

	</form>
	</div>
	
	<script type="text/javascript">
		function verifyusername() {
			var username = document.getElementsByName('tt_register_username')[0].value;
			document.cookie="tt_temp_username="+username;
			
			
			var res =
				<?php
					global $wpdb;
					
			
					
					$username = $_COOKIE['tt_temp_username'];
					
					
					$tablename = $wpdb->prefix."tt_user";
					$sql = "select count(username) from $tablename where username = '$username';";
					$result = $wpdb->get_var($sql);
					//echo $result;
					
					echo '"#'.$username.'#"';
					
					
				?>;
			
			alert(res);
			
			/*
			var username_inURL = 
			<?php
				echo '"'.$_REQUEST['username'].'";';
			?>
			
			
			if((username_inURL && !username) 
					||(!username_inURL && !username)
					||(username_inURL && username && username_inURL == username)
				){
				//nothing
				
			}
			else {
				//check and jump to new link as username
				window.location.href="register?username="+username; 
				//window.history.pushState({},0,"?username="+username);		

				var res = 
				<?php
					global $wpdb;
					$username = $_REQUEST['username'];
					
					
					$tablename = $wpdb->prefix."tt_user";
					$sql = "select count(username) from $tablename where username = '$username';";
					$result = $wpdb->get_var($sql);
					
					$username = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					//echo $result;
					echo '"'.$username.'"';
				?>;
				
				alert(res);
				
				//if(res == 0) {
				//	alert("yes");
				//}
				//else{
				//	alert("no");
				//}
				
				
				
				//document.getElementsByName('tt_register_username')[0].value = username;
			}
			
			

			
			/*
			var res =
				<?php
					global $wpdb;
					$username = sanitize_text_field($_request["tt_register_username"]);
					
					
					$tablename = $wpdb->prefix."tt_user";
					$sql = "select count(username) from $tablename where username = '$username';";
					$result = $wpdb->get_var($sql);
					//echo $result;
					
					echo '"#'.$username.'#"';
				?>;
			
			
			//alert(username[0].value);
			*/
			
			
		}
	</script>	
	
<?php
	if (isset($_POST['tt_register_register']) ) {
		$username = sanitize_text_field($_POST["tt_register_username"]);
		$password = sanitize_text_field($_POST["tt_register_password"]);
		$re_password = sanitize_text_field($_POST["tt_register_repassword"]);
		$firstname = sanitize_text_field($_POST["tt_register_firstname"]);
		$lastname = sanitize_text_field($_POST["tt_register_lastname"]);
		$email = sanitize_text_field($_POST["tt_register_email"]);
		$phone = sanitize_text_field($_POST["tt_register_phone"]);
		
		global $wpdb;
		$tablename = $wpdb->prefix."tt_user";
		$sql = "select * from $tablename where username = '$username';";
		$result = $wpdb->get_results($sql);
		
		
		if($result){
			//username existed
			echo '<p id="tt_errmsg">This name has been registered by others.</p>';
		}
		else if(strcmp($password, $re_password)){
			//two passwords NOT equal
			echo '<p id="tt_errmsg">The two passwords are NOT equal.</p>';
		}
		else{
			global $wpdb;
			$tablename = $wpdb->prefix."tt_user";
			$username_password = $username.$password;
			$sql = "insert into $tablename (username, password_md5, username_password_md5,firstname, lastname, email,phone,login_count) values('$username',MD5('$password'),MD5('$username_password'),'$firstname','$lastname','$email','$phone',0);";
			
			$wpdb->query($sql);
			echo "<script>alert('Register successfully, click to return to the home page.')</script>";
			echo "<script>window.close();</script>";
		}
		
	}
	
	//if (isset($_POST['tt_register_verify_username']) ) {
	//	echo "";
	//}
	
	

}


function tt_scf_forgetpassword() { 
	echo '<div id="tt_form" style="width: 420px;height: 285px;">';
	echo '<form  action="'.esc_url( $_SERVER['REQUEST_URI'] ).'" method="post">';
?>
    <h1>Forget Password</h1>
	<P>Please enter your username(case sensitive):</p>
	<input id="tt_input" type="text" name="tt_forgetpassword_username"  pattern="^[a-zA-Z0-9]{1}[a-zA-Z0-9|_|.|-]{1,13}[a-zA-Z0-9]{1}$" required title="Your username must be 3 to 15 characters as well as contain numbers, letters, or one of '.-_', special characters cannot occur at the start or end of the username." placeholder=" " />
	<label id="tt_label" for="tt_forgetpassword_username">Username</label>
	<br>
	<br>
	<P>Please enter your email address coresponded to the username:</p>
	<input id="tt_input" type="email" name="tt_forgetpassword_email" required placeholder=" " />
	<label id="tt_label" for="tt_forgetpassword_email">Email</label>
	<br>
	
		<div id="tt_bt_area" style="margin-top: 12px;padding-left: 90px;">
			<div id="tt_button">
				<input type="submit" id="submit"  name="tt_forgetpassword_submit" value="Submit"> 
				<input type="button" id="submit"  name="tt_forgetpassword_cancel" value="Cancel" onClick="window.close();"> 
			</div>
		</div>
	</form>
	</div>
<?php
	if (isset($_POST['tt_forgetpassword_submit']) ) {
		$username = sanitize_text_field($_POST["tt_forgetpassword_username"]);
		$email = sanitize_text_field($_POST["tt_forgetpassword_email"]);
	
		
		global $wpdb;
		$tablename = $wpdb->prefix."tt_user";
		$username_password = $username.$password;
		$sql = "select email from $tablename where username = '$username';";
		
		$email_inDB = $wpdb->get_var($sql);
		
		
		if($email_inDB == NULL){
			//no results 
			echo '<p id="tt_errmsg">The username does not existed.</p>';
		}
		else if(!strcmp($email_inDB, $email)){
			//match, generate a random password
			//random password: n from $characters + 1 from $characters2 + (8-n) from $characters (9 digits)
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$characters2 = '.*!@#$%^&+=';
			$characters2Length = strlen($characters2);
			
			$n = rand(0, 9);
			
			$randomPassword = '';
			for ($i = 0; $i < $n; $i++) {
				$randomPassword .= $characters[rand(0, $charactersLength - 1)];
			}
			
			$randomPassword .= $characters2[rand(0, $characters2Length - 1)];
			
			for ($i = 0; $i < (8-$n); $i++) {
				$randomPassword .= $characters[rand(0, $charactersLength - 1)];
			}
			
			$randomPassword .= $characters[rand(0, 9)];
			
			$username_password = $username.$randomPassword;
			
			$sql = "update $tablename set password_md5=MD5('$randomPassword'), username_password_md5=MD5('$username_password') where username = '$username' and email = '$email';";
			
			$wpdb->query($sql);
			
			//mail to user
			$address = $email;
			$subject = '[DoNotReply]Reset Password';
			$message = 'Your passord has been reset to '.$randomPassword.' . Please use your new password to login.';
			$headers = 'From: support@ethanshub.com'."\r\n".'X-Mailer: PHP/'.phpversion();
			mail($address,$subject,$message,$headers);
			
			echo "<script>alert('Your password has been reset successfully, and a email has been sent to ".$email." . Please check your mailbox, click to return to the home page.')</script>";
			echo "<script>window.close();</script>";
			
			
		}
		else{
			//not match
			echo '<p id="tt_errmsg">The username and email entered do not match.</p>';
		}
		
		
		
		
		
		
	}
	
	


}

?>