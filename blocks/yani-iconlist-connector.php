<?php

/**
 * Registers the `wprig/postgrid` block on server.
 *
 * @since 1.1.0
 */

class Yani_IconList_Connector_Block{
	function __construct(){
		add_action('init', [$this,'register_block_el_button'], 100);
	}
	public function register_block_el_button(){
		// Check if the register function exists.
		if (!function_exists('register_block_type')) {
			return;
		}
		register_block_type(
			'wprig/eliconlist-connector',
			array(
				'attributes' => array(
					'uniqueId' => array(
						'type' => 'string',
						'default' => '',
					),
					'listStyle' => array(
						'type' => 'string',
						'default' => 'ordered',
					),
					'ordered' => array(
						'type' => 'boolean',
						'default' => false
					),
					'style' => array(
						'type' => 'string',
						'default' => ''
					),
					'alignment' => array(
						'type' => 'string',
						'default' => 'left'
					),
					'layout' => array(
						'type' => 'string',
						'default' => 'classic',
					),
					'listItems' => array(
						'type' => 'array',
						'default' => [
							['icon' => 'far fa-star',
							'text' => 'Add beautiful icons and text'],
							['icon' => 'far fa-heart',
							'text' => 'Set icon color for normal and hover state'],
							['icon' => 'fas fa-check',
							'text' => 'Add beautiful icons and text'],
							['icon' => 'fas fa-burn',
							'text' => 'Choose a desired layout from the list'],
						],
					),
					'iconPosition' => array(
						'type' => 'string',
						'default' => 'left',
					),
					'iconColor' => array(
						'type' => 'string',
						'default' => 'primary'
					),


					'textField' => array(
						'type' => 'string',
						'default' => ''
					),
					'textFieldColor' => array(
						'type' => 'string',
						'default' => ''
					),
					'iconName' => array(
						'type' => 'string',
						'default' => ''
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
	public function renderListItems($listItems,$iconPosition,$iconColor,$textFieldColor){
		$html = "";
		if(!empty($listItems)){
			foreach($listItems as $index => $items){
				$html .= "<li class='yani-list-li'>";
					$html .= "<div class='yani-list-item yani-list-item-".$index."'>";
						if($iconPosition=="left"){
							$html .= "<span class='yani-list-item-icon ".$items['icon']." ".$iconColor."'></span>";
						}
						$html .= "<div class='yani-list-item-text ".$textFieldColor."' id='yani-list-item-text-".$index."'>";
						$html .= $items["text"];
						$html .= "</div>";
						if($iconPosition=="right"){
							$html .= "<span class='yani-list-item-icon ".$items['icon']." ".$iconColor."'></span>";
						}
					$html .= "</div>";
				$html .= "</li>";
			}
		}
		return $html;
	}
	public function render_block_el_button($att){
		$layout 		        = isset($att['layout']) ? $att['layout'] : 3;
		$uniqueId 		        = isset($att['uniqueId']) ? $att['uniqueId'] : '';
		$className 		        = isset($att['className']) ? $att['className'] : '';
		$textField 		        = isset($att['textField']) ? $att['textField'] : '';
		$listItems 		        = isset($att['listItems']) ? $att['listItems'] : [];
		$iconColor 		        = isset($att['iconColor']) ? $att['iconColor'] : '';
		$textFieldColor 		= isset($att['textFieldColor']) ? $att['textFieldColor'] : '';
		$iconPosition 			= isset($att['iconPosition']) ? $att['iconPosition'] : '';
		$alignment 		        = isset($att['alignment']) ? $att['alignment'] : [];
		$style 		        	= isset($att['style']) ? $att['style'] : "";
		$buttonSize 		    = isset($att['buttonSize']) ? $att['buttonSize'] : "large";
		$buttonColor 		    = isset($att['buttonColor']) ? $att['buttonColor'] : "bg-info white";
		$buttonWidthType 		= isset($att['buttonWidthType']) ? $att['buttonWidthType'] : "auto";
		$iconPosition 		    = isset($att['iconPosition']) ? $att['iconPosition'] : "auto";
		$iconName 		   		= isset($att['iconName']) ? $att['iconName'] : "auto";
		$animation 		   		= isset($att['animation']) ? $att['animation'] : [];
		$url 				    = isset($att['url']) ? $att['url']['url'] : "#";
		$html = [];
		
		if(!empty($animation)){
			$html =  "<div class='".$classname."' id='yani-block-".$uniqueId ."' data-yani-animation='".json_encode($animation)."'>";	
		}else{
			$html =  "<div class='".$classname."' id='yani-block-".$uniqueId ."'>";
		}
				$html .= "<div class='yani-block-icon-list'>";		
					$html .= "<ul class='yani-list yani-icon-list-connector ".$style."'>";		
						$html .= $this->renderListItems($listItems,$iconPosition,$iconColor,$textFieldColor);
					$html .= "</ul>";
				$html .= "</div>";
			$html .= "</div>";
		return $html;
	}
}

new Yani_IconList_Connector_Block();






