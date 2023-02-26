<?php
/**
 * Paddle Customizer Custom Controls
 */

use Paddle_Custom_Control as GlobalPaddle_Custom_Control;
use Paddle_Slider_Custom_Control as GlobalPaddle_Slider_Custom_Control;

if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Custom Control Base Class
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Paddle_Custom_Control extends WP_Customize_Control {
		protected function get_paddle_resource_url() {
			return trailingslashit( get_template_directory_uri() );
		}
	}

	/**
	 * Custom Section Base Class
	 */
	class Paddle_Custom_Section extends WP_Customize_Section {
		protected function get_paddle_resource_url() {
			return trailingslashit( get_template_directory_uri() );
		}
	}

		/**
		 * Image Radio Button Custom Control
		 *
		 * @author Anthony Hortin <http://maddisondesigns.com>
		 * @license http://www.gnu.org/licenses/gpl-2.0.html
		 * @link https://github.com/maddisondesigns
		 */
	class Paddle_Image_Radio_Button_Custom_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'image_radio_button';

		/**
		 * Option to show more
		 */
		private $toggle = false;

		/**
		 * Number of items to show before show more button
		 */
		private $visible_items = null;
		/**
		 * Label for toggle
		 */
		private $toggle_label = null;

		/**
		 * show count
		 */
		private $show_number = false;

		/**
		 * Full width label
		 */
		private $fullwidth_label = false;

		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			// Check if toggle is enable
			if ( isset( $this->input_attrs['toggle'] ) && $this->input_attrs['toggle'] ) {
				$this->toggle = true;
			}
			// Get number of visible items
			if ( isset( $this->input_attrs['visible_items'] ) && '' !== $this->input_attrs['visible_items'] ) {
				$this->visible_items = $this->input_attrs['visible_items'];
			}
			// Label for toggle
			if ( isset( $this->input_attrs['toggle_label'] ) && '' !== $this->input_attrs['toggle_label'] ) {
				$this->toggle_label = $this->input_attrs['toggle_label'];
			}

			if ( isset( $this->input_attrs['show_number'] ) && $this->input_attrs['show_number'] ) {
				$this->show_number = true;
			}

			if ( isset( $this->input_attrs['fullwidth_label'] ) && $this->input_attrs['fullwidth_label'] ) {
				$this->fullwidth_label = true;
			}
		}
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.0.3', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$counter = 0;
			?>
			<div class="image_radio_button_control paddle-section-spacing paddle-item<?php echo esc_html( $this->fullwidth_label ? ' paddle-fw-label' : '' ); ?>">
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

				<?php
				foreach ( $this->choices as $key => $value ) {

					if ( $this->visible_items && $counter >= $this->visible_items && $this->toggle ) :
						if ( $counter === $this->visible_items ) {

							?>
						 <div class="single-accordion"> 
							<?php
						}
						?>
					<label class="radio-button-label paddle-toggle-item">
						<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
						<img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
						<?php
						if ( $this->show_number ) {
							?>
							 <span class="number"><?php echo esc_attr( $counter + 1 ); ?></span> <?php } ?>
					</label>
						<?php
						if ( $counter === count( $this->choices ) - 1 ) {
							?>
							 </div> <?php } ?>
				<?php else : ?>
					<label class="radio-button-label">
						<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
						<img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
						<?php
						if ( $this->show_number ) {
							?>
							 <span class="number"><?php echo esc_attr( $counter + 1 ); ?></span> <?php } ?>
					</label>
					<?php
					endif;

					$counter++;
				}
				if ( $this->toggle ) {
					?>
					<div class="single-accordion-toggle">
						<span class="count-total"><?php echo esc_attr( $counter - $this->visible_items ); ?></span>
						<span>
							<span class="label-title"><?php echo esc_html( $this->toggle_label ); ?></span>
							<span class="accordion-icon-toggle dashicons dashicons-plus"></span>
						</span>
					</div>
				<?php } ?>
			</div>
			<?php
		}
	}

	/**
	 * Text Radio Button Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Paddle_Text_Radio_Button_Custom_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'text_radio_button';

		/**
		 * Full width label
		 */
		private $fullwidth_label = false;
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );

			if ( isset( $this->input_attrs['fullwidth_label'] ) && $this->input_attrs['fullwidth_label'] ) {
				$this->fullwidth_label = true;
			}
		}
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.0.3', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
			<div class="text_radio_button_control  paddle-item  paddle-item<?php echo esc_html( $this->fullwidth_label ? ' paddle-fw-label' : '' ); ?>">
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

				<div class="radio-buttons">
					<?php foreach ( $this->choices as $key => $value ) { ?>
						<label class="radio-button-label">
							<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
							<span><?php echo esc_html( $value ); ?></span>
						</label>
					<?php	} ?>
				</div>
			</div>
			<?php
		}
	}

	/**
	 * Option buttons Custom Control
	 */
	class Paddle_Option_Buttons_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'option_radio_button';

		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.0.4', 'all' );
		}

		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
			<div class="text_radio_button_control option_radio_button_control  paddle-item">
				<label></label>
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

				<div class="input-wrapper paddle-control-wrapper option-radio-button">
					<?php foreach ( $this->choices as $key => $value ) { ?>
						<label class="radio-button-label radio-button-option">
							<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
							<span><?php echo esc_html( $value ); ?></span>
						</label>
					<?php	} ?>
				</div>

			</div>
			<?php
		}
	}

	/**
	 * Option buttons - use this to show header title and switch between options
	 */
	class Paddle_Option_Buttons_Title_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'option_radio_button_title';

		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.0.4', 'all' );
		}

		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
			<div class="text_radio_button_control option_radio_button_title_control  paddle-item">
				<label></label>
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title"></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

				<div class="input-wrapper paddle-control-wrapper option-radio-button">
					<?php foreach ( $this->choices as $key => $value ) { ?>
						<label class="radio-button-label radio-button-option option-button-title">
							<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
							<span><?php echo esc_html( $value ); ?></span>
						</label>
					<?php	} ?>
				</div>

			</div>
			<?php
		}
	}


	/**
	 * Image Checkbox Custom Control
	 */
	class Paddle_Image_Checkbox_Custom_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'image_checkbox';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
			<div class="image_checkbox_control  paddle-item">
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<?php	$chkboxValues = explode( ',', esc_attr( $this->value() ) ); ?>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-multi-image-checkbox" <?php $this->link(); ?> />
				<?php foreach ( $this->choices as $key => $value ) { ?>
					<label class="checkbox-label">
						<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( in_array( esc_attr( $key ), $chkboxValues ), 1 ); ?> class="multi-image-checkbox"/>
						<img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
					</label>
				<?php	} ?>
			</div>
			<?php
		}
	}

	/**
	 * Slider Custom Control with Image
	 */
	class Paddle_Slider_Opacity_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'slider_control';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_script( 'paddle-custom-controls-js', $this->get_paddle_resource_url() . 'inc/customizer/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.2.5', true );
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.0.3', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
			
			<div class="slider-custom-control  paddle-item">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<span class="opacity-image"></span>
				<input type="number" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />
				<div class="slider" slider-min-value="<?php echo esc_attr( $this->input_attrs['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->input_attrs['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->input_attrs['step'] ); ?>"></div><span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $this->value() ); ?>"></span>
			</div>
			<?php
		}
	}


	/**
	 * Slider Custom Control
	 */
	class Paddle_Slider_Custom_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'slider_control';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_script( 'paddle-custom-controls-js', $this->get_paddle_resource_url() . 'inc/customizer/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.2.3', true );
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
			<div class="slider-custom-control  paddle-item">
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="paddle-label customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><input type="number" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />
				<div class="slider" slider-min-value="<?php echo esc_attr( $this->input_attrs['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->input_attrs['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->input_attrs['step'] ); ?>"></div><span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $this->value() ); ?>"></span>
			</div>
			<?php
		}
	}

	/**
	 * Toggle Switch Custom Control
	 */
	class Paddle_Toggle_Switch_Custom_control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'toggle_switch';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
			<div class="toggle-switch-control  paddle-item">
				<div class="toggle-switch">
					<input type="checkbox" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" class="toggle-switch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" 
														  <?php
															$this->link();
															checked( $this->value() );
															?>
					>
					<label class="toggle-switch-label" for="<?php echo esc_attr( $this->id ); ?>">
						<span class="toggle-switch-inner"></span>
						<span class="toggle-switch-switch"></span>
					</label>
				</div>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
			</div>
			<?php
		}
	}

	/**
	 * Toggle Switch Custom Control
	 */
	class Paddle_Toggle_Switch_Custom_control_2 extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'toggle_switch_2';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
			<div class="toggle-switch-control toggle-switch-control-v2  paddle-item">
				<div class="toggle-switch">
					<input type="checkbox" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" class="toggle-switch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" 
														  <?php
															$this->link();
															checked( $this->value() );
															?>
					>
					<label class="toggle-switch-label" for="<?php echo esc_attr( $this->id ); ?>">
						<span class="toggle-switch-inner toggle-switch-inner-v2">
						</span>
						<span class="toggle-switch-switch">
							<i class="dashicons dashicons-visibility"></i>
						</span>
					</label>
				</div>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
			</div>
			<?php
		}
	}


	/**
	 * Simple Notice Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Paddle_Simple_Notice_Custom_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'simple_notice';

		/**
		 * Array of info to display
		 */
		private $infos      = array();
		private $show_label = false;
		private $show_desc  = false;

		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );

			if ( isset( $this->input_attrs['show_label'] ) && $this->input_attrs['show_label'] ) {
				$this->show_label = true;
			}

			if ( isset( $this->input_attrs['show_desc'] ) && $this->input_attrs['show_desc'] ) {
				$this->show_desc = true;
			}
			// Label for toggle
			if ( isset( $this->input_attrs['infos'] ) && ! empty( $this->input_attrs['infos'] ) ) {
				$this->infos = $this->input_attrs['infos'];
			}

		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$allowed_html = array(
				'a'      => array(
					'href'   => array(),
					'title'  => array(),
					'class'  => array(),
					'target' => array(),
				),
				'br'     => array(),
				'em'     => array(),
				'strong' => array(),
				'i'      => array(
					'class' => array(),
				),
				'span'   => array(
					'class' => array(),
				),
				'code'   => array(),
			);
			?>
			<div class="simple-notice-custom-control">
				<?php if ( ! empty( $this->label ) && $this->show_label ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) && $this->show_desc ) { ?>
					<span class="customize-control-description"><?php echo wp_kses( $this->description, $allowed_html ); ?></span>
				<?php } ?>

				<?php
				if ( ! empty( $this->infos ) ) {
					$html_info = '';
					foreach ( $this->infos as $key => $value ) {
						?>
						<span class="customize-control-description <?php echo esc_html( $key ); ?>">
							<span class="dashicons dashicons-info"></span>
							<span><?php echo wp_kses( $value, $allowed_html ); ?></span>
						</span>
						<?php
					}
				}
				?>
			</div>
			<?php
		}
	}

	/**
	 * Simple Header Title Custom Control
	 * This control shows header label
	 */
	class Paddle_Simple_Header_Title_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'simple_header_title';
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$allowed_html = array(
				'a'      => array(
					'href'   => array(),
					'title'  => array(),
					'class'  => array(),
					'target' => array(),
				),
				'br'     => array(),
				'em'     => array(),
				'strong' => array(),
				'i'      => array(
					'class' => array(),
				),
				'span'   => array(
					'class' => array(),
				),
				'code'   => array(),
			);
			?>
			<div class="simple-notice-custom-control">
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title paddle-simple-header-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo wp_kses( $this->description, $allowed_html ); ?></span>
				<?php } ?>
			</div>
			<?php
		}
	}

	/**
	 * Simple Header Title Custom Control
	 * This control shows header label
	 */
	class Paddle_Simple_Header_Title_Control_2 extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'simple_header_title_2';
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$allowed_html = array(
				'a'      => array(
					'href'   => array(),
					'title'  => array(),
					'class'  => array(),
					'target' => array(),
				),
				'br'     => array(),
				'em'     => array(),
				'strong' => array(),
				'i'      => array(
					'class' => array(),
				),
				'span'   => array(
					'class' => array(),
				),
				'code'   => array(),
			);
			?>
			<div class="simple-notice-custom-control">
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title paddle-simple-header-title-2"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo wp_kses( $this->description, $allowed_html ); ?></span>
				<?php } ?>
			</div>
			<?php
		}
	}

		/**
		 * Sortable Pill Checkbox Custom Control
		 *
		 * @author Anthony Hortin <http://maddisondesigns.com>
		 * @license http://www.gnu.org/licenses/gpl-2.0.html
		 * @link https://github.com/maddisondesigns
		 */
	class Paddle_Pill_Checkbox_Custom_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'pill_checkbox';
		/**
		 * Define whether the pills can be sorted using drag 'n drop. Either false or true. Default = false
		 */
		private $sortable = false;
		/**
		 * The width of the pills. Each pill can be auto width or full width. Default = false
		 */
		private $fullwidth = false;
		/**
		 * The sample to display. This is html code
		 */
		private $sample = null;
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			// Check if these pills are sortable
			if ( isset( $this->input_attrs['sortable'] ) && $this->input_attrs['sortable'] ) {
				$this->sortable = true;
			}
			// Check if the pills should be full width
			if ( isset( $this->input_attrs['fullwidth'] ) && $this->input_attrs['fullwidth'] ) {
				$this->fullwidth = true;
			}
			// Check if the pills should show sample
			if ( isset( $this->input_attrs['sample'] ) && '' !== $this->input_attrs['sample'] ) {
				$this->sample = $this->input_attrs['sample'];
			}
		}
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_script( 'paddle-custom-controls-js', $this->get_paddle_resource_url() . 'inc/customizer/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.2.3', true );
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$reordered_choices = array();
			$saved_choices     = explode( ',', esc_attr( $this->value() ) );

			// Order the checkbox choices based on the saved order
			if ( $this->sortable ) {
				foreach ( $saved_choices as $key => $value ) {
					if ( isset( $this->choices[ $value ] ) ) {
						$reordered_choices[ $value ] = $this->choices[ $value ];
					}
				}
				$reordered_choices = array_merge( $reordered_choices, array_diff_assoc( $this->choices, $reordered_choices ) );
			} else {
				$reordered_choices = $this->choices;
			}
			?>
			<div class="pill_checkbox_control">
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>

				<?php if ( ! empty( $this->sample ) ) { ?>
					<div class="sample-container type-<?php echo esc_attr( $this->sample ); ?>">
						<span><?php echo esc_attr( $this->sample ); ?> preview</span>
						<a class="button" a href="#">
							Button
						</a>
					</div>
				<?php } ?>
				
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-sortable-pill-checkbox" <?php $this->link(); ?> />
				<div class="sortable_pills<?php echo ( $this->sortable ? ' sortable' : '' ) . ( $this->fullwidth ? ' fullwidth_pills' : '' ); ?>">
				<?php foreach ( $reordered_choices as $key => $value ) { ?>
					<label class="checkbox-label">
						<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( in_array( esc_attr( $key ), $saved_choices, true ), true ); ?> class="sortable-pill-checkbox"/>
						<span class="sortable-pill-title"><?php echo esc_attr( $value ); ?></span>
						<?php if ( $this->sortable && $this->fullwidth ) { ?>
							<span class="dashicons dashicons-sort"></span>
						<?php } ?>
					</label>
				<?php	} ?>
				</div>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
			</div>
			<?php
		}
	}

	/**
	 * Upsell section
	 */
	class Paddle_Upsell_Section extends Paddle_Custom_Section {
		/**
		 * The type of control being rendered
		 */
		public $type = 'paddle-upsell';
		/**
		 * The Upsell URL
		 */
		public $url = '';
		/**
		 * The background color for the control
		 */
		public $backgroundcolor = '';
		/**
		 * The text color for the control
		 */
		public $textcolor = '';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_script( 'paddle-custom-controls-js', $this->get_paddle_resource_url() . 'inc/customizer/js/customizer.js', array( 'jquery' ), '1.2.1', true );
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.0.3', 'all' );
		}
		/**
		 * Render the section, and the controls that have been added to it.
		 */
		protected function render() {
			$bkgrndcolor = ! empty( $this->backgroundcolor ) ? esc_attr( $this->backgroundcolor ) : '#fff';
			$color       = ! empty( $this->textcolor ) ? esc_attr( $this->textcolor ) : '#555d66';
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="paddle_upsell_section accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
				<h3 class="upsell-section-title" <?php echo ' style="color:' . esc_attr( $color ) . ';border-left-color:' . esc_attr( $bkgrndcolor ) . ';border-right-color:' . esc_attr( $bkgrndcolor ) . ';"'; ?>>
					<a href="<?php echo esc_url( $this->url ); ?>" target="_blank"<?php echo ' style="background-color:' . esc_attr( $bkgrndcolor ) . ';color:' . esc_attr( $color ) . ';"'; ?>><?php echo esc_html( $this->title ); ?></a>
				</h3>
			</li>
			<?php
		}
	}


	/**
	 * Sortable Repeater Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Paddle_Sortable_Repeater_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'sortable_repeater';
		/**
		 * Button labels
		 */
		public $button_labels = array();

		/**
		 * Multiple input
		 */
		private $multiple_input = false;

		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			// Merge the passed button labels with our default labels
			$this->button_labels = wp_parse_args(
				$this->button_labels,
				array(
					'add' => __( 'Add', 'paddle' ),
				)
			);
			if ( isset( $this->input_attrs['multiple_input'] ) && $this->input_attrs['multiple_input'] ) {
				$this->multiple_input = true;
			}
		}
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_script( 'paddle-custom-controls-js', $this->get_paddle_resource_url() . 'js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.3.2', true );
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'css/customizer.css', array(), '1.0', 'all' );
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
		  <div class="sortable_repeater_control  paddle-item">
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-sortable-repeater" <?php $this->link(); ?> />
				<div class="sortable_repeater sortable<?php if ( $this->multiple_input ) { echo esc_html(' is-multiple-input');} else { echo esc_html(' is-single-input');} ?>">
					<div class="repeater">
						<?php if ( $this->multiple_input ) : ?>
						<input type="text" value="" class="repeater-input is-text" placeholder="title" />
						<?php endif; ?>
						<input type="url" value="" class="repeater-input is-url" placeholder="https://" />
						<span class="dashicons dashicons-sort"></span><a class="customize-control-sortable-repeater-delete" href="#"><span class="dashicons dashicons-no-alt"></span></a>
					</div>
				</div>
				<button class="button customize-control-sortable-repeater-add" type="button"><?php echo esc_html( $this->button_labels['add'] ); ?></button>
			</div>
			<?php
		}
	}

	/**
	 * Dropdown Posts Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Paddle_Dropdown_Menu_Custom_Control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'dropdown_menu';
		/**
		 * Posts
		 */
		private $posts = array();
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			// Get our Posts
			$this->posts = paddle_get_registered_menu();
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
			<div class="dropdown_menu_control">
				<?php if( !empty( $this->label ) ) { ?>
					<label for="<?php echo esc_attr( $this->id ); ?>" class="customize-control-title">
						<?php echo esc_html( $this->label ); ?>
					</label>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<select class="customize-control-select-dropdown-menu" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>" <?php $this->link(); ?>>
					<option value=""> -- </option>
					<?php
						if( !empty( $this->posts ) ) {
							foreach ( $this->posts as $post ) {
								printf( '<option value="%s" %s>%s</option>',
									$post,
									selected( $this->value(), $post, false ),
									$post
								);
							}
						}
					?>
				</select>
			</div>
		<?php
		}
	}

	/**
	 * TinyMCE Custom Control
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class Paddle_TinyMCE_Custom_control extends Paddle_Custom_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'tinymce_editor';
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue(){
			wp_enqueue_script( 'paddle-custom-controls-js', $this->get_paddle_resource_url() . 'inc/customizer/js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.2.5', true );
			wp_enqueue_style( 'paddle-custom-controls-css', $this->get_paddle_resource_url() . 'inc/customizer/css/customizer.css', array(), '1.0.3', 'all' );
			wp_enqueue_editor();
		}
		/**
		 * Pass our TinyMCE toolbar string to JavaScript
		 */
		public function to_json() {
			parent::to_json();
			$this->json['paddletinymcetoolbar1'] = isset( $this->input_attrs['toolbar1'] ) ? esc_attr( $this->input_attrs['toolbar1'] ) : 'bold italic bullist numlist alignleft aligncenter alignright link';
			$this->json['paddletinymcetoolbar2'] = isset( $this->input_attrs['toolbar2'] ) ? esc_attr( $this->input_attrs['toolbar2'] ) : '';
			$this->json['paddlemediabuttons'] = isset( $this->input_attrs['mediaButtons'] ) && ( $this->input_attrs['mediaButtons'] === true ) ? true : false;
		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content(){
		?>
			<div class="tinymce-control">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<textarea id="<?php echo esc_attr( $this->id ); ?>" class="customize-control-tinymce-editor" <?php $this->link(); ?>><?php echo wp_kses_post( $this->value() ); ?></textarea>
			</div>
		<?php
		}
	}
	/**
	 * URL sanitization
	 *
	 * @param  string   Input to be sanitized (either a string containing a single url or multiple, separated by commas)
	 * @return string   Sanitized input
	 */
	if ( ! function_exists( 'paddle_url_sanitization' ) ) {
		function paddle_url_sanitization( $input ) {
			if ( strpos( $input, ',' ) !== false ) {
				$input = explode( ',', $input );
			}
			if ( is_array( $input ) ) {
				foreach ( $input as $key => $value ) {
					$input[ $key ] = esc_url_raw( $value );
				}
				$input = implode( ',', $input );
			} else {
				$input = esc_url_raw( $input );
			}
			return $input;
		}
	}

	/**
	 * Switch sanitization
	 *
	 * @param  string       Switch value
	 * @return integer  Sanitized value
	 */
	if ( ! function_exists( 'paddle_switch_sanitization' ) ) {
		function paddle_switch_sanitization( $input ) {
			if ( true === $input ) {
				return 1;
			} else {
				return 0;
			}
		}
	}

	/**
	 * Radio Button and Select sanitization
	 *
	 * @param  string       Radio Button value
	 * @return integer  Sanitized value
	 */
	if ( ! function_exists( 'paddle_radio_sanitization' ) ) {
		function paddle_radio_sanitization( $input, $setting ) {
			// get the list of possible radio box or select options
			$choices = $setting->manager->get_control( $setting->id )->choices;

			if ( array_key_exists( $input, $choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		}
	}

	/**
	 * Integer sanitization
	 *
	 * @param  string       Input value to check
	 * @return integer  Returned integer value
	 */
	if ( ! function_exists( 'paddle_sanitize_integer' ) ) {
		function paddle_sanitize_integer( $input ) {
			return (int) $input;
		}
	}

	/**
	 * Text sanitization
	 *
	 * @param  string   Input to be sanitized (either a string containing a single string or multiple, separated by commas)
	 * @return string   Sanitized input
	 */
	if ( ! function_exists( 'paddle_text_sanitization' ) ) {
		function paddle_text_sanitization( $input ) {
			if ( strpos( $input, ',' ) !== false ) {
				$input = explode( ',', $input );
			}
			if ( is_array( $input ) ) {
				foreach ( $input as $key => $value ) {
					$input[ $key ] = sanitize_text_field( $value );
				}
				$input = implode( ',', $input );
			} else {
				$input = sanitize_text_field( $input );
			}
			return $input;
		}
	}

	/**
	 * Array sanitization
	 *
	 * @param  array    Input to be sanitized
	 * @return array    Sanitized input
	 */
	if ( ! function_exists( 'paddle_array_sanitization' ) ) {
		function paddle_array_sanitization( $input ) {
			if ( is_array( $input ) ) {
				foreach ( $input as $key => $value ) {
					$input[ $key ] = sanitize_text_field( $value );
				}
			} else {
				$input = '';
			}
			return $input;
		}
	}

	/**
	 * Only allow values between a certain minimum & maxmium range
	 *
	 * @param  number   Input to be sanitized
	 * @return number   Sanitized input
	 */
	if ( ! function_exists( 'paddle_in_range' ) ) {
		function paddle_in_range( $input, $min, $max ) {
			if ( $input < $min ) {
				$input = $min;
			}
			if ( $input > $max ) {
				$input = $max;
			}
			return $input;
		}
	}


	/**
	 * Slider sanitization
	 *
	 * @param  string   Slider value to be sanitized
	 * @return string   Sanitized input
	 */
	if ( ! function_exists( 'paddle_range_sanitization' ) ) {
		function paddle_range_sanitization( $input, $setting ) {
			$attrs = $setting->manager->get_control( $setting->id )->input_attrs;

			$min  = ( isset( $attrs['min'] ) ? $attrs['min'] : $input );
			$max  = ( isset( $attrs['max'] ) ? $attrs['max'] : $input );
			$step = ( isset( $attrs['step'] ) ? $attrs['step'] : 1 );

			$number = floor( $input / $attrs['step'] ) * $attrs['step'];

			return paddle_in_range( $number, $min, $max );
		}
	}

	if ( ! function_exists( 'paddle_check_active_control_enable_secondary_color' ) ) {

		/**
		 * Check if enable banner background color checkbox is active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_check_active_control_enable_secondary_color( $control ) {

			if ( 1 === $control->manager->get_setting( 'enable_secondary_color' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}


	if ( ! function_exists( 'paddle_check_theme_header_options' ) ) {

		/**
		 * Check the active header style.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_check_theme_header_options( $control ) {
			if ( 'logo-left-style-2' === $control->manager->get_setting( 'paddle_header_layout_style' )->value()
				&& '#ffffff' !== $control->manager->get_setting( 'paddle_menu_bgcolor' )->value()
				&& 1 === $control->manager->get_setting( 'paddle_header_cta' )->value()
				&& paddle_count_menu_items() > 5
				) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_using_header_1_4' ) ) {

		/**
		 * Check the active header style.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_using_header_1_4( $control ) {
			$style_array = array( 'paddle-header-1', 'paddle-header-2', 'paddle-header-3', 'paddle-header-4' );
			if ( in_array( $control->manager->get_setting( 'paddle_header_layout_style' )->value(), $style_array ) ) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_using_header_1_4_desktop_selected' ) ) {

		/**
		 * Check the active header style.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_using_header_1_4_desktop_selected( $control ) {
			$style_array = array( 'paddle-header-1', 'paddle-header-2', 'paddle-header-3', 'paddle-header-4' );
			if ( in_array( $control->manager->get_setting( 'paddle_header_layout_style' )->value(), $style_array )
			&& 'desktop' === $control->manager->get_setting( 'title_options_header' )->value()
			&& 1 === $control->manager->get_setting( 'paddle_header_search_button' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_count_menu_items' ) ) {
		/**
		 * Count menu items
		 *
		 * @return Number
		 */
		function paddle_count_menu_items() {
			$theme_location  = 'primary';
			$theme_locations = get_nav_menu_locations();
			$counter         = 0;
			if ( is_array( $theme_locations ) ) {
				if ( isset( $theme_locations[ $theme_location ] ) ) {
					$menu_obj    = get_term( $theme_locations[ $theme_location ], 'nav_menu' );
					$dc_get_menu = wp_get_nav_menu_items( $menu_obj->name );

					if ( is_array( $dc_get_menu ) ) {
						foreach ( $dc_get_menu as $key => $menu_item ) {
							if ( $menu_item->menu_item_parent != 0 ) {
								continue;
							}
							$counter++;
						}
					}
				}
			}

			return $counter;
		}
	}


	if ( ! function_exists( 'paddle_top_header_option_contact' ) ) {
		/**
		 * Check the contact option is selected
		 *
		 * @param  mixed $control
		 * @return void
		 */
		function paddle_top_header_option_contact( $control ) {
			if ( true == $control->manager->get_setting( 'enable_top_bar' )->value()
			&& 'contact' == $control->manager->get_setting( 'top_bar_options_header' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_top_header_option_content' ) ) {
		/**
		 * Check the links option is selected
		 *
		 * @param  mixed $control
		 * @return void
		 */
		function paddle_top_header_option_content( $control ) {
			if ( true == $control->manager->get_setting( 'enable_top_bar' )->value()
			&& 'content' == $control->manager->get_setting( 'top_bar_options_header' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_top_header_option_content_is_menu' ) ) {
		/**
		 * Check the links option is selected
		 *
		 * @param  mixed $control
		 * @return void
		 */
		function paddle_top_header_option_content_is_menu( $control ) {
			if ( true == $control->manager->get_setting( 'enable_top_bar' )->value()
			&& 'menu' === $control->manager->get_setting( 'topbar_content_select' )->value()
			&& 'content' == $control->manager->get_setting( 'top_bar_options_header' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_top_header_option_content_is_content' ) ) {
		/**
		 * Check the links option is selected
		 *
		 * @param  mixed $control
		 * @return void
		 */
		function paddle_top_header_option_content_is_content( $control ) {
			if ( true == $control->manager->get_setting( 'enable_top_bar' )->value()
			&& 'content' === $control->manager->get_setting( 'topbar_content_select' )->value()
			&& 'content' == $control->manager->get_setting( 'top_bar_options_header' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}
	}


	if ( ! function_exists( 'paddle_top_header_option_settings' ) ) {
		/**
		 * Check the links option is selected
		 *
		 * @param  mixed $control
		 * @return void
		 */
		function paddle_top_header_option_settings( $control ) {
			if ( true == $control->manager->get_setting( 'enable_top_bar' )->value()
			&& 'settings' == $control->manager->get_setting( 'top_bar_options_header' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_top_header_border_active' ) ) {
		/**
		 * Check the links option is selected
		 *
		 * @param  mixed $control
		 * @return void
		 */
		function paddle_top_header_border_active( $control ) {
			if ( true == $control->manager->get_setting( 'enable_top_bar' )->value()
			&& 1 === $control->manager->get_setting( 'topbar_border_bottom' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_is_top_header_active' ) ) :

		/**
		 * Check if featured slider is active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_is_top_header_active( $control ) {

			if ( true == $control->manager->get_setting( 'enable_top_bar' )->value() ) {
				return true;
			} else {
				return false;
			}

		}

	endif;

	if ( ! function_exists( 'paddle_top_header_select_button' ) ) {
		/**
		 * Check the top header is active and button is selected
		 *
		 * @param  mixed $control
		 * @return void
		 */
		function paddle_top_header_select_button( $control ) {
			if ( true == $control->manager->get_setting( 'enable_top_bar' )->value()
			&& 'button' == $control->manager->get_setting( 'topbar_select' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_top_header_select_social' ) ) {
		/**
		 * Check the top header is active and social link is selected
		 *
		 * @param  mixed $control
		 * @return void
		 */
		function paddle_top_header_select_social( $control ) {
			if ( true == $control->manager->get_setting( 'enable_top_bar' )->value()
			&& 'social' == $control->manager->get_setting( 'topbar_select' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_footer_select_social' ) ) {
		/**
		 * Check the top header is active and social link is selected
		 *
		 * @param  mixed $control
		 * @return void
		 */
		function paddle_footer_select_social( $control ) {
			if ( true == $control->manager->get_setting( 'paddle_footer_social' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_banner_bgcolor_active' ) ) :

		/**
		 * Check if enable banner background color checkbox is active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_banner_bgcolor_active( $control ) {

			if ( 1 === $control->manager->get_setting( 'paddle_enable_banner_bgcolor' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'header_media_selected_hero' ) ) :

		/**
		 * Check Hero is selected
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function header_media_selected_hero( $control ) {

			if ( 'hero' === $control->manager->get_setting( 'header_media_select' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'header_media_selected_slider' ) ) :

		/**
		 * Check Slider is selected
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function header_media_selected_slider( $control ) {

			if ( 'slider' === $control->manager->get_setting( 'header_media_select' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_slider_pid_active' ) ) :

		/**
		 * Check if user has selected source by ids.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_slider_pid_active( $control ) {

			if ( 'post-ids' === $control->manager->get_setting( 'paddle_slider_source' )->value()
				&& 'slider' === $control->manager->get_setting( 'header_media_select' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_slider_source_from_page_active' ) ) :

		/**
		 * Check if user has selected source from page for slider.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_slider_source_from_page_active( $control ) {

			if ( 'page' === $control->manager->get_setting( 'paddle_slider_source' )->value()
				&& 'slider' === $control->manager->get_setting( 'header_media_select' )->value()
				) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_banner_custom_link_active' ) ) :

		/**
		 * Check if enable banner background color checkbox is active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_banner_custom_link_active( $control ) {

			if ( 1 === $control->manager->get_setting( 'paddle_slider_custom_url' )->value()
			&& 'slider' === $control->manager->get_setting( 'header_media_select' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_is_fullwidth_active' ) ) :

		/**
		 * Check if full with content is active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_is_fullwidth_active( $control ) {

			if ( 1 === $control->manager->get_setting( 'paddle_page_layout_width' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_grid_selected' ) ) :

		/**
		 * Check grid layout is selected.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_grid_selected( $control ) {

			if ( 'grid' === $control->manager->get_setting( 'post_archive_layout' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_custom_content_selected' ) ) :

		/**
		 * Check custom container is selected.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_custom_content_selected( $control ) {

			if ( 'custom' === $control->manager->get_setting( 'custom_container' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_blog_excerpt_enabled' ) ) :

		/**
		 * Check if excerpt is enable.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_blog_excerpt_enabled( $control ) {

			if ( 1 === $control->manager->get_setting( 'enable_blog_excerpt' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_blog_design_archive_selected' ) ) :

		/**
		 * Check if blog design section is selected
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_blog_design_archive_selected( $control ) {

			if ( 'design' === $control->manager->get_setting( 'title_options_blog' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_blog_design_archive_selected_grid_selected' ) ) :

		/**
		 * Check if blog design section is selected and grid layout selected
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_blog_design_archive_selected_grid_selected( $control ) {

			if ( 'design' === $control->manager->get_setting( 'title_options_blog' )->value()
				&& 'grid' === $control->manager->get_setting( 'post_archive_layout' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;



	if ( ! function_exists( 'paddle_blog_general_archive_selected' ) ) :

		/**
		 * Check if blog general section is selected
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_blog_general_archive_selected( $control ) {

			if ( 'general' === $control->manager->get_setting( 'title_options_blog' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;


	if ( ! function_exists( 'paddle_blog_general_archive_selected_excerpt_enabled' ) ) :

		/**
		 * Check if blog general section is selected and excerpt is enabled
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_blog_general_archive_selected_excerpt_enabled( $control ) {

			if ( 'general' === $control->manager->get_setting( 'title_options_blog' )->value()
				&& 1 === $control->manager->get_setting( 'enable_blog_excerpt' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_selected_custom_width' ) ) :

		/**
		 * Check if blog general section is selected and custom width is enable is enabled
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_selected_custom_width( $control ) {

			if ('custom' === $control->manager->get_setting( 'custom_container' )->value() ) {
				return true;
			} else {
				return false;
			}
		}

	endif;

	if ( ! function_exists( 'paddle_check_header_border_is_active' ) ) {

		/**
		 * Check if header border section is active and on desktop section page.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_check_header_border_is_active( $control ) {

			if ( 1 === $control->manager->get_setting( 'menu_border_bottom' )->value()
			&& 'desktop' === $control->manager->get_setting( 'title_options_header' )->value()
			||
			1 === $control->manager->get_setting( 'menu_border_top' )->value()
			&& 'desktop' === $control->manager->get_setting( 'title_options_header' )->value()
			) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_header_desktop_selected' ) ) {

		/**
		 * Check if Desktop Header section is active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_header_desktop_selected( $control ) {

			if ( 'desktop' === $control->manager->get_setting( 'title_options_header' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_header_mobile_selected' ) ) {

		/**
		 * Check if Mobile Header section is active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_header_mobile_selected( $control ) {

			if ( 'mobile' === $control->manager->get_setting( 'title_options_header' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_header_desktop_selected_search_enab' ) ) {

		/**
		 * Check if Desktop Header section is active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_header_desktop_selected_search_enab( $control ) {

			if ( 'desktop' === $control->manager->get_setting( 'title_options_header' )->value()
			&& 1 === $control->manager->get_setting( 'paddle_header_search_button' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_header_desktop_selected_header_6' ) ) {

		/**
		 * Check if Desktop Header section is active and header 6 is selected.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_header_desktop_selected_header_6( $control ) {

			if ( 'desktop' === $control->manager->get_setting( 'title_options_header' )->value()
			&& 'paddle-header-6' === $control->manager->get_setting( 'paddle_header_layout_style' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_header_desktop_selected_header_5' ) ) {

		/**
		 * Check if Desktop Header section is active and header 5 is selected.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_header_desktop_selected_header_5( $control ) {

			if ( 'desktop' === $control->manager->get_setting( 'title_options_header' )->value()
			&& 'paddle-header-5' === $control->manager->get_setting( 'paddle_header_layout_style' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_header_desktop_selected_header_5_6' ) ) {

		/**
		 * Check if Desktop Header section is active and header 5/6 is selected.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_header_desktop_selected_header_5_6( $control ) {

			if ( paddle_header_desktop_selected_header_5( $control )
			|| paddle_header_desktop_selected_header_6( $control ) ) {
				return true;
			} else {
				return false;
			}
		}
	}


	if ( ! function_exists( 'paddle_using_header_1_4_5_desktop_selected' ) ) {

		/**
		 * Check if Desktop selected apply this to section 1-4+5.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_using_header_1_4_5_desktop_selected( $control ) {

			if ( paddle_using_header_1_4_desktop_selected( $control )
			|| 'paddle-header-5' === $control->manager->get_setting( 'paddle_header_layout_style' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_header_desktop_selected_cta_enab' ) ) {

		/**
		 * Check if Desktop Header section is active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_header_desktop_selected_cta_enab( $control ) {

			if ( 'desktop' === $control->manager->get_setting( 'title_options_header' )->value()
			&& 1 === $control->manager->get_setting( 'paddle_header_cta' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * FOOTER
	 */
	if ( ! function_exists( 'paddle_footer_logo_enab' ) ) {

		/**
		 * Check if Desktop Header section is active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_footer_logo_enab( $control ) {

			if ( 1 === $control->manager->get_setting( 'paddle_footer_logo' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_footer_1_content_type_editor' ) ) {

		/**
		 * Check if selected content type is editor.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_footer_1_content_type_editor( $control ) {

			if ( 'editor' === $control->manager->get_setting( 'footer_1_content_type' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	function paddle_footer_1_content_type_html( $control ) {

		if ( 'html' === $control->manager->get_setting( 'footer_1_content_type' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	function paddle_footer_1_content_type_menu( $control ) {

		if ( 'menu' === $control->manager->get_setting( 'footer_1_content_type' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	function paddle_footer_1_content_type_menu_enabled( $control ) {

		if ( 'menu' === $control->manager->get_setting( 'footer_1_content_type' )->value() 
			&& 1 === $control->manager->get_setting( 'footer_1_menu_enable' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	if ( ! function_exists( 'paddle_footer_2_content_type_editor' ) ) {

		/**
		 * Check if selected content type is editor.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_footer_2_content_type_editor( $control ) {

			if ( 'editor' === $control->manager->get_setting( 'footer_2_content_type' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	function paddle_footer_2_content_type_html( $control ) {

		if ( 'html' === $control->manager->get_setting( 'footer_2_content_type' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	function paddle_footer_2_content_type_menu( $control ) {

		if ( 'menu' === $control->manager->get_setting( 'footer_2_content_type' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	function paddle_footer_2_content_type_menu_enabled( $control ) {

		if ( 'menu' === $control->manager->get_setting( 'footer_2_content_type' )->value() 
			&& 1 === $control->manager->get_setting( 'footer_2_menu_enable' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	if ( ! function_exists( 'paddle_footer_3_content_type_editor' ) ) {

		/**
		 * Check if selected content type is editor.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_footer_3_content_type_editor( $control ) {

			if ( 'editor' === $control->manager->get_setting( 'footer_3_content_type' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	function paddle_footer_3_content_type_html( $control ) {

		if ( 'html' === $control->manager->get_setting( 'footer_3_content_type' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	function paddle_footer_3_content_type_menu( $control ) {

		if ( 'menu' === $control->manager->get_setting( 'footer_3_content_type' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	function paddle_footer_3_content_type_menu_enabled( $control ) {

		if ( 'menu' === $control->manager->get_setting( 'footer_3_content_type' )->value() 
			&& 1 === $control->manager->get_setting( 'footer_3_menu_enable' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

		
	if ( ! function_exists( 'paddle_footer_4_content_type_editor' ) ) {

		/**
		 * Check if selected content type is editor.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_footer_4_content_type_editor( $control ) {

			if ( 'editor' === $control->manager->get_setting( 'footer_4_content_type' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	function paddle_footer_4_content_type_html( $control ) {

		if ( 'html' === $control->manager->get_setting( 'footer_4_content_type' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	function paddle_footer_4_content_type_menu( $control ) {

		if ( 'menu' === $control->manager->get_setting( 'footer_4_content_type' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	function paddle_footer_4_content_type_menu_enabled( $control ) {

		if ( 'menu' === $control->manager->get_setting( 'footer_4_content_type' )->value() 
			&& 1 === $control->manager->get_setting( 'footer_4_menu_enable' )->value() ) {
			return true;
		} else {
			return false;
		}
	}

	if ( ! function_exists( 'paddle_footer_about_enab' ) ) {

		/**
		 * Check if about us is  active.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_footer_about_enab( $control ) {

			if ( 1 === $control->manager->get_setting( 'paddle_footer_about_enable' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_page_general_selected' ) ) {

		/**
		 * Check the general section selected.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_page_general_selected( $control ) {

			if ( 'general' === $control->manager->get_setting( 'page_options_header' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}


	if ( ! function_exists( 'paddle_page_meta_selected' ) ) {

		/**
		 * Check the design section selected.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_page_meta_selected( $control ) {

			if ( 'meta' === $control->manager->get_setting( 'page_options_header' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	}

	

	if ( ! function_exists( 'paddle_page_header_is_banner' ) ) {

		/**
		 * Check the header style selected.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_page_header_is_banner( $control ) {

			if ( 'PageBanner' === $control->manager->get_setting( 'paddle_page_header_type' )->value() 
			&& paddle_page_general_selected($control)
			) 
			{
				return true;
			} else {
				return false;
			}
		}
	}

	if ( ! function_exists( 'paddle_page_header_is_default' ) ) {

		/**
		 * Check the header style selected.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
		function paddle_page_header_is_default( $control ) {

			if ( '0' === $control->manager->get_setting( 'paddle_page_header_type' )->value() 
			&& paddle_page_general_selected($control)
			) 
			{
				return true;
			} else {
				return false;
			}
		}
	}

	
}
