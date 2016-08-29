<?php
add_shortcode( 'tt_sc_setting', 'tt_scf_setting' );
add_shortcode( 'tt_sc_action', 'tt_scf_action' );
add_shortcode( 'tt_sc_project', 'tt_scf_project' );
add_shortcode( 'tt_sc_meeting', 'tt_scf_meeting' );
add_shortcode( 'tt_sc_calendar', 'tt_scf_calendar' );
add_shortcode( 'tt_sc_register_details', 'tt_scf_register_details' );
add_shortcode( 'tt_sc_project_details', 'tt_scf_project_details' );
add_shortcode( 'tt_sc_meeting_details', 'tt_scf_meeting_details' );
add_shortcode( 'tt_sc_calendar_details', 'tt_scf_calendar_details' );



//action page
function tt_scf_action() {
	$id = tt_getwelcome();
	tt_getsidebar($id, 'action');
	
?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

	function drawTable() {
		var data = new google.visualization.DataTable();
		<?php
			global $wpdb;
			$tablename = $wpdb->prefix."tt_action";
			
			$username = tt_getcurrentuser();
			$sql = "select * from $tablename where creator = '$username';";
			
			//print columns
			echo "data.addColumn('string', 'ID');";
			echo "data.addColumn('string', 'Name');";
			echo "data.addColumn('string', 'Begin Time');";
			echo "data.addColumn('string', 'End Time');";
			echo "data.addColumn('string', 'Risk');";
			echo "data.addColumn('string', 'Progress');";
			echo "data.addColumn('string', 'Description');";
			//print rows
			$result = $wpdb->get_results($sql);
			
			printf("data.addRows([");
			
			foreach($result as $row){
				global $wpdb;
				$tablename = $wpdb->prefix."tt_configuration";
				
				$sql = "select a.value from $tablename as a where a.key = 'risk_type' and a.creator = '$username';";
				$result = $wpdb->get_var($sql);
				
				$risk_output;
				
				if(1 == (int)$result){
					switch($row->risk){
						case '1':
							$risk_output = 'Level 1';
							break;
						case '2':
							$risk_output = 'Level 2';
							break;
						case '3':
							$risk_output = 'Level 3';
							break;
						case '4':
							$risk_output = 'Level 4';
							break;
						case '5':
							$risk_output = 'Level 5';
							break;
						default:
					}
				}
				else if (2 == (int)$result){
					switch($row->risk){
						case '1':
							$risk_output = 'Low';
							break;
						case '2':
							$risk_output = 'Medium-Low';
							break;
						case '3':
							$risk_output = 'Medium';
							break;
						case '4':
							$risk_output = 'Medium-High';
							break;
						case '5':
							$risk_output = 'High';
							break;
						default:
					}
				}
				else{
					switch($row->risk){
						case '1':
							$risk_output = '1';
							break;
						case '2':
							$risk_output = '2';
							break;
						case '3':
							$risk_output = '3';
							break;
						case '4':
							$risk_output = '4';
							break;
						case '5':
							$risk_output = '5';
							break;
						default:
					}
				}
				
						
				
				printf("['%s','%s','%s','%s','%s','%s','%s'],",$row->id,$row->action_name, $row->begin_time,$row->end_time,$risk_output,$row->progress, $row->description);
				//printf("['%s','%s','%s','%s','%s','%s'],",$row->action_name, $row->begin_time,$row->end_time,$row->risk,$row->progress, $row->description);
			}
			
			printf("]);");
			
		?>
		//data.setColumnProperty(0, 'style', 'width:5px;');
		var table = new google.visualization.Table(document.getElementById('table_div'));
		//var options = "{showRowNumber: false, width: '100%', height: '100%', page:'enable',pageSize: 6,pagingButtons:'both'}";
		
		
		table.draw(data, {showRowNumber: false, width: '100%', height: '100%', page:'enable',pageSize: 6,pagingButtons:'auto'});
		
		google.visualization.events.addListener(table, 'select',  function() {
			
			var item = table.getSelection()[0].row;
			var actionID = data.getValue(item, 0);
			
			//alert(data.getValue(item, 0));
   
			window.open ("register_details?actionID="+actionID,"subwindow","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no");
		});
	}	 
    </script>
	<div id = "tt_content">
		<div id="table_div">please wait...it's coming</div>
		<div id="tt_p">*click one action for more operations and details.</div>
		<?php
			echo '<form enctype="multipart/form-data" action="'.esc_url($_SERVER['REQUEST_URI']).'" method="post">';
		?>
		<div id="tt_button" style="float:right;">
			<input type="submit" id="submit"  name="tt_action_add" value="Add New"> 
			<input type="submit" id="submit" value="Refresh" onClick="window.location.reload()">
		</div>
	</div>	
	</form>
<?php	
	if (isset($_POST['tt_action_add']) ) {
	?>
	<script>
		window.open ("register_details?id=<?php echo tt_getuserid();?>","newwindow","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no");
	</script>
	<?php
	}
}

//register details
function tt_scf_register_details(){
	$ActionID = $_REQUEST['actionID'];
	
	//variables
	$action_name = $creator = $create_time = $begin_time = $end_time = $finish_time = $risk = $progress = $location = $belongs = $depends = $description = NULL;
	
	
	
	if(!empty($ActionID)){
		global $wpdb;
		$tablename = $wpdb->prefix."tt_action";
		$sql = "select * from $tablename where id = $ActionID;";
		$result = $wpdb->get_row($sql);
		
		$action_name = $result->action_name;	
		$creator = $result->creator;	
		$create_time = tt_convert_mysql_to_datetime($result->create_time);	
		$begin_time = tt_convert_mysql_to_datetime($result->begin_time);	
		$end_time = tt_convert_mysql_to_datetime($result->end_time);	
		$finish_time = tt_convert_mysql_to_datetime($result->real_finish_time);	
		$risk = $result->risk;	
		$progress = $result->progress;
		$location = $result->location; 	
		$belongs = $result->parent_project_id;	
		$depends = $result->prerequisite_task_id; 	
		$description = $result->description;
	}
	
	echo '<div id="tt_form" style="width: 420px;height: 900px;">';
	echo '<form  action="'.esc_url( $_SERVER['REQUEST_URI'] ).'" method="post">';

	if(!empty($ActionID)){
		echo '<h1>Action #'.$ActionID.':</h1>';
	}
	else{
		echo '<h1>New Action:</h1>';
		$creator = tt_getcurrentuser();
	}
?>
	
	<input id="tt_input" type="text" name="tt_action_detail_actionname" style="background:none;" value="<?php echo $action_name; ?>" required placeholder=" "/>
	<label id="tt_label" for="tt_action_detail_actionname" >Name</label>
	<br>
	<input id="tt_input" type="text" name="tt_action_detail_creator" style="background:none;" value="<?php echo $creator; ?>" readonly />
	<label id="tt_label" for="tt_action_detail_creator" >Creator</label>
	<br>
	<input id="tt_input" type="datetime-local" name="tt_action_detail_create" style="background:none;" value="<?php echo $create_time; ?>" required placeholder=" "/>
	<label id="tt_label_date" for="tt_action_detail_create" >Create Time</label>
	<br>	
	<input id="tt_input" type="datetime-local" name="tt_action_detail_begin" style="background:none;" value="<?php echo $begin_time; ?>" required placeholder=" "/>
	<label id="tt_label_date" for="tt_action_detail_end" >Begin Time</label>
	<br>
	<input id="tt_input" type="datetime-local" name="tt_action_detail_end" style="background:none;" value="<?php echo $end_time; ?>" required placeholder=" "/>
	<label id="tt_label_date" for="tt_action_detail_begin" >End Time</label>
	<br>
	<input id="tt_input" type="datetime-local" name="tt_action_detail_finish" style="background:none;" value="<?php echo $finish_time; ?>" placeholder=" "/>
	<label id="tt_label_date" for="tt_action_detail_finish" >Finish Time</label>
	<br>
	<select id="tt_select" name="tt_action_detail_risk" required placeholder=" ">
	<?php 
		global $wpdb;
		$tablename = $wpdb->prefix."tt_configuration";
		
		$sql = "select a.value from $tablename as a where a.key = 'risk_type' and a.creator = '$creator';";
		$result = $wpdb->get_var($sql);
		
		
		$one = $two = $three = $four = $five = '';
		
		switch($risk){
			case '1':
				$one = 'selected="selected"';
				break;
			case '2':
				$two = 'selected="selected"';
				break;
			case '3':
				$three = 'selected="selected"';
				break;
			case '4':
				$four = 'selected="selected"';
				break;
			case '5':
				$five = 'selected="selected"';
				break;
			default:
				$one = 'selected="selected"';
		}
		
		
		switch ($result){
			case '1':
				echo '<option value="1" '.$one.'>Level 1</option>';
				echo '<option value="2" '.$two.'>Level 2</option>';
				echo '<option value="3" '.$three.'>Level 3</option>';
				echo '<option value="4" '.$four.'>Level 4</option>';
				echo '<option value="5" '.$five.'>Level 5</option>';
				break;  
			case '2':
				echo '<option value="1" '.$one.'>Low</option>';
				echo '<option value="2" '.$two.'>Medium-Low</option>';
				echo '<option value="3" '.$three.'>Medium</option>';
				echo '<option value="4" '.$four.'>Medium-High</option>';
				echo '<option value="5" '.$five.'>High</option>';			  
				break;
			default:
				echo '<option value="1" '.$one.'>1</option>';
				echo '<option value="2" '.$two.'>2</option>';
				echo '<option value="3" '.$three.'>3</option>';
				echo '<option value="4" '.$four.'>4</option>';
				echo '<option value="5" '.$five.'>5</option>';	
		}		
	?>	
				
	</select>
	<label id="tt_label_date" for="tt_action_detail_risk" >Risk</label>
	<br>	
	<input id="tt_input" class="special_progress" type="text" name="tt_action_detail_progress" style="background:none;" pattern="\d{1,2}(?!\d)|100" title="Rang from 0 to 100." value="<?php echo $progress; ?>" required placeholder=" "/>
	<label id="tt_label" for="tt_action_detail_progress" >Progress</label>
	<br>
	<input id="tt_input" type="text" name="tt_action_detail_location" style="background:none;" value="<?php echo $location; ?>" required placeholder=" "/>
	<label id="tt_label" for="tt_action_detail_location" >Location</label>
	<br>
	<select id="tt_select" name="tt_action_detail_belong" required placeholder=" ">
	<?php 
		global $wpdb;
		$tablename_project = $wpdb->prefix."tt_project";
		
		
		$sql = "select id,project_name from $tablename_project where creator = '$creator' ;";
		
		$result = $wpdb->get_results($sql);
		$belong_bool = 0;
		
		foreach($result as $row){
			$output = 'Project #'.$row->id.' - '.$row->project_name;
			
			if(!strcmp($belongs,$row->id)){
				printf('<option value="%s" selected="selected">%s</option>',$output,$output);
				$belong_bool = 1;
			}else{
				printf('<option value="%s">%s</option>',$output,$output);
			}			
		}
		
		if($belong_bool == 1){
			printf('<option value="None">None</option>');
		}else{
			printf('<option value="None" selected="selected">None</option>');
		}
	?>
	</select>
	<label id="tt_label_date" for="tt_action_detail_belong" >Belongs</label>
	<br>
	
	<select id="tt_select" name="tt_action_detail_depend" required placeholder=" ">
	<?php 
		global $wpdb;
		$tablename_action = $wpdb->prefix."tt_action";
		//$tablename_project = $wpdb->prefix."tt_project";
		$sql = "select parent_project_id from $tablename_action where id = $ActionID;";
		$result = $wpdb->get_var($sql);
		$belong_bool = 0;
		
		if($result != NULL){
			$sql = "select id,action_name from $tablename_action where parent_project_id = $result and id != $ActionID;";
			$result = $wpdb->get_results($sql);
			
			foreach($result as $row){
				$output = 'Action #'.$row->id.' - '.$row->action_name;
				
				if(!strcmp($depends,$row->id)){
					printf('<option value="%s" selected="selected">%s</option>',$output,$output);
					$belong_bool = 1;
				}else{
					printf('<option value="%s">%s</option>',$output,$output);
				}
				
				
			}			
			
		}
		
		if($belong_bool == 1){
			printf('<option value="None">None</option>');
		}else{
			printf('<option value="None" selected="selected">None</option>');
		}
		
	?>
	</select>
	<label id="tt_label_date" for="tt_action_detail_depend" >Depends</label>
	<br>


	<textarea id="tt_textarea" name="tt_action_detail_description" placeholder=" "><?php echo $description; ?></textarea>
	<label id="tt_label" for="tt_action_detail_description">Description</label>
	<br>
		<div id="tt_bt_area" <?php if(empty($_REQUEST['actionID'])){echo 'style="padding-left: 90px;"';}?>>
			<div id="tt_button"  >
				
				<?php
					if(!empty($_REQUEST['actionID'])){
						echo '<input type="submit" id="submit"  name="tt_action_detail_update" value="Update">';
						echo '<input type="submit" id="submit" name="tt_action_detail_delete" value="Delete">';
					}
					else{
						echo '<input type="submit" id="submit"  name="tt_action_detail_update" value="Submit">';
					}
				?>
				<input type="button" id="submit"  name="tt_action_detail_cancel" value="Cancel" onClick="window.close();"> 
			</div>
		</div>
	</div>
	</form>
<?php
	if (isset($_POST['tt_action_detail_update']) ) {
		$action_name = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_action_detail_actionname"]));
		$creator = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_action_detail_creator"]));
		$create_time = tt_convert_string_for_mysql(tt_convert_datetime_to_mysql(sanitize_text_field($_POST["tt_action_detail_create"])));
		$begin_time = tt_convert_string_for_mysql(tt_convert_datetime_to_mysql(sanitize_text_field($_POST["tt_action_detail_begin"])));
		$end_time = tt_convert_string_for_mysql(tt_convert_datetime_to_mysql(sanitize_text_field($_POST["tt_action_detail_end"])));
		$finish_time = tt_convert_string_for_mysql(tt_convert_datetime_to_mysql(sanitize_text_field($_POST["tt_action_detail_finish"])));
		$risk = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_action_detail_risk"]));
		$progress = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_action_detail_progress"]));
		$location = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_action_detail_location"]));
		$belongs = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_action_detail_belong"]));
		$depends = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_action_detail_depend"]));
		$description = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_action_detail_description"]));
		
		//hadnle $belongs and $depends
		$pos = strpos($belongs,"#");
		$belongs = substr($belongs,$pos+1);
		$pos = strpos($belongs," ");
		$belongs = tt_convert_string_for_mysql(substr($belongs,0,$pos));
		
		$pos = strpos($depends,"#");
		$depends = substr($depends,$pos+1);
		$pos = strpos($depends," ");
		$depends = tt_convert_string_for_mysql(substr($depends,0,$pos));
		
		global $wpdb;
		$tablename = $wpdb->prefix."tt_action";
		
		echo "<script>alert('".$progress."')</script>";
		if(empty($ActionID)){
			$sql = "insert into $tablename (description,creator,action_name,begin_time,end_time, real_finish_time,create_time,location,risk,progress,prerequisite_task_id,parent_project_id) values ($description,$creator,$action_name,$begin_time,$end_time,$finish_time,$create_time,$location,$risk,$progress,$depends,$belongs);";
			$wpdb->query($sql);
			//echo "<script>window.close();</script>";
			//echo $sql;
		}
		else{
			$sql = "delete from $tablename where id = $ActionID;";
			$wpdb->query($sql);
			
			$sql = "insert into $tablename (id,description,creator,action_name,begin_time,end_time, real_finish_time,create_time,location,risk,progress,prerequisite_task_id,parent_project_id) values ($ActionID,$description,$creator,$action_name,$begin_time,$end_time,$finish_time,$create_time,$location,$risk,$progress,$depends,$belongs);";
			$wpdb->query($sql);
			echo $sql;
		}
		
		echo  "<script type='text/javascript'>";
		echo "window.close();";
		echo "</script>";
	}

	if (isset($_POST['tt_action_detail_delete']) ) {
		$ActionID = $_REQUEST['actionID'];
		
		if(!empty($ActionID)){
			global $wpdb;
			$tablename = $wpdb->prefix."tt_action";
			$sql = "delete from $tablename where id = $ActionID;";
			$result = $wpdb->query($sql);
		}
		
		echo "<script>window.close();</script>";
	}

}

//project details
function tt_scf_project_details() {
	$ActionID = $_REQUEST['actionID'];
	
	//variables
	$project_name = $creator = $create_time = $begin_time = $end_time = $finish_time = $belongs = $description = NULL;
	
	if(!empty($ActionID)){
		global $wpdb;
		$tablename = $wpdb->prefix."tt_project";
		
		//retrieve part of info from DB
		$sql = "select * from $tablename where id = $ActionID;";
		$result = $wpdb->get_row($sql);
		$project_name = $result->project_name;	
		$creator = $result->creator;
		$create_time = tt_convert_mysql_to_datetime($result->create_time);
		$belongs = $result->parent_project_id;	
		$description = $result->description;
		
		//Calculate other part of info
		//first, assume only actione belongs to projects. Projects do NOT belongs to Projects.
		
		$action_tablename = $wpdb->prefix."tt_action";
		
		$sql = "select  min(begin_time) as a from  $action_tablename c where c.parent_project_id = $ActionID;";
		$result = $wpdb->get_row($sql);
		$begin_time =  tt_convert_mysql_to_datetime($result->a);
		
		$sql = "select  max(end_time) as a from  $action_tablename c where c.parent_project_id = $ActionID;";
		$result = $wpdb->get_row($sql);
		$end_time =  tt_convert_mysql_to_datetime($result->a);
		
		$sql = "select  max(real_finish_time) as a from  $action_tablename c where c.parent_project_id = $ActionID;";
		$result = $wpdb->get_row($sql);
		$finish_time =  tt_convert_mysql_to_datetime($result->a);
	}
	
	if(!empty($ActionID)){
		$height = '580px';
	}
	else{
		$height = '405px';
	}
	
	echo '<div id="tt_form" style="width: 420px;height:'.$height.';">';
	echo '<form  action="'.esc_url( $_SERVER['REQUEST_URI'] ).'" method="post">';
	
	if(!empty($ActionID)){
		echo '<h1>Project #'.$ActionID.':</h1>';
	}
	else{
		echo '<h1>New Project:</h1>';
		$creator = tt_getcurrentuser();
	}
?>
	<input id="tt_input" type="text" name="tt_project_detail_projectname" style="background:none;" value="<?php echo $project_name; ?>" required placeholder=" "/>
	<label id="tt_label" for="tt_project_detail_projectname" >Name</label>
	<br>
	<input id="tt_input" type="text" name="tt_project_detail_creator" style="background:none;" value="<?php echo $creator; ?>" readonly />
	<label id="tt_label" for="tt_project_detail_creator" >Creator</label>
	<br>
	<input id="tt_input" type="datetime-local" name="tt_project_detail_create" style="background:none;" value="<?php echo $create_time; ?>" required placeholder=" "/>
	<label id="tt_label_date" for="tt_project_detail_create" >Create Time</label>
	<br>
	
<?php
	
	if(!empty($_REQUEST['actionID'])){	
?>
	<input id="tt_input" type="datetime-local" name="tt_project_detail_begin" style="background:none;" value="<?php echo $begin_time; ?>" readonly/>
	<label id="tt_label_date" for="tt_project_detail_begin" >Begin Time</label>
	<br>
	<input id="tt_input" type="datetime-local" name="tt_project_detail_end" style="background:none;" value="<?php echo $end_time; ?>" readonly/>
	<label id="tt_label_date" for="tt_project_detail_end" >End Time</label>
	<br>
	<input id="tt_input" type="datetime-local" name="tt_project_detail_finish" style="background:none;" value="<?php echo $finish_time; ?>" readonly/>
	<label id="tt_label_date" for="tt_project_detail_finish" >Finish Time</label>
	<br>
<?php
	}	
?>
	<!--...Not now
	<select id="tt_select" name="tt_project_detail_belong" required placeholder=" ">
		<option value="none" selected="selected">None</option>
		<option value="volvo">Volvo</option>
		<option value="saab">Saab</option>
		<option value="mercedes">Mercedes</option>
		<option value="audi">Audi</option>
	</select>
	<label id="tt_label_date" for="tt_project_detail_belong" >Belongs</label>
	<br>
	-->
	
	<textarea id="tt_textarea" name="tt_project_detail_description" placeholder=" "><?php echo $description; ?></textarea>
	<label id="tt_label" for="tt_project_detail_description">Description</label>
	<br>
		<div id="tt_bt_area" <?php if(empty($_REQUEST['actionID'])){echo 'style="padding-left: 90px;"';}?>>
			<div id="tt_button">
				
				<?php
					if(!empty($_REQUEST['actionID'])){
						echo '<input type="submit" id="submit"  name="tt_project_detail_update" value="Update">';
						echo '<input type="submit" id="submit" name="tt_project_detail_delete" value="Delete">';
					}
					else{
						echo '<input type="submit" id="submit"  name="tt_project_detail_update" value="Submit">';
					}
				?>
				<input type="button" id="submit"  name="tt_project_detail_cancel" value="Cancel" onClick="window.close();"> 
			</div>
		</div>
	</div>
	</form>
<?php
	if (isset($_POST['tt_project_detail_update']) ) {
				$project_name = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_project_detail_projectname"]));
		$creator = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_project_detail_creator"]));
		//$belongs = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_project_detail_belong"]));
		$description = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_project_detail_description"]));
		$create_time = tt_convert_string_for_mysql(tt_convert_datetime_to_mysql(sanitize_text_field($_POST["tt_project_detail_create"])));
		
		

		global $wpdb;
		$tablename = $wpdb->prefix."tt_project";
		
		if(empty($ActionID)){
			//$sql = "insert into $tablename (description,creator,project_name,parent_project_id) values ($description,$creator,$project_name,$belongs);";
			$sql = "insert into $tablename (description,creator,project_name,create_time) values ($description,$creator,$project_name,$create_time);";
			$wpdb->query($sql);
			//echo "<script>window.close();</script>";
			//echo $sql;
		}
		else{
			$sql = "delete from $tablename where id = $ActionID;";
			$wpdb->query($sql);
			
			$sql = "insert into $tablename (id,description,creator,project_name,create_time) values ($ActionID,$description,$creator,$project_name,$create_time);";
			$wpdb->query($sql);
			
		}
		
		echo  "<script type='text/javascript'>";
		echo "window.close();";
		echo "</script>";
	}

	if (isset($_POST['tt_project_detail_delete']) ) {
		$ActionID = $_REQUEST['actionID'];
		
		if(!empty($ActionID)){
			global $wpdb;
			$tablename = $wpdb->prefix."tt_project";
			$sql = "delete from $tablename where id = $ActionID;";
			$result = $wpdb->query($sql);
		}
		
		echo "<script>window.close();</script>";
	}

}

//meeting details
function tt_scf_meeting_details() {
	$ActionID = $_REQUEST['actionID'];
	
	//variables
	$creator = $time = $topic = $note = NULL;
	
	if(!empty($ActionID)){
		global $wpdb;
		$tablename = $wpdb->prefix."tt_meeting";
		$sql = "select * from $tablename where id = $ActionID;";
		$result = $wpdb->get_row($sql);
		$topic = $result->topic;	
		$creator = $result->creator;	
		$time =  tt_convert_mysql_to_datetime($result->time);	
		$note = $result->note;
		
	}
	echo '<div id="tt_form" style="width: 420px;height: 400px;">';
	echo '<form  action="'.esc_url( $_SERVER['REQUEST_URI'] ).'" method="post">';
	
	if(!empty($ActionID)){
		echo '<h1>Meeting #'.$ActionID.':</h1>';
	}
	else{
		echo '<h1>New Meeting:</h1>';
		$creator = tt_getcurrentuser();
	}	
?>

	<input id="tt_input" type="text" name="tt_meeting_detail_topic" style="background:none;" value="<?php echo $topic; ?>" required placeholder=" "/>
	<label id="tt_label" for="tt_meeting_detail_topic" >Topic</label>
	<br>
	<input id="tt_input" type="text" name="tt_meeting_detail_creator" style="background:none;" value="<?php echo $creator; ?>" readonly />
	<label id="tt_label" for="tt_meeting_detail_creator" >Creator</label>
	<br>
	<input id="tt_input" type="datetime-local" name="tt_meeting_detail_time" style="background:none;" value="<?php echo $time; ?>" required placeholder=" "/>
	<label id="tt_label_date" for="tt_meeting_detail_time" >Time</label>
	<br>
	<textarea id="tt_textarea" name="tt_meeting_detail_note" placeholder=" "><?php echo $note; ?></textarea>
	<label id="tt_label" for="tt_meeting_detail_note">Note</label>
	<br>
	
	<div id="tt_bt_area" <?php if(empty($_REQUEST['actionID'])){echo 'style="padding-left: 90px;"';}?>>
			<div id="tt_button">
				<?php
					if(!empty($_REQUEST['actionID'])){
						echo '<input type="submit" id="submit"  name="tt_meeting_detail_update" value="Update">';
						echo '<input type="submit" id="submit" name="tt_meeting_detail_delete" value="Delete">';
					}
					else{
						echo '<input type="submit" id="submit"  name="tt_meeting_detail_update" value="Submit">';
					}
				?>
				<input type="button" id="submit"  name="tt_meeting_detail_cancel" value="Cancel" onClick="window.close();"> 
			</div>
		</div>
	</div>
	
	
	</form>
	
	
<?php
	if (isset($_POST['tt_meeting_detail_update']) ) {
		$topic = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_meeting_detail_topic"]));
		$creator = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_meeting_detail_creator"]));
		$time = tt_convert_string_for_mysql(tt_convert_datetime_to_mysql(sanitize_text_field($_POST["tt_meeting_detail_time"])));
		$note = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_meeting_detail_note"]));
		

		global $wpdb;
		$tablename = $wpdb->prefix."tt_meeting";
		
		if(empty($ActionID)){
			$sql = "insert into $tablename (topic,creator,time,note) values ($topic,$creator,$time,$note);";
			$wpdb->query($sql);
			//echo "<script>window.close();</script>";
			//echo $sql;
		}
		else{
			$sql = "delete from $tablename where id = $ActionID;";
			$wpdb->query($sql);
			$sql = "insert into $tablename (id,topic,creator,time,note) values ($ActionID,$topic,$creator,$time,$note);";
			$wpdb->query($sql);
		}
		
		echo  "<script type='text/javascript'>";
		echo "window.close();";
		echo "</script>";
	}

	if (isset($_POST['tt_meeting_detail_delete']) ) {
		$ActionID = $_REQUEST['actionID'];
		
		if(!empty($ActionID)){
			global $wpdb;
			$tablename = $wpdb->prefix."tt_meeting";
			$sql = "delete from $tablename where id = $ActionID;";
			$result = $wpdb->query($sql);
		}
		
		echo "<script>window.close();</script>";
	}
}
//calendar details
function tt_scf_calendar_details() {
	$ActionID = $_REQUEST['actionID'];
	
	//variables
	$creator; $time; $topic; $note;
	
	if(!empty($ActionID)){
		global $wpdb;
		$tablename = $wpdb->prefix."tt_calendar";
		$sql = "select * from $tablename where id = $ActionID;";
		$result = $wpdb->get_row($sql);
		$topic = $result->topic;	
		$creator = $result->creator;	
		$time =  tt_convert_mysql_to_datetime($result->time);	
		$note = $result->note;
		
	}
	echo '<div id="tt_form" style="width: 420px;height: 400px;">';
	echo '<form  action="'.esc_url( $_SERVER['REQUEST_URI'] ).'" method="post">';
	
	if(!empty($ActionID)){
		echo '<h1>Calendar Entry #'.$ActionID.':</h1>';
	}
	else{
		echo '<h1>New Calendar Entry:</h1>';
		$creator = tt_getcurrentuser();
	}	
?>
	
	<input id="tt_input" type="text" name="tt_calendar_detail_topic" style="background:none;" value="<?php echo $topic; ?>" required placeholder=" "/>
	<label id="tt_label" for="tt_calendar_detail_topic" >Topic</label>
	<br>

	<input id="tt_input" type="text" name="tt_calendar_detail_creator" style="background:none;" value="<?php echo $creator; ?>" readonly />
	<label id="tt_label" for="tt_calendar_detail_creator" >Creator</label>
	<br>
	
	<input id="tt_input" type="datetime-local" name="tt_calendar_detail_time" style="background:none;" value="<?php echo $time; ?>" required placeholder=" "/>
	<label id="tt_label_date" for="tt_calendar_detail_time" >Time</label>
	<br>
	
	<textarea id="tt_textarea" name="tt_calendar_detail_note" placeholder=" "><?php echo $note; ?></textarea>
	<label id="tt_label" for="tt_calendar_detail_note">Note</label>
	<br>
	
		<div id="tt_bt_area" <?php if(empty($_REQUEST['actionID'])){echo 'style="padding-left: 90px;"';}?>>
			<div id="tt_button">
				
				<?php
					if(!empty($_REQUEST['actionID'])){
						echo '<input type="submit" id="submit"  name="tt_calendar_detail_update" value="Update">';
						echo '<input type="submit" id="submit" name="tt_calendar_detail_delete" value="Delete">';
					}
					else{
						echo '<input type="submit" id="submit"  name="tt_calendar_detail_update" value="Submit">';
					}
				?>
				<input type="button" id="submit"  name="tt_calendar_detail_cancel" value="Cancel" onClick="window.close();"> 
			</div>
		</div>
	</div>
	</form>
<?php
	if (isset($_POST['tt_calendar_detail_update']) ) {
		$topic = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_calendar_detail_topic"]));
		$creator = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_calendar_detail_creator"]));
		$time = tt_convert_string_for_mysql(tt_convert_datetime_to_mysql(sanitize_text_field($_POST["tt_calendar_detail_time"])));
		$note = tt_convert_string_for_mysql(sanitize_text_field($_POST["tt_calendar_detail_note"]));
		

		global $wpdb;
		$tablename = $wpdb->prefix."tt_calendar";
		
		if(empty($ActionID)){
			$sql = "insert into $tablename (topic,creator,time,note) values ($topic,$creator,$time,$note);";
			$wpdb->query($sql);
			//echo "<script>window.close();</script>";
			//echo $sql;
		}
		else{
			$sql = "delete from $tablename where id = $ActionID;";
			$wpdb->query($sql);
			$sql = "insert into $tablename (id,topic,creator,time,note) values ($ActionID,$topic,$creator,$time,$note);";
			$wpdb->query($sql);
		}
		
		echo  "<script type='text/javascript'>";
		echo "window.close();";
		echo "</script>";
	}

	if (isset($_POST['tt_calendar_detail_delete']) ) {
		$ActionID = $_REQUEST['actionID'];
		
		if(!empty($ActionID)){
			global $wpdb;
			$tablename = $wpdb->prefix."tt_calendar";
			$sql = "delete from $tablename where id = $ActionID;";
			$result = $wpdb->query($sql);
		}
		
		echo "<script>window.close();</script>";
	}
}


function tt_convert_mysql_to_datetime($raw){
	list($first,$second) = sscanf($raw,"%s %s");	
	return $first.'T'.$second;
}

function tt_convert_datetime_to_mysql($raw){
	$mylist = explode('T',$raw);
	return $mylist[0].' '.$mylist[1].':00';
}

function tt_convert_string_for_mysql($raw){
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

//project page
function tt_scf_project() {
	$id = tt_getwelcome();
	tt_getsidebar($id, 'project');
	
	
?>	
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

	function drawTable() {
		var data = new google.visualization.DataTable();
		<?php
			global $wpdb;
			$tablename = $wpdb->prefix."tt_project";
			$username = tt_getcurrentuser();
			$sql = "select * from $tablename where creator = '$username';";
			
			//print columns
			echo "data.addColumn('string', 'ID');";
			echo "data.addColumn('string', 'Project Name');";
			//echo "data.addColumn('string', 'Begin Time');";
			//echo "data.addColumn('string', 'End Time');";
			//echo "data.addColumn('string', 'Parent');";
			echo "data.addColumn('string', 'Description');";
			//print rows
			$result = $wpdb->get_results($sql);
			//$begin = 'begin';
			//$end = 'end';
			
			printf("data.addRows([");
			
			foreach($result as $row){
				//printf("['%s','%s','%s','%s','%s','%s'],",$row->id,$row->project_name, $begin,$end,$row->parent_project_id,$row->description);
				printf("['%s','%s','%s'],",$row->id,$row->project_name, $row->description);
				
			}
			
			printf("]);");
			
		?>
		//data.setColumnProperty(0, 'style', 'width:5px;');
		var table = new google.visualization.Table(document.getElementById('table_div'));
		var options = "{showRowNumber: false, width: '100%', height: '100%', page:'enable',allowHtml: true}";
		
		
		table.draw(data, options);
		
		google.visualization.events.addListener(table, 'select',  function() {
			
			var item = table.getSelection()[0].row;
			var actionID = data.getValue(item, 0);
			
			//alert(data.getValue(item, 0));
   
			window.open ("project_details?actionID="+actionID,"subwindow","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no");
		});
	}	 
    </script>
	<div id = "tt_content">
		<div id="table_div">please wait...</div>
		<div id="tt_p">*click one action for more operations and details.</div>
		<?php
			echo '<form enctype="multipart/form-data" action="'.esc_url($_SERVER['REQUEST_URI']).'" method="post">';
		?>
		<div id="tt_button" style="float:right;">
			<input type="submit" id="submit"  name="tt_action_add" value="Add New"> 
			<input type="submit" id="submit" value="Refresh" onClick="window.location.reload()">
		</div>
	</div>
	</form>
<?php	
	if (isset($_POST['tt_action_add']) ) {
	?>
	<script>
		window.open ("project_details?id=<?php echo tt_getuserid();?>","newwindow","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no");
	</script>
	<?php
	}
}



//meeting page
function tt_scf_meeting() {
	$id = tt_getwelcome();
	tt_getsidebar($id, 'meeting');
	?>	
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

	function drawTable() {
		var data = new google.visualization.DataTable();
		<?php
			global $wpdb;
			$tablename = $wpdb->prefix."tt_meeting";
			$username = tt_getcurrentuser();
			$sql = "select * from $tablename where creator = '$username';";
			
			//print columns
			echo "data.addColumn('string', 'ID');";
			echo "data.addColumn('string', 'Topic');";
			echo "data.addColumn('string', 'Time');";
			echo "data.addColumn('string', 'Note');";

			//print rows
			$result = $wpdb->get_results($sql);
			$begin = 'begin';
			$end = 'end';
			
			printf("data.addRows([");
			
			foreach($result as $row){
				printf("['%s','%s','%s','%s'],",$row->id,$row->topic, $row->time,$row->note);
				
			}
			
			printf("]);");
			
		?>
		//data.setColumnProperty(0, 'style', 'width:5px;');
		var table = new google.visualization.Table(document.getElementById('table_div'));
		var options = "{showRowNumber: false, width: '100%', height: '100%', page:'enable',allowHtml: true}";
		
		
		table.draw(data, options);
		
		google.visualization.events.addListener(table, 'select',  function() {
			
			var item = table.getSelection()[0].row;
			var actionID = data.getValue(item, 0);
			
			//alert(data.getValue(item, 0));
   
			window.open ("meeting_details?actionID="+actionID,"subwindow","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no");
		});
	}	 
    </script>
	<div id = "tt_content">
		<div id="table_div">please wait...</div>
		<div id="tt_p">*click one action for more operations and details.</div>
		<?php
			echo '<form enctype="multipart/form-data" action="'.esc_url($_SERVER['REQUEST_URI']).'" method="post">';
		?>
		<div id="tt_button" style="float:right;">
			<input type="submit" id="submit"  name="tt_action_add" value="Add New"> 
			<input type="submit" id="submit" value="Refresh" onClick="window.location.reload()">
		</div>
		    
   
	</div>
	
	</form>
	
<?php	
	if (isset($_POST['tt_action_add']) ) {
	?>
	<script>
		window.open ("meeting_details?id=<?php echo tt_getuserid();?>","newwindow","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no");
	</script>
	<?php
	}

}

//calendar page
function tt_scf_calendar() {
	$id = tt_getwelcome();
	tt_getsidebar($id, 'calendar');
	
	$pdf_creator = $pdf_author = tt_getcurrentuser();
	$pdf_filename = $pdf_title = $pdf_creator."'s Calendar";
	
	
	?>	

				
	
<section class="tabs">
    <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1"  checked="checked"/>
    <label for="tab-1" class="tab-label-1">Calendar View</label>
	
    <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2" />
    <label for="tab-2" class="tab-label-2">Table View</label>
	
	<div class="clear-shadow"></div>
        <div class="content">
			<div class="content-1" style="top: 0;	left: 0; padding: 10px 40px; z-index: 1; transition: all linear 0.1s;">
				<span style="color: rgb(48, 57, 66);font-family: 'Segoe UI', Tahoma, sans-serif;	font-size: 0.8em;">*This view contains all calendar entries, all meeting entries and start/end of an action. Please note project will not occur in this view because a project is not meaningful unless there are actions belong to it.</span>
				<link rel="stylesheet" href="//kendo.cdn.telerik.com/2016.2.714/styles/kendo.common-material.min.css" />
				<link rel="stylesheet" href="//kendo.cdn.telerik.com/2016.2.714/styles/kendo.material.min.css" />
				<link rel="stylesheet" href="//kendo.cdn.telerik.com/2016.2.714/styles/kendo.default.mobile.min.css" />

				<script src="//kendo.cdn.telerik.com/2016.2.714/js/jquery.min.js"></script>
				<script src="//kendo.cdn.telerik.com/2016.2.714/js/kendo.all.min.js"></script>
				<script src="//kendo.cdn.telerik.com/2016.2.714/js/kendo.timezones.min.js"></script>
				
				<script>
				// Import DejaVu Sans font for embedding

				// NOTE: Only required if the Kendo UI stylesheets are loaded
				// from a different origin, e.g. cdn.kendostatic.com
				kendo.pdf.defineFont({
					"DejaVu Sans"             : "//kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans.ttf",
					"DejaVu Sans|Bold"        : "//kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
					"DejaVu Sans|Bold|Italic" : "//kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
					"DejaVu Sans|Italic"      : "//kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf"
				});
				</script>

				<!-- Load Pako ZLIB library to enable PDF compression -->
				<script src="//kendo.cdn.telerik.com/2016.2.714/js/pako_deflate.min.js"></script>
				
				<div id="tt_calendar_view">
					<div id="scheduler"></div>
				</div>
                <script>
				$(function() {
					$("#scheduler").kendoScheduler({
						toolbar: [ "pdf" ],
						pdf: {
							fileName: "<?php echo $pdf_filename; ?>",
							//proxyURL: "//demos.telerik.com/kendo-ui/service/export"
							title: "<?php echo $pdf_title; ?>",
							author: "<?php echo $pdf_author; ?>",
							creator: "<?php echo $pdf_creator; ?>",
							margin: {
								left: 10,
								right: 10,
								top: 10,
								bottom: 10
							}
						},
						//date: new Date("2016/6/6"),
						//startTime: new Date("2016/6/1 07:00 AM"),
						//height: 700,
						//width: 840,
						views: [
							"day",
							//"workWeek",
							//"week",
							{ type: "month", selected: true },
							"agenda",
							
							//{ type: "timeline", eventHeight: 50}
						],
						//timezone: "America/New_York",
						//editable: false,
						editable: {
							confirmation: false,
							create: false,
							destroy: false,
							move: false,
							resize: false,
							update: false
						},
						dataSource: [
						
						<?php
							//get current username
							$creator = tt_convert_string_for_mysql(tt_getcurrentuser());
						
							//retrieve calendar data, id starts with 1
							global $wpdb;
							$tablename_calendar = $wpdb->prefix."tt_calendar";
							$sql = "SELECT id, DATE_FORMAT(time,'%Y/%m/%d %h:%i %p') as time, topic FROM $tablename_calendar where creator = $creator;";
							$result = $wpdb->get_results($sql);
							
							$output = '';
							foreach($result as $row){
								$content = 'C'.$row->id.' - '.$row->topic;
								$output = $output.'{id:1'.$row->id.',start: new Date("'.$row->time.'"),end:new Date("'.$row->time.'"),title:"'.$content.'"},';
							}
							
							
							//retrieve meeting data, id starts with 2
							$tablename_meeting = $wpdb->prefix."tt_meeting";
							$sql = "SELECT id, DATE_FORMAT(time,'%Y/%m/%d %h:%i %p') as time, topic FROM $tablename_meeting where creator = $creator;";
							$result = $wpdb->get_results($sql);
							
							foreach($result as $row){
								$content = 'M'.$row->id.' - '.$row->topic;
								$output = $output.'{id:2'.$row->id.',start: new Date("'.$row->time.'"),end:new Date("'.$row->time.'"),title:"'.$content.'"},';
							}
							
							//retrieve action data, id starts with 3 for begin & 4 for end
							$tablename_action = $wpdb->prefix."tt_action";
							$sql = "SELECT id, DATE_FORMAT(begin_time,'%Y/%m/%d %h:%i %p') as btime,DATE_FORMAT(end_time,'%Y/%m/%d %h:%i %p') as etime, action_name FROM $tablename_action where creator = $creator;";
							$result = $wpdb->get_results($sql);
							foreach($result as $row){
								$content = 'Start of A'.$row->id.' - '.$row->action_name;
								$output = $output.'{id:2'.$row->id.',start: new Date("'.$row->btime.'"),end:new Date("'.$row->btime.'"),title:"'.$content.'"},';
								
								$content = 'End of A'.$row->id.' - '.$row->action_name;
								$output = $output.'{id:2'.$row->id.',start: new Date("'.$row->etime.'"),end:new Date("'.$row->etime.'"),title:"'.$content.'"},';
							}
							
							//print all date
							rtrim($output, ',');
							echo $output;
						?>
							

						],
					});


				});
				</script>

			</div>

		    <div class="content-2" style="top: 0;	left: 0; padding: 10px 40px; z-index: 1; transition: all linear 0.1s;">
				<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
				<script type="text/javascript">
				  google.charts.load('current', {'packages':['table','calendar']});
				  google.charts.setOnLoadCallback(drawTable);
				  //google.charts.setOnLoadCallback(drawChart);
	
				function drawTable() {
					var data = new google.visualization.DataTable();
					<?php
						global $wpdb;
						$tablename = $wpdb->prefix."tt_calendar";
						$username = tt_getcurrentuser();
						$sql = "select * from $tablename where creator = '$username';";
						
						//print columns
						echo "data.addColumn('string', 'ID');";
						echo "data.addColumn('string', 'Topic');";
						echo "data.addColumn('string', 'Time');";
						echo "data.addColumn('string', 'Note');";

						//print rows
						$result = $wpdb->get_results($sql);
						$begin = 'begin';
						$end = 'end';
						
						printf("data.addRows([");
						
						foreach($result as $row){
							printf("['%s','%s','%s','%s'],",$row->id,$row->topic, $row->time,$row->note);
							
						}
						
						printf("]);");
						
					?>
					//data.setColumnProperty(0, 'style', 'width:5px;');
					var table = new google.visualization.Table(document.getElementById('table_div'));
					var options = "{showRowNumber: false, width: '100%', height: '100%', page:'enable',allowHtml: true}";
					
					
					table.draw(data, options);
					
					google.visualization.events.addListener(table, 'select',  function() {
						
						var item = table.getSelection()[0].row;
						var actionID = data.getValue(item, 0);
						
						window.open ("calendar_details?actionID="+actionID,"subwindow","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no");
					});
				}

				</script>
				<?php
					echo '<form enctype="multipart/form-data" action="'.esc_url($_SERVER['REQUEST_URI']).'" method="post">';
				?>				
					<div id="table_div"></div>
					<p id="tt_p">*click one action for more operations and details.</p>
					
					<div id="tt_button" style="float:right;">
						<input type="submit" id="submit"  name="tt_action_add" style="margin:0;margin-right:15px;" value="Add New"> 
						<input type="submit" id="submit" value="Refresh" style="margin:0;margin-right:15px;" onClick="window.location.reload()">
					</div>
				</form>
			</div>				
      	</div>
</section>

				
	



	
	
	
<?php	
	if (isset($_POST['tt_action_add']) ) {
	?>
	<script>
		window.open ("calendar_details?id=<?php echo tt_getuserid();?>","newwindow","height=640,width=600,top=20,left=480,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no,titlebar=no");
	</script>
	<?php
	}

}




function tt_getsidebar($id, $type){

?>
	
	<div id ="tt_sidebar">
	<nav>
		<ul class="mcd-menu">
			<li>
				<a href="action<?php echo '?id='.$id; ?>" <?php if($type == 'action'){echo 'class="active"';}?>>
					<i class="fa fa-tasks"></i>
					<strong>Action</strong>
					<small>manage your actions</small>
				</a>
			</li>
			<li>
				<a href="project<?php echo '?id='.$id; ?>" <?php if($type == 'project'){echo 'class="active"';}?>>
					<i class="fa fa-folder-open"></i>
					<strong>Project</strong>
					<small>put actions into a project</small>
				</a>
			</li>
			<li>
				<a href="meeting<?php echo '?id='.$id; ?>" <?php if($type == 'meeting'){echo 'class="active"';}?>>
					<i class="fa fa-comments-o"></i>
					<strong>Meeting</strong>
					<small>want to discuss with others?</small>
				</a>
			</li>
			<li>
				<a href="calendar<?php echo '?id='.$id; ?>" <?php if($type == 'calendar'){echo 'class="active"';}?>>
					<i class="fa fa-calendar"></i>
					<strong>Calendar</strong>
					<small>put them on your desk</small>
				</a>
			</li>
			<li>
				<a href="report<?php echo '?id='.$id; ?>" <?php if($type == 'report'){echo 'class="active"';}?>>
					<i class="fa fa-file-archive-o"></i>
					<strong>Report</strong>
					<small>it's tough to see the results</small>
				</a>
			</li>
			<li>
				<a href="setting<?php echo '?id='.$id; ?>" <?php if($type == 'setting'){echo 'class="active"';}?>>
					<i class="fa fa-cogs"></i>
					<strong>Setting</strong>
					<small>configuration</small>
				</a>
			</li>
			<li>
				<a href="login">
					<i class="fa fa-sign-out"></i>
					<strong>Sign Out</strong>
					<small>was good to see you here!</small>
				</a>
			</li>
	</nav>

</div>
<?php
}

function tt_getwelcome(){
	$username_inDB = tt_getcurrentuser();
	
	echo '<div id="tt_welcome">Hello, '.$username_inDB.'!</div>';
	
	$id =  $_REQUEST['id'];	
	
	return $id;
}

function tt_getuserid(){
	$id =  $_REQUEST['id'];
	return $id;
}

function tt_getcurrentuser(){
	$id =  $_REQUEST['id'];
	
	global $wpdb;
	$tablename = $wpdb->prefix."tt_user";
	
	$sql = "select username from $tablename where username_password_md5 = '$id';";
	$username_inDB = $wpdb->get_var($sql);
	
	return $username_inDB;
}

?>