<?php

/**
 * Registers the `wprig/postgrid` block on server.
 *
 * @since 1.1.0
 */

class Yani_Infobox_Block{
	function __construct(){
		add_action('init', [$this,'register_block_el_button'], 100);
	}
	public function register_block_el_button(){
		// Check if the register function exists.
		if (!function_exists('register_block_type')) {
			return;
		}
		register_block_type(
			'wprig/yaniinfobox',
			array(
				'attributes' => array(
					'uniqueId' => array(
						'type' => 'string',
						'default' => '',
					),
					'layout' => array(
						'type' => 'number',
						'default' => 1
					),
					'alignment' => array(
						'type' => 'string',
						'default' => 'left',
					),
					'mediaType' => array(
						'type' => 'string',
						'default' => 'icon',
					),
					'enableButton' => array(
						'type' => 'boolean',
						'default' => true
					),
					'iconName' => array(
						'type' => 'string',
						'default' => ''
					),
					'style' => array(
						'type' => 'string',
						'default' => 'style-1'
					),

					'image' => array(
						'type' => 'object',
						'default' => []
					),
					'imageType' => array(
						'type' => 'string',
						'default' => 'local'
					),
					'externalImageUrl' => array(
						'type' => 'object',
						'default' => []
					),
					'image2x' => array(
						'type' => 'object',
						'default' => []
					),
					'imageUrl' => array(
						'type' => 'object',
						'default' => []
					),
					'imgAlt' => array(
						'type' => 'string',
						'default' => ''
					),
					'number' => array(
						'type' => 'number',
						'default' => 1
					),

					'enableTitle' => array(
						'type' => 'boolean',
						'default' => true
					),

					'title' => array(
						'type' => 'string',
						'default' => 'Product Title'
					),
					'titleLevel' => array(
						'type' => 'number',
						'default' => 2
					),
					'titleColor' => array(
						'type' => 'string',
						'default' => 'primary'
					),
					

					
					
					'enableSubTitle' => array(
						'type' => 'boolean',
						'default' => true
					),

						'subTitleContent' => array(
						'type' => 'string',
						'default' => 'Product Sub Title'
					),
					'subTitleLevel' => array(
						'type' => 'number',
						'default' => 3
					),
					'subTitleColor' => array(
						'type' => 'string',
						'default' => 'secondary'
					),
					'enableContent' => array(
						'type' => 'boolean',
						'default' => false
					),
					
					'textfield' => array(
						'type' => 'string',
						'default' => ''
					),
					'textfieldColor' => array(
						'type' => 'string',
						'default' => 'dark'
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
		$mediaType 		        = isset($att['mediaType']) ? $att['mediaType'] : 'icon';
		$iconName 		   		= isset($att['iconName']) ? $att['iconName'] : "auto";
		$imageType 		   		= isset($att['imageType']) ? $att['imageType'] : "local";
		$image 		   			= isset($att['image']) ? $att['image'] : [];
		$externalImageUrl 		= isset($att['externalImageUrl']) ? $att['externalImageUrl'] : [];
		$number 				= isset($att['number']) ? $att['number'] : 0;

		$enableTitle 				= isset($att['enableTitle']) ? $att['enableTitle'] : false;
		$title 						= isset($att['title']) ? $att['title'] : "";
		$titleColor 				= isset($att['titleColor']) ? $att['titleColor'] : "primary";
		$titleLevel 				= isset($att['titleLevel']) ? $att['titleLevel'] : 2;

		$enableSubTitle 			= isset($att['enableSubTitle']) ? $att['enableSubTitle'] : false;
		$subTitleContent 			= isset($att['subTitleContent']) ? $att['subTitleContent'] : "";
		$subTitleColor 				= isset($att['subTitleColor']) ? $att['subTitleColor'] : "secondary";
		$subTitleLevel 				= isset($att['subTitleLevel']) ? $att['subTitleLevel'] : 3;
		
		$textfield 					= isset($att['textfield']) ? $att['textfield'] : "";
		$textfieldColor 			= isset($att['textfieldColor']) ? $att['textfieldColor'] : "";

		$alignment 		        = isset($att['alignment']) ? $att['alignment'] : [];
		$buttonSize 		    = isset($att['buttonSize']) ? $att['buttonSize'] : "large";
		$buttonColor 		    = isset($att['buttonColor']) ? $att['buttonColor'] : "bg-info white";
		$buttonWidthType 		= isset($att['buttonWidthType']) ? $att['buttonWidthType'] : "auto";
		$iconPosition 		    = isset($att['iconPosition']) ? $att['iconPosition'] : "auto";
		$animation 		   		= isset($att['animation']) ? $att['animation'] : [];
		$url 				    = isset($att['url']) ? $att['url']['url'] : "#";
		$html = [];
		

		$titleTagName = 'h' . $titleLevel;
        $subTitleTagName = 'h' . $subTitleLevel;

		if(!empty($animation)){
			$html =  "<div class='".$classname."' id='yani-infobox-".$uniqueId ."' data-yani-animation='".json_encode($animation)."'>";	
		}else{
			$html =  "<div class='".$classname."' id='yani-infobox-".$uniqueId ."'>";
		}
			$html .= "<div class='yani-block-info-box  yani-info-box-layout-".$layout."'>";			

			if($layout!=4 ){
				if($mediaType!="image"){
					$html .="<div class='yani-info-box-media yani-media-has-bg'>";
				}else{
					$html .="<div class='yani-info-box-media'>";
				}
				if($mediaType=="icon"){
					$html .= "<i class='yani-info-box-icon ".$iconName."'></i>";
				}else if($mediaType=="image"){
					if($imageType=="local" && isset($image["url"])){
						$html .= "<img class='yani-info-box-image' src='".$image['url']."'/>";						
					}else if($imageType=="external" && isset($externalImageUrl["url"])){
						$html .= "<img class='yani-info-box-image' src='".$externalImageUrl['url']."' />";						
					}
				}else if($mediaType=="number"){
					$html .= "<div class='yani-info-box-number '>".$number."</div>";
				}
				$html .= "</div>";
			}
			
			$html .= "<div class='yani-info-box-body'>";
				$html .= "<div class='yani-info-box-title-container'>";
				if($enableTitle){
					$html .= "<div class='yani-info-box-title-inner'>";
						$html .= "<".$titleTagName." class='yani-info-box-title text-".$alignment." ".$titleColor."'>";
							$html .= $title;
						$html .= "</".$titleTagName.">";
					$html .= "</div>";
				}
				if($enableSubTitle){
					$html .= "<div class='yani-info-box-title-inner'>";
						$html .= "<".$subTitleTagName." class='yani-info-box-sub-title text-".$alignment." ".$subTitleColor."'>";
							$html .= $subTitleContent;
							$html .= "</".$subTitleTagName.">";
							$html .= "</div>";
						}
				$html .= "</div>";
				$html .= "<div class='yani-info-box-content'>";
					$html .= "<div class='yani-info-box-text text-".$alignment." ".$textfieldColor."'>";
						$html .= $textfield;
					$html .= "</div>";
				$html .= "</div>";
			$html .= "</div>";


			
		$html .= "</div>";
		$html .= "</div>";
		return $html;
	}
}

new Yani_Infobox_Block();






