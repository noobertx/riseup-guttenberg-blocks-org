<?php

/**
 * Registers the `wprig/product-carousel` block on server.
 *
 * @since 1.1.0
 */

class WPRIG_Product_Carousel{
	function __construct(){
		add_action('init', [$this,'register_block_wprig_product_carousel'], 100);
		add_action('wp_ajax_wprig_woocommerce_ajax_add_to_cart',[$this, 'wprig_woocommerce_ajax_add_to_cart']); 
		add_action('wp_ajax_nopriv_wprig_woocommerce_ajax_add_to_cart',[$this, 'wprig_woocommerce_ajax_add_to_cart']); 
	}
	function enqueue_skin_additional_assets(){
		wp_enqueue_style( 'slick', WPRIG_DIR_URL . 'vendors/slick-carousel/slick.css', false, microtime() );
		wp_enqueue_style( 'slick-theme', WPRIG_DIR_URL . 'vendors/slick-carousel/slick-theme.css', false, microtime() );
		wp_enqueue_script( 'slick', WPRIG_DIR_URL . 'vendors/slick-carousel/slick.min.js', array( 'jquery' ), microtime() );
		wp_enqueue_script( 'wprig-add-to-cart', WPRIG_DIR_URL . 'vendors/add-to-cart.js', array( 'jquery' ), microtime() );
		wp_localize_script( 'wprig-add-to-cart', 'wprig_admin',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
	function register_block_wprig_product_carousel(){
		// Check if the register function exists.
		if (!function_exists('register_block_type')) {
			return;
		}
		register_block_type(
			'wprig/productcarousel',
			array(
				'attributes' => array(
					'uniqueId' => array(
						'type' => 'string',
						'default' => '',
					),
					//general
					'postType' => array(
						'type' => 'string',
						'default' => 'Products',
					),
					'carouselItems' => [
                        'type' => 'object',
                        'default' => [
                            'md' => 3,
                            'sm' => 2,
                            'xs' => 1,
                        ]
                    ],
					'enableDots' => [
                        'type' => 'boolean',
                        'default' => true
                    ], 
                    'dotsColorActive' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .slick-dots li.slick-active button:before{ color:{{dotsColorActive}}!important; }' 
                            ]
                        ]
                    ], //slick-dots
                    'dotsColor' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .slick-dots li button:before{ color:{{dotsColor}}!important; }' 
                            ]
                        ]
                    ], 
                    'enableArrows' => [
                        'type' => 'boolean',
                        'default' => true
                    ], 
                    'arrowColor' => [
                        'type' => 'string',
                        'default' => '#47a',
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .slick-arrow:before,{{WPRIG}} .swiper-button-next,{{WPRIG}} .swiper-button-prev{ color:{{arrowColor}}; }' 
                            ]
                        ]
                    ],
					'carouselItemMargin' => array(
						'type' => 'object',
						'default' => (object) [
							'openMargin' => 1,
							'marginType' => 'custom',
							'custom' => [
								'md' => '0 0 0 10',
							],
							'unit' => 'px'
						],
						'style' => [(object) [
							'selector' => '{{WPRIG}} .wprig-product-carousel.slick-slide'
						]]
					),
					'enablePrice' => [
                        'type' => 'boolean',
                        'default' => true
                    ],
					'enableRegularPrice' => [
                        'type' => 'boolean',
                        'default' => true
                    ], 	
					'enableOnSale' => [
                        'type' => 'boolean',
                        'default' => true
                    ],	
					'taxonomy' => array(
						'type' => 'string',
						'default' => 'product_cat',
					),
					'categories' => array(
						'type' => 'array',
						'default' => [],
						'items'   => [
							'type' => 'object'
						],
					),
					'tags' => array(
						'type' => 'array',
						'default' => [],
						'items'   => [
							'type' => 'object'
						],
					),
					'order' => array(
						'type'    => 'string',
						'default' => 'desc',
					),
					'orderBy' => array(
						'type'    => 'string',
						'default' => 'date',
					),
					//layout
					'layout' => array(
						'type' => 'number',
						'default' => 2
					),
					'style' => array(
						'type' => 'number',
						'default' => 1
					),
					'column' => array(
						'type' => 'object',
						'default' => array('md' => 3, 'sm' => 2, 'xs' => 1),
					),
	
					//content
					'showTitle' => array(
						'type' => 'boolean',
						'default' => true
					),
					'titlePosition' => array(
						'type' => 'boolean',
						'default' => true,
					),
					'showCategory' => array(
						'type' => 'string',
						'default' => 'default',
					),
					'categoryPosition' => array(
						'type' => 'string',
						'default' => 'leftTop',
					),
					'badgePosition' => array(
						'type' => 'string',
						'default' => 'default',
					),
					'badgePadding' => array(
						'type' => 'object',
						'default' => (object) [
							'paddingType' => 'custom',
							'unit' => 'px',
						],
						'style' => [
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 2,],
									(object) ['key' => 'style', 'relation' => '!=', 'value' => 4],
									(object) ['key' => 'badgePosition', 'relation' => '!=', 'value' => 'default'],
								],
								'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-post-grid-wrapper .wprig-product-carousel-cat-position'
							]
						]
					),
					'showComment' => array(
						'type' => 'boolean',
						'default' => true
					),
					'showcartButton' => array(
						'type' => 'boolean',
						'default' => true
					),
					'verticalAlignment' => array(
						'type'    => 'string',
						'default' => 'center',
					),
					'items' => array(
						'type' => 'number',
						'default' => 2,
					),
					'postsToShow' => array(
						'type' => 'number',
						'default' => 4,
					),					
					//Seperator
					'showSeparator' => array(
						'type' => 'boolean',
						'default' => true
					),
	
					'separatorColor' => array(
						'type'    => 'string',
						'default' => '#e5e5e5',
						'style' => [(object) [
							'condition' => [
								(object) ['key' => 'style', 'relation' => '==', 'value' => 1],
								(object) ['key' => 'showSeparator', 'relation' => '==', 'value' => true]
							],
							'selector' => '{{WPRIG}} .wprig-post-list-view.wprig-product-carousel-style-1:not(:last-child) {border-bottom-color: {{separatorColor}};}'
						]]
					),
	
					'separatorHeight' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 1,
							'unit' => 'px'
						),
						'style' => [
							(object) [
								'condition' => [
									(object) ['key' => 'style', 'relation' => '==', 'value' => 1],
									(object) ['key' => 'showSeparator', 'relation' => '==', 'value' => true]
								],
								'selector' => '{{WPRIG}} .wprig-post-list-view.wprig-product-carousel-style-1:not(:last-child){border-bottom-style: solid;border-bottom-width: {{separatorHeight}};}'
							],
						],
					),
	
					'separatorSpace' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 20,
							'unit' => 'px'
						),
						'style' => [
							(object) [
								'condition' => [
									(object) ['key' => 'style', 'relation' => '==', 'value' => 1],
									(object) ['key' => 'showSeparator', 'relation' => '==', 'value' => true]
								],
								'selector' => '{{WPRIG}} .wprig-post-list-view.wprig-product-carousel-style-1:not(:last-child){padding-bottom: {{separatorSpace}};margin-bottom: {{separatorSpace}};}'
							],
						],
					),
	
	
					//card
					'cardBackground' => array(
						'type' => 'object',
						'default' => (object) [],
						'style' => [
							(object) [
								'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 2]],
								'selector' => '{{WPRIG}} .wprig-product-carousel-style-2'
							]
						]
					),
					'cardBorder' => array(
						'type' => 'object',
						'default' => (object) array(
							'unit' => 'px',
							'widthType' => 'global',
							'global' => (object) array(
								'md' => '1',
							),
						),
						'style' => [
							(object) [
								'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 2]],
								'selector' => '{{WPRIG}} .wprig-product-carousel-style-2'
							]
						]
					),
					'cardBorderRadius' => array(
						'type' => 'object',
						'default' => (object) array(
							'unit' => 'px',
							'openBorderRadius' => true,
							'radiusType' => 'global',
							'global' => (object) array(
								'md' => 10,
							),
						),
						'style' => [
							(object) [
								'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 2]],
								'selector' => '{{WPRIG}} .wprig-product-carousel-style-2'
							]
						]
					),
					'cardSpace' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 25,
							'unit' => 'px'
						),
						'style' => [
							(object) [
								'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 2]],
								'selector' => '{{WPRIG}} .wprig-post-list-view.wprig-product-carousel-style-2:not(:last-child) {margin-bottom: {{cardSpace}};}'
							]
						]
					),
					'cardPadding' => array(
						'type' => 'object',
						'default' => (object) [
							'openPadding' => 1,
							'paddingType' => 'global',
							'unit' => 'px',
							'global' => (object) ['md' => 25],
						],
						'style' => [
							(object) [
								'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 2]],
								'selector' => '{{WPRIG}} .wprig-product-carousel-style-2'
							]
						]
					),
					'cardBoxShadow' => array(
						'type' => 'object',
						'default' => (object) array(
							'blur' => 8,
							'color' => "rgba(0,0,0,0.10)",
							'horizontal' => 0,
							'inset' => 0,
							'openShadow' => true,
							'spread' => 0,
							'vertical' => 4
						),
						'style' => [
							(object) [
								'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 2]],
								'selector' => '{{WPRIG}} .wprig-product-carousel-style-2'
							]
						]
					),
	
					//scart
					'stackBg' => array(
						'type' => 'object',
						'default' => (object) [],
						'style' => [
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 1],
									(object) ['key' => 'style', 'relation' => '==', 'value' => 3]
								],
								'selector' => '{{WPRIG}} .wprig-post-list-view.wprig-product-carousel-style-3 .wprig-post-list-wrapper .wprig-post-list-content'
							],
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 2],
									(object) ['key' => 'style', 'relation' => '==', 'value' => 3]
								],
								'selector' => '{{WPRIG}} .wprig-post-grid-view.wprig-product-carousel-style-3 .wprig-post-grid-content'
							]
						]
					),
					'stackBorderRadius' => array(
						'type' => 'object',
						'default' => (object) array(
							'unit' => 'px',
							'openBorderRadius' => true,
							'radiusType' => 'global',
							'global' => (object) array(
								'md' => 10,
							),
						),
						'style' => [
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 1],
									(object) ['key' => 'style', 'relation' => '==', 'value' => 3]
								],
								'selector' => '{{WPRIG}} .wprig-post-list-view.wprig-product-carousel-style-3 .wprig-post-list-wrapper .wprig-post-list-content'
							],
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 2],
									(object) ['key' => 'style', 'relation' => '==', 'value' => 3]
								],
								'selector' => '{{WPRIG}} .wprig-post-grid-view.wprig-product-carousel-style-3 .wprig-post-grid-content'
							]
						]
					),
					'stackWidth' => array(
						'type' => 'object',
						'default' => (object) array(),
	
						'style' => [
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 2],
									(object) ['key' => 'style', 'relation' => '==', 'value' => 3]
								],
								'selector' => '{{WPRIG}} .wprig-post-grid-view.wprig-product-carousel-style-3 .wprig-post-grid-img + .wprig-post-grid-content {width: {{stackWidth}};}'
							]
						]
					),
					'stackSpace' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 40,
							'unit' => 'px'
						),
						'style' => [
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 1],
									(object) ['key' => 'style', 'relation' => '==', 'value' => 3]
								],
								'selector' => '{{WPRIG}} .wprig-post-list-view.wprig-product-carousel-style-3:not(:last-child) {margin-bottom: {{stackSpace}};}'
							]
						]
	
					),
					'stackPadding' => array(
						'type' => 'object',
						'default' => (object) [
							'openPadding' => 1,
							'paddingType' => 'global',
							'unit' => 'px',
							'global' => (object) ['md' => 30],
						],
						'style' => [
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 1],
									(object) ['key' => 'style', 'relation' => '==', 'value' => 3]
								],
								'selector' => '{{WPRIG}} .wprig-post-list-view.wprig-product-carousel-style-3 .wprig-post-list-wrapper .wprig-post-list-content'
							],
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 2],
									(object) ['key' => 'style', 'relation' => '==', 'value' => 3]
								],
								'selector' => '{{WPRIG}} .wprig-post-grid-view.wprig-product-carousel-style-3 .wprig-post-grid-wrapper .wprig-post-grid-content'
							]
						]
					),
					'stackBoxShadow' => array(
						'type' => 'object',
						'default' => (object) array(
							'blur' => 28,
							'color' => "rgba(0,0,0,0.15)",
							'horizontal' => 0,
							'inset' => 0,
							'openShadow' => true,
							'spread' => -20,
							'vertical' => 34
						),
						'style' => [
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 1],
									(object) ['key' => 'style', 'relation' => '==', 'value' => 3]
								],
								'selector' => '{{WPRIG}} .wprig-post-list-view.wprig-product-carousel-style-3 .wprig-post-list-wrapper .wprig-post-list-content'
							],
							(object) [
								'condition' => [
									(object) ['key' => 'layout', 'relation' => '==', 'value' => 2],
									(object) ['key' => 'style', 'relation' => '==', 'value' => 3]
								],
								'selector' => '{{WPRIG}} .wprig-post-grid-view.wprig-product-carousel-style-3 .wprig-post-grid-content'
							]
						]
					),
	
					//typography
					'titleTypography' => array(
						'type' => 'object',
						'default' => (object) [
							'openTypography' => 1,
							'family' => "Roboto",
							'type' => "sans-serif",
							'size' => (object) ['md' => 32, 'unit' => 'px'],
						],
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showTitle', 'relation' => '==', 'value' => true]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-title'
						]]
					),
					'metaTypography' => array(
						'type' => 'object',
						'default' => (object) [
							'openTypography' => 1,
							'family' => "Roboto",
							'type' => "sans-serif",
							'size' => (object) ['md' => 12, 'unit' => 'px'],
						],
						'condition' => [
							(object) ['key' => 'showDates', 'relation' => '==', 'value' => true],
							(object) ['key' => 'showComment', 'relation' => '==', 'value' => true]
						],
						'style' => [(object) ['selector' => '{{WPRIG}} .wprig-product-carousel-meta']]
					),
					'categoryTypography' => array(
						'type' => 'object',
						'default' => (object) [
							'openTypography' => 1,
							'family' => "Roboto",
							'type' => "sans-serif",
							'size' => (object) ['md' => 12, 'unit' => 'px'], 'spacing' => (object) ['md' => 1.1, 'unit' => 'px'], 'transform' => 'uppercase'
						],
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showCategory', 'relation' => '!=', 'value' => 'none']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-category a'
						]]
					),
	
					//image
					'showImages' => array(
						'type' => 'boolean',
						'default' => true
					),
					'enableFixedHeight' => array(
						'type' => 'boolean',
						'default' => true
					),
					'fixedHeight' => array(
						'type' => 'object',
						'default' => (object) array(),
						'style' => [(object) ['selector' => '{{WPRIG}} .wprig-post-image{object-fit: cover;height: {{fixedHeight}};}']]
					),
					'imgSize' => array(
						'type'    => 'string',
						'default' => 'large',
					),
					'imageRadius' => array(
						'type' => 'object',
						'default' => (object) array(
							'unit' => 'px',
							'openBorderRadius' => true,
							'radiusType' => 'global',
							'global' => (object) array(
								'md' => 10,
							),
						),
						'style' => [(object) ['selector' => '{{WPRIG}} .wprig-post-img']]
					),
					'imageAnimation' => array(
						'type' => 'string',
						'default' => 'zoom-out'
					),
	
					//cartButton link
					'cartButtonText' => array(
						'type' => 'string',
						'default' => 'Add To Cart'
					),
					'cartButtonStyle' => array(
						'type' => 'string',
						'default' => 'fill'
					),
					'cartButtonSize' => array(
						'type' => 'string',
						'default' => 'small'
					),
					'cartButtonCustomSize' => array(
						'type' => 'object',
						'default' => (object) [
							'openPadding' => 1,
							'paddingType' => 'custom',
							'unit' => 'px',
							'custom' => (object) ['md' => '5 10 5 10'],
						],
						'style' => [(object) [
							'condition' => [
								(object) ['key' => 'cartButtonStyle', 'relation' => '==', 'value' => 'fill'],
								(object) ['key' => 'cartButtonSize', 'relation' => '==', 'value' => 'custom']
							],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-product-carousel-btn-wrapper .wprig-product-carousel-btn.wprig-button-fill.is-custom'
						]]
					),
	
					'cartButtonTypography' => array(
						'type' => 'object',
						'default' => (object) [
							'openTypography' => 1,
							'family' => "Roboto",
							'type' => "sans-serif",
							'size' => (object) ['md' => 14, 'unit' => 'px'],
						],
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showTitle', 'relation' => '==', 'value' => true]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-product-carousel-btn'
						]]
					),
					'cartButtonColor' => array(
						'type'    => 'string',
						'default' => '#fff',
						'style' => [(object) [
							'condition' => [
								(object) ['key' => 'showcartButton', 'relation' => '==', 'value' => true],
								(object) ['key' => 'cartButtonStyle', 'relation' => '==', 'value' => 'fill']
							],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel a.wprig-product-carousel-btn {color: {{cartButtonColor}};}'
						]]
	
					),
					'cartButtonColor2' => array(
						'type'    => 'string',
						'default' => '#2184F9',
						'style' => [(object) [
							'condition' => [
								(object) ['key' => 'showcartButton', 'relation' => '==', 'value' => true],
								(object) ['key' => 'cartButtonStyle', 'relation' => '==', 'value' => 'outline']
							],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel a.wprig-product-carousel-btn {color: {{cartButtonColor2}};}'
						]]
	
					),
					'cartButtonHoverColor' => array(
						'type'    => 'string',
						'default' => '',
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showcartButton', 'relation' => '==', 'value' => true]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel a.wprig-product-carousel-btn:hover {color: {{cartButtonHoverColor}};}'
						]]
	
					),
					'cartButtonBg' => array(
						'type' => 'object',
						'default' => (object) array(
							'openColor' => 1,
							'type' => 'color',
							'color' => '#2184F9',
							'gradient' => (object) [
								'color1' => '#16d03e',
								'color2' => '#1f91f3',
								'direction' => 45,
								'start' => 0,
								'stop' => 100,
								'type' => 'linear'
							],
						),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'cartButtonStyle', 'relation' => '==', 'value' => 'fill']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-product-carousel-btn'
						]]
					),
					'cartButtonHoverBg' => array(
						'type' => 'object',
						'default' => (object) array(),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'cartButtonStyle', 'relation' => '==', 'value' => 'fill']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-product-carousel-btn:hover'
						]]
					),
					'cartButtonBorder' => array(
						'type' => 'object',
						'default' => (object) array(),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'cartButtonStyle', 'relation' => '==', 'value' => 'fill']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-product-carousel-btn'
						]]
					),
					'cartButtonBorderRadius' => array(
						'type' => 'object',
						'default' => (object) array(
							'unit' => 'px',
							'openBorderRadius' => true,
							'radiusType' => 'global',
							'global' => (object) array(
								'md' => 2,
							),
						),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'cartButtonStyle', 'relation' => '==', 'value' => 'fill']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-product-carousel-btn'
						]]
					),
					'cartButtonBoxShadow' => array(
						'type' => 'object',
						'default' => (object) array(),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'cartButtonStyle', 'relation' => '==', 'value' => 'fill']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-product-carousel-btn'
						]]
					),
	
					//color
					'categoryPadding' => array(
						'type' => 'object',
						'default' => (object) array(
							'unit' => 'px',
							'openPadding' => true,
							'paddingType' => 'custom',
							'custom' => (object) array(
								'md' => '4 8 4 8',
							),
						),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showCategory', 'relation' => '==', 'value' => 'badge']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-category a'
						]]
					),
					'contentPadding' => array(
						'type' => 'object',
						'default' => (object) array(),
						'style' => [(object) ['selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-post-grid-content,{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-post-list-content']]
					),
					'categoryRadius' => array(
						'type' => 'object',
						'default' => (object) array(
							'unit' => 'px',
							'openBorderRadius' => true,
							'radiusType' => 'global',
							'global' => (object) array(
								'md' => 2,
							),
						),
						'style' => [(object) ['selector' => '{{WPRIG}} .wprig-product-carousel-category a']]
					),
					'titleColor' => array(
						'type'    => 'string',
						'default' => '#1b1b1b',
						'style' => [(object) [
							'condition' => [
								(object) ['key' => 'style', 'relation' => '!=', 'value' => 4],
								(object) ['key' => 'showTitle', 'relation' => '==', 'value' => true]
							],
							'selector' => '{{WPRIG}} .wprig-product-carousel-title a {color: {{titleColor}};}'
						]]
					),
					'titleOverlayColor' => array(
						'type'    => 'string',
						'default' => '#fff',
						'style' => [(object) [
							'condition' => [
								(object) ['key' => 'style', 'relation' => '==', 'value' => 4],
								(object) ['key' => 'showTitle', 'relation' => '==', 'value' => true]
							],
							'selector' => '{{WPRIG}} .wprig-product-carousel-title a {color: {{titleOverlayColor}};}'
						]]
					),
					'titleHoverColor' => array(
						'type'    => 'string',
						'default' => '#FF0096',
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showTitle', 'relation' => '==', 'value' => true]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-title a:hover {color: {{titleHoverColor}};}'
						]]
					),
					'categoryColor' => array(
						'type'    => 'string',
						'default' => '#FF0096',
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showCategory', 'relation' => '==', 'value' => 'default']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-category a {color: {{categoryColor}};}'
						]]
					),
					'categoryColor2' => array(
						'type'    => 'string',
						'default' => '#fff',
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showCategory', 'relation' => '==', 'value' => 'badge']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-category a {color: {{categoryColor2}};}'
						]]
					),
					'categoryHoverColor' => array(
						'type'    => 'string',
						'default' => '#FF0096',
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showCategory', 'relation' => '==', 'value' => 'default']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-category a:hover {color: {{categoryHoverColor}};}'
						]]
					),
					'categoryBackground' => array(
						'type'    => 'string',
						'default' => '#FF0096',
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showCategory', 'relation' => '==', 'value' => 'badge']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-category a {background: {{categoryBackground}};}'
						]]
					),
					'categoryHoverBackground' => array(
						'type'    => 'string',
						'default' => '#e00e89',
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showCategory', 'relation' => '==', 'value' => 'badge']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-category a:hover {background: {{categoryHoverBackground}};}'
						]]
					),
	
					'categoryHoverColor2' => array(
						'type'    => 'string',
						'default' => '#fff',
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showCategory', 'relation' => '==', 'value' => 'badge']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-category a:hover {color: {{categoryHoverColor2}};}'
						]]
					),
					'metaColor' => array(
						'type'    => 'string',
						'default' => '#9B9B9B',
						'style' => [(object) [
							'condition' => [
								(object) ['key' => 'style', 'relation' => '!=', 'value' => 4]
							],
							'selector' => '{{WPRIG}} .wprig-product-carousel-meta a {color: {{metaColor}};} {{WPRIG}} .wprig-product-carousel-meta {color: {{metaColor}};} {{WPRIG}} .wprig-product-carousel-meta span:before {background: {{metaColor}};}'
						]]
					),
					'metaOverlayColor' => array(
						'type'    => 'string',
						'default' => '#fff',
						'style' => [(object) [
							'condition' => [
								(object) ['key' => 'style', 'relation' => '==', 'value' => 4]
							],
							'selector' => '{{WPRIG}} .wprig-product-carousel-meta a {color: {{metaOverlayColor}};} {{WPRIG}} .wprig-product-carousel-meta {color: {{metaOverlayColor}};} {{WPRIG}} .wprig-product-carousel-meta span:before {background: {{metaOverlayColor}};}'
						]]
					),
	
					//design
					'spacer' => 	array(
						'type' => 'object',
						'default' => (object) array(
							'spaceTop' => (object) ['md' => '10', 	'unit' => "px"],
							'spaceBottom' => (object) ['md' => '10', 'unit' => "px"],
						),
						'style' => [(object) ['selector' => '{{wprig}}']]
					),
					'contentPosition' =>  array(
						'type' => 'string',
						'default' => 'center',
					),
					'girdContentPosition' =>  array(
						'type' => 'string',
						'default' => 'center',
					),
					'color' => array(
						'type'    => 'string',
						'default' => '',
						'style' => [(object) [
							'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 1]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel .wprig-post-list-content {color: {{color}};}'
						]]
					),
					'bgColor' => array(
						'type' => 'object',
						'default' => (object) array(),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 1]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper'
						]]
					),
					'border' => array(
						'type' => 'object',
						'default' => (object) array(),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 1]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper'
						]]
					),
					'borderRadius' => array(
						'type' => 'object',
						'default' => (object) array(),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 1]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper'
						]]
					),
					'padding' => array(
						'type' => 'object',
						'default' => (object) array(),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 1]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper'
						]]
					),
					'boxShadow' => array(
						'type' => 'object',
						'default' => (object) array(),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 1]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-wrapper'
						]]
					),
	
					//overlay
					'overlayBg' => array(
						'type' => 'object',
						'default' => (object) [
							'openColor' => 1,
							'type' => 'color',
							'color' => '#101a3b',
							'gradient' => (object) [
								'color1' => '#071b0b',
								'color2' => '#101a3b',
								'direction' => 45,
								'start' => 0,
								'stop' => 100,
								'type' => 'linear'
							],
						],
						'style' => [(object) [
							'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 4]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-style-4:before'
						]]
					),
					'overlayHoverBg' => array(
						'type' => 'object',
						'default' => (object) [
							'openColor' => 1,
							'type' => 'color',
							'color' => '#4c4e54',
							'gradient' => (object) [
								'color1' => '#4c4e54',
								'color2' => '#071b0b',
								'direction' => 45,
								'start' => 0,
								'stop' => 100,
								'type' => 'linear'
							],
						],
						'style' => [(object) [
							'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 4]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-style-4:hover:before'
						]]
					),
					'overlayBorderRadius' => array(
						'type' => 'object',
						'default' => (object) array(
							'unit' => 'px',
							'openBorderRadius' => true,
							'radiusType' => 'global',
							'global' => (object) array(
								'md' => 20,
							),
						),
						'style' => [
							(object) [
								'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 4]],
								'selector' => '{{WPRIG}} .wprig-product-carousel-style-4'
							]
						]
					),
					'overlaySpace' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 30,
							'unit' => 'px'
						),
						'style' => [
							(object) [
								'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 4]],
								'selector' => '{{WPRIG}} .wprig-post-list-view.wprig-product-carousel-style-4:not(:last-child) {margin-bottom: {{overlaySpace}};}'
							]
						]
					),
					'overlayHeight' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 300,
							'unit' => 'px'
						),
						'style' => [
							(object) [
								'condition' => [
									(object) ['key' => 'style', 'relation' => '==', 'value' => 4]
								],
								'selector' => '{{WPRIG}} .wprig-product-carousel-style-4 {height: {{overlayHeight}};}'
							]
						]
					),
					'overlayBlend' => array(
						'type'    => 'string',
						'default' => '',
						'style' => [(object) [
							'condition' => [(object) ['key' => 'style', 'relation' => '==', 'value' => 4]],
							'selector' => '{{WPRIG}} .wprig-product-carousel.wprig-post-list-view.wprig-product-carousel-style-4:before {mix-blend-mode: {{overlayBlend}};}'
						]]
					),
					//Spacing
					'columnGap' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 30,
							'unit' => 'px'
						),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'layout', 'relation' => '==', 'value' => 2]],
							'selector' => '{{WPRIG}} .wprig-product-carousel-column {grid-column-gap: {{columnGap}};}, {{WPRIG}} .wprig-product-carousel-column {grid-row-gap: {{columnGap}};}'
						]]
					),
					'titleSpace' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 10,
							'unit' => 'px'
						),
						'style' => [(object) ['selector' => '{{WPRIG}} .wprig-product-carousel-title {padding-bottom: {{titleSpace}};}']]
					),
					'categorySpace' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 5,
							'unit' => 'px'
						),
						'style' => [(object) [
							'condition' => [(object) ['key' => 'showCategory', 'relation' => '==', 'value' => 'default']],
							'selector' => '{{WPRIG}} .wprig-product-carousel-category {display:inline-block;padding-bottom: {{categorySpace}};}'
						]]
					),
					'metaSpace' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 10,
							'unit' => 'px'
						),
						'style' => [(object) ['selector' => '{{WPRIG}} .wprig-product-carousel-meta {padding-bottom: {{metaSpace}};}']]
					),
					'postSpace' => array(
						'type' => 'object',
						'default' => (object) array(
							'md' => 10,
							'unit' => 'px'
						),
						// 'style' => [(object) ['selector' => '{{WPRIG}} .wprig-product-carousel-wrapper .wprig-product-carousel']]
					),
					'interaction' => array(
						'type' => 'object',
						'default' => (object) array(),
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
					// 'showContextMenu' => array(
					// 	'type' => 'boolean',
					// 	'default' => true
					// ),
				),
				'render_callback' => [$this,'render_block_wprig_product_carousel']
			)
		);
	}
	function render_block_wprig_product_carousel($att){
		$layout 		        = isset($att['layout']) ? $att['layout'] : 3;
		$uniqueId 		        = isset($att['uniqueId']) ? $att['uniqueId'] : '';
		$className 		        = isset($att['className']) ? $att['className'] : '';
		$style 		            = isset($att['style']) ? $att['style'] : 3;
		$column 		        = isset($att['column']) ? $att['column'] : 3;
		$numbers 		        = isset($att['postsToShow']) ? $att['postsToShow'] : 3;
		$showCategory 		    = isset($att['showCategory']) ? $att['showCategory'] : 'default';
		$categoryPosition 		= isset($att['categoryPosition']) ? $att['categoryPosition'] : 'leftTop';
		$contentPosition 		= isset($att['contentPosition']) ? $att['contentPosition'] : 'center';
		$girdContentPosition 	= isset($att['girdContentPosition']) ? $att['girdContentPosition'] : 'center';
		$showTitle 		        = isset($att['showTitle']) ? $att['showTitle'] : 1;
		$showDates 		        = isset($att['showDates']) ? $att['showDates'] : 1;
		$showComment 		    = isset($att['showComment']) ? $att['showComment'] : 1;
		$showcartButton 		    = isset($att['showcartButton']) ? $att['showcartButton'] : 1;
		$titlePosition 		    = isset($att['titlePosition']) ? $att['titlePosition'] : 1;
		$cartButtonText 		    = isset($att['cartButtonText']) ? $att['cartButtonText'] : 'Read More';
		$cartButtonSize 		    = isset($att['cartButtonSize']) ? $att['cartButtonSize'] : 'small';
		$cartButtonStyle 		    = isset($att['cartButtonStyle']) ? $att['cartButtonStyle'] : 'fill';
		$showImages 		    = isset($att['showImages']) ? $att['showImages'] : 1;
		$imgSize 		        = isset($att['imgSize']) ? $att['imgSize'] : 'large';
		$showBadge 		        = isset($att['showBadge']) ? $att['showBadge'] : 1;
		$order 		            = isset($att['order']) ? $att['order'] : 'DESC';
		$imageAnimation 		= isset($att['imageAnimation']) ? $att['imageAnimation'] : '';
		$orderBy 		        = isset($att['orderBy']) ? $att['orderBy'] : 'date';
		$categories             = $att['categories'];
		$tags                   = $att['tags'];
		$taxonomy               = $att['taxonomy'];

		$enableDots 		        = isset($att['enableDots']) ? $att['enableDots'] : false;
        $enableArrows 		        = isset($att['enableArrows']) ? $att['enableArrows'] : false;
		$carouselItems 		    = isset($att['carouselItems']) ? $att['carouselItems'] : array(
            'md' => 3,
            'sm' => 2,
            'xs' => 1,
        );

		$enablePrice 		        = isset($att['enablePrice']) ? $att['enablePrice'] : false;
		$enableRegularPrice 		        = isset($att['enableRegularPrice']) ? $att['enableRegularPrice'] : false;
		$enableOnSale 		        = isset($att['enableOnSale']) ? $att['enableOnSale'] : false;
		// $html = "";
		$slickSettings = (object) array(
            "slidesToShow" => $carouselItems['md'],
            "slidesToScroll" => 1,
            "dots"=> $enableDots,
            "arrows"=> $enableArrows,
            "responsive" => [
                [
                    "breakpoint" => 1000,
                    "settings" => [
                        "slidesToShow" => $carouselItems['md'],
                    ]
                ],
                [
                    "breakpoint" => 800,
                    "settings" => [
                        "slidesToShow" => $carouselItems['sm'],
                    ]
                ],
                [
                    "breakpoint" => 500,
                    "settings" => [
                        "slidesToShow" => $carouselItems['xs'],
                    ]
                ]
            ]
        );
	
		$animation 		        = isset($att['animation']) ? (count((array) $att['animation']) > 0 &&  $att['animation']['animation'] ? 'data-wpriganimation="' . htmlspecialchars(json_encode($att['animation']), ENT_QUOTES, 'UTF-8') . '"' : '') : '';
		
	
		$interaction = '';
		if (isset($att['interaction'])) {
			if (!empty((array) $att['interaction'])) {
				if (isset($att['interaction']['while_scroll_into_view'])) {
					if ($att['interaction']['while_scroll_into_view']['enable']) {
						$interaction = 'wprig-block-interaction';
					}
				}
				if (isset($att['interaction']['mouse_movement'])) {
					if ($att['interaction']['mouse_movement']['enable']) {
						$interaction = 'wprig-block-interaction';
					}
				}
			}
		}
	
	
		$paged = 1;
		if (!empty(get_query_var('page')) || !empty(get_query_var('paged'))) {
			$paged = is_front_page() ? get_query_var('page') : get_query_var('paged');
		}
	
		$args = array(
			'post_type' 		=> 'product',
			'posts_per_page' 	=> esc_attr($numbers),
			'order' 			=> esc_attr($order),
			'orderby' 			=> esc_attr($orderBy),
			'status' 			=> 'publish',
			'paged'             => $paged
		);

		$tax_query = ["relation"=>'AND'];
		foreach($categories as $cat){
			array_push($tax_query,[
				'taxonomy'=>$taxonomy,
				'field'=>'slug',
				'terms'=>$cat['value']
			]);
		}

	
		$active_taxonomy_array = $att['taxonomy'] == 'categories' ? $categories : $tags;
		$active_taxonomy_name = $att['taxonomy'] == 'categories' ? 'category__in' : 'tag__in';
	
		// if (is_array($active_taxonomy_array) && count($active_taxonomy_array) > 0) {
		// 	$args[$active_taxonomy_name] = array_column($active_taxonomy_array, 'value');
		// }

		$args['tax_query'] = $tax_query;
		$query = new WP_Query($args);
	
		
	
		$this->enqueue_skin_additional_assets();
		$html = "";
		//column
		if ($layout == 2) {
			$col = (' wprig-product-carousel wprig-product-carousel-column wprig-product-carousel-column-md' . $column['md'] . ' wprig-product-carousel-column-sm' . $column['sm'] . ' wprig-product-carousel-column-xs' . $column['xs']);
		} else {
			$col = "wprig-product-carousel";
		}
		$class = 'wp-block-wprig-product-carousel wprig-block-' . $uniqueId;
		if (isset($att['align'])) {
			$class .= ' align' . $att['align'];
		}
		if (isset($att['className'])) {
			$class .= $att['className'];
		}
		if ($query->have_posts()) {
			$html .= '<div class="' . $class . '">';
			$html .= '<div class="wprig-product wprig-product-carousel-wrapper ' . $interaction . ' wprig-product-carousel-layout-' . esc_attr($layout) . esc_attr($col) . '" ' . $animation . " data-slick='".json_encode($slickSettings)."'". ' >';

			
			while ($query->have_posts()) {
				$meta = "";
				$query->the_post();
				$id = get_post_thumbnail_id();
				$src = wp_get_attachment_image_src($id, $imgSize);
				if($enableOnSale && wc_get_product(get_the_ID())->is_on_sale()){
					$meta .= "<span class='onsale'>Sale!</span>";
				}
				$image = '<img class="wprig-post-image" src="' . esc_url($src[0]) . '" alt="' . get_the_title() . '"/>';
				$title = '<h3 class="wprig-product-carousel-title"><a href="' . esc_url(get_the_permalink()) . '">' . get_the_title() . '</a></h3>';
				
				$category = '<span class="wprig-product-carousel-category">' . get_the_category_list(' ') . '</span>';
				if($enableRegularPrice ){
					$meta .= '<span>Price ';
				} 
				$meta .= ($enablePrice) ? '<strike>$ '. number_format((float) wc_get_product(get_the_ID())->get_regular_price(), 2, '.', ',').'</strike>' :'$'.number_format((float) wc_get_product(get_the_ID())->get_regular_price(), 2, '.', ',');
				$meta .= '</span><br>';
		
				$meta .= ($enablePrice )? '<span>Price $ '. number_format( (float)wc_get_product(get_the_ID())->get_price(), 2, '.', ',').'</span><br>' :'';
		
				$meta .= ($showComment == 1) ? '<span><i class="fas fa-comment"></i> ' . get_comments_number('0', '1', '%') . '</span>' : '';
				$btn = '<div class="wprig-product-carousel-btn-wrapper"><a class="button product_type_simple add_to_cart_button ajax_add_to_cart wprig-product-carousel-btn wprig-button-' . esc_attr($cartButtonStyle) . ' is-' . esc_attr($cartButtonSize) . '" href="?add-to-cart=' . get_the_ID() . '" data-product-ID="'.get_the_ID().'" aria-label="Add '.get_the_title().'to your cart" rel="nofolow">' . esc_attr($cartButtonText) . '</a></div>';
				
				if ($layout === 1) {
					$html .= '<div class="wprig-product-carousel wprig-post-list-view wprig-product-carousel-style-' . esc_attr($style) . '">';
					$html .= '<div class="wprig-post-list-wrapper wprig-post-list-' .  esc_attr(($layout == 2 && $style === 3) ? $contentPosition : $girdContentPosition)  . '">';
					if (($showImages == 1) && has_post_thumbnail()) {
						if ($showCategory == 'badge'  && $style == 4) {
							$html .= '<div class="wprig-product-carousel-cat-position wprig-product-carousel-cat-position-' . esc_attr($categoryPosition) . '">';
							$html .= $category;
							$html .= '</div>';
						}
						$html .= '<div class="wprig-post-list-img wprig-post-img wprig-post-img-' . esc_attr($imageAnimation) . '">';
						$html .= '<a href="' . esc_url(get_the_permalink()) . '">';
						$html .= $image;
						$html .= '</a>';
						if ($showCategory == 'badge'  && $style != 4) {
							$html .= '<div class="wprig-product-carousel-cat-position wprig-product-carousel-cat-position-' . esc_attr($categoryPosition) . '">';
							$html .= $category;
							$html .= '</div>';
						}
						$html .= '</div>'; //wprig-post-list-img
					}
					$html .= '<div class="wprig-post-list-content">';
					if ($showCategory == 'default') {
						$html .= $category;
					}
					if (($showTitle == 1) && ($titlePosition == 1)) {
						$html .= $title;
					}

					if (($showDates == 1) || ($showComment == 1)) {
						$html .= '<div class="wprig-product-carousel-meta">';
						$html .= $meta;
						$html .= '</div>';
					}
					if (($showTitle === 1) || ($titlePosition == 0)) {
						$html .= $title;
					}

					if ($showcartButton == 1) {
						$html .= $btn;
					}
					$html .= '</div>'; //wprig-post-list-content
					$html .= '</div>'; //wprig-post-list-wrap
					$html .= '</div>'; //wprig-product-carousel
				}
				if ($layout === 2) {
					$html .= '<div class="wprig-product-carousel wprig-post-grid-view wprig-product-carousel-style-' . esc_attr($style) . '">';
					$html .= '<div class="wprig-post-grid-wrapper wprig-post-grid-' . esc_attr(($layout == 2 && $style === 3) ? $contentPosition : $girdContentPosition)  . '">';
					if (($showImages == 1) && has_post_thumbnail()) {
						$html .= '<div class="wprig-post-grid-img wprig-post-img wprig-post-img-' . esc_attr($imageAnimation) . '">';
						$html .= '<a href="' . esc_url(get_the_permalink()) . '">';
						$html .= $image;
						$html .= '</a>';
						if ($showCategory == 'badge'  && $style != 4) {
							$html .= '<div class="wprig-product-carousel-cat-position wprig-product-carousel-cat-position-' . esc_attr($categoryPosition) . '">';
							$html .= $category;
							$html .= '</div>';
						}
						$html .= '</div>'; //wprig-post-grid-img
					}
					$html .= '<div class="wprig-post-grid-content">';
					if ($showCategory == 'default') {
						$html .= $category;
					}
					if ($showCategory == 'badge'  && $style == 4) {
						$html .= '<div class="wprig-product-carousel-cat-position wprig-product-carousel-cat-position-' . esc_attr($categoryPosition) . '">';
						$html .= $category;
						$html .= '</div>';
					}
					if (($showTitle == 1) && ($titlePosition == 1)) {
						$html .= $title;
						$html .= '<div class="wprig-product-carousel-meta">';
						$html .= $meta;
						$html .= '</div>';
					}
					if (($showTitle === 1) || ($titlePosition == 0)) {
						$html .= $title;
						$html .= '<div class="wprig-product-carousel-meta">';
						$html .= $meta;
						$html .= '</div>';
					}
					if ($showcartButton == 1) {
						$html .= $btn;
					}
					$html .= '</div>'; //wprig-post-grid-content
					$html .= '</div>'; //wprig-post-grid-wrap
					$html .= '</div>'; //wprig-product-carousel
				}
			}
			$html .= '</div>';
			$html .= '</div>';
			wp_reset_postdata();
		}
		return $html;
	}

	function wprig_woocommerce_ajax_add_to_cart(){
		$product_id = sanitize_text_field($_POST['id']);
		$quantity = sanitize_text_field($_POST['qty']);

		$status = WC()->cart->add_to_cart($product_id, $quantity);
		// $status = WC_Cart::add_to_cart($product_id, $quantity);
		return wp_send_json_success($status);
	}
};

new WPRIG_Product_Carousel();
