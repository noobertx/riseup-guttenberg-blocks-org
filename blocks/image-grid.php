<?php

class Riseup_Gallery_Block{
    function __construct(){
        add_action('init', [$this,'register_block_wprig_image_grid'], 100);
        add_action('wp_footer', [$this,'render_overlay_block']);
        add_action('rest_api_init', [$this,'getImageMedia']);
        add_action( 'wp_body_open', [$this,'render_modal_component'] );
        add_action( 'print_tooltip', [$this,'renderTooltip'] );
    }
    function register_block_wprig_image_grid(){
        if (!function_exists('register_block_type')) {
            return;
        }
        
    
        register_block_type(
            'wprig/image-grid',
            [
                'attributes'=>[
                    'uniqueId' => [
                        'type' => 'string',
                        'default' => '',
                    ],
                    'imageItems' => [
                        'type' => 'array',
                        'default' => []
                    ],
                    'skin' => [
                        'type' => 'string',
                        'default' => ""
                    ], 
                    'carouselItems' => [
                        'type' => 'object',
                        'default' => [
                            'md' => 3,
                            'sm' => 2,
                            'xs' => 1,
                        ]
                    ],
                    'maxRowHeight' => [
                        'type' => 'string',
                        'default' => 400
                    ], 
                    'innerGap' => [
                        'type' => 'string',
                        'default' => 0
                    ],
                    'columnsTablet' => [
                        'type' => 'object',
                        'default' => 2,
                        'style' => [
                            [
                                'selector' => '@media(min-width:480px) { {{WPRIG}}.wprig-grid-gallery{grid-template-columns: repeat({{columnsTablet}},1fr); } }'
                            ]
                        ]
                    ],
                    'columns' => [
                        'type' => 'object',
                        'default' => 3,
                        'style' => [
                            [
                                'selector' => '@media(min-width:1200px) { {{WPRIG}}.wprig-grid-gallery{grid-template-columns: repeat({{columns}},1fr); } }'
                            ]
                        ]
                    ],
                    
                    'columnsPhone' => [
                        'type' => 'object',
                        'default' => 1,
                        'style' => [
                            [
                                'selector' => '@media(max-width:480px) { {{WPRIG}}.wprig-grid-gallery{grid-template-columns: repeat({{columnsPhone}},1fr); } }'
                            ]
                        ]
                    ],
                    'rowGap' => [
                        'type' => 'object',
                        'default' => [
                            'md' => 10,
                            'sm' => 10,
                            'xs' => 10,
                            'unit' => 'px'
                        ],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}}.wprig-grid-gallery{ row-gap: {{rowGap}}; }'
                            ]
                        ]
                    ],
                    'columnGap' => [
                        'type' => 'object',
                        'default' => [
                            'md' => 10,
                            'sm' => 10,
                            'xs' => 10,
                            'unit' => 'px'
                        ],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}}.wprig-grid-gallery{ column-gap: {{columnGap}}; }'
                            ]
                        ]
                    ],      
                    'cellWidth' => [
                        'type' => 'object',
                        'default' => [
                            'md'=> 250,
                            'unit'=> 'px'
                        ],
                        'style' => [
                            [                            
                                'selector' => ' {{WPRIG}}.wprig-masonry-gallery .cells{ width: {{cellWidth}}; }' 
                            ]
                        ]
                    ],
                    'cellMargin' => [
                        'type' => 'object',
                        'default' => [
                            'md'=> 5,
                            'unit'=> 'px'
                        ],
                        'style' => [
                            [                            
                                'selector' => ' {{WPRIG}}.wprig-masonry-gallery .cells{ margin: {{cellMargin}}; }' 
                            ]
                        ]
                    ],
                    'cellHeight' => [
                        'type' => 'object',
                        'default' => [
                            'md'=> 300,
                            'unit'=> 'px'
                        ],
                        'style' => [                        
                            [       
                                'condition' => [
                                    [
                                        'key' => 'skin',
                                        'relation' => '!=',
                                        'value' => "masonry",
                                    ]
                                ],                     
                                'selector' => ' {{WPRIG}}.slider .cells,{{WPRIG}}.wprig-grid-gallery .cells{ height: {{cellHeight}}; }' 
                            ]
                        ]
                    ],
    
                    'gutter' => [
                        'type' => 'number',
                        'default' => 10
                    ],
                    'enableViewButton' => [
                        'type' => 'boolean',
                        'default' => true
                    ], 
                    'viewButtonType' => [
                        'type' => 'string',
                        'default' => "text"
                    ], 
                    'viewButtonLabel' => [
                        'type' => 'string',
                        'default' => "View Item"
                    ], 
                    'viewButtonIcon' => [
                        'type' => 'string',
                        'default' => ""
                    ],                 
                    'viewIconName' => [
                        'type'=> 'string',
                        'default'=> ''
                    ],
                    'viewIconSize' => [
                        'type'=> 'object',
                        'default'=> [],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .view .wprig-btn-icon {font-size: {{viewIconSize}}}'
                            ]
                        ]
                    ],
                    'viewFillType' => [
                        'type'=> 'string',
                        'default'=> 'fill'
                    ],
                    'viewButtonColor' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'viewFillType',
                                        'relation' => '==',
                                        'value' => "fill",
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .view{ color:{{viewButtonColor}}; }' 
                            ]
                        ]
                    ],
                    'viewButtonColor2' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'viewFillType',
                                        'relation' => '!=',
                                        'value' => "fill",
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .view{ color:{{viewButtonColor2}}; }' 
                            ]
                        ]
                    ],
                    'viewButtonHoverColor' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'viewFillType',
                                        'relation' => '==',
                                        'value' => "fill",
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .view:hover{ color:{{viewButtonHoverColor}}; }' 
                            ]
                        ]
                    ],
                    'viewButtonHoverColor2' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'viewFillType',
                                        'relation' => '!=',
                                        'value' => "fill",
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .view:hover{ color:{{viewButtonHoverColor2}}; }' 
                            ]
                        ]
                    ],
                    'viewButtonBgColor' => [
                        'type' => 'object',
                        'default' => [
                            'type' => 'color',
                            'openColor' => 1,
                            'color' => '#333',
                            'gradient' => [
                                'color1'=> 'var(--wprig-color-2)',
                                'color2'=> 'var(--wprig-color-1)',
                                'direction'=> 0,
                                'start'=> 0,
                                'stop'=> 100,
                                'type'=> 'linear'
                            ]
                        ],
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'viewFillType',
                                        'relation' => '==',
                                        'value' => "fill",
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .view' 
                            ]
                        ]
                    ],
                    'viewButtonBgColorHover' => [
                        'type' => 'object',
                        'default' => [
                            'type' => 'color',
                            'openColor' => 1,
                            'color' => '#333',
                            'gradient' => [
                                'color1'=> '#16d03e',
                                'color2'=> '#1f91f3',
                                'direction'=> 0,
                                'start'=> 0,
                                'stop'=> 100,
                                'type'=> 'linear'
                            ]
                        ],
                        'style' => [
                            [                            
                                'selector' => '{{WPRIG}} .view:hover' 
                            ]
                        ]
                    ],
                    'viewButtonBorder' => [
                        'type' => 'object',
                        'default' => [
                            'openBorder' => 1,
                            'widthType' => 'global',
                            'global' => ['md' => '1' ],
                            'type' => 'solid',
                            'color' => 'var(--wprig-color-1)' 
                        ],
                        'style' => [
                            [                            
                                'selector' => '{{WPRIG}} .view' 
                            ]
                        ]
                    ],
                    'viewButtonBorderHoverColor' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .view:hover{border-color: {{viewButtonBorderHoverColor}};}' 
                            ]
                        ]
                    ],
                    'viewButtonBorderRadius' => [
                        'type' => 'object',
                        'default' => [
                            'openBorderRadius'=> 1,
                            'radiusType'=> 'global',
                            'global'=> [ 'md'=> 4 ],
                            'unit'=> 'px',
                        ],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .view' 
                            ]
                        ]
                    ],
                    'viewButtonShadow' => [
                        'type' => 'object',
                        'default' => [],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .view' 
                            ]
                        ]
                    ],
                    'viewButtonShadowHover' => [
                        'type' => 'object',
                        'default' => [],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .view:hover' 
                            ]
                        ]
                    ],
                    'enableShareButton' => [
                        'type' => 'boolean',
                        'default' => true
                    ], 
                    'shareButtonType' => [
                        'type' => 'string',
                        'default' => "text"
                    ], 
                    'shareButtonLabel' => [
                        'type' => 'string',
                        'default' => "Share Item"
                    ], 
                    'shareButtonIcon' => [
                        'type' => 'string',
                        'default' => ""
                    ],                 
                    'shareIconName' => [
                        'type'=> 'string',
                        'default'=> ''
                    ],
                    'shareIconSize' => [
                        'type'=> 'object',
                        'default'=> [],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .share .tool-tip a,{{WPRIG}} .share .wprig-btn-icon {font-size: {{shareIconSize}}}'
                            ]
                        ]
                    ],
                    'shareFillType' => [
                        'type'=> 'string',
                        'default'=> 'fill'
                    ],
                    'shareButtonColor' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'shareFillType',
                                        'relation' => '==',
                                        'value' => "fill",
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .share,{{WPRIG}} .share .tool-tip a{ color:{{shareButtonColor}}; }' 
                            ]
                        ]
                    ],
                    'shareButtonColor2' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'shareFillType',
                                        'relation' => '!=',
                                        'value' => "fill",
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .share , {{WPRIG}} .share .tool-tip a{ color:{{shareButtonColor2}}; }' 
                            ]
                        ]
                    ],
                    'shareButtonHoverColor' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'shareFillType',
                                        'relation' => '==',
                                        'value' => "fill",
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .share:hover, {{WPRIG}} .share .tool-top a:hover{ color:{{shareButtonHoverColor}}; }' 
                            ]
                        ]
                    ],
                    'shareButtonHoverColor2' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'shareFillType',
                                        'relation' => '!=',
                                        'value' => "fill",
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .share:hover,{{WPRIG}} .share .tool-tip a:hover { color:{{shareButtonHoverColor2}}; }' 
                            ]
                        ]
                    ],
                    'shareButtonBgColor' => [
                        'type' => 'object',
                        'default' => [
                            'type' => 'color',
                            'openColor' => 1,
                            'color' => '#333',
                            'gradient' => [
                                'color1'=> 'var(--wprig-color-2)',
                                'color2'=> 'var(--wprig-color-1)',
                                'direction'=> 0,
                                'start'=> 0,
                                'stop'=> 100,
                                'type'=> 'linear'
                            ]
                        ],
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'shareFillType',
                                        'relation' => '==',
                                        'value' => "fill",
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .share , {{WPRIG}} .share .tool-tip a' 
                            ]
                        ]
                    ],
                    'shareButtonBgColorHover' => [
                        'type' => 'object',
                        'default' => [
                            'type' => 'color',
                            'openColor' => 1,
                            'color' => '#333',
                            'gradient' => [
                                'color1'=> '#16d03e',
                                'color2'=> '#1f91f3',
                                'direction'=> 0,
                                'start'=> 0,
                                'stop'=> 100,
                                'type'=> 'linear'
                            ]
                        ],
                        'style' => [
                            [                            
                                'selector' => '{{WPRIG}} .share:hover, {{WPRIG}} .share .tool-tip a:hover' 
                            ]
                        ]
                    ],
                    'shareButtonBorder' => [
                        'type' => 'object',
                        'default' => [
                            'openBorder' => 1,
                            'widthType' => 'global',
                            'global' => ['md' => '1' ],
                            'type' => 'solid',
                            'color' => 'var(--wprig-color-1)' 
                        ],
                        'style' => [
                            [                            
                                'selector' => '{{WPRIG}} .share,{{WPRIG}} .share .tool-tip a:hover' 
                            ]
                        ]
                    ],
                    'shareButtonBorderHoverColor' => [
                        'type' => 'string',
                        'default' => '#fff',
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .share:hover,{{WPRIG}} .share .tool-tip a:hover{border-color: {{shareButtonBorderHoverColor}};}' 
                            ]
                        ]
                    ],
                    'shareButtonBorderRadius' => [
                        'type' => 'object',
                        'default' => [
                            'openBorderRadius'=> 1,
                            'radiusType'=> 'global',
                            'global'=> [ 'md'=> 4 ],
                            'unit'=> 'px',
                        ],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .share,{{WPRIG}} .share .tool-tip a' 
                            ]
                        ]
                    ],
                    'shareButtonShadow' => [
                        'type' => 'object',
                        'default' => [],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .share,{{WPRIG}} .share .tool-tip a' 
                            ]
                        ]
                    ],
                    'shareButtonShadowHover' => [
                        'type' => 'object',
                        'default' => [],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .share:hover,{{WPRIG}} .share .tool-tip a:hover' 
                            ]
                        ]
                    ],
                    'enableFacebook' => [
                        'type' => 'boolean',
                        'default' => true
                    ], 
                    'enableModal' => [
                        'type' => 'boolean',
                        'default' => true
                    ], 
                    'modalOverlayBg' => [
                        'type' => 'object',
                        'default' => [
                            'bgimgPosition' => 'center center',
                            'bgimgSize' => 'cover',
                            'bgimgRepeat' => 'no-repeat',
                            'bgDefaultColor' => '',
                            'bgimageSource' => 'local',
                            'externalImageUrl' => []
                        ],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} ~ .components-modal__screen-overlay'
                            ]
                        ]
                    ],
                    'overlayLayout' => [
                        'type'=> 'string',
                        'default'=> 'overlay-layout-2'
                    ],
    
                    'enableBannerOverlay' => [
                        'type' => 'boolean',
                        'default' => false
                    ],
                    'bannerBg' => [
                        'type' => 'object',
                        'default' => [
                            'bgimgPosition' => 'center center',
                            'bgimgSize' => 'cover',
                            'bgimgRepeat' => 'no-repeat',
                            'bgDefaultColor' => '',
                            'bgimageSource' => 'local',
                            'externalImageUrl' => []
                        ],
                        'style' => [
                            ['selector' => '{{WPRIG}} .overlay' ]
                        ]
                    ],
                    'bannerOverlay' => [
                        'type' => 'object',
                        'default' => [],
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .overlay' 
                            ]
                        ]
                    ],
                    'bannerBlend' => [
                        'type' => 'string',
                        'default' => '',
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .overlay { mix-blend-mode: {{bannerBlend}}; }' 
                            ]
                        ]
                    ],
                    'bannerOpacity' => [
                        'type' => 'string',
                        'default' => '0.8',
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .overlay { opacity: {{bannerOpacity}}; }' 
                            ]
                        ]
                    ],
                    'enableBannerOverlayHover' => [
                        'type' => 'boolean',
                        'default' => false
                    ],
                    'bannerOverlayHover' => [
                        'type' => 'object',
                        'default' => [],
                        'style' => [
                            [
                                'condition' => [
                                    [
                                        'key' => 'enableBannerOverlayHover',
                                        'relation' => '==',
                                        'value' => true,
                                    ]
                                ],
                                'selector' => '{{WPRIG}} .wprig-block-info-box' 
                            ]
                        ]
                    ],
                    'bannerBlendHover' => [
                        'type' => 'string',
                        'default' => '',
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .overlay { mix-blend-mode: {{bannerBlendHover}}; }' 
                            ]
                        ]
                    ],
                    'bannerOpacityHover' => [
                        'type' => 'string',
                        'default' => '0.8',
                        'style' => [
                            [
                                'selector' => '{{WPRIG}} .overlay { mix-blend-mode: {{bannerOpacityHover}}; }' 
                            ]
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
    
                    'overlayEffect' => [
                        'type'=>'string',
                        'default'=>'let-me-in'
                    ],
    
                    'hoverEffect'=> [
                        'type'=> 'string',
                        'default'=> 'wprig-box-effect-1'
                    ],
                    'hoverEffectDirection'=> [
                        'type'=> 'string',
                        'default'=> ''
                    ],
                    'enableHoverFx' =>[
                        'type' => 'boolean',
                        'default' => false,
                    ],
                    'overlayEffect' => [
                        'type'=>'string',
                        'default'=>'overlay-slidedown'
                    ],
    
                    'modalLayout' => [
                        'type'=> 'string',
                        'default'=> 'modal-layout-1'
                    ],
                    
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
    
                ],
                'render_callback' => [$this,'render_block_wprig_image_grid']
            ]
        );
    }
    function enqueue_skin_additional_assets($skin){    
        wp_enqueue_style( 'slick', WPRIG_DIR_URL . 'vendors/slick-carousel/slick.css', false, microtime() );
        wp_enqueue_style( 'slick-theme', WPRIG_DIR_URL . 'vendors/slick-carousel/slick-theme.css', false, microtime() );
        wp_enqueue_script( 'slick', WPRIG_DIR_URL . 'vendors/slick-carousel/slick.min.js', array( 'jquery' ), microtime() );

        wp_enqueue_script( 'jquery-mosaic', WPRIG_DIR_URL . 'vendors/jquery-mosaic/jquery.mosaic.min.js', array( 'jquery' ), microtime() );

        wp_enqueue_script( 'images-loaded', WPRIG_DIR_URL . 'vendors/imagesloaded.pkgd.min.js', array( 'jquery' ), microtime() );
        wp_enqueue_script( 'jquery-masonry-2', WPRIG_DIR_URL . 'vendors/masonry.pkgd.min.js', array( 'jquery' ), microtime() );
    
        wp_enqueue_script( 'riseup-gallery', WPRIG_DIR_URL . 'assets/js/riseup-gallery.js', array( 'jquery' ), microtime(), true );
        wp_enqueue_script( 'gallery-carousel', WPRIG_DIR_URL . 'assets/js/front.js', array( 'jquery' ), microtime(), true );
    }
    function render_block_wprig_image_grid($att){
        $uniqueId 		        = isset($att['uniqueId']) ? $att['uniqueId'] : '';
        $className 		        = isset($att['className']) ? $att['className'] : '';
        $imageItems 		    = isset($att['imageItems']) ? (array) $att['imageItems'] : '';
        $enableHoverFx 		        = isset($att['enableHoverFx']) ? $att['enableHoverFx'] : false;
        $hoverEffect 		    = isset($att['hoverEffect']) ? (array) $att['hoverEffect'] : '';
        $hoverEffectDirection 		    = isset($att['hoverEffectDirection']) ? (array) $att['hoverEffectDirection'] : '';
        $overlayEffect 		        = isset($att['overlayEffect']) ? $att['overlayEffect'] : 'fall';
    
        $overlayLayout 		        = isset($att['overlayLayout']) ? $att['overlayLayout'] : 'overlay-layout-2';
        $enableViewButton 		        = isset($att['enableViewButton']) ? $att['enableViewButton'] : false;
        $viewIconName 		        = isset($att['viewIconName']) ? $att['viewIconName'] : "";
        $viewButtonLabel 		        = isset($att['viewButtonLabel']) ? $att['viewButtonLabel'] : "";
        $columns 		        = isset($att['columns']) ? $att['columns'] : "";
        $gutter 		        = isset($att['gutter']) ? $att['gutter'] : "";
        
        
        $enableShareButton 		        = isset($att['enableShareButton']) ? $att['enableShareButton'] : true;
        $shareIconName 		        = isset($att['shareIconName']) ? $att['shareIconName'] : '';
        $shareButtonLabel 		        = isset($att['shareButtonLabel']) ? $att['shareButtonLabel'] : '';

        $enableFacebook 		        = isset($att['enableFacebook']) ? $att['enableFacebook'] : true;
    
        $modalOverlayBg 		    = isset($att['modalOverlayBg']) ? (array) $att['modalOverlayBg'] : '';
        $carouselItems 		    = isset($att['carouselItems']) ? $att['carouselItems'] : array(
            'md' => 3,
            'sm' => 2,
            'xs' => 1,
        );
    
        $enableDots 		        = isset($att['enableDots']) ? $att['enableDots'] : false;
        $enableArrows 		        = isset($att['enableArrows']) ? $att['enableArrows'] : false;
        $enableModal 		        = isset($att['enableModal']) ? $att['enableModal'] : false;
        $modalLayout 		        = isset($att['modalLayout']) ? $att['modalLayout'] : 'modal-layout-1';
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
    
        $modalSettings = ($enableModal) ? (object) array(
            'id'=>$uniqueId ,
            'overlayEffect' => $overlayEffect ,
            'modalLayout' => $modalLayout
        ): (object) array();
    
        $skin 		        = isset($att['skin']) ? $att['skin'] : '';
    
        $masonrySettings = (object) array(
            'columns' => $columns,
            'gutter' => $gutter
        );
    
        $maxRowHeight 		        = isset($att['maxRowHeight']) ? $att['maxRowHeight'] : "";
        $innerGap 		        = isset($att['innerGap']) ? $att['innerGap'] : "";
    
        $hoverParams = "";
        if($enableHoverFx==true  ){
            $hoverParams  =  $hoverEffect[0]." ". $hoverEffectDirection[0] ." box-effect-active"  ;
        }

    
        if($skin=="carousel"){
    
            $html[] = "<div class=\"wprig-block-$uniqueId $className wprig-custom-gallery wprig-gallery slider riseup-gallery $hoverParams \" 
            data-modal='".json_encode($modalSettings)."'
            data-slick='".json_encode($slickSettings)."'>";
        }else if($skin=="mosaic"){
            $html[] = "<div class=\"wprig-block-$uniqueId $className  wprig-mosaic-gallery riseup-gallery $hoverParams  \" 
            data-max-row-height= '".$maxRowHeight."' data-inner-gap='".$innerGap ."'
             data-modal='".json_encode($modalSettings)."'>";
        }else if ($skin=="masonry"){
            $html[] = "<div class=\"wprig-block-$uniqueId $className wprig-grid-gallery wprig-masonry-gallery riseup-gallery $hoverParams  \"   data-modal='".json_encode($modalSettings) ."'>";
        }else{
            $html[] = "<div class='wprig-modal-wrap '>";
            $html[] = "<div class=\"wprig-block-$uniqueId $className  wprig-custom-gallery wprig-grid-gallery riseup-gallery $hoverParams \"  data-modal='".json_encode($modalSettings)."'>";
        }
    
        $this->enqueue_skin_additional_assets($skin);
    
        if(count($imageItems)){
            foreach( $imageItems as $image){
                $html[] = "<div class='cells'>";
                $html[] = "<div class='overlay'>";
    
                $html[] = "<div class='overlay-content ".$overlayLayout."'>";
                    if($enableViewButton && $enableModal){
                        $html[] = "<button href='".$image['url']."' class='view wprig-gallery-item'  data-id='".$image['id']."'>";
                        $html[] = "<i class='wprig-btn-icon ".$viewIconName."'></i>";
                        $html[] = $viewButtonLabel;
                        $html[] = "</button>";                                      
                    }

                    if($enableShareButton){
                        $html[] = "<button href='#' class='share'>";
                        $html[] = "<i class='wprig-btn-icon ".$shareIconName."'></i>";
                        $html[] = $shareButtonLabel;
                        $html[] = "<ul class='tool-tip'>";

                        if($enableFacebook){
                            $html [] = "<li>
                                            <a href='#'>
                                                <span class='fab fa-facebook'></span>
                                            </a>
                                        </li>";
                        }
                        $html[] = "</ul>";
                        $html[] = "</button>";
                    }
                $html[] = "</div>";
                $html[] = "</div>";
                        if(!$enableViewButton){
                            $html[] = "<a href='".$image['url']."' class='wprig-gallery-item'>";
                            $html[] = "<img src='".$image['url']."'/>";
                            $html[] = "</a>";
                        }else{
                            $html[] = "<img src='".$image['url']."'/>";
                        }
                $html[] = "</div>";
            }
        }
        $html[] = "</div>";
        if($skin==""){
        $html[] = "</div>";
        }
    
        return implode("",$html);
    }
    function renderTooltip(){
        return  "<ul class='tool-tip'>
        <li>
            <a href='#'>
                <span class='fab fa-facebook'></span>
            </a>
        </li>
        <li>
            <a href='#'>
                <span class='fab fa-instagram'></span>
            </a>
        </li>
        <li>
            <a href='#'>
                <span class='fab fa-twitter'></span>
            </a>
        </li>
    </ul>";
        
    }
    function render_modal_component(){
        if(!is_admin()){
            ?>
                    
                    <div class="components-modal__frame wprig-dynamic-modal">
                        <div class="components-modal__header">
                            <div class="components-modal__header-heading-container">
                                <h3 id="components-modal-header-1" class="components-modal__header-heading">
                                        This is my Modal
                                    </h3>                                
                                </div>                            
                                <button type="button" id="close-modal" class="components-button has-icon" aria-label="Close dialog"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path></svg></button>
                            </div>
                            <div class="components-modal__content">                                

                            </div>
                    </div>
                    
                    <?php
        }
    }
    function render_overlay_block(){ ?>
        <div class="components-modal__screen-overlay"></div>    
    <?php }
    function getImageMedia() {
        register_rest_route('riseup', 'get_media', array(
            'methods' => WP_REST_SERVER::READABLE,
            'callback' => [$this,'getMediaItem']
        ));
    }
    function getMediaItem($data){
        if(!isset($data['item']))
            return "Item Not Found";
            
        $id = sanitize_text_field($data['item']);
        $post = get_post($id);
        return $post;
        // return "Hello World";
    }

};

new Riseup_Gallery_Block();
?>