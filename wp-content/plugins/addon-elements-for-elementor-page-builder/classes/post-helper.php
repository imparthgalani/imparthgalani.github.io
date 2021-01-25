<?php

namespace WTS_EAE\Classes;

//use WTS_EAE\Modules\Posts\Widgets\Postgrid;
use WTS_EAE\Plugin;
use Elementor\Controls_Manager;

class Post_Helper {


	function query_controls( $widget ) {

		$widget->add_control(
			'source',
			[
				'label'   => __( 'Source', 'wts-eae' ),
				'type'    => Controls_Manager::SELECT,
				'options' => self::get_post_types(),
				'default' => 'post'
			]
		);


		$taxonomies = $this->get_taxonomies();

		foreach ( $taxonomies as $taxonomy => $tax_object ) {

			$widget->add_control(
				$taxonomy . '_filter_heading',
				[
					'label'     => $tax_object->labels->singular_name . ' Filters',
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'source' => $tax_object->object_type,
					],
					'separator' => 'before',
				]
			);
			$widget->add_control(
				$taxonomy . '_rule',
				[
					'label'     => __( 'Filter Mode', 'wts-eae' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'IN' => __( 'Includes', 'wts-eae' ),
						'NOT IN' => __( 'Excludes', 'wts-eae' )
					],
					'condition' => [
						'source' => $tax_object->object_type,
					],
				]
			);

			$widget->add_control(
				$taxonomy . '_terms',
				[
					'label'       => $tax_object->label,
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'object_type' => $taxonomy,
					'options'     => $this->get_taxonomy_terms( $taxonomy ),
					'condition'   => [
						'source' => $tax_object->object_type,
					],
				]
			);


		}


		// Ordering controls

		$widget->add_control(
			'order_heading',
			[
				'label'     => __( 'Order & Limit', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$widget->add_control(
			'order_by',
			[
				'label' =>  __('Order By', 'wts-eae'),
				'type'  => Controls_Manager::SELECT,
				'options'   => [
					'ID'         => __( 'ID', 'wts-eae' ),
					'date'       => __( 'Date', 'wts-eae' ),
					'title'       => __( 'Title', 'wts-eae' ),
					'menu_order' => __( 'Menu Order', 'wts-eae' ),
					'random'     => __( 'Random', 'wts-eae' ),
					'meta_value'   => __( 'Custom Field', 'wts-eae' )
				],
				'default'   => 'menu_order'
			]
		);

		$widget->add_control(
			'order_meta_key',
			[
				'label' => __('Meta Key (Custom Field Name)', 'wts-eae'),
				'type'  => Controls_Manager::TEXT,
				'condition' => [
					'order_by'  => 'meta_value'
				]
			]
		);

		$widget->add_control(
			'order',
			[
				'label' => __('Order', 'wts-eae'),
				'type'  => Controls_Manager::SELECT,
				'options'   => [
					'ASC'   => __('Ascending', 'wts-eae'),
					'DESC'  => __('Descending', 'wts-eae')
				],
				'default'   => 'DESC'
			]
		);

		$widget->add_control(
			'offset',
			[
				'label' => __('Offset', 'wts-eae'),
				'type'  => Controls_Manager::NUMBER
			]
		);

		$widget->add_control(
			'post_count',
			[
				'label'     => __('Post Count', 'wts-eae'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '6'
			]
		);


	}

	private function get_post_types() {

		$types = [];

		$post_types = get_post_types( array( 'public' => true ), 'object' );

		$exclusions = [ 'attachment', 'elementor_library', 'ae_global_templates' ];


		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type->name, $exclusions ) ) {
				continue;
			}
			$types[ $post_type->name ] = $post_type->label;
		}

		return $types;
	}

	private function get_taxonomies() {

		$taxonomies = get_taxonomies( [ 'show_in_nav_menus' => 'true' ], 'objects' );

		return $taxonomies;
	}

	private function get_taxonomy_terms( $taxonomy ) {

		$term_array = [];
		$terms      = get_terms( [
			'taxonomy'   => $taxonomy,
			'hide_empty' => false
		] );

		if ( count( $terms ) ) {

			foreach ( $terms as $term ) {
				$term_array[ $term->term_id ] = $term->name;
			}
		}

		return $term_array;
	}

	public function get_queried_posts($settings, $page = 1){

		$query_vars = [];

		$query_vars['post_type']    =   $settings['source'];
		$query_vars['orderby']      =   $settings['order_by'];
		$query_vars['order']        =   $settings['order'];

		$query_vars['posts_per_page']   =   $settings['post_count'];
		$query_vars['offset']       =   $settings['offset'];

		if($query_vars['orderby'] == 'meta_value'){
			$query_vars['meta_key'] =   $settings['order_meta_key'];
		}

		// Taxonomy Query
		$taxonomies = get_object_taxonomies( $settings['source'], 'objects' );
		foreach ( $taxonomies as $object ) {

				$setting_key = $object->name . '_terms';

				if ( ! empty( $settings[ $setting_key ] ) ) {

					$operator = $settings[$object->name.'_rule'];

					$query_vars['tax_query'][] = [
						'taxonomy'  =>  $object->name,
						'field'     =>  'term_id',
						'terms'     =>  $settings[ $setting_key ],
						'operator'  =>  $operator
					];
				}
		}


		$posts  =   new \WP_Query($query_vars);

		return $posts;

	}
}