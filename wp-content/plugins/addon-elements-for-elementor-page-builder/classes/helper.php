<?php

namespace WTS_EAE\Classes;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Colors_And_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use WTS_EAE\Controls\Group\Group_Control_Icon;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

class Helper
{
	function eae_get_post_data($args)
	{
		$defaults = array(
			'posts_per_page'   => 5,
			'offset'           => 0,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => 'date',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'post',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'author'           => '',
			'author_name'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => false
		);

		$atts = wp_parse_args($args, $defaults);

		$posts = get_posts($atts);

		return $posts;
	}

	function eae_get_post_types()
	{
		$args = array(
			'public' => true
		);

		$skip_post_types = ['attachment'];

		$post_types = get_post_types($args);

		return $post_types;
	}

	function eae_get_post_settings($settings)
	{
		$post_args['post_type'] = $settings['post_type'];

		if ($settings['post_type'] == 'post') {
			$post_args['category'] = $settings['category'];
		}

		$post_args['posts_per_page'] = $settings['num_posts'];
		$post_args['offset']         = $settings['post_offset'];
		$post_args['orderby']        = $settings['orderby'];
		$post_args['order']          = $settings['order'];

		return $post_args;
	}

	function eae_get_excerpt_by_id($post_id, $excerpt_length)
	{
		$the_post = get_post($post_id); //Gets post ID

		$the_excerpt = null;
		if ($the_post) {
			$the_excerpt = $the_post->post_excerpt ? $the_post->post_excerpt : $the_post->post_content;
		}

		// $the_excerpt = ($the_post ? $the_post->post_content : null);//Gets post_content to be used as a basis for the excerpt
		//echo $the_excerpt;
		$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
		$words       = explode(' ', $the_excerpt, $excerpt_length + 1);

		if (count($words) > $excerpt_length) :
			array_pop($words);
			//array_push($words, '…');
			$the_excerpt = implode(' ', $words);
			$the_excerpt .= '...';  // Don't put a space before
		endif;

		return $the_excerpt;
	}

	function eae_get_thumbnail_sizes()
	{
		$sizes = get_intermediate_image_sizes();
		foreach ($sizes as $s) {
			$ret[$s] = $s;
		}

		return $ret;
	}

	function eae_get_post_orderby_options()
	{
		$orderby = array(
			'ID'            => 'Post Id',
			'author'        => 'Post Author',
			'title'         => 'Title',
			'date'          => 'Date',
			'modified'      => 'Last Modified Date',
			'parent'        => 'Parent Id',
			'rand'          => 'Random',
			'comment_count' => 'Comment Count',
			'menu_order'    => 'Menu Order',
		);

		return $orderby;
	}

	public function get_icon_html($settings, $control_name, $default, $all_settings)
	{

		$icon_html = '';
		$skin_type = $all_settings['_skin'];
		//echo '<pre>'; print_r($settings); echo '</pre>';die();
		// --------------New Work-----------------

		$view = 'eae-icon-view-' . $default['view'];
		$shape = 'eae-icon-shape-' . $default['shape'];

		$icon_migrated = isset($all_settings['__fa4_migrated'][$skin_type . '_global_icon_new']);
		$icon_is_new = empty($all_settings[$skin_type . '_global_icon']);

		$item_icon_migrated = isset($settings['__fa4_migrated'][$control_name . '_icon_new']);
		$item_icon_is_new = empty($settings[$control_name . '_icon']);
		if (!isset($settings[$control_name . '_eae_icon']) ||  $settings[$control_name . '_eae_icon'] == '') {

			switch ($default['icon_type']) {

				case 'image':
					$icon_html = '<i><img src="' . $default['image']['url'] . '"/></i>';
					break;

				case 'text':
					$icon_html = '<i class="">' . $default['text'] . '</i>';
					break;
			}

			$view = 'eae-icon-view-' . $default['view'];
			$shape = 'eae-icon-shape-' . $default['shape'];
			$icon_type = 'eae-icon-type-' . $default['icon_type'];
			$icon_name = 'eae-icon-' . $control_name;

			if ($default['icon_new'] !== '') {
?>
				<div class="eae-icon <?php echo $icon_name . ' ' . $view . ' ' . $shape . ' ' . $icon_type; ?>">
					<div class="eae-icon-wrap">
						<?php if ($default['icon_type'] == 'icon') { ?>
							<?php if ($icon_migrated || $icon_is_new) :
								Icons_Manager::render_icon($all_settings[$skin_type . '_global_icon_new'], ['aria-hidden' => 'true']);
							else : ?>
								<i class="<?php echo $default['icon']; ?>"></i>
							<?php endif; ?>
						<?php } else {
							echo $icon_html;
						} ?>
					</div>
				</div>
			<?php
			}
		} else {
			//echo $settings[ $control_name . '_icon_text' ];
			switch ($settings[$control_name . '_icon_type']) {


				case 'image':
					$icon_html = '<i><img src="' . $settings[$control_name . '_image']['url'] . '" /></i>';
					break;

				case 'text':
					$icon_html = '<i class="">' . $settings[$control_name . '_text'] . '</i>';
					break;
			}

			if ($settings[$control_name . '_view'] != 'global') {
				$view = 'eae-icon-view-' . $settings[$control_name . '_view'];
			}

			if ($settings[$control_name . '_shape'] != 'global') {
				$shape = 'eae-icon-shape-' . $settings[$control_name . '_shape'];
			}

			$icon_type = 'eae-icon-type-' . $settings[$control_name . '_icon_type'];

			$icon_name = 'eae-icon-' . $control_name;
		}
		if (isset($settings[$control_name . '_eae_icon'])  && $settings[$control_name . '_eae_icon'] !== '') {
			?>
			<div class="eae-icon <?php echo $icon_name . ' ' . $view . ' ' . $shape . ' ' . $icon_type; ?>">
				<div class="eae-icon-wrap">
					<?php
					if ($settings[$control_name . '_icon_type'] == 'icon') { ?>
						<?php if ($item_icon_migrated || $item_icon_is_new) :
							Icons_Manager::render_icon($settings[$control_name . '_icon_new'], ['aria-hidden' => 'true']);
						else : ?>
							<i class="<?php echo $settings[$control_name . '_icon']; ?>"></i>
						<?php endif; ?>
					<?php } else {
						echo $icon_html;
					} ?>
				</div>
			</div>
<?php
		}
		//return $icon_html;
	}

	public function get_icon_timeline_html($settings, $control_name)
	{

		$icon_html = '';
		//echo '<pre>'; print_r($settings); echo '</pre>';
		$icon_data = '';

		if ($settings[$control_name . '_eae_icon'] == '') {
			$settings[$control_name . '_icon']  = 'fa fa-star';
			$settings[$control_name . '_view']  = 'stacked';
			$settings[$control_name . '_shape'] = 'cricle';
			$settings[$control_name . '_icon_type'] = 'icon';
			$icon_data = '<i class="' . $settings[$control_name . '_icon'] . ' hvr-icon"></i>';
		} else {

			if ($settings[$control_name . '_icon_type'] == 'icon') {
				if ($settings[$control_name . '_icon'] == '') {
					$settings[$control_name . '_icon']  = 'fa fa-star';
					$settings[$control_name . '_view']  = 'stacked';
					$settings[$control_name . '_shape'] = '';
				}
				if ($settings[$control_name . '_icon'] != '') {
					$icon_data = '<i class="' . $settings[$control_name . '_icon'] . ' hvr-icon"></i>';
				}
			} elseif ($settings[$control_name . '_icon_type'] == 'image') {
				if ($settings[$control_name . '_image']['id'] != '') {
					$icon_data = wp_get_attachment_image($settings[$control_name . '_image']['id']);
				}
			} elseif ($settings[$control_name . '_icon_type'] == 'text') {
				if ($settings[$control_name . '_text'] != '') {
					$icon_data = $settings[$control_name . '_text'];
				}
			} else {
				$icon_data = '';
			}
		}


		if ($icon_data != '') {
			$icon_html .= '<span class="eae-icon-wrapper eae-icon-' . $control_name . '_wrapper eae-icon-view-stacked' . ' elementor-shape-' . $settings[$control_name . '_shape'] . ' eae-icon-type-' . $settings[$control_name . '_icon_type'] . '">';
			$icon_html .= '<span class="elementor-icon eae-icon elementor-animation-' . $settings[$control_name . '_icon_hover_animation'] . '">';
			$icon_html .= $icon_data;
			$icon_html .= '</span>';
			$icon_html .= '</span>';
		}

		return $icon_html;
	}



	public function group_icon_styles($widget, $args)
	{

		$defaults = [
			'primary_color'         => true,
			'secondary_color'       => true,
			'hover_primary_color'   => true,
			'hover_secondary_color' => true,
			'hover_animation'       => true,
			'focus_primary_color'   => false,
			'focus_secondary_color' => false,
			'icon_size'             => true,
			'icon_padding'          => true,
			'rotate'                => true,
			'border_width'          => true,
			'border_style'          => true,
			'border_radius'         => true,
			'name'                  => 'icon',
			'tabs'                  => true,
			'custom_style_switch'   => false,
			'focus_item_class'      => '',
		];

		$args = wp_parse_args($args, $defaults);

		$control_name  = $args['name'];

		//$control_label = $args['label'];

		/*$widget->start_controls_section(
			'section_style_' . $control_name . '_icon',
			[
				'label' => __( $control_label . ' Icon', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					$control_name . '_icon!' => '',
				],
			]
		);*/

		$widget->start_controls_tabs($control_name . 'icon_colors');

		$widget->start_controls_tab(
			$control_name . '_icon_colors_normal',
			[
				'label' => __('Normal', 'wts-eae'),
			]
		);

		if ($args['primary_color']) {
			$widget->add_control(
				$control_name . '_icon_primary_color',
				[
					'label'     => __('Primary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-stacked' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-framed'  => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-framed i'  => 'color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-framed svg'  => 'fill: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-default i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-default svg' => 'fill: {{VALUE}};',
					],
				]
			);
		}

		if ($args['secondary_color']) {
			$widget->add_control(
				$control_name . '_icon_secondary_color',
				[
					'label'     => __('Secondary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#fff',
					//'condition' => [
					//	$control_name . '_view!' => 'default',
					//],
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-framed'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-stacked i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-stacked svg' => 'fill: {{VALUE}};',
					],
				]
			);
		}

		$widget->end_controls_tab();

		if ($args['hover_primary_color'] || $args['hover_secondary_color']) {
			$widget->start_controls_tab(
				$control_name . '_icon_colors_hover',
				[
					'label' => __('Hover', 'wts-eae'),
				]
			);
		}
		if ($args['hover_primary_color']) {
			$widget->add_control(
				$control_name . '_icon_hover_primary_color',
				[
					'label'     => __('Primary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-stacked:hover' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-framed:hover'  => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-framed:hover i'  => 'color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-framed:hover svg'  => 'fill: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-default:hover i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-default:hover svg' => 'fill: {{VALUE}};',
					],
				]
			);
		}

		if ($args['hover_secondary_color']) {
			$widget->add_control(
				$control_name . '_icon_hover_secondary_color',
				[
					'label'     => __('Secondary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					//'condition' => [
					//	$control_name . '_view!' => 'default',
					//],
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-stacked:hover i'  => 'color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-stacked:hover svg'  => 'fill: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon-view-framed:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
		}

		if ($args['hover_animation']) {
			$widget->add_control(
				$control_name . '_icon_hover_animation',
				[
					'label' => __('Hover Animation', 'wts-eae'),
					'type'  => Controls_Manager::HOVER_ANIMATION,
				]
			);
		}

		$widget->end_controls_tab();

		if ($args['focus_item_class'] != "") {

			$widget->start_controls_tab(
				$control_name . '_icon_colors_focus',
				[
					'label' => __('Focus', 'wts-eae'),
				]
			);


			if ($args['focus_primary_color']) {
				$widget->add_control(
					$control_name . '_icon_focus_primary_color',
					[
						'label'     => __('Primary Color', 'wts-eae'),
						'type'      => Controls_Manager::COLOR,
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
						'selectors' => [
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-stacked' => 'background-color: {{VALUE}};',
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-framed'  => 'border-color: {{VALUE}};',
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-framed i'  => 'color: {{VALUE}};',
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-framed svg'  => 'fill: {{VALUE}};',
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-default i' => 'color: {{VALUE}}; border-color: {{VALUE}};',
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-default svg' => 'fill: {{VALUE}}; border-color: {{VALUE}};',
						],
					]
				);
			}

			if ($args['focus_secondary_color']) {
				$widget->add_control(
					$control_name . '_icon_focus_secondary_color',
					[
						'label'     => __('Secondary Color', 'wts-eae'),
						'type'      => Controls_Manager::COLOR,
						'global' => [
							'default' => Global_Colors::COLOR_ACCENT,
						],
						//'condition' => [
						//	$control_name . '_view!' => 'default',
						//],
						'selectors' => [
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-framed'  => 'background-color: {{VALUE}};',
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-stacked i   ' => 'color: {{VALUE}};',
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-stacked svg   ' => 'fill: {{VALUE}};',
						],
					]
				);
			}


			$widget->end_controls_tab();
		}


		$widget->end_controls_tabs();

		if ($args['icon_size']) {
			$widget->add_responsive_control(
				$control_name . '_icon_size',
				[
					'label'     => __('Size', 'wts-eae'),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 5,
							'max' => 100,
						],
					],
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
		}

		if ($args['icon_padding']) {
			$widget->add_control(
				$control_name . '_icon_padding',
				[
					'label'     => __('Padding', 'wts-eae'),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon' => 'padding: {{SIZE}}{{UNIT}};',
					],
					'range'     => [
						'px' => [
							'min' => 5,
							'max' => 100,
						],
					],

					//'condition' => [
					//	$control_name . '_view!' => 'default',
					//],
				]
			);
		}

		if ($args['rotate']) {
			$widget->add_control(
				$control_name . '_icon_rotate',
				[
					'label'     => __('Rotate', 'wts-eae'),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 0,
						'unit' => 'deg',
					],
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
				]
			);
		}

		if ($args['border_style']) {
			$widget->add_control(
				$control_name . '_border_style',
				[
					'label'     => __('Border Style', 'wts-eae'),
					'type'      => Controls_Manager::SELECT,
					'options' => [
						'none' => __('None', 'wts-eae'),
						'solid' => __('Solid', 'wts-eae'),
						'double' => __('Double', 'wts-eae'),
						'dotted' => __('Dotted', 'wts-eae'),
						'dashed' => __('Dashed', 'wts-eae'),
					],
					'default' => 'solid',
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon' => 'border-style: {{VALUE}};',
					],

				]
			);
		}

		if ($args['border_width']) {
			$widget->add_control(
				$control_name . '_border_width',
				[
					'label'     => __('Border Width', 'wts-eae'),
					'type'      => Controls_Manager::DIMENSIONS,
					'default'   => [
						'value' => 20,
					],
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],

				]
			);
		}

		if ($args['border_radius']) {
			$widget->add_control(
				$control_name . '_icon_border_radius',
				[
					'label'      => __('Border Radius', 'wts-eae'),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors'  => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '.eae-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		}

		/*$widget->end_controls_section();*/
	}

	public function group_icon_styles_repeater($widget, $args)
	{

		$defaults = [
			'primary_color'         => true,
			'secondary_color'       => true,
			'hover_primary_color'   => true,
			'hover_secondary_color' => true,
			'focus_primary_color'   => false,
			'focus_secondary_color' => false,
			'hover_animation'       => true,
			'icon_size'             => true,
			'icon_padding'          => true,
			'rotate'                => true,
			'border_style'          => true,
			'border_width'          => true,
			'border_radius'         => true,
			'name'                  => 'icon',
			'tabs'                  => true,
			'label'                 => 'Icon',
			'custom_style_switch'   => true,
			'focus_item_class'      => '',

		];

		$args = wp_parse_args($args, $defaults);

		$control_name  = $args['name'];
		$control_label = $args['label'];

		/*$widget->start_controls_section(
			'section_style_' . $control_name . '_icon',
			[
				'label' => __( $control_label . ' Icon', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					$control_name . '_icon!' => '',
				],
			]
		);*/

		$widget->add_control(
			$control_name . 'custom_styles',
			[
				'label'     => __('Custom Icon Style', 'wts-eae'),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __('No', 'wts-eae'),
				'label_on'  => __('Yes', 'wts-eae'),
				'default'   => '',
			]
		);

		if ($args['tabs']) {
			$widget->start_controls_tabs($control_name . 'icon_colors');

			$widget->start_controls_tab(
				$control_name . '_icon_colors_normal',
				[
					'label' => __('Normal', 'wts-eae'),
				]
			);
		} else {

			$widget->add_control(
				$control_name . '_icon_colors_normal',
				[
					'label'     => __('Normal', 'wts-eae'),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}

		if ($args['primary_color']) {
			$widget->add_control(
				$control_name . '_icon_primary_color',
				[
					'label'     => __('Primary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-stacked' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-framed'  => 'border-color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-framed i'  => 'color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-framed svg'  => 'fill: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-default i' => 'color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-default svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}

		if ($args['secondary_color']) {
			$widget->add_control(
				$control_name . '_icon_secondary_color',
				[
					'label'     => __('Secondary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'condition' => [
						$control_name . '_view!' => 'default',
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-framed'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-stacked i' => 'color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-stacked svg' => 'color: {{VALUE}};',
					],
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}

		if ($args['tabs']) {

			$widget->end_controls_tab();
		}

		if ($args['tabs']) {
			$widget->start_controls_tab(
				$control_name . '_icon_colors_hover',
				[
					'label'     => __('Hover', 'wts-eae'),
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		} else {
			if ($args['hover_primary_color'] || $args['hover_secondary_color']) {
				$widget->add_control(
					$control_name . '_icon_colors_hover',
					[
						'label'     => __('Hover', 'wts-eae'),
						'type'      => Controls_Manager::HEADING,
						'condition' => [
							$control_name . 'custom_styles' => 'yes'
						]
					]
				);
			}
		}

		if ($args['hover_primary_color']) {
			$widget->add_control(
				$control_name . '_icon_hover_primary_color',
				[
					'label'     => __('Primary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-stacked:hover' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-framed:hover'  => 'border-color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-framed:hover i'  => 'color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-framed:hover svg'  => 'fill: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-default:hover i' => 'color: {{VALUE}}; border-color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-default:hover svg' => 'fill: {{VALUE}}; border-color: {{VALUE}};',
					],
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}

		if ($args['hover_secondary_color']) {
			$widget->add_control(
				$control_name . '_icon_hover_secondary_color',
				[
					'label'     => __('Secondary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'condition' => [
						$control_name . '_view!' => 'default',
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-framed:hover'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-stacked:hover i' => 'color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-stacked:hover svg' => 'fill: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-default:hover i' => 'color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon-view-default:hover svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}

		if ($args['hover_animation']) {
			$widget->add_control(
				$control_name . '_icon_hover_animation',
				[
					'label'     => __('Hover Animation', 'wts-eae'),
					'type'      => Controls_Manager::HOVER_ANIMATION,
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}


		if ($args['tabs']) {

			$widget->end_controls_tab();
		}

		if ($args['focus_item_class'] != "") {
			if ($args['tabs']) {

				$widget->start_controls_tab(
					$control_name . '_icon_colors_focus',
					[
						'label' => __('Focus', 'wts-eae'),
					]
				);
			} else {

				$widget->add_control(
					$control_name . '_icon_colors_focus',
					[
						'label'     => __('Focus', 'wts-eae'),
						'type'      => Controls_Manager::HEADING,
						'condition' => [
							$control_name . 'custom_styles' => 'yes'
						]
					]
				);
			}

			if ($args['focus_primary_color']) {
				$widget->add_control(
					$control_name . '_icon_focus_primary_color',
					[
						'label'     => __('Primary Color', 'wts-eae'),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}}.' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-stacked' => 'background-color: {{VALUE}};',
							'{{WRAPPER}} {{CURRENT_ITEM}}.' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-framed'  => 'border-color: {{VALUE}};',
							'{{WRAPPER}} {{CURRENT_ITEM}}.' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-framed i'  => 'color: {{VALUE}};',
							'{{WRAPPER}} {{CURRENT_ITEM}}.' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-framed svg'  => 'fill: {{VALUE}};',
							'{{WRAPPER}} {{CURRENT_ITEM}}.' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-default i' => 'color: {{VALUE}}; border-color: {{VALUE}};',
							'{{WRAPPER}} {{CURRENT_ITEM}}.' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-default svg' => 'fill: {{VALUE}}; border-color: {{VALUE}};',
						],
						'condition' => [
							$control_name . 'custom_styles' => 'yes'
						]
					]
				);
			}

			if ($args['focus_secondary_color']) {
				$widget->add_control(
					$control_name . '_icon_focus_secondary_color',
					[
						'label'     => __('Secondary Color', 'wts-eae'),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'condition' => [
							$control_name . '_view!' => 'default',
						],
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}}.' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-framed'  => 'background-color: {{VALUE}};',
							'{{WRAPPER}} {{CURRENT_ITEM}}.' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-stacked i' => 'color: {{VALUE}};',
							'{{WRAPPER}} {{CURRENT_ITEM}}.' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '.eae-icon-view-stacked svg' => 'fill: {{VALUE}};',
						],
						'condition' => [
							$control_name . 'custom_styles' => 'yes'
						]
					]
				);
			}

			if ($args['tabs']) {

				$widget->end_controls_tab();
			}
		}
		if ($args['tabs']) {

			$widget->end_controls_tabs();
		}

		if ($args['icon_size']) {
			$widget->add_responsive_control(
				$control_name . '_icon_size',
				[
					'label'     => __('Size', 'wts-eae'),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 6,
							'max' => 300,
						],
					],
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon i, {{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon svg' => 'width: {{SIZE}}{{UNIT}};',
						//'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '_wrapper.eae-icon-type-text' => 'display: inline-block; height: calc({{SIZE}}{{UNIT}} * 1); width: calc({{SIZE}}{{UNIT}} * 1); text-align: center;',
					],
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}

		if ($args['icon_padding']) {
			$widget->add_control(
				$control_name . '_icon_padding',
				[
					'label'     => __('Padding', 'wts-eae'),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => [
						//'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '_wrapper .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon' => 'padding: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .bpe-layout-left .bpe-timline-progress-bar' => 'left: calc({{SIZE}}{{UNIT}} / 2); right: auto;',
						'{{WRAPPER}} {{CURRENT_ITEM}} .bpe-layout-right .bpe-timline-progress-bar' => 'left: auto; right: calc({{SIZE}}{{UNIT}} / 2);',
					],
					'range'     => [
						'em' => [
							'min' => 0,
							'max' => 5,
						],
					],
					'condition' => [
						$control_name . '_view!'        => 'default',
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}

		if ($args['rotate']) {
			$widget->add_control(
				$control_name . '_icon_rotate',
				[
					'label'     => __('Rotate', 'wts-eae'),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 0,
						'unit' => 'deg',
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}
		if ($args['border_style']) {
			$widget->add_control(
				$control_name . '_border_style',
				[
					'label'     => __('Border Style', 'wts-eae'),
					'type'      => Controls_Manager::SELECT,
					'options' => [
						'none' => __('None', 'wts-eae'),
						'solid' => __('Solid', 'wts-eae'),
						'double' => __('Double', 'wts-eae'),
						'dotted' => __('Dotted', 'wts-eae'),
						'dashed' => __('Dashed', 'wts-eae'),
					],
					'default' => 'solid',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon' => 'border-style: {{VALUE}};',
					],
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]

				]
			);
		}

		if ($args['border_width']) {
			$widget->add_control(
				$control_name . '_border_width',
				[
					'label'     => __('Border Width', 'wts-eae'),
					'type'      => Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}

		if ($args['border_radius']) {
			$widget->add_control(
				$control_name . '_icon_border_radius',
				[
					'label'      => __('Border Radius', 'wts-eae'),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors'  => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .eae-icon-' . $control_name . '.eae-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						$control_name . '_view!'        => 'default',
						$control_name . 'custom_styles' => 'yes'
					]
				]
			);
		}

		/*$widget->end_controls_section();*/
	}

	public function group_icon_timeline_styles($widget, $args)
	{

		$defaults = [
			'primary_color'         => true,
			'secondary_color'       => true,
			'hover_primary_color'   => true,
			'hover_secondary_color' => true,
			'hover_animation'       => true,
			'focus_primary_color'   => false,
			'focus_secondary_color' => false,
			'icon_size'             => true,
			'icon_padding'          => true,
			'rotate'                => true,
			'border_width'          => true,
			'border_radius'         => true,
			'name'                  => 'icon',
			'tabs'                  => true,
			'custom_style_switch'   => false,
			'focus_item_class'      => '',
		];

		$args = wp_parse_args($args, $defaults);

		$control_name  = $args['name'];
		//$control_label = $args['label'];

		/*$widget->start_controls_section(
			'section_style_' . $control_name . '_icon',
			[
				'label' => __( $control_label . ' Icon', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					$control_name . '_icon!' => '',
				],
			]
		);*/

		$widget->start_controls_tabs($control_name . 'icon_colors');

		$widget->start_controls_tab(
			$control_name . '_icon_colors_normal',
			[
				'label' => __('Normal', 'wts-eae'),
			]
		);

		if ($args['primary_color']) {
			$widget->add_control(
				$control_name . '_icon_primary_color',
				[
					'label'     => __('Primary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#6ec1e4',
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.eae-icon-view-stacked' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.eae-icon-view-framed .elementor-icon'  => 'color: {{VALUE}}; border-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					],
				]
			);
		}

		if ($args['secondary_color']) {
			$widget->add_control(
				$control_name . '_icon_secondary_color',
				[
					'label'     => __('Secondary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					//'condition' => [
					//	$control_name . '_view!' => 'default',
					//],
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.eae-icon-view-framed'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.eae-icon-view-stacked .elementor-icon' => 'color: {{VALUE}};',
					],
				]
			);
		}

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			$control_name . '_icon_colors_hover',
			[
				'label' => __('Hover', 'wts-eae'),
			]
		);

		if ($args['hover_primary_color']) {
			$widget->add_control(
				$control_name . '_icon_hover_primary_color',
				[
					'label'     => __('Primary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.eae-icon-view-stacked:hover' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.eae-icon-view-framed .elementor-icon:hover'  => 'color: {{VALUE}}; border-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.elementor-view-default .elementor-icon:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					],
				]
			);
		}

		if ($args['hover_secondary_color']) {
			$widget->add_control(
				$control_name . '_icon_hover_secondary_color',
				[
					'label'     => __('Secondary Color', 'wts-eae'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					//'condition' => [
					//	$control_name . '_view!' => 'default',
					//],
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.eae-icon-view-framed:hover'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.eae-icon-view-stacked .elementor-icon:hover' => 'color: {{VALUE}};',
					],
				]
			);
		}

		if ($args['hover_animation']) {
			$widget->add_control(
				$control_name . '_icon_hover_animation',
				[
					'label' => __('Hover Animation', 'wts-eae'),
					'type'  => Controls_Manager::HOVER_ANIMATION,
				]
			);
		}

		$widget->end_controls_tab();

		if ($args['focus_item_class'] != "") {

			$widget->start_controls_tab(
				$control_name . '_icon_colors_focus',
				[
					'label' => __('Focus', 'wts-eae'),
				]
			);


			if ($args['focus_primary_color']) {
				$widget->add_control(
					$control_name . '_icon_focus_primary_color',
					[
						'label'     => __('Primary Color', 'wts-eae'),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '_wrapper.eae-icon-view-stacked' => 'background-color: {{VALUE}};',
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '_wrapper.eae-icon-view-framed'  => 'color: {{VALUE}}; border-color: {{VALUE}};',
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '_wrapper.elementor-view-default' => 'color: {{VALUE}}; border-color: {{VALUE}};',
						],
					]
				);
			}

			if ($args['focus_secondary_color']) {
				$widget->add_control(
					$control_name . '_icon_focus_secondary_color',
					[
						'label'     => __('Secondary Color', 'wts-eae'),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						//'condition' => [
						//	$control_name . '_view!' => 'default',
						//],
						'selectors' => [
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '_wrapper.eae-icon-view-framed'  => 'background-color: {{VALUE}};',
							'{{WRAPPER}} .' . $args['focus_item_class'] . ' .eae-icon-' . $control_name . '_wrapper.eae-icon-view-stacked .elementor-icon' => 'color: {{VALUE}};',
						],
					]
				);
			}


			$widget->end_controls_tab();
		}


		$widget->end_controls_tabs();

		if ($args['icon_size']) {
			$widget->add_responsive_control(
				$control_name . '_icon_size',
				[
					'label'     => __('Size', 'wts-eae'),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 6,
							'max' => 30,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
		}

		if ($args['icon_padding']) {
			$widget->add_control(
				$control_name . '_icon_padding',
				[
					'label'     => __('Background Size', 'wts-eae'),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper.eae-icon-wrapper' => 'display: inline-block; min-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .bpe-layout-left .bpe-timline-progress-bar' => 'left: calc({{SIZE}}{{UNIT}} / 2); right: auto;',
						'{{WRAPPER}} .bpe-layout-right .bpe-timline-progress-bar' => 'left: auto; right: calc({{SIZE}}{{UNIT}} / 2);',
					],
					'range'     => [
						'px' => [
							'min' => 30,
							'max' => 100,
						],
					],
					//'condition' => [
					//	$control_name . '_view!' => 'default',
					//],
				]
			);
		}

		if ($args['rotate']) {
			$widget->add_control(
				$control_name . '_icon_rotate',
				[
					'label'     => __('Rotate', 'wts-eae'),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 0,
						'unit' => 'deg',
					],
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper .elementor-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
				]
			);
		}

		if ($args['border_width']) {
			$widget->add_control(
				$control_name . '_border_width',
				[
					'label'     => __('Border Width', 'wts-eae'),
					'type'      => Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					//'condition' => [
					//	$control_name . '_view' => 'framed',
					//],
				]
			);
		}

		if ($args['border_radius']) {
			$widget->add_control(
				$control_name . '_icon_border_radius',
				[
					'label'      => __('Border Radius', 'wts-eae'),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors'  => [
						'{{WRAPPER}} .eae-icon-' . $control_name . '_wrapper .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					//'condition'  => [
					//	$control_name . '_view!' => 'default',
					//],
				]
			);
		}

		/*$widget->end_controls_section();*/
	}


	function box_model_controls($widget, $args)
	{

		$defaults = [
			'border' => true,
			'border-radius' => true,
			'margin' => true,
			'padding' => true,
			'box-shadow' => true
		];

		$args = wp_parse_args($args, $defaults);

		if ($args['border']) {
			$widget->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => $args['name'] . '_border',
					'label' => __($args['label'] . ' Border', 'wts-eae'),
					'selector' => $args['selector'],
					'condition' => [
						'ribbons_badges_switcher!' => ''
					]
				]
			);
		}

		if ($args['border-radius']) {
			$widget->add_control(
				$args['name'] . '_border_radius',
				[
					'label' => __('Border Radius', 'wts-eae'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						$args['selector'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'ribbons_badges_switcher!' => ''
					]
				]
			);
		}

		if ($args['box-shadow']) {
			$widget->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => $args['name'] . '_box_shadow',
					'label' => __('Box Shadow', 'wts-eae'),
					'selector' => $args['selector'],
					'condition' => [
						'ribbons_badges_switcher!' => ''
					]
				]
			);
		}

		if ($args['padding']) {
			$widget->add_control(
				$args['name'] . '_padding',
				[
					'label' => __('Padding', 'wts-eae'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						$args['selector'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'ribbons_badges_switcher!' => ''
					]
				]
			);
		}


		if ($args['margin']) {
			$widget->add_control(
				$args['name'] . '_margin',
				[
					'label' => __('Margin', 'wts-eae'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						$args['selector'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'ribbons_badges_switcher!' => ''
					]
				]
			);
		}
	}

	function get_eae_modules()
	{
		$modules = [
			'timeline'          => ['name' => 'Timeline', 'enabled' => true, 'type' => 'widget'],
			'info-circle'       => ['name' => 'Info Circle', 'enabled' => true, 'type' => 'widget'],
			'comparison-table'  => ['name' => 'Comparison Table', 'enabled' => true, 'type' => 'widget'],
			'image-compare'     => ['name' => 'Image Compare', 'enabled' => true, 'type' => 'widget'],
			'animated-text'     => ['name' => 'Animated Text', 'enabled' => true, 'type' => 'widget'],
			'dual-button'       => ['name' => 'Dual Button', 'enabled' => true, 'type' => 'widget'],
			'particles'         => ['name' => 'Particles', 'enabled' => true, 'type' => 'feature'],
			//'ribbon-badges'     => [ 'name' => 'Ribbon & Badges', 'enabled' => true, 'type' => 'feature' ],
			'wrapper-links'     => ['name' => 'Wrapper Link', 'enabled' => true, 'type' => 'feature'],
			'modal-popup'       => ['name' => 'Modal Popup', 'enabled' => true, 'type' => 'widget'],
			'progress-bar'      => ['name' => 'Progress Bar', 'enabled' => true, 'type' => 'widget'],
			'flip-box'          => ['name' => 'Flip Box', 'enabled' => true, 'type' => 'widget'],
			'split-text'        => ['name' => 'Split Text', 'enabled' => true, 'type' => 'widget'],
			'gmap'              => ['name' => 'Google Map', 'enabled' => true, 'type' => 'widget'],
			'text-separator'    => ['name' => 'Text Separator', 'enabled' => true, 'type' => 'widget'],
			'price-table'       => ['name' => 'Price Table', 'enabled' => true, 'type' => 'widget'],
			'twitter'           => ['name' => 'Twitter', 'enabled' => true, 'type' => 'widget'],
			'bg-slider'         => ['name' => 'Background Slider', 'enabled' => true, 'type' => 'feature'],
			'animated-gradient' => ['name' => 'Animated Gradient', 'enabled' => true, 'type' => 'feature'],
			//'unfold'            => [ 'name' => 'Unfold', 'enabled' => true, 'type' => 'feature' ],
			'post-list'         => ['name' => 'Post List', 'enabled' => true, 'type' => 'widget'],
			'shape-separator'   => ['name' => 'Shape Separator', 'enabled' => true, 'type' => 'widget'],
			'filterable-gallery'   => ['name' => 'Filterable Gallery', 'enabled' => true, 'type' => 'widget'],
			'content-switcher'   => ['name' => 'Content Switcher', 'enabled' => true, 'type' => 'widget'],
			//'charts'                => [ 'name' => 'EAE-Charts', 'enabled' => true, 'type' => 'widget' ],
			'thumb-gallery'      => ['name' => 'Thumbnail Slider', 'enabled' => true, 'type' => 'widget'],
		];

		$saved_modules = get_option('wts_eae_elements');

		if ($saved_modules !== false) {
			foreach ($modules as $key => $module_name) {
				if (array_key_exists($key, $saved_modules)) {
					$modules[$key]['enabled'] = $saved_modules[$key];
				} else {
					$modules[$key]['enabled'] = true;
				}
			}
		}

		$modules = apply_filters('wts_eae_active_modules', $modules);

		return $modules;
	}

	public function get_current_url_non_paged()
	{

		global $wp;
		$url = get_pagenum_link(1);

		return trailingslashit($url);
	}
}
