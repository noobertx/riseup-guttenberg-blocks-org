<?php

/**
 * Registers the `wprig/postgrid` block on server.
 *
 * @since 1.1.0
 */

class Yani_CountDown{
	function __construct(){
		add_action('init', [$this,'register_custom_block'], 100);
	}
	public function register_custom_block(){
		// Check if the register function exists.
		if (!function_exists('register_block_type')) {
			return;
		}
		register_block_type(
			'wprig/yanicountdown',
			array(
				'attributes' => array(
					'uniqueId' => array(
						'type' => 'string',
						'default' => '',
					),
					'layout' => array(
						'type' => 'string',
						'default' => 'bottom',
					),
					'style' => array(
						'type' => 'string',
						'default' => 'style-1',
					),
					'itemColor' => array(
						'type' => 'string',
						'default' => 'bg-info white',
					),
					'justify' => array(
						'type' => 'string',
						'default' => 'space-around',
					),
					'untilDate' => array(
						'type' => 'string',
						'default' => date("F j, Y H:i:s"),
					),
					'isInverted' => array(
						'type' => 'boolean',
						'default' => false
					),
					'displayYear' => array(
						'type' => 'boolean',
						'default' => true
					),
					'displayMonth' => array(
						'type' => 'boolean',
						'default' => true
					),
					'displayDay' => array(
						'type' => 'boolean',
						'default' => true
					),
					'displayHour' => array(
						'type' => 'boolean',
						'default' => true
					),
					'displayMinute' => array(
						'type' => 'boolean',
						'default' => true
					),
					'displaySeconds' => array(
						'type' => 'boolean',
						'default' => true
					),
					'yearLabel' => array(
						'type' => 'string',
						'default' => 'year',
					),
					'monthLabel' => array(
						'type' => 'string',
						'default' => 'month',
					),
					'dayLabel' => array(
						'type' => 'string',
						'default' => 'day',
					),
					'hourLabel' => array(
						'type' => 'string',
						'default' => 'hour',
					),
					'minuteLabel' => array(
						'type' => 'string',
						'default' => 'minute',
					),
					'secondsLabel' => array(
						'type' => 'string',
						'default' => 'second',
					),
					'recreateStyles' => array(
						'type' => 'boolean',
						'default' => true
					),
					'interaction' => array(
						'type' => 'object',
						'default' => array(),
					),
					'animation' => array(
						'type' => 'object',
						'default' =>  array(),
					),
					'globalZindex' => array(
						'type' => 'string',
						'default' => '0',
						'style' => [(object) ['selector' => '{{WPRIG}} {z-index:{{globalZindex}};}']]
					),
					'hideTablet' => array(
						'type' => 'boolean',
						'default' => false,
						'style' => [(object) ['selector' => '{{wprig}}{display:none;}']]
					),
					'hideMobile' => array(
						'type' => 'boolean',
						'default' => false,
						'style' => [(object) ['selector' => '{{wprig}}{display:none;}']]
					),
					'globalCss' => array(
						'type' => 'string',
						'default' => '',
						'style' => [(object) ['selector' => '']]
					),
				),
				'render_callback' => [$this,'render_custom_block']
			)
		);
	}
	public function render_custom_block($att){
		$layout 		        = isset($att['layout']) ? $att['layout'] : 3;
		$uniqueId 		        = isset($att['uniqueId']) ? $att['uniqueId'] : '';
		$className 		        = isset($att['className']) ? $att['className'] : '';
		$textField 		        = isset($att['textField']) ? $att['textField'] : '';
		$alignment 		        = isset($att['alignment']) ? $att['alignment'] : [];
		$style 		        	= isset($att['style']) ? $att['style'] : "style-1";
		$justify 		        = isset($att['justify']) ? $att['justify'] : "space-between";
		$untilDate 		        = isset($att['untilDate']) ? $att['untilDate'] : new Date();
		$layout 		        = isset($att['layout']) ? $att['layout'] : "top";

		$displayYear 		        = isset($att['displayYear']) ? $att['displayYear'] : false;
		$displayMonth 		        = isset($att['displayMonth']) ? $att['displayMonth'] : false;
		$displayDay 		        = isset($att['displayDay']) ? $att['displayDay'] : false;
		$displayHour 		        = isset($att['displayHour']) ? $att['displayHour'] : false;
		$displayMinute 		        = isset($att['displayMinute']) ? $att['displayMinute'] : false;
		$displaySeconds 		    = isset($att['displaySeconds']) ? $att['displaySeconds'] : false;

		$yearLabel 		        = isset($att['yearLabel']) ? $att['yearLabel'] : "";
		$monthLabel 		    = isset($att['monthLabel']) ? $att['monthLabel'] : "";
		$dayLabel 		        = isset($att['dayLabel']) ? $att['dayLabel'] : "";
		$hourLabel 		        = isset($att['hourLabel']) ? $att['hourLabel'] : "";
		$minuteLabel 		    = isset($att['minuteLabel']) ? $att['minuteLabel'] : "";
		$secondsLabel 		    = isset($att['secondsLabel']) ? $att['secondsLabel'] : "";

		$itemColor 		   		= isset($att['itemColor']) ? $att['itemColor'] : false;
		$isInverted 		   	= isset($att['isInverted']) ? $att['isInverted'] : false;


		$html = [];

		$mainClass = "";

		// dformat dLayout
		$dformat = "";
        // $dformat.= ($displayYear) ? "Y" : "";
        // $dformat.= ($displayMonth) ? "O" : "";
        // $dformat.= ($displayDay) ? "D" : "";
        // $dformat.= ($displayHour) ? "H" : "";
        // $dformat.= ($displayMinute) ? "M" : "";
        // $dformat.= ($displaySeconds) ? "S" : "";
        
		$dlabels = "";		
        // $dlabels .= intval($yearLabel)+"/";
        // $dlabels .= intval($monthLabel)+"/";
        // $dlabels .= intval($dayLabel)+"/";
        // $dlabels .= intval($hourLabel)+"/";
        // $dlabels .= intval($minuteLabel)+"/";
        // $dlabels .= intval($secondsLabel)+"/";


		$titleTagName = "h".$titleLevel;

		if(!empty($animation)){
			$html =  "<div class='".$classname."' id='yani-block-".$uniqueId ."' data-yani-animation='".json_encode($animation)."'>";	
		}else{
			$html =  "<div class='".$classname."' id='yani-block-".$uniqueId ."'>";
		}
			$html .= "<div class='yani-countdown-wrapper  yani-countdown-".$style."'>";
				$html .= "<div class='countdown__content  yani-countdown-".$style."' data-format='".$dformat."' data-labels='".$dlabels."' data-layout='".$layout."'>";
					
				$html .= "</div>";
			$html .= "</div>";
			$html .= "</div>";
		return $html;
	}
}

new Yani_CountDown();






