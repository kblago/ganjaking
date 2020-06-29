<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Porto Elementor Recent Members slider Widget
 *
 * Porto Element widget to display recent members slider.
 *
 * @since 5.4.1
 */

use Elementor\Controls_Manager;

class Porto_Elementor_Recent_Members_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'porto_recent_members';
	}

	public function get_title() {
		return __( 'Recent Members', 'porto-functionality' );
	}

	public function get_categories() {
		return array( 'theme-elements' );
	}

	public function get_keywords() {
		return array( 'recent member', 'person', 'author', 'carousel', 'slider' );
	}

	public function get_script_depends() {
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			return array( 'porto-elementor-widgets-js' );
		} else {
			return array();
		}
	}

	protected function _register_controls() {
		$order_by_values  = array_slice( porto_vc_woo_order_by(), 1 );
		$order_way_values = array_slice( porto_vc_woo_order_way(), 1 );

		$this->start_controls_section(
			'section_members',
			array(
				'label' => __( 'Member Layout', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => __( 'Title', 'porto-functionality' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Title', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'view',
			array(
				'label'     => __( 'View Type', 'porto-functionality' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'classic',
				'options'   => array_combine( array_values( porto_sh_commons( 'member_view' ) ), array_keys( porto_sh_commons( 'member_view' ) ) ),
				'condition' => array(
					'style' => array( '' ),
				),
			)
		);

		$this->add_control(
			'hover_image_effect',
			array(
				'label'   => __( 'Hover Image Effect', 'porto-functionality' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array_combine( array_values( porto_sh_commons( 'custom_zoom' ) ), array_keys( porto_sh_commons( 'custom_zoom' ) ) ),
				'default' => 'zoom',
			)
		);

		$this->add_control(
			'overview',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Show Overview', 'porto-functionality' ),
				'default'   => 'yes',
				'condition' => array(
					'style' => array( '' ),
				),
			)
		);

		$this->add_control(
			'socials',
			array(
				'type'    => Controls_Manager::SWITCHER,
				'label'   => __( 'Show Social Links', 'porto-functionality' ),
				'default' => 'yes',
			)
		);

		$this->add_control(
			'socials_style',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Use Social Links Advance Style', 'porto-functionality' ),
				'default'   => 'yes',
				'condition' => array(
					'socials' => 'yes',
				),
			)
		);

		$this->add_control(
			'spacing',
			array(
				'type'        => Controls_Manager::NUMBER,
				'label'       => __( 'Column Spacing (px)', 'porto-functionality' ),
				'description' => __( 'Default is 25px', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'items_desktop',
			array(
				'type'    => Controls_Manager::NUMBER,
				'label'   => __( 'Items to show on Desktop', 'porto-functionality' ),
				'default' => 4,
				'min'     => 1,
				'max'     => 10,
			)
		);

		$this->add_control(
			'items_tablets',
			array(
				'type'    => Controls_Manager::NUMBER,
				'label'   => __( 'Items to show on Tablets', 'porto-functionality' ),
				'default' => 3,
				'min'     => 1,
				'max'     => 6,
			)
		);

		$this->add_control(
			'items_mobile',
			array(
				'type'    => Controls_Manager::NUMBER,
				'label'   => __( 'Items to show on Mobile', 'porto-functionality' ),
				'default' => 2,
				'min'     => 1,
				'max'     => 4,
			)
		);

		$this->add_control(
			'items_row',
			array(
				'type'    => Controls_Manager::NUMBER,
				'label'   => __( 'Items Row', 'porto-functionality' ),
				'default' => 1,
				'min'     => 1,
				'max'     => 3,
			)
		);

		$this->add_control(
			'cats',
			array(
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Category IDs', 'porto-functionality' ),
				'description' => __( 'comma separated list of category ids', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'number',
			array(
				'type'    => Controls_Manager::NUMBER,
				'label'   => __( 'Members Count', 'porto-functionality' ),
				'default' => 8,
				'min'     => 1,
				'max'     => 100,
			)
		);

		$this->add_control(
			'ajax_load',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => __( 'Enable Ajax Load', 'porto-functionality' ),
			)
		);

		$this->add_control(
			'ajax_modal',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Ajax Load on Modal', 'porto-functionality' ),
				'condition' => array(
					'ajax_load' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_members_slider_options',
			array(
				'label' => __( 'Slider Options', 'porto-functionality' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'slider_config',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => __( 'Change Slider Options', 'porto-functionality' ),
			)
		);

		$slider_options = porto_vc_product_slider_fields();
		unset( $slider_options[2], $slider_options[6], $slider_options[8], $slider_options[9] );
		$slider_options[1]               = array(
			'type'       => 'dropdown',
			'heading'    => __( 'Nav Position', 'porto-functionality' ),
			'param_name' => 'nav_pos',
			'value'      => array(
				__( 'Middle', 'porto-functionality' ) => '',
				__( 'Middle Inside', 'porto-functionality' ) => 'nav-pos-inside',
				__( 'Middle Outside', 'porto-functionality' ) => 'nav-pos-outside',
				__( 'Top', 'porto-functionality' )    => 'show-nav-title',
				__( 'Bottom', 'porto-functionality' ) => 'nav-bottom',
			),
			'dependency' => array(
				'element'   => 'show_nav',
				'not_empty' => true,
			),
		);
		$slider_options[0]['param_name'] = 'show_nav';
		$slider_options[5]['param_name'] = 'show_dots';

		$slider_options[1]['dependency']['element'] = 'show_nav';
		$slider_options[4]['dependency']['element'] = 'show_nav';
		$slider_options[7]['dependency']['element'] = 'show_dots';

		$slider_options = porto_update_vc_options_to_elementor( $slider_options );
		unset( $slider_options['show_nav']['default'] );
		$slider_options['nav_type']['condition'] = array( 'show_nav' => 'yes' );

		foreach ( $slider_options as $key => $opt ) {
			unset( $opt['condition']['view'] );
			$opt['condition']['slider_config'] = 'yes';
			$this->add_control( $key, $opt );
		}

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		if ( $template = porto_shortcode_template( 'porto_recent_members' ) ) {
			include $template;
		}
	}

	protected function content_template() {}
}