<?php 
    /*
    Plugin Name: Lists
    Plugin URI: daler445@gmail.com
    Description: Make lists from posts
    Author: Azimov Daler
    Version: 1.0
    Author URI: http://epic.tj
    */
    function oscimp_admin() {
    	include('unm.php');
	}
    function oscimp_admin_settings() {
        include('unm_set.php');
    }
    function oscimp_admin_setme() {
        include('unm_arr.php');
    }
    function oscimp_admin_li() {
        include('unm_li.php');
    }
    function oscimp_admin_show() {
        include('unm_show.php');
    }

    function osimp_get_list($id) {
        if ($id==null) {
            die();
        }
        else {
            global $wpdb;
            $table_name = $wpdb->prefix . "adlists";
            $retrieve_data_l = $wpdb->get_results( "SELECT post_num FROM $table_name WHERE id=$id" );
            $postnum = $retrieve_data_l[0]->post_num;
                $vals = array();
            for ($i = 1;$i<=$postnum;$i++) {
                //$template = $id.".".$postnum.".".$i;
                $template = "val-".$id."-".$i;
                array_push($vals, get_option($template));
                //get_option($postnum);    
            }
            return $vals;
            
        }
    }

    function oscimp_admin_actions() {
    	//add_options_page("Lists", "Lists", 1, "Lists", "oscimp_admin");
      //add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
        add_menu_page('Списки', 'Списки', '1', 'adlists', 'oscimp_admin');
      //add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
        add_submenu_page('adlists', 'Все списки', 'Все списки', '1', 'adlists_li', 'oscimp_admin_li');
        add_submenu_page('adlists', 'Посмотреть', 'Посмотреть', '1', 'adlists_show', 'oscimp_admin_show');
        add_submenu_page('adlists', 'Настройки', 'Настройки', '1', 'adlists_set', 'oscimp_admin_settings');
        add_submenu_page('adlists', 'Установка', 'Установка', '1', 'adlists_arr', 'oscimp_admin_setme');
	}
	add_action('admin_menu', 'oscimp_admin_actions');
?>