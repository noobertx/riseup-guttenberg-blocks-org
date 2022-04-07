/*----------------------------------------------------------------------------*\
	COUNTDOWN SHORTCODE
\*----------------------------------------------------------------------------*/
( function( $ ) {
	"use strict";

    simplyCountdown('.countdown__content',{
        year: 2021,
        month: 6,
        day: 6,
        hours : 14, 
        minutes: 0,
        seconds: 0,
        words: { //words displayed into the countdown
            days: { singular: 'day', plural: 'days' },
            hours: { singular: 'hour', plural: 'hours' },
            minutes: { singular: 'minute', plural: 'minutes' },
            seconds: { singular: 'second', plural: 'seconds' }
        },
        amountClass: 'bg-info'
    
    })
    // console.log("delay init");
	function delay_init( $this, options ) {
		if ( $this.countdown ) {
			$this.countdown( {
                year: 2021,
                month: 6,
                day: 6,
                hours : 14, 
                minutes: 0,
                seconds: 0,
                words: { //words displayed into the countdown
                    days: { singular: 'day', plural: 'days' },
                    hours: { singular: 'hour', plural: 'hours' },
                    minutes: { singular: 'minute', plural: 'minutes' },
                    seconds: { singular: 'second', plural: 'seconds' }
                },
            
            } );
		} else {
			setTimeout( function() {
				// delay_init( $this, options );
			}, 50 );
		}
	}

	var _top_layout, _bottom_layout;

	_bottom_layout = '{y<}<div class="yani-countdown__section"><span class="yani-main"><div><div>{yn}</div></div></span><h4>{yl}</h4></div>{y>}';
	_bottom_layout += '{o<}<div class="yani-countdown__section"><span class="yani-main"><div><div>{on}</div></div></span><h4>{ol}</h4></div>{o>}';
	_bottom_layout += '{d<}<div class="yani-countdown__section"><span class="yani-main"><div><div>{dn}</div></div></span><h4>{dl}</h4></div>{d>}';
	_bottom_layout += '{h<}<div class="yani-countdown__section"><span class="yani-main"><div><div>{hn}</div></div></span><h4>{hl}</h4></div>{h>}';
	_bottom_layout += '{m<}<div class="yani-countdown__section"><span class="yani-main"><div><div>{mn}</div></div></span><h4>{ml}</h4></div>{m>}';
	_bottom_layout += '{s<}<div class="yani-countdown__section"><span class="yani-main"><div><div>{sn}</div></div></span><h4>{sl}</h4></div>{s>}';

	_top_layout = '{y<}<div class="yani-countdown__section"><h4>{yl}</h4><span class="yani-main"><div><div>{yn}</div></div></span></div>{y>}';
	_top_layout += '{o<}<div class="yani-countdown__section"><h4>{ol}</h4><span class="yani-main"><div><div>{on}</div></div></span></div>{o>}';
	_top_layout += '{d<}<div class="yani-countdown__section"><h4>{dl}</h4><span class="yani-main"><div><div>{dn}</div></div></span></div>{d>}';
	_top_layout += '{h<}<div class="yani-countdown__section"><h4>{hl}</h4><span class="yani-main"><div><div>{hn}</div></div></span></div>{h>}';
	_top_layout += '{m<}<div class="yani-countdown__section"><h4>{ml}</h4><span class="yani-main"><div><div>{mn}</div></div></span></div>{m>}';
	_top_layout += '{s<}<div class="yani-countdown__section"><h4>{sl}</h4><span class="yani-main"><div><div>{sn}</div></div></span></div>{s>}';

	function init_shortcode( $countdown ) {
		var $this   = $countdown.find( '.yani-countdown__content' ),
		    _until  = $this.attr( 'data-until' ),
		    _format = $this.attr( 'data-format' ),
		    _layout = $this.attr( 'data-layout' ),
		    _labels = $this.attr( 'data-labels' ).split( '/' ),
		    _label_typography = 'yani-typography--' + $countdown.attr( 'data-label-typo' ),
		    _item_typography  = 'yani-typography--' + $countdown.attr( 'data-item-typo' );

		if( _layout == 'top' ) {
			_layout = _top_layout.replace( /<span class="yani-main">/g, '<span class="yani-main ' + _item_typography + '">' );
			_layout = _layout.replace( /<h4>/g, '<h4 class="' + _label_typography + '">' );
		} else {
			_layout = _bottom_layout.replace( /<span class="yani-main">/g, '<span class="yani-main ' + _item_typography + '">' );
			_layout = _layout.replace( /<h4>/g, '<h4 class="' + _label_typography + '">' );
		}

		// delay_init( $this, { '_until': _until, '_format': _format, '_layout': _layout, '_labels': _labels } );

		$this.attr( 'data-columns', _format.length );

		$countdown.trigger( 'mpc.inited' );

		if( $countdown.attr( 'data-square' ) == '1' ) {
			setTimeout( function() {
				init_square_countdown( $countdown );
			}, 10 );
		}
	}

	function init_square_countdown( $countdown ) {
		var _section_size = 0,
		    _section_size_with_margin = 0,
		    $sections = $countdown.find( '.yani-countdown__section span' );

		$sections.each( function() {
			var $section = $( this );

			if( $section.outerHeight() > $section.outerWidth() && $section.outerHeight() >= _section_size ) {
				_section_size = $section.outerHeight();
				_section_size_with_margin = $section.outerHeight( true );
			} else if( $section.outerWidth() >= _section_size ) {
				_section_size = $section.outerWidth();
				_section_size_with_margin = $section.outerWidth( true );
			}
		});

		var $css = '.yani-countdown[id="' + $countdown.attr( 'id' ) + '"] .yani-main { height: ' +  _section_size + 'px; width: ' + _section_size +'px; }';
		$css += '.yani-countdown[id="' + $countdown.attr( 'id' ) + '"] .yani-countdown__section { min-width: ' + _section_size_with_margin +'px; }';

		$countdown.after( '<style>' + $css + '</style>' );
	}

	if ( typeof window.InlineShortcodeView != 'undefined' ) {
		window.InlineShortcodeView_mpc_countdown = window.InlineShortcodeView.extend( {
			rendered: function() {
				var $countdown = this.$el.find( '.yani-countdown' );

				$countdown.addClass( 'yani-waypoint--init' );

				_mpc_vars.$body.trigger( 'mpc.font-loaded', [ $countdown ] );
				_mpc_vars.$body.trigger( 'mpc.inited', [ $countdown ] );

				init_shortcode( $countdown );

				window.InlineShortcodeView_mpc_countdown.__super__.rendered.call( this );
			},
			beforeUpdate: function () {
				var $countdown = this.$el.find( '.yani-countdown__content' );

				$countdown.countdown( 'destroy' );
				$countdown.siblings( 'style' ).remove();
			}
		} );
	}

	var $countdowns = $( '.yani-countdown' );

	$countdowns.each( function() {
		var $countdown = $( this );

		$countdown.one( 'mpc.init', function () {
			init_shortcode( $countdown );
		} );
	} );
} )( jQuery );