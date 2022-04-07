<?php

/**
 * Registers the `wprig/postgrid` block on server.
 *
 * @since 1.1.0
 */

class Yani_Tabs_Block{
	function __construct(){
		add_action('init', [$this,'register_block_el_button'], 100);
	}
	public function register_block_el_button(){
		// Check if the register function exists.
		if (!function_exists('register_block_type')) {
			return;
		}
		register_block_type(
			'wprig/yanitabs',
			array(
				'attributes' => array(
					'uniqueId' => array(
						'type' => 'string',
						'default' => '',
					),
					'textField' => array(
						'type' => 'string',
						'default' => ''
					),
					'navAlignment' => array(
						'type' => 'string',
						'default' => 'left'
					),
					'tabs' => array(
						'type' => 'number',
						'default' => 3
					),
					'tabStyle' => array(
						'type'=> 'string',
						'default'=> 'pills'
					),
					'tabTitles' => [
						'type' => 'array',
						'default' => [
							[ 'title' => 'Tab 1'],
							[ 'title' => 'Tab 2'],
							[ 'title' => 'Tab 3']
						]
					],
					'iconName' => array(
						'type' => 'string',
						'default' => ''
					),
					'iconPosition' => array(
						'type' => 'string',
						'default' => 'left',
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
				'render_callback' => [$this,'render_block_el_button']
			)
		);
	}
	public function render_block_el_button($att){
		$layout 		        = isset($att['layout']) ? $att['layout'] : 3;
		$uniqueId 		        = isset($att['uniqueId']) ? $att['uniqueId'] : '';
		$className 		        = isset($att['className']) ? $att['className'] : '';
		$textField 		        = isset($att['textField']) ? $att['textField'] : '';
		$alignment 		        = isset($att['alignment']) ? $att['alignment'] : [];
		$buttonSize 		    = isset($att['buttonSize']) ? $att['buttonSize'] : "large";
		$buttonColor 		    = isset($att['buttonColor']) ? $att['buttonColor'] : "bg-info white";
		$buttonWidthType 		= isset($att['buttonWidthType']) ? $att['buttonWidthType'] : "auto";
		$iconPosition 		    = isset($att['iconPosition']) ? $att['iconPosition'] : "auto";
		$iconName 		   		= isset($att['iconName']) ? $att['iconName'] : "auto";
		$animation 		   		= isset($att['animation']) ? $att['animation'] : [];
		$url 				    = isset($att['url']) ? $att['url']['url'] : "#";
		$html = [];
		
		if(!empty($animation)){
			$html =  "<div class='".$classname."' id='yani-btn-".$uniqueId ."' data-yani-animation='".json_encode($animation)."'>";	
		}else{
			$html =  "<div class='".$classname."' id='yani-btn-".$uniqueId ."'>";
		}
			$html .= "<div class='yani-btn-wrapper  yani-btn-wrapper--".$alignment['md']."'>";			
				$html .= "<a href = '".$url."' class='yani-btn yani-btn--".$buttonSize." ".$buttonColor." yani-btn--".$buttonWidthType."'>";
				if($iconPosition=="left"){
					$html .= "<i class='yani-btn-icon ".$iconName."'></i>";
				}
				$html .=$textField;
				if($iconPosition=="right"){
					$html .= "<i class='yani-btn-icon ".$iconName."'></i>";
				}
				$html .= "</a>";
		$html .= "</div>";
		$html .= "</div>";
		return $html;
	}
}

new Yani_Tabs_Block();






