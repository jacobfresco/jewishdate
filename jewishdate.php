<?php
/**

 * JewishDate 0.7
 *
 * @package           JewishDate
 * @author            Jacob Fresco
 * @copyright         2019 Jacob Fresco
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       JewishDate
 * Plugin URI:        https://github.com/jacobfresco/jewishdate
 * Description:       A plugin that provides Hebrew dates in Wordpress (both fonetic and Hebrew (r-t-l). Includes a two widgets for dynamic sidebars. The idea for this plugin came from the wonderfull Hebrew Date-plugin by KosherJava. Unfortunately, that plugin didn't have the possibility to display the current date in Hebrew i.e. in the sidebar.
 * Version:           0.6
 * Requires PHP:      5.3
 * Author:            Jacob Fresco
 * Author URI:        https://jacobfresco.nl
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt


*/

	date_default_timezone_set(get_option('timezone_string'));

	function JewishDateNS() {

		$gregorianMonth = date(n);
		$gregorianDay = date(j);
		$gregorianYear = date(Y);

		$jdDate = gregoriantojd($gregorianMonth,$gregorianDay,$gregorianYear);

		$hebrewMonthName = jdmonthname($jdDate,4);

		$hebrewDate = jdtojewish($jdDate);

		list($hebrewMonth, $hebrewDay, $hebrewYear) = explode('/',$hebrewDate);
	 
		if (($hebrewMonthName == "AdarI") || ($hebrewMonthName == "AdarII")) {
		  $hebrewMonthName = "Adar";
		}
		
		return "$hebrewDay $hebrewMonthName $hebrewYear";
	}

	function JewishDateHebrew() {

		$gregorianMonth = date(n);
		$gregorianDay = date(j);
		$gregorianYear = date(Y);

		$jdDate = gregoriantojd($gregorianMonth,$gregorianDay,$gregorianYear);

		$hebrewdate = jdtojewish($jdDate, true, CAL_JEWISH_ADD_GERESHAYIM + CAL_JEWISH_ADD_ALAFIM + CAL_JEWISH_ADD_ALAFIM_GERESH); 
		$hebrewdate = iconv ('WINDOWS-1255', 'UTF-8', $hebrewdate); 
			
		return "<p style='text-align: right;'>" .$hebrewdate ."</p>";
	}

	class JewishDate extends WP_Widget {
		function JewishDate()
		{
			$widget_ops = array('classname' => 'WP_JewishDate', 'description' => 'Toon de huidige datum, omgerekend naar de joodse kalender');
			$this->WP_Widget('JewishDate', 'JewishDate', $widget_ops);
		}
	  
	 
		function form($instance)
		{
			$instance = wp_parse_args((array) $instance, array( 'title'));
			$title = $instance['title'];
		
			?>
				<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>	
			<?php
		}
	  
		function update($new_instance, $old_instance)
		{
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			return $instance;
		}
	  
		function widget($args, $instance)
		{
			extract($args, EXTR_SKIP);
		
			$complete_widget = "";
			
			$complete_widget .= $before_widget;
			
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
	 
			if (!empty($title)) {
				echo $before_title . $title . $after_title;
			}
		
			$gregorianMonth = date(n);
			$gregorianDay = date(j);
			$gregorianYear = date(Y);

			$jdDate = gregoriantojd($gregorianMonth,$gregorianDay,$gregorianYear);

			$hebrewMonthName = jdmonthname($jdDate,4);

			$hebrewDate = jdtojewish($jdDate);

			list($hebrewMonth, $hebrewDay, $hebrewYear) = explode('/',$hebrewDate);
	 
			if (($hebrewMonthName == "AdarI") || ($hebrewMonthName == "AdarII")) {
				$hebrewMonthName = "Adar";
			}
		
			$complete_widget .= $hebrewDay ." " .$hebrewMonthName ." ".$hebrewYear;
			$complete_widget .= $after_widget;
			
			echo  $complete_widget;
		}
	}

	class HebrewDate extends WP_Widget {
		function HebrewDate()
		{
			$widget_ops = array('classname' => 'WP_hebrewDate', 'description' => 'Toon de huidige datum in het Hebreeuws, omgerekend naar de joodse kalender');
			$this->WP_Widget('HebrewDate', 'HebrewDate', $widget_ops);
		}
	   
		function form($instance)
		{
			$instance = wp_parse_args((array) $instance, array( 'title'));
			$title = $instance['title'];
		
			?>
				<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>	
			<?php
		}
	  
		function update($new_instance, $old_instance)
		{
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			return $instance;
		}
	  
		function widget($args, $instance)
		{
			extract($args, EXTR_SKIP);
	 
			$complete_widget = "";
			
			$complete_widget .= $before_widget;
			
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
	 
			if (!empty($title)) {
				echo $before_title . $title . $after_title;
			}
		
			$gregorianMonth = date(n);
			$gregorianDay = date(j);
			$gregorianYear = date(Y);

			$jdDate = gregoriantojd($gregorianMonth,$gregorianDay,$gregorianYear);

			$hebrewdate = jdtojewish($jdDate, true, CAL_JEWISH_ADD_GERESHAYIM + CAL_JEWISH_ADD_ALAFIM + CAL_JEWISH_ADD_ALAFIM_GERESH); 
			$hebrewdate = iconv ('WINDOWS-1255', 'UTF-8', $hebrewdate); 
			
			$complete_widget .= "<p style='text-align: right;'>" .$hebrewdate ."</p>";
		
			$complete_widget .= $after_widget;
			
			echo $complete_widget;
		}
	}

	add_action( 'widgets_init', create_function('', 'return register_widget("JewishDate");') );
	add_action( 'widgets_init', create_function('', 'return register_widget("HebrewDate");') );
	
?>