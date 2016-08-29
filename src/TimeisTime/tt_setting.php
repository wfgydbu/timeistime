<?php
add_shortcode( 'tt_sc_setting', 'tt_scf_setting' );
add_shortcode( 'tt_sc_changepassword', 'tt_scf_changepassword' );

//setting page
function tt_scf_setting() {
	$id = tt_getwelcome();
	tt_getsidebar($id, 'setting');
	
	//get current user
	$ActionID = $_REQUEST['id'];
	
	global $wpdb;
	$tablename = $wpdb->prefix."tt_user";
	
	$sql = "select * from $tablename where username_password_md5 = '$id';";
	$result = $wpdb->get_row($sql);
	
	//generate form
	echo '<form enctype="multipart/form-data" action="'.esc_url($_SERVER['REQUEST_URI']).'" method="post">';
	
?>

<section class="tabs">
    <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
    <label for="tab-1" class="tab-label-1">Basic</label>
	
    <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2" />
    <label for="tab-2" class="tab-label-2">About</label>
	
	<div class="clear-shadow"></div>
        <div class="content">
			<div class="content-1" style="top: 0;	left: 0; padding: 10px 40px; z-index: 1; transition: all linear 0.1s;">
				<h3>Configure Personal Information</h3>
				
				<span id="former">Username:</span>
				<input type="text" name="tt_setting_username" value="<?php echo $result->username ?> " readonly/>
				<span id="explanation">*Username cannot be changed.</span>
				<br>
				
				<span id="former">First Name:</span>
				<input type="text" name="tt_setting_firstname" value="<?php echo $result->firstname ?>" pattern="^[a-zA-Z]{1,15}$" title="Your first name must be a set of letters."/>
				<br>
				
				<span id="former">Last Name:</span>
				<input type="text" name="tt_setting_lastname" value="<?php echo $result->lastname ?>" pattern="^[a-zA-Z]{1,15}$" title="Your last name must be a set of letters"/>
				<br>
				
				<span id="former">Email:</span>
				<input type="email" name="tt_setting_email"  value="<?php echo $result->email ?>"/>
				<br>
				
				<span id="former">Phone:</span>
				<input type="text" name="tt_setting_phone" value="<?php echo $result->phone ?>" pattern="\d\d\d-\d\d\d-\d\d\d\d" title="Sample: 555-555-5555."/>
				<span id="explanation">*Sample: 555-555-5555</span>
				<br>
				
				<input type="submit" id="submit"  name="tt_setting_changepassword" value="Change Password" >
				<span id="explanation">*Click this button to change your password.</span>
				<br>
				
				<hr>
				
				<h3>Risk Style</h3>
				<span  id="former" style="width:100%;">Set which style of Risk Level you prefer when recording your actions.</span>
				<br>
				<select name="tt_setting_risktype">
				<?php
					global $wpdb;
					$tablename = $wpdb->prefix."tt_configuration";
					
					$sql = "select a.value from $tablename as a where a.key = 'risk_type' and a.creator = '$result->username';";
					$result = $wpdb->get_var($sql);
					
					
					$one = $two = $three = '';
					
					switch($result){
						case '1':
							$one = 'selected="selected"';
							break;
						case '2':
							$two = 'selected="selected"';
							break;
						default:
							$three = 'selected="selected"';
					}
					
					echo '<option value="1" '.$one.'>Style #1 - Level 1, Level 2, Level 3, Level 4,Level 5</option>';
					echo '<option value="2" '.$two.'>Style #2 - Low, Medium-Low, Medium, Medium-High, High</option>';
					echo '<option value="3" '.$three.'>Style #3 - 1, 2, 3, 4, 5</option>';	
					
				?>
				</select>
				
				<br>
				<hr>
				
				<h3>Template</h3>
				<span  id="former" style="width:100%;">Import/Export a series of records(including action, project, meeting and entry) to/from the system by a formatted XML file. See <a target="_blank" href="https://github.com/wfgydbu/timeistime/blob/master/template/Template%20sample.xml" >Sample XML file</a>.</span>
				<br>
				<br>
				
				<span id="former" style="font-weight:bold;">Import</span>
				<br>
				
				<input class="custom-file-input" type="file" name="tt_setting_upload_file"  accept=".xml">
				<span id="explanation">*Reminder: make sure the XML file is effective.</span>
				<br>
				<input type="submit" id="submit" style="width:100px;" name="tt_setting_upload_bt" value="Upload">
				<br><br>
				<span id="former" style="font-weight:bold;">Export</span>
				<br>
				<span id="former" style="width:200px;">Step 1: Click this button</span>
				<input type="submit" id="submit" style="width:200px;margin-top:0;margin-left:0;" name="tt_setting_download_bt" value="Generate XML File">
				<span id="explanation">*The system generates the file on the server, then makes it downloadable to client.</span>
				<br>
				<span id="former" style="width:200px;">Step 2: Click this link</span>
				<div id="tt_setting_download_link"></div>
				
				<br>
				<hr>
				
				<input type="submit" id="submit"  name="tt_setting_save" value="Save Changes" style="float:right;">
				
			</div>
		    <div class="content-2" style="top: 0;	left: 0; padding: 10px 40px; z-index: 1; transition: all linear 0.1s;">
                <!--<h3>An introduction to this project.</h3>-->
				<span  id="former" style="width:100%;" >This project can be accessed on <a target="_blank" href="https://github.com/wfgydbu/timeistime">GitHub</a>.</span>
			</div>
      	</div>
</section>

</form>

<?php
	if (isset($_POST['tt_setting_save']) ) {
		global $wpdb;
		$tablename = $wpdb->prefix."tt_user";
		
		//retrieve&update personal information
		$username = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_setting_username"]));
		$firstname = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_setting_firstname"]));
		$lastname = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_setting_lastname"]));
		$email = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_setting_email"]));
		$phone = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_setting_phone"]));
		
		$sql = "update $tablename set firstname = $firstname,lastname = $lastname, email=$email, phone=$phone where username = $username;";
		$wpdb->query($sql);
		
		//retrieve&update risk type
		$tablename = $wpdb->prefix."tt_configuration";
		
		$sql = "select a.value from $tablename as a where a.key = 'risk_type' and a.creator = $username;";
		$result = $wpdb->get_var($sql);
		
		$risk_type = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_setting_risktype"]));
		
		if(empty($result)){
			//echo '1';
			$sql = "insert into $tablename values('risk_type',$risk_type, $username);";
			//echo $sql;
			$wpdb->query($sql);
		}else{
			$sql = "update $tablename as a set a.value = $risk_type where a.key = 'risk_type' and a.creator = $username;";
			$wpdb->query($sql);
		}		
	}
	
	if (isset($_POST['tt_setting_changepassword']) ) {
?>
	<script>
		window.open ("changepassword?id=<?php echo $_REQUEST['id'];?>","newwindow","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no");
	</script>
<?php
	}
	
	
	if (isset($_POST['tt_setting_upload_bt']) ) {
		//upload the file to @PLUGIN_DIRECTORY/@PLUGIN_NAME/temp
		// named @filename.xml.@creator@time
		$myFile = $_FILES['tt_setting_upload_file'];
		
		if(empty($_FILES['tt_setting_upload_file']['name'])){
			$error = 'Please choose a XML file.';
			echo "<script type='text/javascript'>alert('".$error."');</script>";
			exit(0);
		}
		
		if ($myFile["error"] > 0)
		{
			echo "<script type='text/javascript'>alert('".$$myFile["error"]."');</script>";
			exit(0);
		}
		
	
		
		
		if($myFile['type'] != "text/xml"){
			$error = 'Only XML file is allowed.';
			echo "<script type='text/javascript'>alert('".$error."');</script>";
			exit(0);
		}
		
		//resolve this file
		$resolve_result = true;
		
		$project_name = $project_creator = $project_create_time	= $project_description;
		
		$action_name = $action_creator = $action_create_time = $action_begin_time;
		$action_end_time = $action_finish_time = $action_risk = $action_progress;
		$action_location = $action_description;
		
		$meeting_creator = $meeting_time = $meeting_topic = $meeting_note;
		$calendar_creator = $calendar_time = $calendar_topic = $calendar_note;
		 
		
		$xml = simplexml_load_file($myFile["tmp_name"]);
		
		$xml = $xml->children();  //level(project,action,meeting,calendar)
		
		foreach($xml as $entrytype){
			if(!strcmp($entrytype->getName(),'project')){
				//project
				
				$project_name = $project_creator = $project_create_time	= $project_description = NULL;
				$child_actions  = array();
				
				$project_content = $entrytype->children(); //project parameter
				
				foreach($project_content as $temp){  // $temp is project value,$temp->getName() is patameter name
					
					switch($temp->getName()){
						case 'project_name':
							$project_name = prime_string_for_mysql($temp);
							break;
						case 'project_creator':
							$project_creator = prime_string_for_mysql($temp);					
							break;
						case 'project_create_time':
							$project_create_time = prime_string_for_mysql($temp);
							break;
						case 'project_description':
							$project_description = prime_string_for_mysql($temp);
							break;
						case 'children':  //have child action
							$action_num = $temp->children();
							
							foreach($action_num as $temp3){
								
								$action_name = $action_creator = $action_create_time = $action_begin_time = NULL;
								$action_end_time = $action_finish_time = $action_risk = $action_progress = NULL;
								$action_location = $action_description = NULL;
								
								$action_content = $temp3->children();
								
								foreach($action_content as $temp2){
									switch($temp2->getName()){
										case 'action_name':
											$action_name = prime_string_for_mysql($temp2);

											break;
										case 'action_creator':
											$action_creator = prime_string_for_mysql($temp2);				
											break;
										case 'action_create_time':
											$action_create_time = prime_string_for_mysql($temp2);
											break;
										case 'action_begin_time':
											$action_begin_time = prime_string_for_mysql($temp2);
											break;
										case 'action_end_time':
											$action_end_time = prime_string_for_mysql($temp2);
											break;
										case 'action_finish_time':
											$action_finish_time = prime_string_for_mysql($temp2);					
											break;
										case 'action_risk':
											$action_risk = prime_string_for_mysql($temp2);
											break;
										case 'action_progress':
											$action_progress = prime_string_for_mysql($temp2);
											break;
										case 'action_location':
											$action_location = prime_string_for_mysql($temp2);
											break;
										case 'action_description':
											$action_description = prime_string_for_mysql($temp2);
											break;
										default:
									}
								}	
								//check valiation

								//insert action
								global $wpdb;
								$tablename = $wpdb->prefix."tt_action";
								$sql = "insert into $tablename (description,creator,action_name,begin_time,end_time, real_finish_time,create_time,location,risk,progress) values($action_description,$action_creator,$action_name,$action_begin_time,$action_end_time,$action_finish_time,$action_create_time,$action_location,$action_risk,$action_progress);";
								
								
								$wpdb->query($sql);
								
								$sql = "select max(id) from $tablename where description = $action_description and creator = $action_creator and action_name = $action_name and begin_time = $action_begin_time and end_time = $action_end_time and real_finish_time = $action_finish_time and create_time = $action_create_time and location = $action_location and risk = $action_risk and progress = $action_progress;";
								
								$child_actions[] = $wpdb->get_var($sql);
								
							}	
							
							
							//insert children
							break;
						default:
					}
					
					
				}
				
				global $wpdb;
				$tablename = $wpdb->prefix."tt_project";
				$sql = "insert into $tablename (description,creator,project_name,create_time) values ($project_description,$project_creator,$project_name,$project_create_time);";
								
				$wpdb->query($sql);
				
				$sql = "select max(id) from $tablename where description = $project_description and creator = $project_creator and project_name = $project_name and create_time = $project_create_time;";
				
				$projectID = $wpdb->get_var($sql);
				
				foreach ($child_actions as $value) {
					global $wpdb;
					$tablename = $wpdb->prefix."tt_action";
					$sql = "update $tablename set parent_project_id = $projectID where $tablename.id = $value;";
					
					$wpdb->query($sql);					
				}
				
				//insert project
				
			}
			
			if(!strcmp($entrytype->getName(),'action')){
				$action_name = $action_creator = $action_create_time = $action_begin_time = NULL;
				$action_end_time = $action_finish_time = $action_risk = $action_progress = NULL;
				$action_location = $action_description = NULL;
				
				$action_content = $entrytype->children(); 
				
				foreach($action_content as $temp2){
					switch($temp2->getName()){
						case 'action_name':
							$action_name = prime_string_for_mysql($temp2);

							break;
						case 'action_creator':
							$action_creator = prime_string_for_mysql($temp2);				
							break;
						case 'action_create_time':
							$action_create_time = prime_string_for_mysql($temp2);
							break;
						case 'action_begin_time':
							$action_begin_time = prime_string_for_mysql($temp2);
							break;
						case 'action_end_time':
							$action_end_time = prime_string_for_mysql($temp2);
							break;
						case 'action_finish_time':
							$action_finish_time = prime_string_for_mysql($temp2);					
							break;
						case 'action_risk':
							$action_risk = prime_string_for_mysql($temp2);
							break;
						case 'action_progress':
							$action_progress = prime_string_for_mysql($temp2);
							break;
						case 'action_location':
							$action_location = prime_string_for_mysql($temp2);
							break;
						case 'action_description':
							$action_description = prime_string_for_mysql($temp2);
							break;
						default:
					}
				}
				
				global $wpdb;
				$tablename = $wpdb->prefix."tt_action";
				$sql = "insert into $tablename (description,creator,action_name,begin_time,end_time, real_finish_time,create_time,location,risk,progress) values($action_description,$action_creator,$action_name,$action_begin_time,$action_end_time,$action_finish_time,$action_create_time,$action_location,$action_risk,$action_progress);";
				
				
				$wpdb->query($sql);
				
			}
			
			if(!strcmp($entrytype->getName(),'meeting')){
				$meeting_topic = $meeting_creator = $meeting_time = $meeting_note = NULL;
				
				$meeting_content = $entrytype->children(); 
				
				foreach($meeting_content as $temp2){
					switch($temp2->getName()){
						case 'meeting_topic':
							$meeting_topic = prime_string_for_mysql($temp2);

							break;
						case 'meeting_creator':
							$meeting_creator = prime_string_for_mysql($temp2);				
							break;
						case 'meeting_time':
							$meeting_time = prime_string_for_mysql($temp2);
							break;
						case 'meeting_note':
							$meeting_note = prime_string_for_mysql($temp2);
							break;

						default:
					}
				}
				
				global $wpdb;
				$tablename = $wpdb->prefix."tt_meeting";
				$sql = "insert into $tablename (topic,creator,time,note) values ($meeting_topic,$meeting_creator,$meeting_time,$meeting_note);";
				
				
				$wpdb->query($sql);
			
			}
			
			if(!strcmp($entrytype->getName(),'calendar')){
				$calendar_topic = $calendar_creator = $calendar_time = $calendar_note = NULL;
				
				$calendar_content = $entrytype->children(); 
				
				foreach($calendar_content as $temp2){
					switch($temp2->getName()){
						case 'calendar_topic':
							$calendar_topic = prime_string_for_mysql($temp2);

							break;
						case 'calendar_creator':
							$calendar_creator = prime_string_for_mysql($temp2);				
							break;
						case 'calendar_time':
							$calendar_time = prime_string_for_mysql($temp2);
							break;
						case 'calendar_note':
							$calendar_note = prime_string_for_mysql($temp2);
							break;

						default:
					}
				}
				
				global $wpdb;
				$tablename = $wpdb->prefix."tt_calendar";
				$sql = "insert into $tablename (topic,creator,time,note) values ($calendar_topic,$calendar_creator,$calendar_time,$calendar_note);";
				
				
				$wpdb->query($sql);
			
			}
		}
		
		
		if($resolve_result){
			echo "<script type='text/javascript'>alert('The template has been uploaded and resolved successully.');</script>";
		}
		else{
			echo "<script type='text/javascript'>alert('Something is wrong.');</script>";
		}
		
	}
	
	if (isset($_POST['tt_setting_download_bt']) ) {
		$id =  $_REQUEST['id'];
	
		global $wpdb;
		$tablename = $wpdb->prefix."tt_user";
		
		$sql = "select username from $tablename where username_password_md5 = '$id';";
		$creator = $wpdb->get_var($sql);
		
		$filename = "export_".$creator."_".date("Ymdhis").".xml";
		$filefullname = __DIR__."/temp/".$filename;
		
		$myfile = fopen($filefullname, "w") or die("Unable to open file!");
		
		//$line = '<br />';
		
		$buffer = '<?xml version="1.0" encoding="UTF-8"?>';
		fwrite($myfile, $buffer);
		
		$buffer = '<time>';
		fwrite($myfile, $buffer);
		
		//project
		$tablename = $wpdb->prefix."tt_project";
		$sql = "select * from $tablename where creator = '$creator';";
		
		$result = $wpdb->get_results($sql);
		
		if($result){
			foreach($result as $row){
				
				$buffer = '<project>';
				fwrite($myfile, $buffer);
				
				$buffer = '<project_name>'.$row->project_name.'</project_name>';
				fwrite($myfile, $buffer);
				
				$buffer = '<project_creator>'.$row->creator.'</project_creator>';
				fwrite($myfile, $buffer);
				
				$buffer = '<project_create_time>'.$row->create_time.'</project_create_time>';
				fwrite($myfile, $buffer);
				
				$buffer = '<project_description>'.$row->description.'</project_description>';
				fwrite($myfile, $buffer);
								
				//children
				$parentID = $row->id;
				
				$tablename = $wpdb->prefix."tt_action";
				$sql = "select * from $tablename where creator = '$creator' and parent_project_id = $parentID;";
				
				$res_actions = $wpdb->get_results($sql);
				
				if($res_actions){
					
					$buffer = '<children>';
					fwrite($myfile, $buffer);
					
					foreach($res_actions as $action){
						$buffer = '<action>';
						fwrite($myfile, $buffer);
						
						$buffer = '<action_name>'.$action->action_name.'</action_name>';
						fwrite($myfile, $buffer);
						
						$buffer = '<action_creator>'.$action->creator.'</action_creator>';
						fwrite($myfile, $buffer);
						
						$buffer = '<action_create_time>'.$action->begin_time.'</action_create_time>';
						fwrite($myfile, $buffer);
						
						$buffer = '<action_begin_time>'.$action->begin_time.'</action_begin_time>';
						fwrite($myfile, $buffer);
						
						$buffer = '<action_end_time>'.$action->end_time.'</action_end_time>';
						fwrite($myfile, $buffer);
						
						$buffer = '<action_finish_time>'.$action->real_finish_time.'</action_finish_time>';
						fwrite($myfile, $buffer);
						
						$buffer = '<action_risk>'.$action->risk.'</action_risk>';
						fwrite($myfile, $buffer);
						
						$buffer = '<action_progress>'.$action->progress.'</action_progress>';
						fwrite($myfile, $buffer);
						
						$buffer = '<action_location>'.$action->location.'</action_location>';
						fwrite($myfile, $buffer);
						
						$buffer = '<action_description>'.$action->description.'</action_description>';
						fwrite($myfile, $buffer);						
						
						$buffer = '</action>';
						fwrite($myfile, $buffer);
					}
					
					$buffer = '</children>';
					fwrite($myfile, $buffer);
				}
				
				//END children
				
				$buffer = '</project>';
				fwrite($myfile, $buffer);
				
			}		
		}
		
		
		//remain actions
		$tablename = $wpdb->prefix."tt_action";
		$sql = "select * from $tablename where creator = '$creator' and parent_project_id is null;";
		
		$result = $wpdb->get_results($sql);
		
		//echo $sql;	
		if($result){
			foreach($result as $row){
				$buffer = '<action>';
				fwrite($myfile, $buffer);
				
				$buffer = '<action_name>'.$row->action_name.'</action_name>';
				fwrite($myfile, $buffer);
				
				$buffer = '<action_creator>'.$row->creator.'</action_creator>';
				fwrite($myfile, $buffer);
				
				$buffer = '<action_create_time>'.$row->begin_time.'</action_create_time>';
				fwrite($myfile, $buffer);
				
				$buffer = '<action_begin_time>'.$row->begin_time.'</action_begin_time>';
				fwrite($myfile, $buffer);
				
				$buffer = '<action_end_time>'.$row->end_time.'</action_end_time>';
				fwrite($myfile, $buffer);
				
				$buffer = '<action_finish_time>'.$row->real_finish_time.'</action_finish_time>';
				fwrite($myfile, $buffer);
				
				$buffer = '<action_risk>'.$row->risk.'</action_risk>';
				fwrite($myfile, $buffer);
				
				$buffer = '<action_progress>'.$row->progress.'</action_progress>';
				fwrite($myfile, $buffer);
				
				$buffer = '<action_location>'.$row->location.'</action_location>';
				fwrite($myfile, $buffer);
				
				$buffer = '<action_description>'.$row->description.'</action_description>';
				fwrite($myfile, $buffer);
				
				
				$buffer = '</action>';
				fwrite($myfile, $buffer);
			}
		}
		
		
		//meeting
		$tablename = $wpdb->prefix."tt_meeting";
		$sql = "select * from $tablename where creator = '$creator';";
		
		$result = $wpdb->get_results($sql);
		
		//echo $sql;	
		
		if($result){
			foreach($result as $row){
				$buffer = '<meeting>';
				fwrite($myfile, $buffer);
				
				$buffer = '<meeting_creator>'.$row->creator.'</meeting_creator>';
				fwrite($myfile, $buffer);
				
				$buffer = '<meeting_time>'.$row->time.'</meeting_time>';
				fwrite($myfile, $buffer);
				
				$buffer = '<meeting_topic>'.$row->topic.'</meeting_topic>';
				fwrite($myfile, $buffer);
				
				$buffer = '<meeting_note>'.$row->note.'</meeting_note>';
				fwrite($myfile, $buffer);
				
				$buffer = '</meeting>';
				fwrite($myfile, $buffer);
			}
		}
		
		
		//calendar
		$tablename = $wpdb->prefix."tt_calendar";
		$sql = "select * from $tablename where creator = '$creator';";
		
		$result = $wpdb->get_results($sql);
		
		//echo $sql;	
		
		if($result){
			foreach($result as $row){
				$buffer = '<calendar>';
				fwrite($myfile, $buffer);
				
				$buffer = '<calendar_creator>'.$row->creator.'</calendar_creator>';
				fwrite($myfile, $buffer);
				
				$buffer = '<calendar_time>'.$row->time.'</calendar_time>';
				fwrite($myfile, $buffer);
				
				$buffer = '<calendar_topic>'.$row->topic.'</calendar_topic>';
				fwrite($myfile, $buffer);
				
				$buffer = '<calendar_note>'.$row->note.'</calendar_note>';
				fwrite($myfile, $buffer);
				
				$buffer = '</calendar>';
				fwrite($myfile, $buffer);
			}
		}
		
		$buffer = '</time>';
		fwrite($myfile, $buffer);
		
	}
	
	fclose($myfile);
	
	$output_name =  plugins_url('/temp/'.$filename,__FILE__);
	
	
	
	$output_a =  '<a href="'.$output_name.'" download>Download</a>';
	
	//echo '<script  type="text/javascript"> window.open("'.$link.'","newwindow")</script>';
	
	printf("<script  type='text/javascript'> document.getElementById('tt_setting_download_link').innerHTML = '%s'</script>",$output_a);
	
	//printf("<script  type='text/javascript'> document.getElementById('tt_setting_download_link').style.display = 'initial';</script>;");
	
	
	//exit(0);
	//$file = $filefullname;
	
	//echo $file;
	
	//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
    //echo '<script type="text/javascript">window.location.href("'.$link.'")</script>';
}


function tt_scf_changepassword() {
	echo '<div id="tt_form" style="width: 420px;height: 330px;">';
	echo '<form  action="'.esc_url( $_SERVER['REQUEST_URI'] ).'" method="post">';
?>
	<h1>Change Password</h1>
	
	<P>Current password:</p>
	<input id="tt_input" type="password" name="tt_changepassword_oldpass" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.*!@#$%^&+=])(?=\S+$).{8,20}$" required  placeholder=" " title="Your username must be 3 to 15 characters as well as contain numbers, letters, or one of '.-_', special characters cannot occur at the start or end of the username."/>
	<label id="tt_label" for="tt_changepassword_oldpass">Old Password</label>
	
	<P>New password:</p>
	<input id="tt_input" type="password" name="tt_changepassword_newpass"  pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.*!@#$%^&+=])(?=\S+$).{8,20}$" required  placeholder=" "title="Your username must be 3 to 15 characters as well as contain numbers, letters, or one of '.-_', special characters cannot occur at the start or end of the username." />
	<label id="tt_label" for="tt_changepassword_newpass">New Password</label>
	
	<P>Retype new password:</p>
	<input id="tt_input" type="password" name="tt_changepassword_newpass2"  pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.*!@#$%^&+=])(?=\S+$).{8,20}$" required  placeholder=" " title="Your username must be 3 to 15 characters as well as contain numbers, letters, or one of '.-_', special characters cannot occur at the start or end of the username."/>
	<label id="tt_label" for="tt_changepassword_newpass2">New Password</label>
	
	<div id="tt_bt_area" style="margin-top: 12px;">
			<div id="tt_button">
				<input type="submit" id="submit"  name="tt_changepassword_submit" value="submit"> 
				<input type="reset" id="submit" value="Reset"> 
				<input type="button" id="submit"  name="tt_changepassword_cancel" value="Cancel" onClick="window.close();"> 
			</div>
		</div>
	</form>
<?php	
	if (isset($_POST['tt_changepassword_submit']) ) {
		$username_password_md5 = $_REQUEST['id'];
		
		$oldpass = sanitize_text_field($_POST["tt_changepassword_oldpass"]);
		$newpass1 = sanitize_text_field($_POST["tt_changepassword_newpass"]);
		$newpass2 = sanitize_text_field($_POST["tt_changepassword_newpass2"]);
		
		if(strcmp($newpass1, $newpass2)){
			//two passwords NOT equal
			echo '<p id="tt_errmsg">The two passwords are NOT equal.</p>';
		}else{
			global $wpdb;
			$tablename = $wpdb->prefix."tt_user";
			
			$sql = "select username,username_password_md5 from $tablename where password_md5 = MD5('$oldpass')";
			$result = $wpdb->get_row($sql);
			
			if(empty($result)){
				echo '<p id="tt_errmsg">The old password is NOT correct.</p>';
			}
			else{
				if(strcmp($result->username_password_md5,$username_password_md5)){
					echo '<p id="tt_errmsg">The old password is NOT correct.</p>';
				}
				else{
					$temp = $result->username.$newpass1;
					$sql = "update $tablename set password_md5=MD5('$newpass1'),username_password_md5=MD5('$temp') where username = '$result->username'";
					$wpdb->query($sql);
					//echo $sql;
				}
			}
			
		}
		
		
	}

}


function prime_string_for_mysql($raw){
	if(empty($raw) && 0 != (int)$raw){
		return "NULL";		
	}
	else if(!strcmp($raw,'None')){
		return "NULL";
	}
	else{
		return "'".$raw."'";
	}
}



