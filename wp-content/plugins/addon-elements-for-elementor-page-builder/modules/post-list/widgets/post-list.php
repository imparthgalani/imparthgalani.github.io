<?php
namespace WTS_EAE\Modules\PostList\Widgets;


use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use WTS_EAE\Classes\Helper;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PostList extends EAE_Widget_Base {

	public function get_name() {
		return 'wts-postlist';
	}

	public function get_title() {
		return __( 'EAE - Post List', 'wts-eae' );
	}

	public function get_icon() {
		return 'eicon-post-list wts-eae-pe';
	}

	public function get_categories() {
		return [ 'wts-eae' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_post_filters',
			[
				'label' => __( 'Post Filters', 'wts-eae' )
			]
		);

		$this->add_control(
			'refer_wp_org',
			[
				'raw' => __( 'For more detail about following filters please refer <a href="https://codex.wordpress.org/Template_Tags/get_posts" target="_blank">here</a>', 'wts-eae' ),
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$helper = new Helper();

		$this->add_control(
            'post_type',
            [
                'label' => __( 'Post Type', 'wts-eae' ),
                'type' => Controls_Manager::SELECT,
                'options' => $helper->eae_get_post_types(),
                'default' => 'post',

            ]
        );

        $this->add_control(
            'category',
            [
                'label' => __( 'Category ID', 'wts-eae' ),
                'description' => __('Comma separated list of category ids','wts-eae'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                       'post_type' => 'post'
                ]
            ]
        );

        $this->add_control(
            'num_posts',
            [
                'label' => __( 'Number of Posts', 'wts-eae' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '5'
            ]
        );

        $this->add_control(
            'post_offset',
            [
                'label' => __( 'Post Offset', 'wts-eae' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '0'
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __( 'Order By', 'wts-eae' ),
                'type' => Controls_Manager::SELECT,
                'options' => $helper->eae_get_post_orderby_options(),
                'default' => 'date',

            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __( 'Order', 'wts-eae' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'desc',

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_layout_settings',
			[
				'label' => __( 'Layout Settings', 'wts-eae' )
			]
		);


        $this->add_control(
            'show_image',
            [
                'label' => __( 'Show Image', 'wts-eae' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wts-eae' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wts-eae' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'exclude' => [ 'custom' ],
				'condition' => [
                    'show_image' => '1',
                ]
			]
		);

		$this->add_responsive_control(
			'image_align',
			[
				'label' => __( 'Image Alignment', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'none' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'default' => 'left',
				'condition' => [
                    'show_image' => '1',
                ],
				'selectors' => [
				     '{{WRAPPER}} .eae-pl-image-wrapper' => 'float: {{VALUE}};',
                ],
                'prefix_class' => 'eae-pl-img-align-'
			]
		);

		$this->add_responsive_control(
			'image_indent',
			[
				'label' => __( 'Image Indent', 'wts-eae' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'condition' => [
                    'show_image' => '1',
                ],
				'selectors' => [
					'{{WRAPPER}}.eae-pl-img-align-left .eae-pl-image-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.eae-pl-img-align-right .eae-pl-image-wrapper' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
            'show_title',
            [
                'label' => __( 'Show Title', 'wts-eae' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wts-eae' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wts-eae' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );

        $this->add_control(
            'title_on_top',
            [
                'label' => __( 'Title on top', 'wts-eae' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'top' => [
						'title' => __( 'Yes', 'wts-eae' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wts-eae' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '0',
				'condition' => [
				    'show_title' => '1'
                ]
            ]
        );

		$this->add_control(
            'show_excrept',
            [
                'label' => __( 'Show Excrept', 'wts-eae' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wts-eae' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wts-eae' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );

        $this->add_control(
            'excrept_size',
            [
                'label' => __( 'Excrept Size', 'wts-eae' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '10',
                'condition' => [
                    'show_excrept' => '1',
                ]

            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label' => __( 'Show Read More', 'wts-eae' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wts-eae' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wts-eae' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => __( 'Read More Text', 'wts-eae' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Read More', 'wts-eae' ),
                'default' => __( 'Read More', 'wts-eae' ),
                'condition' => [
                    'show_read_more' => '1',
                ]
            ]
        );


		$this->end_controls_section();

        $this->start_controls_section(
            'section-general-style',
            [
                'label' => __( 'General', 'wts-eae' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'heading_image_border',
			[
				'label' => __( 'Image Border', 'wts-eae' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => __( 'Image Border', 'wts-eae' ),
				'selector' => '{{WRAPPER}} .eae-pl-image-wrapper a img',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eae-pl-image-wrapper a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .eae-pl-image-wrapper a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'section-item-typography',
            [
                'label' => __( 'Typography', 'wts-eae' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'heading_title_typography',
			[
				'label' => __( 'Title Typography', 'wts-eae' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
				'global'    =>  [
				        'default'   =>  Global_Colors::COLOR_PRIMARY,
                ],
				'selectors' => [
					'{{WRAPPER}} .eae-pl-title a' => 'color: {{VALUE}};',
				]

			]
		);

		$this->add_responsive_control(
			'title_align',
			[
				'label' => __( 'Title Align', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'selectors' => [
					'{{WRAPPER}} .eae-pl-title a' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'wts-eae' ),
                'global'    =>  [
                    'default'   =>  Global_Typography::TYPOGRAPHY_PRIMARY
                ],
				'selector' => '{{WRAPPER}} .eae-pl-title a',
			]
		);

		$this->add_control(
			'heading_excrept_typography',
			[
				'label' => __( 'Excrept Typography', 'wts-eae' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'excrept_color',
			[
				'label' => __( 'Excrept Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
                'global'    =>  [
                    'default'   =>  Global_Colors::COLOR_TEXT,
                ],
				'selectors' => [
					'{{WRAPPER}} .eae-pl-content-box' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_responsive_control(
			'excrept_align',
			[
				'label' => __( 'Excrept Align', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'wts-eae' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .eae-pl-content-box' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excrept_typography',
				'label' => __( 'Excrept Typography', 'wts-eae' ),
                'global'    =>  [
                    'default'   =>  Global_Typography::TYPOGRAPHY_TEXT,
                ],
				'selector' => '{{WRAPPER}} .eae-pl-content-box',
			]
		);

		$this->add_control(
			'heading_readmore_typography',
			[
				'label' => __( 'Readmore Typography', 'wts-eae' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'readmore_color',
			[
				'label' => __( 'Readmore Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
                'global'    =>  [
                    'default'   =>  Global_Colors::COLOR_TEXT,
                ],
				'selectors' => [
					'{{WRAPPER}} .eae-pl-readmore a' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_responsive_control(
			'readmore_align',
			[
				'label' => __( 'Readmore Align', 'wts-eae' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'default' => 'right',
				'selectors' => [
					'{{WRAPPER}} .eae-pl-readmore' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'readmore_typography',
				'label' => __( 'Readmore Typography', 'wts-eae' ),
                'global'    =>  [
                    'default'   =>  Global_Typography::TYPOGRAPHY_TEXT,
                ],
				'selector' => '{{WRAPPER}} .eae-pl-readmore a',
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
            'section-list-item-style',
            [
                'label' => __( 'List Item Style', 'wts-eae' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
			'list_item_padding',
			[
				'label' => __( 'List Item Padding', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wts-eae-pl-wrapper > ul > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'list_item_margin',
			[
				'label' => __( 'List Item Margin', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wts-eae-pl-wrapper > ul > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_item_border',
				'label' => __( 'Image Border', 'wts-eae' ),
				'selector' => '{{WRAPPER}} .wts-eae-pl-wrapper > ul > li',
			]
		);

		$this->add_control(
			'list_item_border_radius',
			[
				'label' => __( 'Border Radius', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wts-eae-pl-wrapper > ul > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'section-readmore_button',
            [
                'label' => __( 'Read More Button', 'wts-eae' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'readmore_bg',
			[
				'label' => __( 'Background Color', 'wts-eae' ),
				'type' => Controls_Manager::COLOR,
                'global'    =>  [
                    'default'   =>  Global_Colors::COLOR_PRIMARY,
                ],
				'selectors' => [
					'{{WRAPPER}} .eae-pl-readmore a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'readmore_border',
				'label' => __( 'Border', 'wts-eae' ),
				'default' => '1px',
				'selector' => '{{WRAPPER}} .eae-pl-readmore a',
			]
		);

		$this->add_control(
			'readmore_border_radius',
			[
				'label' => __( 'Border Radius', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eae-pl-readmore a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'readmore_text_padding',
			[
				'label' => __( 'Text Padding', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eae-pl-readmore a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'readmore_text_margin',
			[
				'label' => __( 'Read More Margin', 'wts-eae' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eae-pl-readmore a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
	}

	protected function render( ) {
	    $helper = new Helper();
        $settings = $this->get_settings();
        //echo '<pre>'; print_r($settings); echo '</pre>';
        $post_args = $helper-> eae_get_post_settings($settings);

        $posts = $helper->eae_get_post_data($post_args);
	   // $this->add_render_attribute('separator_wrapper','class','wts-eae-textseparator');
        ?>
            <div class="wts-eae-pl-wrapper">
                <?php
                    if(count($posts)){
                        global $post;
                        ?>
                        <ul>
                            <?php
                                foreach($posts as $post){
                                    setup_postdata($post);
                                ?>
                                <li>
                                    <?php if($settings['show_title'] && ($settings['title_on_top'] == 'top')){ ?>
                                        <h3 class="eae-pl-title"><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                    <?php } ?>
                                    <?php if($settings['show_image'] == 1){ ?>
                                    <div class="eae-pl-image-wrapper">
                                        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php the_post_thumbnail($settings['image_size']); ?>
                                        </a>
                                    </div>
                                    <?php } ?>
                                    <div class="eae-pl-content-box-wrapper">

                                             <?php if($settings['show_title'] && ($settings['title_on_top'] != 'top')){ ?>
                                                <h3 class="eae-pl-title"><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                            <?php } ?>

                                           <?php if($settings['show_excrept']){ ?>
                                               <div class="eae-pl-content-box">
                                                    <?php echo  $helper->eae_get_excerpt_by_id(get_the_ID(),$settings['excrept_size']);?>
                                               </div>
                                           <?php } ?>

                                           <?php if($settings['show_read_more']){ ?>
                                               <div class="eae-pl-readmore">
                                                    <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php echo $settings['read_more_text']; ?></a>
                                               </div>
                                           <?php } ?>
                                    </div>
                                </li>
                                <?php
                                }
                                wp_reset_postdata();
                            ?>
                        </ul>
                        <?php
                    }
                ?>
            </div>
        <?php
	}

}
//Plugin::instance()->widgets_manager->register_widget_type( new Widget_PostList() );