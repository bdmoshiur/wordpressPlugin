<?php
/**
 * Elementor Basic Addons.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Basic_addons extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Basic Addons name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'basicaddons';
	}
	
	/**
	 * Get widget title.
	 *
	 * Retrieve Basic Addons title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Basic Addons', 'homepage-sections' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Basic Addons icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-home';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Basic Addons belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Register Basic Addons controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'basic_addons_section',
			[
				'label' => __( 'Basic Addons', 'homepage-sections' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'basic_addons_heading',
			[
				'label' => __( 'Insert Heading', 'homepage-sections' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Enter The Heading', 'homepage-sections' ),
			]
		);

        $this->add_control(
			'basic_addons_description',
			[
				'label' => __( 'Insert Description', 'homepage-sections' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'basic_addons_number',
			[
				'label' => __( 'Insert Number', 'homepage-sections' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
			]
		);

		$this->add_control(
			'basic_addons_icon',
			[
				'label' => __( 'Insert Icon', 'homepage-sections' ),
				'type' => \Elementor\Controls_Manager::ICON,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render Basic Addons output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
        ?>
            <h2><?php echo $settings['basic_addons_heading'] ?></h2>
            <p><?php echo $settings['basic_addons_description'] ?></p>
            <p><?php echo $settings['basic_addons_number'] ?></p>
            <h2><?php echo $settings['basic_addons_icon'] ?></>
        <?php
	}

    protected function content_template() {
        ?>
            <h2>{{{ settings.basic_addons_heading }}}</h2>
            <p>{{{ settings.basic_addons_description }}}</p>
            <p>{{{ settings.basic_addons_number }}}</p>
            <p>{{{ settings.basic_addons_icon }}}</p>
        <?php
	}

}