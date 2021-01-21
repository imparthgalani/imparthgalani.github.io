<?php

namespace WTS_EAE\Controls\Group;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

class Group_Control_Grid extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'eae-grid';
	}

	protected function init_fields() {

		$controls = [];

		$controls['columns'] = [

			'label'      => __( 'Columns', 'wts-eae' ),
			'type'       => Controls_Manager::SELECT,
			'options'    => [
				'1' => __( '1', 'wts-eae' ),
				'2' => __( '2', 'wts-eae' ),
				'3' => __( '3', 'wts-eae' ),
				'4' => __( '4', 'wts-eae' ),
				'5' => __( '5', 'wts-eae' ),
				'6' => __( '6', 'wts-eae' ),
			],
			'default'    => '3',
			'responsive' => true,
			'selectors' => [
				'{{WRAPPER}} .bepl-grid-container' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
			]
		];

		$controls['col-gap'] = [
			'label'     => __('Column Gap', 'wts-eae'),
			'type'      => Controls_Manager::SLIDER,
			'default' => [
				'size' => 30,
			],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'responsive' => true,
			'selectors' => [
				'{{WRAPPER}} .bepl-grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
			],
		];

		$controls['row-gap'] = [
			'label'     => __('Row Gap', 'wts-eae'),
			'type'      => Controls_Manager::SLIDER,
			'default' => [
				'size' => 30,
			],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'responsive' => true,
			'selectors' => [
				'{{WRAPPER}} .bepl-grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
			],
		];



		return $controls;
	}

	protected function get_default_options() {
		return [
			'popover' => false,
		];
	}
}

