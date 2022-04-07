<?php
class WPRIG_Product_Categories{
    function __construct(){
		add_action('init', [$this,'register_wprig_block'], 100);
	}
    function register_wprig_block(){
        if (!function_exists('register_block_type')) {
			return;
		}
        register_block_type(
            'wprig/product-categories',
            array(
                'attributes' => [
                    'uniqueId' => array(
						'type' => 'string',
						'default' => '',
					),
                    'animation' => array(
						'type' => 'object',
						'default' => (object) array(),
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
                ],
                'render_callback' => [$this,'render_wprig_block']
            )
        );
    }

    function render_wprig_block(){
        $html = "Product Category Menu";
        return $html;
    }
}
?>