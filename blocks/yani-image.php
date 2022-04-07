<?php

/**
 * Registers the `wprig/postgrid` block on server.
 *
 * @since 1.1.0
 */

class Yani_Image_Block{
	function __construct(){
		add_action('init', [$this,'register_custom_block'], 100);
	}
	public function register_custom_block(){
		// Check if the register function exists.
		if (!function_exists('register_block_type')) {
			return;
		}
		register_block_type(
			'wprig/elimage',
			array(
				'attributes' => array(
					'uniqueId' => array(
						'type' => 'string',
						'default' => '',
					),
					'layout' => array(
						'type' => 'string',
						'default' => 'simple'
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

					'enableCaption' => array(
						'type' => 'boolean',
						'default' => false
					),
					'caption' => array(
						'type' => 'string',
						'default' => 'Image Caption'
					),
					'enableTitle' => array(
						'type' => 'boolean',
						'default' => false
					),
					'title' => array(
						'type' => 'string',
						'default' => 'Image Block'
					),
					'titleLevel' => array(
						'type' => 'number',
						'default' => 3
					),

					'enableSubtitle' => array(
						'type' => 'boolean',
						'default' => false
					),
					'animateOnHover' => array(
						'type' => 'boolean',
						'default' => false
					),	  
					'titleVisibleOnHover' => array(
						'type' => 'boolean',
						'default' => false
					),	
					'subTitleVisibleOnHover' => array(
						'type' => 'boolean',
						'default' => false
					),	
					'frameAnimateOnHover' => array(
						'type' => 'boolean',
						'default' => false
					),			 //
					'enableOverlay' => array(
						'type' => 'boolean',
						'default' => false
					),
					'enableFrame' => array(
						'type' => 'boolean',
						'default' => false
					),
					'subtitle' => array(
						'type' => 'string',
						'default' => 'Image Subtitle'
					),

					'contentAnimation' => array(
						'type' => 'string',
						'default' => 'zoom-out'
					),			

					'titleColor' => array(
						'type' => 'string',
						'default' => 'primary'
					),
					'subTitleColor' => array(
						'type' => 'string',
						'default' => 'secondary'
					),
					'captionColor' => array(
						'type' => 'string',
						'default' => 'dark'
					),
					'alignment' => array(
						'type' => 'string',
						'default' => 'center',
					),
					'contentAlignment' => array(
						'type' => 'string',
						'default' => 'center',
					),
					'contentVerticalAlign' => array(
						'type' => 'string',
						'default' => 'center',
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

		$enableLeftSeparator 	= isset($att['enableLeftSeparator']) ? $att['enableLeftSeparator'] : false;
		$enableRightSeparator 	= isset($att['enableRightSeparator']) ? $att['enableRightSeparator'] : false;
		$separatorNumbers 		= isset($att['separatorNumbers']) ? $att['separatorNumbers'] : 1;
		$separatorStyle 		= isset($att['separatorStyle']) ? $att['separatorStyle'] : "style-1";
		$mainColor 		    	= isset($att['mainColor']) ? $att['mainColor'] : "bg-info white";

		$iconName 		   		= isset($att['iconName']) ? $att['iconName'] : "auto";
		$contentAnimation 		= isset($att['contentAnimation']) ? $att['contentAnimation'] : false;
		$contentVerticalAlign 	= isset($att['contentVerticalAlign']) ? $att['contentVerticalAlign'] : "center";
		$contentAlignment 		= isset($att['contentAlignment']) ? $att['contentAlignment'] : "center";
		$enableFrame 			= isset($att['enableFrame']) ? $att['enableFrame'] : false;
		$animateOnHover 		= isset($att['animateOnHover']) ? $att['animateOnHover'] : false;
		$frameAnimateOnHover 	= isset($att['frameAnimateOnHover']) ? $att['frameAnimateOnHover'] : false;
		$animation 		   		= isset($att['animation']) ? $att['animation'] : [];

		$image	 		   		= isset($att['image']) ? $att['image'] : [];
		$imgAlt 		   		= isset($att['imgAlt']) ? $att['imgAlt'] : "";

		$titleLevel 		   	= isset($att['titleLevel']) ? $att['titleLevel'] : 3;
		$title		 		   	= isset($att['title']) ? $att['title'] : "";

		$enableSubtitle 	   	= isset($att['enableSubtitle']) ? $att['enableSubtitle'] : false;
		$subtitle 	   			= isset($att['subtitle']) ? $att['subtitle'] : "";

		$enableCaption	 	   	= isset($att['enableCaption']) ? $att['enableCaption'] : false;
		$caption	 	   		= isset($att['caption']) ? $att['caption'] : "";

		$titleColor	 	   		= isset($att['titleColor']) ? $att['titleColor'] : "";
		$subTitleColor	 	   	= isset($att['subTitleColor']) ? $att['subTitleColor'] : "";
		$captionColor	 	   	= isset($att['captionColor']) ? $att['captionColor'] : "";

		$html = [];

		$mainClass = "";

		if($animateOnHover && $layout=="blurb"){
			$mainClass .= " yani-hover-animation-on ";
			$mainClass .= " yani-hover-animation-type-".$contentAnimation;
		}
		$mainClass .= " yani-vertical-alignment-".$contentVerticalAlign;
		$mainClass .= " yani-horizontal-alignment-".$contentAlignment;

		if($enableFrame){
			$mainClass.= " yani-has-frame";
			if($frameAnimateOnHover){
				$mainClass.= " yani-frame-animate-on-hover";
			}
		}

		$titleTagName = "h".$titleLevel;

		if(!empty($animation)){
			$html =  "<div class='".$classname."' id='yani-block-".$uniqueId ."' data-yani-animation='".json_encode($animation)."'>";	
		}else{
			$html =  "<div class='".$classname."' id='yani-block-".$uniqueId ."'>";
		}
			$html .= "<div class='yani-divider-wrapper  yani-divider-layout--".$layout."'>";
			
				$html .= "<div class = '".$mainClass."'>";
				
					$html .= "<figure>";
						$html .= "<div class = 'yani-image-container'>";
							$html .= "<img class='yani-image-image' src='".$image['url']."' alt='".$imgAlt."' />";
						$html .= "</div>";
					$html .= "</figure>";

					if($layout=="blurb"){
						$html .= "<div class='yani-image-content'>";
						$html .= "<div class='yani-image-content-inner'>";
						$html .= "<div class='yani-image-title'>";
						$html .= "<".$titleTagName." class='".$titleColor."'>".$title."</".$titleTagName.">";
						$html .= "</div>";
						$html .= "</div>";
						if($enableSubtitle){
							$html .= "<div class='yani-image-sub-title ".$subTitleColor."'>";
							$html .= $subtitle;
							$html .= "</div>";							
						}
						$html .= "</div>";
					}else if($layout=="simple" && $enableCaption){
						$html .= "<figcaption class='yani-image-caption ".$captionColor."'>";
							$html .= $caption;						
						$html .= "</figcaption>";
					}
					
				$html .= "</div>";
				
		$html .= "</div>";
		$html .= "</div>";
		return $html;
	}
}

new Yani_Image_Block();






