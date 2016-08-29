<?php
class tt_init {
    static function tt_activate() {
		//add custom pages when the plguin is activated
		$tt_page = array(
			'post_title'    => 'login',
			'post_content'  => '[tt_sc_login_form]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		$tt_page_id = wp_insert_post( $tt_page );
		
		update_option( 'page_on_front', $tt_page_id);
		update_option( 'show_on_front', 'page' );
		
		$tt_page = array(
			'post_title'    => 'setting',
			'post_content'  => '[tt_sc_setting]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'report',
			'post_content'  => '[tt_sc_report]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'action',
			'post_content'  => '[tt_sc_action]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'project',
			'post_content'  => '[tt_sc_project]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'calendar',
			'post_content'  => '[tt_sc_calendar]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'meeting',
			'post_content'  => '[tt_sc_meeting]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'forgetpassword',
			'post_content'  => '[tt_sc_forgetpassword]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'register',
			'post_content'  => '[tt_sc_register]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'register_details',
			'post_content'  => '[tt_sc_register_details]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'project_details',
			'post_content'  => '[tt_sc_project_details]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'meeting_details',
			'post_content'  => '[tt_sc_meeting_details]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'calendar_details',
			'post_content'  => '[tt_sc_calendar_details]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		$tt_page = array(
			'post_title'    => 'changepassword',
			'post_content'  => '[tt_sc_changepassword]',
			'post_type' => 'page',
			'post_status'   => 'publish'
		);
		wp_insert_post( $tt_page );
		
		//create custom tables 
		global $wpdb;
		/* tt_user */
		$tablename = $wpdb->prefix.'tt_user';
		$charset_collate = $wpdb->get_charset_collate();		
		$sql = "CREATE TABLE $tablename (
			`username` varchar(45) NOT NULL,
			`password_md5` varchar(45) DEFAULT NULL,
			`username_password_md5` varchar(45) DEFAULT NULL,
			`firstname` varchar(45) DEFAULT NULL,
			`lastname` varchar(45) DEFAULT NULL, 
			`email` varchar(45) DEFAULT NULL,
			`phone` varchar(45) DEFAULT NULL,
			`login_count` int(11) DEFAULT NULL,
			PRIMARY KEY (`username`)
		)$charset_collate;";		
		$wpdb->query($sql);
		
		/* tt_action */
		$tablename = $wpdb->prefix.'tt_action';
		$sql = "CREATE TABLE $tablename (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`description` varchar(45) DEFAULT NULL,
			`creator` varchar(45) DEFAULT NULL,
			`action_name` varchar(45) DEFAULT NULL,
			`begin_time` datetime DEFAULT NULL,
			`end_time` datetime DEFAULT NULL,
			`real_finish_time` datetime DEFAULT NULL,
			`create_time` datetime DEFAULT NULL,
			`location` varchar(45) DEFAULT NULL,
			`risk` varchar(45) DEFAULT NULL,
			`progress` int(11) DEFAULT '0',
			`prerequisite_task_id` int(11) DEFAULT NULL,
			`parent_project_id` int(11) DEFAULT NULL,
			PRIMARY KEY (`id`)
		)$charset_collate;";		
		$wpdb->query($sql);
		
		/* tt_project*/
		$tablename = $wpdb->prefix.'tt_project';
		$sql = "CREATE TABLE $tablename (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`description` varchar(45) DEFAULT NULL,
			`creator` varchar(45) DEFAULT NULL,
			`create_time` datetime DEFAULT NULL,
			`project_name` varchar(45) DEFAULT NULL,
			`parent_project_id` int(11) DEFAULT NULL,
			PRIMARY KEY (`id`)
		)$charset_collate;";		
		$wpdb->query($sql);
		
		/* tt_meeting*/
		$tablename = $wpdb->prefix.'tt_meeting';
		$sql = "CREATE TABLE $tablename (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`note` varchar(256) DEFAULT NULL,
			`time` datetime DEFAULT NULL,
			`topic` varchar(45) DEFAULT NULL,
			`creator` varchar(45) DEFAULT NULL,
			PRIMARY KEY (`id`)
		)$charset_collate;";		
		$wpdb->query($sql);
		
		/* tt_calendar*/
		$tablename = $wpdb->prefix.'tt_calendar';
		$sql = "CREATE TABLE $tablename (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`note` varchar(256) DEFAULT NULL,
			`time` datetime DEFAULT NULL,
			`topic` varchar(45) DEFAULT NULL,
			`creator` varchar(45) DEFAULT NULL,
			PRIMARY KEY (`id`)
		)$charset_collate;";		
		$wpdb->query($sql);
		
		
		/* tt_configuration */
		$tablename = $wpdb->prefix.'tt_configuration';
		$sql = "CREATE TABLE $tablename (
			`key` varchar(45) NOT NULL,
			`value` varchar(45) DEFAULT NULL,
			`creator` varchar(45) DEFAULT NULL,
			PRIMARY KEY (`key`,`creator`)
		)$charset_collate;";		
		$wpdb->query($sql);
    }
	
	static function tt_deactivate() {
		//delete all custom pages
		$tt_page = get_page_by_title('login');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('setting');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('report');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('action');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('project');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('calendar');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('meeting');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('forgetpassword');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('register');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('register_details');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('project_details');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('meeting_details');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('calendar_details');
		wp_delete_post($tt_page->ID, true);
		
		$tt_page = get_page_by_title('changepassword');
		wp_delete_post($tt_page->ID, true);
		
		//delete all custom tables
		global $wpdb;
		$tablename = $wpdb->prefix.'tt_user';
		$wpdb->query( "DROP TABLE IF EXISTS $tablename" );
		
		$tablename = $wpdb->prefix.'tt_configuration';
		$wpdb->query( "DROP TABLE IF EXISTS $tablename" );
		
		$tablename = $wpdb->prefix.'tt_action';
		$wpdb->query( "DROP TABLE IF EXISTS $tablename" );
		
		$tablename = $wpdb->prefix.'tt_project';
		$wpdb->query( "DROP TABLE IF EXISTS $tablename" );
		
		$tablename = $wpdb->prefix.'tt_meeting';
		$wpdb->query( "DROP TABLE IF EXISTS $tablename" );
		
		$tablename = $wpdb->prefix.'tt_calendar';
		$wpdb->query( "DROP TABLE IF EXISTS $tablename" );
	}
	
	static function tt_uninstall() {

	}
}



?>