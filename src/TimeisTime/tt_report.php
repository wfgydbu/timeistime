<?php

add_shortcode( 'tt_sc_report', 'tt_scf_report' );

//report page
function tt_scf_report() {
	$id = tt_getwelcome();
	tt_getsidebar($id,'report');

	echo '<form enctype="multipart/form-data" action="'.esc_url($_SERVER['REQUEST_URI']).'" method="post">';
	
?>

<div class="tt_report_fiters">
	<p>Contents:</p>
	<div class="section">
		<input id="tt_report_content_action" type="radio" name="tt_report_content" value="action" onclick="displayType()" checked="checked"><label for="tt_report_content_action"><span><span></span></span>Action</label>
	</div>
	<div class="section">
		<input id="tt_report_content_project" type="radio" name="tt_report_content" value="project" onclick="displayType()"><label for="tt_report_content_project"><span><span></span></span>Project</label>
	</div>
	<div class="section">
		<input id="tt_report_content_meeting" type="radio" name="tt_report_content" value="meeting" onclick="displayType()"><label for="tt_report_content_meeting"><span><span></span></span>Meeting</label>
	</div>
	<div class="section">
		<input id="tt_report_content_calendar" type="radio" name="tt_report_content" value="calendar" onclick="displayType()"><label for="tt_report_content_calendar"><span><span></span></span>Calendar</label>
	</div>
</div>
<div class="tt_report_fiters">
	<p>Parameters:</p>
	<div class="section" id="tt_report_parameter_checkall_sectionid">
		<input id="tt_report_parameter_checkall" type="checkbox" name="tt_report_parameter[]" value="all" onClick="checkallparameters(this)">
		<label for="tt_report_parameter_checkall"><span></span>All</label>
	</div>
	<div class="section" id="tt_report_parameter_risk_sectionid">
		<input id="tt_report_parameter_risk" type="checkbox" name="tt_report_parameter[]"  value="risk" onClick="riskType(this)">
		<label for="tt_report_parameter_risk"><span></span>Risk</label>
	</div>
	<div class="section" id="tt_report_parameter_progress_sectionid">
		<input id="tt_report_parameter_progress" type="checkbox" name="tt_report_parameter[]" value="progress"  onClick="progressType(this)">
		<label for="tt_report_parameter_progress"><span></span>Progress</label>
	</div>
	<div class="section" id="tt_report_parameter_create_sectionid">
		<input id="tt_report_parameter_create" type="checkbox" name="tt_report_parameter[]" value="create_time" onClick="createType(this)" checked="checked">
		<label for="tt_report_parameter_create"><span></span>Create Time</label>
	</div>
	<div class="section" id="tt_report_parameter_begin_sectionid">
		<input id="tt_report_parameter_begin" type="checkbox" name="tt_report_parameter[]" value="begin_time" onClick="beginType(this)">
		<label for="tt_report_parameter_begin"><span></span>Begin Time</label>
	</div>
	<div class="section" id="tt_report_parameter_end_sectionid">
		<input id="tt_report_parameter_end" type="checkbox" name="tt_report_parameter[]" value="end_time" onClick="endType(this)">
		<label for="tt_report_parameter_end"><span></span>End Time</label>
	</div>
	<div class="section" id="tt_report_parameter_finish_sectionid">
		<input id="tt_report_parameter_finish" type="checkbox" name="tt_report_parameter[]" value="real_finish_time" onClick="finishType(this)">
		<label for="tt_report_parameter_finish"><span></span>Finish Time</label>
	</div>	
	
</div>

<div class="tt_report_fiters">
	<p>Charts:</p>
	<div class="section" id="tt_report_chart_line_sectionid">
		<input id="tt_report_chart_line" type="radio" name="tt_report_chart" value="line" checked="checked">
		<label for="tt_report_chart_line"><span><span></span></span>Line</label>
	</div>
	<div class="section" id="tt_report_chart_bar_sectionid">
		<input id="tt_report_chart_bar" type="radio" name="tt_report_chart" value="bar">
		<label for="tt_report_chart_bar"><span><span></span></span>Bar</label>
	</div >
	<div class="section" id="tt_report_chart_area_sectionid">
		<input id="tt_report_chart_area" type="radio" name="tt_report_chart" value="area">
		<label for="tt_report_chart_area"><span><span></span></span>Area</label>
	</div>
	<div class="section" id="tt_report_chart_column_sectionid">
		<input id="tt_report_chart_column" type="radio" name="tt_report_chart" value="column">
		<label for="tt_report_chart_column"><span><span></span></span>Column</label>
	</div>
	<div class="section" id="tt_report_chart_pie_sectionid" style="display:none">
		<input id="tt_report_chart_pie" type="radio" name="tt_report_chart" value="pie">
		<label for="tt_report_chart_pie"><span><span></span></span>Pie</label>
	</div>
</div>
<div class="tt_report_fiters" id="tt_report_percent_scale" style="display:none">
	<p>Percent Scale:</p>
	<div class="section" id="tt_report_percent_25_sectionid">
		<input id="tt_report_percent_25" type="radio" name="tt_report_percent" value="25" checked="checked">
		<label for="tt_report_percent_25"><span><span></span></span>0-25%-50%-75%-Completed</label>
	</div>
	<div class="section" id="tt_report_percent_50_sectionid">
		<input id="tt_report_percent_50" type="radio" name="tt_report_percent" value="50">
		<label for="tt_report_percent_50"><span><span></span></span>0-50%-Completed</label>
	</div >
	<div class="section" id="tt_report_percent_100_sectionid">
		<input id="tt_report_percent_100" type="radio" name="tt_report_percent" value="100">
		<label for="tt_report_percent_100"><span><span></span></span>incompleted/completed</label>
	</div>
</div>

<div class="tt_report_fiters" id="tt_report_special_fiters">
	<p>Time Scale:</p>
	<div class="section">
		<input id="tt_report_range_year" type="radio" name="tt_report_range" value="year" checked="checked">
		<label for="tt_report_range_year"><span><span></span></span>Year</label>
	</div>
	<div class="section">
		<input id="tt_report_range_quarter" type="radio" name="tt_report_range" value="quarter">
		<label for="tt_report_range_quarter"><span><span></span></span>Quarter</label>
	</div class="section">
	<div>
		<input id="tt_report_range_month" type="radio" name="tt_report_range" value="month">
		<label for="tt_report_range_month"><span><span></span></span>Month</label>
	</div>
</div>


<div class="tt_report_fiters">
	<p>Time Range:</p>
	<span>from</span>
	<input type="datetime-local" name="tt_report_range_start"/>
	<span><span>
	<span>to</span><span><span>
	<input type="datetime-local" name="tt_report_range_end"/>
</div>
	<div id="tt_button" >
			<input type="submit" id="submit"  name="tt_report_generate" value=" ↓     Generate     ↓ " style="    float: right;margin-right: 295px;width:300px;margin-top:5px;"> 
	</div>

	<div class="tt_report_fiters"><hr></div>
</div>

<?php	
	//button event: generate
	if (isset($_POST['tt_report_generate']) ) {
		//retrieve all parameters		
		$content = $_POST['tt_report_content'];
		$charts = $_POST['tt_report_chart'];
		$scale = $_POST['tt_report_range'];
		
		$time_from = $time_to = NULL;
		
		if(!empty($_POST['tt_report_range_start'])){
			$time_from_list = explode('T',$_POST['tt_report_range_start']);
			$time_from = $time_from_list[0].' '.$time_from_list[1].':00';
		}
		
		if(!empty($_POST['tt_report_range_end'])){
			$time_to_list = explode('T',$_POST['tt_report_range_end']);
			$time_to = $time_to_list[0].' '.$time_to_list[1].':00';
		}
		
		$parameters = $_POST['tt_report_parameter'];
		
		//delete 'all' parameter
		if(($key = array_search('all', $parameters)) !== false) {
			unset($parameters[$key]);
		}
		
		
		$id =  $_REQUEST['id'];
	
		global $wpdb;
		$tablename = $wpdb->prefix."tt_user";
		
		$sql = "select username from $tablename where username_password_md5 = '$id';";
		$creator = $wpdb->get_var($sql);
		
		$title;
		/*
		if($parameters) {
			foreach($parameters as $check) {
				echo $check."<br />";
			}
		}*/
		if(strcmp($charts,'pie')){
			?>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
			<script src="http://www.cloudformatter.com/Resources/Pages/CSS2Pdf/Script/xepOnline.jqPlugin.js"></script>
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawChart);

				function drawChart() {
					var data = google.visualization.arrayToDataTable([
					<?php
						if(!strcmp($content,'action')){
							$scale_create_time = $scale_begin_time = $scale_end_time = $scale_finish_time;
							$time_range;
							
							switch($scale){
								case 'year':
									$scale_create_time = "date_format(create_time, '%Y')";
									$scale_begin_time = "date_format(begin_time, '%Y')";
									$scale_end_time = "date_format(end_time, '%Y')";
									$scale_finish_time = "date_format(real_finish_time, '%Y')";
									break;
								case 'quarter':
									$scale_create_time = "concat(date_format(create_time, '%Y-'),FLOOR((date_format(create_time, '%m')+2)/3))";
									$scale_begin_time = "concat(date_format(begin_time, '%Y-'),FLOOR((date_format(begin_time, '%m')+2)/3))";
									$scale_end_time = "concat(date_format(end_time, '%Y-'),FLOOR((date_format(end_time, '%m')+2)/3))";
									$scale_finish_time = "concat(date_format(real_finish_time, '%Y-'),FLOOR((date_format(real_finish_time, '%m')+2)/3))";
									break;
								case 'month':
									$scale_create_time = "date_format(create_time, '%Y-%m')";
									$scale_begin_time = "date_format(begin_time, '%Y-%m')";
									$scale_end_time = "date_format(end_time, '%Y-%m')";
									$scale_finish_time = "date_format(real_finish_time, '%Y-%m')";
									break;
								default:
							}
							
							if(empty($time_from) && empty($time_to)){
								$time_range = "is not null "; 
							}
							else if(!empty($time_from) && empty($time_to)){
								$time_range = "> '".$time_from."' ";
							}
							else if(empty($time_from) && !empty($time_to)){
								$time_range = "< '".$time_to."' ";
							}
							else{
								$time_range = "between '".time_from."' and '".$time_to."' ";
							}
							
							global $wpdb;
							$tablename = $wpdb->prefix."tt_action";
							$sql = "select TimeUnion.time as time, coalesce(A.number1,0) as num_create,  coalesce(B.number2,0) as num_begin, coalesce(C.number3,0) as num_end, 				coalesce(D.number4,0) as num_finish from (select $scale_create_time as time from wp_tt_action where create_time $time_range and creator = '$creator' union select $scale_begin_time as time from wp_tt_action where begin_time $time_range and creator = '$creator' union select $scale_end_time as time from wp_tt_action  where end_time $time_range and creator = '$creator'  union select $scale_finish_time as time from wp_tt_action  where real_finish_time $time_range and creator = '$creator' and DATE_FORMAT(real_finish_time,'%Y') != '0000' order by time ) as TimeUnion left join (select $scale_create_time as time1, count(*) as number1 from wp_tt_action where creator='$creator' group by $scale_create_time) AS A on TimeUnion.time=A.time1 left join (select $scale_begin_time as time2, count(*) as number2 from wp_tt_action where creator='$creator'  group by $scale_begin_time) as B on TimeUnion.time=B.time2 left join (select $scale_end_time as time3, count(*) as number3 from wp_tt_action where creator='$creator' group by  $scale_end_time) as C on TimeUnion.time=C.time3 left join (select $scale_finish_time as time4, count(*) as number4 from wp_tt_action where creator='$creator' group by $scale_finish_time) as D on TimeUnion.time=D.time4;";
							
							//echo $sql;
							$result = $wpdb->get_results($sql);
							
							if(!$result){break;}
							
							//start to print & prepare for the title
							$title = "Chart of amount of actions belong to ".$creator." (Filters:";
							
							//print first row
							printf("['");
							
							switch($scale){
								case 'year':
									printf("Year");
									break;
								case 'quarter':
									printf("Year-Quarter");
									break;
								case 'month':
									printf("Year-Month");
									break;
								default:
							}
							
							printf("'");
							
							if(in_array('create_time',$parameters)){
								printf(",'Number of actions create'");
								$title =  $title."Create Time,";
							}
							
							if(in_array('begin_time',$parameters)){
								printf(",'Number of actions begin'");
								$title =  $title."Begin Time,";
							}
							
							if(in_array('end_time',$parameters)){
								printf(",'Number of actions end'");
								$title =  $title."End Time,";
							}
							
							if(in_array('real_finish_time',$parameters)){
								printf(",'Number of actions finish'");
								$title =  $title."Finish Time,";
							}
							
							printf("],");
							
							//print data
							foreach($result as $row){
								printf("['%s'",$row->time);
								
								if(in_array('create_time',$parameters)){
									printf(",%s",$row->num_create);
								}
								
								if(in_array('begin_time',$parameters)){
									printf(",%s",$row->num_begin);
								}
								
								if(in_array('end_time',$parameters)){
									printf(",%s",$row->num_end);
								}
								
								if(in_array('real_finish_time',$parameters)){
									printf(",%s",$row->num_finish);
								}
								
								printf("],");
								
							}
							
							//format $title
							$title = rtrim($title, ',');
							$title = $title."|TimeScale:".$scale."|ChartType:".$charts.")";
						}else{
							//not action
							$scale_create_time;
							$timeFieldName;
							$time_range;
							
							if(!strcmp($content,'project')){
								$timeFieldName = 'create_time';
							}else{
								$timeFieldName = 'time';
							}
							
							switch($scale){
								case 'year':
									$scale_create_time = "date_format(".$timeFieldName.", '%Y')";
									break;
								case 'quarter':
									$scale_create_time = "concat(date_format(".$timeFieldName.", '%Y-'),FLOOR((date_format(".$timeFieldName.", '%m')+2)/3))";
									break;
								case 'month':
									$scale_create_time = "date_format(".$timeFieldName.", '%Y-%m')";
									break;
								default:
							}
							
							if(empty($time_from) && empty($time_to)){
								$time_range = "is not null "; 
							}
							else if(!empty($time_from) && empty($time_to)){
								$time_range = "> '".$time_from."' ";
							}
							else if(empty($time_from) && !empty($time_to)){
								$time_range = "< '".$time_to."' ";
							}
							else{
								$time_range = "between '".time_from."' and '".$time_to."' ";
							}
							
							global $wpdb;
							$tablename;
							
							switch($content){
								case 'project':
									$tablename = $wpdb->prefix."tt_project";
									break;
								case 'meeting':
									$tablename = $wpdb->prefix."tt_meeting";
									break;
								case 'calendar':
									$tablename = $wpdb->prefix."tt_calendar";
									break;
								default:
							}
							
							$sql = "select TimeUnion.rtime as time, coalesce(A.number1,0) as num_create from (select $scale_create_time as rtime from $tablename where $tablename.$timeFieldName $time_range and creator = '$creator' group by rtime order by rtime) as TimeUnion left join (select $scale_create_time as time1, count(*) as number1 from $tablename where creator='$creator' group by $scale_create_time) AS A on TimeUnion.rtime=A.time1;";
							
							$result = $wpdb->get_results($sql);
							
							if(!$result){break;}
							
							//start to print & prepare for the title
							$title = "Chart of amount of ".$content."s belong to ".$creator." (Filters:";
							
							//print first row
							printf("['");
							
							switch($scale){
								case 'year':
									printf("Year");
									break;
								case 'quarter':
									printf("Year-Quarter");
									break;
								case 'month':
									printf("Year-Month");
									break;
								default:
							}
							
							printf("'");
							
							if(in_array('create_time',$parameters)){
								printf(",'Number of actions create'");
								$title =  $title."Create Time,";
							}
							
							printf("],");
							
							//print data
							foreach($result as $row){
								printf("['%s'",$row->time);
								
								if(in_array('create_time',$parameters)){
									printf(",%s",$row->num_create);
								}
								
								printf("],");
								
							}
							
							//format $title
							$title = rtrim($title, ',');
							$title = $title."|TimeScale:".$scale."|ChartType:".$charts.")";
							
						}
					?>
					]);

					var options = {
						title: '<?php echo $title; ?>',
						curveType: 'function',
						legend: { position: 'right' },
						width: 900,
						height: 500
					};
					
					var chart_div = document.getElementById('ins_chart');
					 
					<?php
						switch($charts){
							case 'line':
								printf("var chart = new google.visualization.LineChart(chart_div);");
								break;
							case 'bar':
								printf("var chart = new google.visualization.BarChart(chart_div);");
								break;
							case 'area':
								printf("var chart = new google.visualization.AreaChart(chart_div);");
								break;
							case 'column':
								printf("var chart = new google.visualization.ColumnChart(chart_div);");
								break;
							default:
						}
					?>
					
					
					google.visualization.events.addListener(chart, 'ready', function () {

						
						var chartURI = '<img src="' + chart.getImageURI() + '">';
						
						
						var output = '<a class="tt_print_link" onclick="print_version()">To Printer Friendly Version</a>';
						
						//'<a href="' + chart.getImageURI() + '">Printable version</a>'
						
						document.getElementById('png_div').innerHTML =  output;
						document.getElementById('hidden_div').innerHTML =  chartURI;
					});
					

					
					chart.draw(data, options);
					
					
				}
			
			
			function print_version(){
				var win = window.open("", "win", ""); 
				
				var temp = document.getElementById('hidden_div').innerHTML;
				
			
				var now = new Date();
       
				var year = now.getFullYear();       
				var month = now.getMonth() + 1;     
				var day = now.getDate();            
			   
				var hh = now.getHours();            
				var mm = now.getMinutes();          
			   
				var clock = year + "-";
			   
				if(month < 10)
					clock += "0";
			   
				clock += month + "-";
			   
				if(day < 10)
					clock += "0";
				   
				clock += day + " ";
			   
				if(hh < 10)
					clock += "0";
				   
				clock += hh + ":";
				if (mm < 10) clock += '0'; 
				clock += mm; 
				
				
				var time = clock;
				
				var creator = 
				<?php
					$id =  $_REQUEST['id'];
	
					global $wpdb;
					$tablename = $wpdb->prefix."tt_user";
					
					$sql = "select username from $tablename where username_password_md5 = '$id';";
					$creator = $wpdb->get_var($sql);
					
					echo '"'.$creator.'"';
				?>
				
				var content = '<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><style> @media print {.tt_bt_area {display:none;} }.tt_bt_area{ width:100%;}h1 {color: black;font-size: 1em;font-weight: normal;line-height: 1;    padding-top: 20px;    padding-left: 40px;}p {    padding-left: 200px;color: rgb(48, 57, 66);font-family: \'Segoe UI\', Tahoma, sans-serif;	font-size: 12px;}a {  color:blue;  border-botton:1px solid blue;  cursor:pointer;}  .tt_bt_area{ padding-left: 500px;} .tt_bt_area .submit {     background-color: #ffb94b;    background-image: linear-gradient(top, #fddb6f, #ffb94b);    border-radius: 3px;    text-shadow: 0 1px 0 rgba(255,255,255,0.5);box-shadow: 0 0 1px rgba(0, 0, 0, 0.3), 0 1px 0 rgba(255, 255, 255, 0.3) inset;    border-width: 1px;    border-style: solid;    border-color: #d69e31 #e3a037 #d5982d #e3a037;    float: left;    height: 30px;    padding: 0;    width: 100px;    cursor: pointer;    font: bold 15px Arial, Helvetica;    color: #8f5a0a;	margin-right:15px;}  </style>  <title>Printable Vsersion</title></head><body><div>  <h1>Creater: '+creator+'</h1>  <h1>Print Time: '+clock+'</h1>   </div>  <div class="tt_bt_area" >			<div id="tt_button">				<input type="submit" class="submit"  name="tt_print_submit" value="Print" onCLick="window.print()"> 				<input type="button" class="submit"  name="tt_print_submit" value="Close" onClick="window.close();"> 			</div>  </div>  <div style="    margin-top: 60px;">  '+temp+'    </div>      <p>Powered by <a href="https://developers.google.com/chart/">Google Charts</a > & <a href="http://time.ethanshub.com">TIME Action Tracking System</p> </body></html>';
				
				win.document.open("text/html", "replace");
				win.document.write(content);
				win.document.close();
			}


			
			
			
			</script>
			<div class="tt_report_fiters">
				<div id="ins_chart" ></div>
				<div id="png_div" ></div>
				
				<div id="hidden_div" style="display:none" ></div>
			</div>	



			<?php			
			
			
		}else{
			//pie
			?>
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawChart);
				function drawChart() {
					var data = google.visualization.arrayToDataTable([
					<?php	
						if(in_array('risk',$parameters)){
							//risk
							$title = 'Chart of distribution of actions belong to '.$creator.' (Filter: risk level)';
							time_range;
							
							global $wpdb;
							$tablename = $wpdb->prefix."tt_configuration";
							
							$sql = "select a.value from $tablename as a where a.key = 'risk_type' and a.creator = '$creator';";
							$risk_type = $wpdb->get_var($sql);
							
							$one = $two = $three = $four = $five = '';
		
							switch($risk_type){
								case '1':
									$one = 'Level 1';
									$two = 'Level 2';
									$three = 'Level 3';
									$four = 'Level 4';
									$five = 'Level 5';
									break;
								case '2':
									$one = 'Low';
									$two = 'Medium-Low';
									$three = 'Medium';
									$four = 'Medium-High';
									$five = 'High';
									break;
								default:
									$one = '1';
									$two = '2';
									$three = '3';
									$four = '4';
									$five = '5';
							}
							
							if(empty($time_from) && empty($time_to)){
								$time_range = "is not null "; 
							}
							else if(!empty($time_from) && empty($time_to)){
								$time_range = "> '".$time_from."' ";
							}
							else if(empty($time_from) && !empty($time_to)){
								$time_range = "< '".$time_to."' ";
							}
							else{
								$time_range = "between '".time_from."' and '".$time_to."' ";
							}
							
							$tablename = $wpdb->prefix."tt_action";
							$sql = "select count(*) from $tablename where risk = '1' and create_time $time_range and creator = '$creator';"; 
							$num_risk1 = $wpdb->get_var($sql);
							
							$sql = "select count(*) from $tablename where risk = '2' and create_time $time_range and creator = '$creator';"; 
							$num_risk2 = $wpdb->get_var($sql);
							
							$sql = "select count(*) from $tablename where risk = '3' and create_time $time_range and creator = '$creator';"; 
							$num_risk3 = $wpdb->get_var($sql);
							
							$sql = "select count(*) from $tablename where risk = '4' and create_time $time_range and creator = '$creator';"; 
							$num_risk4 = $wpdb->get_var($sql);
							
							$sql = "select count(*) from $tablename where risk = '5' and create_time $time_range and creator = '$creator';"; 
							$num_risk5 = $wpdb->get_var($sql);
							
							printf("['Actions', 'Amount per risk type'],");
							
							

							printf("['Number of actions with risk:%s',%s],",$one,$num_risk1);
							printf("['Number of actions with risk:%s',%s],",$two,$num_risk2);
							printf("['Number of actions with risk:%s',%s],",$three,$num_risk3);
							printf("['Number of actions with risk:%s',%s],",$four,$num_risk4);
							printf("['Number of actions with risk:%s',%s]",$five,$num_risk5);
							
						}else{
							//progress
							$percent_scale = $_POST['tt_report_percent'];
							
							$title = 'Chart of distribution of actions belong to '.$creator.' (Filter: completeness|Percent Scale: '.$percent_scale.'%)';
							time_range;
							
							if(empty($time_from) && empty($time_to)){
								$time_range = "is not null "; 
							}
							else if(!empty($time_from) && empty($time_to)){
								$time_range = "> '".$time_from."' ";
							}
							else if(empty($time_from) && !empty($time_to)){
								$time_range = "< '".$time_to."' ";
							}
							else{
								$time_range = "between '".time_from."' and '".$time_to."' ";
							}
							
							$tablename = $wpdb->prefix."tt_action";
							$sql = "select count(*) from $tablename where progress >= 0 and progress < 25 and create_time $time_range and creator = '$creator';"; 
							$num_progress_0_25 = $wpdb->get_var($sql);
							
							$sql = "select count(*) from $tablename where progress >= 25 and progress < 50 and create_time $time_range and creator = '$creator';"; 
							$num_progress_25_50 = $wpdb->get_var($sql);
							
							$sql = "select count(*) from $tablename where progress >= 50 and progress < 75 and create_time $time_range and creator = '$creator';"; 
							$num_progress_50_75 = $wpdb->get_var($sql);
							
							$sql = "select count(*) from $tablename where progress >= 75 and progress < 100 and create_time $time_range and creator = '$creator';"; 
							$num_progress_75_100 = $wpdb->get_var($sql);
							
							$sql = "select count(*) from $tablename where progress = 100 and create_time $time_range and creator = '$creator';"; 
							$num_progress_100 = $wpdb->get_var($sql);
							
							printf("['Actions', 'Amount per scale'],");
							
							switch($percent_scale){
								case '50':
									printf("['Number of actions with progress: 0-49',%d],",(int)$num_progress_0_25+(int)$num_progress_25_50);
									printf("['Number of actions with progress: 50-99',%d],",(int)$num_progress_50_75+(int)$num_progress_75_100);
									printf("['Number of actions with progress: 100',%d]",(int)$num_progress_100);
							
									break;
								case '100':
									printf("['Number of actions not completed',%d],",(int)$num_progress_0_25+(int)$num_progress_25_50+(int)$num_progress_50_75+(int)$num_progress_75_100);
									printf("['Number of actions completed',%d]",(int)$num_progress_100);
									$title = "Chart of distribution of actions belong to yitian (incompleted/completed)";
									break;
								default:
									//25%
									printf("['Number of actions with progress: 0-24',%s],",$num_progress_0_25);
									printf("['Number of actions with progress: 25-49',%s],",$num_progress_25_50);
									printf("['Number of actions with progress: 50-74',%s],",$num_progress_50_75);
									printf("['Number of actions with progress: 75-99',%s],",$num_progress_75_100);
									printf("['Number of actions with progress: 100',%s]",$num_progress_100);
							}
							

						
						}

						
					?>

					]);

					var options = {
						title: '<?php echo $title; ?>'
					};

					var chart = new google.visualization.PieChart(document.getElementById('ins_chart'));
					
					google.visualization.events.addListener(chart, 'ready', function () {

						
						var chartURI = '<img src="' + chart.getImageURI() + '">';
						
						
						var output = '<a class="tt_print_link" onclick="print_version()">To Printer Friendly Version</a>';
						
						//'<a href="' + chart.getImageURI() + '">Printable version</a>'
						
						document.getElementById('png_div').innerHTML =  output;
						document.getElementById('hidden_div').innerHTML =  chartURI;
					});
					
					
					chart.draw(data, options);
				}
				
				function print_version(){
				var win = window.open("", "win", ""); 
				
				var temp = document.getElementById('hidden_div').innerHTML;
				
			
				var now = new Date();
       
				var year = now.getFullYear();       
				var month = now.getMonth() + 1;     
				var day = now.getDate();            
			   
				var hh = now.getHours();            
				var mm = now.getMinutes();          
			   
				var clock = year + "-";
			   
				if(month < 10)
					clock += "0";
			   
				clock += month + "-";
			   
				if(day < 10)
					clock += "0";
				   
				clock += day + " ";
			   
				if(hh < 10)
					clock += "0";
				   
				clock += hh + ":";
				if (mm < 10) clock += '0'; 
				clock += mm; 
				
				
				var time = clock;
				
				var creator = 
				<?php
					$id =  $_REQUEST['id'];
	
					global $wpdb;
					$tablename = $wpdb->prefix."tt_user";
					
					$sql = "select username from $tablename where username_password_md5 = '$id';";
					$creator = $wpdb->get_var($sql);
					
					echo '"'.$creator.'"';
				?>
				
				var content = '<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><style> @media print {.tt_bt_area {display:none;} }.tt_bt_area{ width:100%;}h1 {color: black;font-size: 1em;font-weight: normal;line-height: 1;    padding-top: 20px;    padding-left: 40px;}p {    padding-left: 200px;color: rgb(48, 57, 66);font-family: \'Segoe UI\', Tahoma, sans-serif;	font-size: 12px;}a {  color:blue;  border-botton:1px solid blue;  cursor:pointer;}  .tt_bt_area{ padding-left: 500px;} .tt_bt_area .submit {     background-color: #ffb94b;    background-image: linear-gradient(top, #fddb6f, #ffb94b);    border-radius: 3px;    text-shadow: 0 1px 0 rgba(255,255,255,0.5);box-shadow: 0 0 1px rgba(0, 0, 0, 0.3), 0 1px 0 rgba(255, 255, 255, 0.3) inset;    border-width: 1px;    border-style: solid;    border-color: #d69e31 #e3a037 #d5982d #e3a037;    float: left;    height: 30px;    padding: 0;    width: 100px;    cursor: pointer;    font: bold 15px Arial, Helvetica;    color: #8f5a0a;	margin-right:15px;}  </style>  <title>Printable Vsersion</title></head><body><div>  <h1>Creater: '+creator+'</h1>  <h1>Print Time: '+clock+'</h1>   </div>  <div class="tt_bt_area" >			<div id="tt_button">				<input type="submit" class="submit"  name="tt_print_submit" value="Print" onCLick="window.print()"> 				<input type="button" class="submit"  name="tt_print_submit" value="Close" onClick="window.close();"> 			</div>  </div>  <div style="    margin-top: 60px;">  '+temp+'    </div>      <p>Powered by <a href="https://developers.google.com/chart/">Google Charts</a > & <a href="http://time.ethanshub.com">TIME Action Tracking System</p> </body></html>';
				
				win.document.open("text/html", "replace");
				win.document.write(content);
				win.document.close();
			}

				
			</script>
			<div class="tt_report_fiters">
				<div id="ins_chart" ></div>
				<div id="png_div" ></div>
				
				<div id="hidden_div" style="display:none" ></div>
			</div>	
			<?php
		}
		
		//echo $sql;
		
		
	}
?>
</form>


<script type="text/javascript">
    function checkallparameters(source) {
		if(document.getElementById('tt_report_parameter_checkall').checked){
			document.getElementById('tt_report_parameter_checkall').checked = true;
			document.getElementById('tt_report_parameter_create').checked = true;
			document.getElementById('tt_report_parameter_begin').checked = true;
			document.getElementById('tt_report_parameter_end').checked = true;
			document.getElementById('tt_report_parameter_finish').checked = true;
			document.getElementById('tt_report_parameter_risk').checked = false;
			document.getElementById('tt_report_parameter_progress').checked = false;
		}
		else{
			document.getElementById('tt_report_parameter_checkall').checked = false;
			document.getElementById('tt_report_parameter_create').checked = false;
			document.getElementById('tt_report_parameter_begin').checked = false;
			document.getElementById('tt_report_parameter_end').checked = false;
			document.getElementById('tt_report_parameter_finish').checked = false;
			document.getElementById('tt_report_parameter_risk').checked = false;
			document.getElementById('tt_report_parameter_progress').checked = false;
		}
	}
	
	function displayType() {		
		//action selected
		if(document.getElementById('tt_report_content_action').checked) {
			//uncheck all parameters & set charts as Line Charts
			document.getElementById('tt_report_parameter_checkall').checked = false;
			document.getElementById('tt_report_parameter_create').checked = false;
			document.getElementById('tt_report_parameter_begin').checked = false;
			document.getElementById('tt_report_parameter_end').checked = false;
			document.getElementById('tt_report_parameter_finish').checked = false;
			document.getElementById('tt_report_parameter_risk').checked = false;
			document.getElementById('tt_report_parameter_progress').checked = false;
			
			document.getElementById('tt_report_chart_line').checked = true;
			
			//disable all 
			document.getElementById('tt_report_parameter_checkall_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_create_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_begin_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_end_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_finish_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_risk_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_progress_sectionid').style.display = 'none';
			
			//able the one belongs 
			document.getElementById('tt_report_parameter_checkall_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_create_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_begin_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_end_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_finish_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_risk_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_progress_sectionid').style.display = 'initial';
			
			document.getElementById('tt_report_chart_pie_sectionid').style.display = 'none';
			
			document.getElementById('tt_report_parameter_create').checked = true;
			
			document.getElementById('tt_report_chart_line_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_bar_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_column_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_area_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_pie_sectionid').style.display = 'none';
			
			document.getElementById('tt_report_chart_line').checked = true;
			
			document.getElementById('tt_report_special_fiters').style.display = 'initial';
			document.getElementById('tt_report_range_year').checked = true;
			document.getElementById('tt_report_percent_scale').style.display = 'none';
			
		}
		else {
			//projecr or meeting or calendar selected
			//uncheck all parameters & set charts as Line Charts
			document.getElementById('tt_report_parameter_checkall').checked = false;
			document.getElementById('tt_report_parameter_create').checked = false;
			document.getElementById('tt_report_parameter_begin').checked = false;
			document.getElementById('tt_report_parameter_end').checked = false;
			document.getElementById('tt_report_parameter_finish').checked = false;
			document.getElementById('tt_report_parameter_risk').checked = false;
			document.getElementById('tt_report_parameter_progress').checked = false;
			
			document.getElementById('tt_report_chart_line').checked = true;
			
			//disable all 
			document.getElementById('tt_report_parameter_checkall_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_create_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_begin_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_end_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_finish_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_risk_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_progress_sectionid').style.display = 'none';
			
			//able the one belongs 
			document.getElementById('tt_report_parameter_checkall_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_create_sectionid').style.display = 'initial';
			//document.getElementById('tt_report_parameter_begin').style.display = 'initial';
			//document.getElementById('tt_report_parameter_end').style.display = 'initial';
			//document.getElementById('tt_report_parameter_finish').style.display = 'initial';
			//document.getElementById('tt_report_parameter_risk').style.display = 'initial';
			//document.getElementById('tt_report_parameter_progress').style.display = 'initial';
			
			document.getElementById('tt_report_chart_pie_sectionid').style.display = 'none';
			
			document.getElementById('tt_report_parameter_create').checked = true;
			document.getElementById('tt_report_parameter_checkall').checked = true;
			
			document.getElementById('tt_report_chart_line_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_bar_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_column_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_area_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_pie_sectionid').style.display = 'none';
			
			document.getElementById('tt_report_chart_line').checked = true;
			
			document.getElementById('tt_report_special_fiters').style.display = 'initial';
			document.getElementById('tt_report_range_year').checked = true;
			document.getElementById('tt_report_percent_scale').style.display = 'none';
		}
		
		
	}	
	
	function riskType(source){
		if(document.getElementById('tt_report_parameter_risk').checked){
			//document.getElementById('tt_report_parameter_checkall').checked = source.checked;
			//disable all
			//uncheck all parameters & set charts as Line Charts
			//document.getElementById('tt_report_parameter_checkall').checked = false;
			document.getElementById('tt_report_parameter_create').checked = false;
			document.getElementById('tt_report_parameter_begin').checked = false;
			document.getElementById('tt_report_parameter_end').checked = false;
			document.getElementById('tt_report_parameter_finish').checked = false;
			//document.getElementById('tt_report_parameter_risk').checked = false;
			document.getElementById('tt_report_parameter_progress').checked = false;
			
			//document.getElementById('tt_report_chart_line').checked = true;
			
			
			document.getElementById('tt_report_parameter_checkall_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_create_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_begin_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_end_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_finish_sectionid').style.display = 'none';
			//document.getElementById('tt_report_parameter_risk_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_progress_sectionid').style.display = 'none';
			
			//only Pie allowed
			document.getElementById('tt_report_chart_line_sectionid').style.display = 'none';
			document.getElementById('tt_report_chart_bar_sectionid').style.display = 'none';
			document.getElementById('tt_report_chart_column_sectionid').style.display = 'none';
			document.getElementById('tt_report_chart_area_sectionid').style.display = 'none';
			document.getElementById('tt_report_chart_pie_sectionid').style.display = 'initial';
			
			document.getElementById('tt_report_chart_pie').checked = true;
			
			document.getElementById('tt_report_special_fiters').style.display = 'none';
			
		}
		else{
			document.getElementById('tt_report_parameter_checkall').checked = false;
			
			document.getElementById('tt_report_parameter_checkall_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_create_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_begin_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_end_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_finish_sectionid').style.display = 'initial';
			//document.getElementById('tt_report_parameter_risk_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_progress_sectionid').style.display = 'initial';
			
			
			document.getElementById('tt_report_chart_line_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_bar_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_column_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_area_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_pie_sectionid').style.display = 'none';
			
			document.getElementById('tt_report_chart_line').checked = true;
			document.getElementById('tt_report_range_year').checked = true;
			
			document.getElementById('tt_report_special_fiters').style.display = 'initial';
			
			//document.getElementById('tt_report_parameter_checkall').checked = true;
			document.getElementById('tt_report_parameter_create').checked = true;
		}
	}
	
	function progressType(source){
		if(document.getElementById('tt_report_parameter_progress').checked){
			//document.getElementById('tt_report_parameter_checkall').checked = source.checked;
			//disable all
			//uncheck all parameters & set charts as Line Charts
			//document.getElementById('tt_report_parameter_checkall').checked = false;
			document.getElementById('tt_report_parameter_create').checked = false;
			document.getElementById('tt_report_parameter_begin').checked = false;
			document.getElementById('tt_report_parameter_end').checked = false;
			document.getElementById('tt_report_parameter_finish').checked = false;
			document.getElementById('tt_report_parameter_risk').checked = false;
			//document.getElementById('tt_report_parameter_progress').checked = false;
			
			//document.getElementById('tt_report_chart_line').checked = true;
			
			
			document.getElementById('tt_report_parameter_checkall_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_create_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_begin_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_end_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_finish_sectionid').style.display = 'none';
			document.getElementById('tt_report_parameter_risk_sectionid').style.display = 'none';
			//document.getElementById('tt_report_parameter_progress_sectionid').style.display = 'none';
			
			//only Pie allowed
			document.getElementById('tt_report_chart_line_sectionid').style.display = 'none';
			document.getElementById('tt_report_chart_bar_sectionid').style.display = 'none';
			document.getElementById('tt_report_chart_column_sectionid').style.display = 'none';
			document.getElementById('tt_report_chart_area_sectionid').style.display = 'none';
			document.getElementById('tt_report_chart_pie_sectionid').style.display = 'initial';
			
			document.getElementById('tt_report_chart_pie').checked = true;
			
			document.getElementById('tt_report_special_fiters').style.display = 'none';
			document.getElementById('tt_report_percent_scale').style.display = 'initial';
			
		}
		else{
			document.getElementById('tt_report_parameter_checkall').checked = false;
			document.getElementById('tt_report_parameter_checkall_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_create_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_begin_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_end_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_finish_sectionid').style.display = 'initial';
			document.getElementById('tt_report_parameter_risk_sectionid').style.display = 'initial';
			//document.getElementById('tt_report_parameter_progress_sectionid').style.display = 'initial';
			
			document.getElementById('tt_report_chart_line_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_bar_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_column_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_area_sectionid').style.display = 'initial';
			document.getElementById('tt_report_chart_pie_sectionid').style.display = 'none';
			
			document.getElementById('tt_report_chart_line').checked = true;
			document.getElementById('tt_report_range_year').checked = true;
			
			document.getElementById('tt_report_special_fiters').style.display = 'initial';
			
			//document.getElementById('tt_report_parameter_checkall').checked = true;
			document.getElementById('tt_report_parameter_create').checked = true;
			document.getElementById('tt_report_percent_scale').style.display = 'none';
		}
	}
		
	function createType(source){
		if(document.getElementById('tt_report_parameter_create').checked){
			//if(document.getElementById('tt_report_content_project').checked){
			if(document.getElementById('tt_report_content_action').checked) {
				if(document.getElementById('tt_report_parameter_create').checked &&
					document.getElementById('tt_report_parameter_begin').checked &&
					document.getElementById('tt_report_parameter_end').checked &&
					document.getElementById('tt_report_parameter_finish').checked){
						document.getElementById('tt_report_parameter_checkall').checked = true;
					}
			}else{
				document.getElementById('tt_report_parameter_checkall').checked = true;
			}
			
			
			
			
		}else{
			
			document.getElementById('tt_report_parameter_checkall').checked = false;
		}
	}	
	
	function beginType(source){
		if(document.getElementById('tt_report_parameter_begin').checked){
			if(document.getElementById('tt_report_parameter_create').checked &&
				document.getElementById('tt_report_parameter_begin').checked &&
					document.getElementById('tt_report_parameter_end').checked &&
						document.getElementById('tt_report_parameter_finish').checked){
							document.getElementById('tt_report_parameter_checkall').checked = true;
						}
		}
		else{
			document.getElementById('tt_report_parameter_checkall').checked = false;
		}
	}

	function endType(source){
		if(document.getElementById('tt_report_parameter_end').checked){
			if(document.getElementById('tt_report_parameter_create').checked &&
				document.getElementById('tt_report_parameter_begin').checked &&
					document.getElementById('tt_report_parameter_end').checked &&
						document.getElementById('tt_report_parameter_finish').checked){
							document.getElementById('tt_report_parameter_checkall').checked = true;
						}
		}
		else{
			document.getElementById('tt_report_parameter_checkall').checked = false;
		}
	}

	function finishType(source){
		if(document.getElementById('tt_report_parameter_finish').checked){
			if(document.getElementById('tt_report_parameter_create').checked &&
				document.getElementById('tt_report_parameter_begin').checked &&
					document.getElementById('tt_report_parameter_end').checked &&
						document.getElementById('tt_report_parameter_finish').checked){
							document.getElementById('tt_report_parameter_checkall').checked = true;
						}
		}
		else{
			document.getElementById('tt_report_parameter_checkall').checked = false;
		}
		
	}
	
</script>



<?php	
}

?>