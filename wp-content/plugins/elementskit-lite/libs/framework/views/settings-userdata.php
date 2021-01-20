<?php

$user_data = $this->utils->get_option('user_data', []);
$pro_active = (in_array('elementskit/elementskit.php', apply_filters('active_plugins', get_option('active_plugins'))));

?>

<div class="ekit-admin-fields-container">
    <div class="ekit-admin-fields-container-fieldset-- xx">
        <div class="panel-group attr-accordion" id="accordion" role="tablist" aria-multiselectable="true">
            <!-------------------
                Mail Champ
            -------------------->
            <div class="attr-panel ekit_accordion_card">
                <div class="attr-panel-heading label-mail-chimp" role="tab" id="mail_chimp_data_headeing">
                    <a class="attr-btn attr-collapsed" role="button" data-attr-toggle="collapse" data-parent="#accordion"
                       href="#mail_chimp_data_control" aria-expanded="true"
                       aria-controls="mail_chimp_data_control">
				        <span><?php esc_html_e('Mail Chimp Data', 'elementsKit-lite'); ?></span>
                    </a>
                </div>
                
                    

                    <div id="mail_chimp_data_control" class="attr-panel-collapse attr-collapse attr-in" role="tabpanel"
                         aria-labelledby="mail_chimp_data_headeing">
                        <div class="attr-panel-body">
                            <div class="ekit-admin-user-data-separator"></div>
					        <?php
					        $this->utils->input([
						        'type' => 'text',
						        'name' => 'user_data[mail_chimp][token]',
						        'label' => esc_html__('Token', 'elementsKit-lite'),
						        'placeholder' => '24550c8cb06076751a80274a52878-us20',
						        'value' => (!isset($user_data['mail_chimp']['token'])) ? '' : ($user_data['mail_chimp']['token'])
					        ]);
					        ?>

                        </div>
                    </div>



		     
            </div>

            <!-------------------
            Facebook Page Feed
            -------------------->
            <div class="attr-panel ekit_accordion_card">
                <div                        
                        class="<?php echo $this->utils->is_widget_active_class('facebook-feed', $pro_active);?>"
                        data-attr-toggle="modal" 
                        data-target="#elementskit_go_pro_modal"
                        role="tab" id="facebook_data_headeing">


                        <a class="attr-btn" role="button" data-attr-toggle="collapse" data-parent="#accordion"
                        
                        href="#fbp_feed_control_data"
                        aria-expanded="false" aria-controls="fbp_feed_control_data">
				        <span><?php esc_html_e('Facebook Page Feed', 'elementsKit-lite'); ?></span>
                    </a>
                </div>
               
                
                <div id="fbp_feed_control_data" class="attr-panel-collapse attr-collapse" role="tabpanel"
                     aria-labelledby="facebook_data_headeing">
                    <div class="attr-panel-body">
                        <div class="ekit-admin-user-data-separator"></div>

				        <?php
				        $this->utils->input([
					        'type'        => 'text',
					        'name'        => 'user_data[fb_feed][page_id]',
					        'label'       => esc_html__('Facebook Page ID', 'elementsKit-lite'),
					        'placeholder' => __('Facebook app id', 'elementsKit-lite'),
					        'value'       => (!isset($user_data['fb_feed']['page_id'])) ? '' : ($user_data['fb_feed']['page_id']),
				        ]);
				        ?>

				        <?php

				        $val = empty($user_data['fb_feed']['pg_token']) ? '' : $user_data['fb_feed']['pg_token'];

				        $this->utils->input([
					        'type'        => 'text',
					        'name'        => 'user_data[fb_feed][pg_token]',
					        'label'       => esc_html__('Page Access Token', 'elementsKit-lite'),
					        'placeholder' => 'S8LGISx9wBAOx5oUnxpOceDbyD01DYNNUwoz8jTHpm2ZB9RmK6jKwm',
					        'value'       => (!isset($user_data['fb_feed']['pg_token'])) ? '' : ($user_data['fb_feed']['pg_token']),
				        ]);

				        $dbg    = '&app=105697909488869&sec=f64837dd6a129c23ab47bdfdc61cfe19'; //ElementsKit Plugin Review
				        $dbg    = '&app=2577123062406162&sec=a4656a1cae5e33ff0c18ee38efaa47ac'; //ElementsKit Plugin page feed
				        $scopes = '&scope=pages_show_list,pages_read_engagement,pages_manage_engagement,pages_read_user_content'; ?>

                        <a class="ekit-admin-access-token" href="https://token.wpmet.com/social_token.php?provider=facebook&_for=page<?php echo $dbg; ?><?php echo $scopes; ?>"
                           target="_blank"> <?php echo esc_html__('Get access token', 'elementsKit') ?>                            
                        </a>

                    </div>
                </div>
	           
            </div>

            <!-------------------
            Facebook page review
            -------------------->

            <div class="attr-panel ekit_accordion_card">
                <div 
                    class="<?php echo $this->utils->is_widget_active_class('facebook-review', $pro_active);?>"
                    data-attr-toggle="modal" 
                    data-target="#elementskit_go_pro_modal"
                    role="tab" id="facebook_data_headeing">
                    
                    <a class="attr-btn" role="button" data-attr-toggle="collapse" data-parent="#accordion" href="#fbp_review_control_data"
                       aria-expanded="false" aria-controls="fbp_review_control_data">
				        <span><?php esc_html_e('Facebook page review', 'elementsKit-lite'); ?></span>
                    </a>

                </div>
	         
                    <div id="fbp_review_control_data" class="attr-panel-collapse attr-collapse" role="tabpanel"
                     aria-labelledby="facebook_data_headeing">
                    <div class="attr-panel-body">
                        <div class="ekit-admin-user-data-separator"></div>
				        <?php
				        $this->utils->input([
					        'type' => 'text',
					        'name' => 'user_data[fbp_review][pg_id]',
					        'label' => esc_html__('Page ID', 'elementsKit-lite'),
					        'placeholder' => '109208590868891',
					        'value' => (!isset($user_data['fbp_review']['pg_id'])) ? '' : ($user_data['fbp_review']['pg_id'])
				        ]);
				        ?>

				        <?php

                        $val = (empty($user_data['fbp_review']['pg_token'])) ? '' : ($user_data['fbp_review']['pg_token']);
                        $btn = (empty($user_data['fbp_review']['pg_token'])) ? __('Get access token', 'elementsKit-lite') : __('Refresh access token', 'elementsKit-lite');

				        $this->utils->input([
					        'type' => 'text',
					        'name' => 'user_data[fbp_review][pg_token]',
					        'label' => esc_html__('Page Token', 'elementsKit-lite'),
					        'placeholder' => 'S8LGISx9wBAOx5oUnxpOceDbyD01DYNNUwoz8jTHpm2ZB9RmK6jKwm',
					        'value' => $val
				        ]);

				        /**
                         * App name : ElementsKit Plugin page feed
                         * App id : 2577123062406162
                         *
				         * Just empty the string when done debugging :D
                         *
				         */
				        $dbg = '&app=944119176079880&sec=03b20cdd9cf6f1d4d6e03522dc9caa2a';
				        $dbg = '';

				        ?>

                        <a class="ekit-admin-access-token" href="https://token.wpmet.com/social_token.php?provider=facebook&_for=page<?php echo $dbg ?>" target="_blank">
                            <?php echo $btn ?>
                        </a>
                    </div>
                </div>
	         
            </div>

             <!-------------------
                trustpilot
            -------------------->

            <div class="attr-panel ekit_accordion_card">
                <div 
                class="<?php echo $this->utils->is_widget_active_class('trustpilot', $pro_active);?>"
                data-target="#elementskit_go_pro_modal"
                data-attr-toggle="modal"
                role="tab" id="trustpilot_data_headeing">
                
                    <a class="attr-btn attr-collapsed" role="button" data-attr-toggle="collapse"
                       data-parent="#accordion"
                       href="#trustpilot_data_control" aria-expanded="false" aria-controls="trustpilot_data_control">
                        <?php esc_html_e('Trustpilot Settings', 'elementsKit-lite'); ?>
                    </a>
                </div>
	      
                <div id="trustpilot_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel"
                     aria-labelledby="trustpilot_data_headeing">
                    <div class="attr-panel-body">
                        <div class="ekit-admin-user-data-separator"></div>

                        <?php
                        $this->utils->input([
                            'type' => 'text',
                            'name' => 'user_data[trustpilot][page]',
                            'label' => esc_html__('Trustpilot Page', 'elementsKit-lite'),
                            'placeholder' => 'mysite.com',
                            'value' => (!isset($user_data['trustpilot']['page'])) ? '' : ($user_data['trustpilot']['page'])
                        ]);
                        ?>
                    </div>
                </div>
	            
            </div>

            <!-------------------
                yelp
            -------------------->
            <div class="attr-panel ekit_accordion_card">
                <div 
                class="<?php echo $this->utils->is_widget_active_class('yelp', $pro_active);?>"
                data-attr-toggle="modal" 
                data-target="#elementskit_go_pro_modal"
                role="tab" id="yelp_data_headeing">

                    <a class="attr-btn attr-collapsed" role="button" data-attr-toggle="collapse"
                       data-parent="#accordion"
                       href="#yelp_data_control" aria-expanded="false" aria-controls="yelp_data_control">
                        <?php esc_html_e('Yelp Settings', 'elementsKit-lite'); ?>
                    </a>
                </div>

	        
                <div id="yelp_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel"
                     aria-labelledby="yelp_data_headeing">
                    <div class="attr-panel-body">
                        <div class="ekit-admin-user-data-separator"></div>

                        <?php
                        $this->utils->input([
                            'type' => 'text',
                            'name' => 'user_data[yelp][page]',
                            'label' => esc_html__('Yelp Page', 'elementsKit-lite'),
                            'placeholder' => 'awesome-cuisine-san-francisco',
                            'value' => (!isset($user_data['yelp']['page'])) ? '' : ($user_data['yelp']['page'])
                        ]);
                        ?>
                    </div>
                </div>

            </div>

            <!-------------------
            facebook messenger
            -------------------->
            <div class="attr-panel ekit_accordion_card">
                <div
                data-attr-toggle="modal" 
                data-target="#elementskit_go_pro_modal"
                class="<?php echo $this->utils->is_widget_active_class('facebook-messenger', $pro_active);?>"
                role="tab" id="facebook_data_headeing">
                    <a class="attr-btn" role="button" data-attr-toggle="collapse" data-parent="#accordion" href="#fbm_control_data"
                       aria-expanded="false" aria-controls="fbm_control_data">
				        <?php esc_html_e('Facebook Messenger', 'elementsKit-lite'); ?>
                    </a>
                </div>
	            
                <div id="fbm_control_data" class="attr-panel-collapse attr-collapse" role="tabpanel"
                     aria-labelledby="facebook_data_headeing">
                    <div class="attr-panel-body">
                        <div class="ekit-admin-user-data-separator"></div>
				        <?php
				        $this->utils->input([
					        'type' => 'text',
					        'name' => 'user_data[fbm_module][pg_id]',
					        'label' => esc_html__('Page ID', 'elementsKit-lite'),
					        'placeholder' => '109208590868891',
					        'value' => (!isset($user_data['fbm_module']['pg_id'])) ? '' : ($user_data['fbm_module']['pg_id'])
				        ]);
				        ?>

	                    <?php
	                    $this->utils->input([
		                    'type' => 'color',
		                    'name' => 'user_data[fbm_module][txt_color]',
		                    'label' => esc_html__('Color', 'elementsKit-lite'),
		                    'placeholder' => '#3b5998',
		                    'value' => (!isset($user_data['fbm_module']['txt_color'])) ? '#3b5998' : ($user_data['fbm_module']['txt_color'])
	                    ]);
	                    ?>

	                    <?php
	                    $this->utils->input([
		                    'type' => 'text',
		                    'name' => 'user_data[fbm_module][l_in]',
		                    'label' => esc_html__('Logged-in user greeting', 'elementsKit-lite'),
		                    'placeholder' => 'Hi! user',
		                    'value' => (!isset($user_data['fbm_module']['l_in'])) ? 'Hi! user' : ($user_data['fbm_module']['l_in'])
	                    ]);
	                    ?>

	                    <?php
	                    $this->utils->input([
		                    'type' => 'text',
		                    'name' => 'user_data[fbm_module][l_out]',
		                    'label' => esc_html__('Logged out user greeting', 'elementsKit-lite'),
		                    'placeholder' => 'Hi! guest',
		                    'value' => (!isset($user_data['fbm_module']['l_out'])) ? 'Hi! guest' : ($user_data['fbm_module']['l_out'])
	                    ]);
	                    ?>

                        <div>Please add below domain as white listed in page advance messaging option <a href="https://prnt.sc/u4zh96" target="_blank">how?</a></div>
                        <div style="font-weight: bold;font-style: italic;color: blue;padding: 3px;"><?php echo site_url() ?></div>
                    </div>
                </div>
	        
            </div>

            <!-------------------
                dribble-feed
            -------------------->

            <div class="attr-panel ekit_accordion_card">
                <div 
                class="<?php echo $this->utils->is_widget_active_class('dribble-feed', $pro_active);?>"
                data-attr-toggle="modal" 
                data-target="#elementskit_go_pro_modal"
                role="tab" id="dribble_data_headeing">
                    <a class="attr-btn" role="button" data-attr-toggle="collapse" data-parent="#accordion" href="#dribble_control_data"
                       aria-expanded="false" aria-controls="dribble_control_data">
				        <?php esc_html_e('Dribbble User Data', 'elementsKit-lite'); ?>
                    </a>
                </div>
	           
                <div id="dribble_control_data" class="attr-panel-collapse attr-collapse" role="tabpanel"
                     aria-labelledby="dribble_data_headeing">
                    <div class="attr-panel-body">
                        <div class="ekit-admin-user-data-separator"></div>
				        <?php
				        $this->utils->input([
					        'type' => 'text',
					        'name' => 'user_data[dribble][client_id]',
					        'label' => esc_html__('Client ID', 'elementsKit-lite'),
					        'placeholder' => '60ed17852f0720210044a43713e91e7f141ff157dc3d95451d29a95e75e60b1b',
					        'value' => (!isset($user_data['dribble']['client_id'])) ? '' : ($user_data['dribble']['client_id'])
				        ]);


				        $this->utils->input([
					        'type' => 'text',
					        'name' => 'user_data[dribble][client_secret]',
					        'label' => esc_html__('Client Secret', 'elementsKit-lite'),
					        'placeholder' => '94edbabf0feefcec83166f2dddeaa3a9f852785b6d6fb93f4a7a50412f2d3229',
					        'value' => (!isset($user_data['dribble']['client_secret'])) ? '' : ($user_data['dribble']['client_secret'])
				        ]);


	                    $this->utils->input([
		                    'type' => 'text',
		                    'disabled' => (empty($user_data['dribble']['access_token']) ? 'disabled' : ''),
		                    'name' => 'user_data[dribble][access_token]',
		                    'label' => esc_html__('Access token', 'elementsKit-lite'),
		                    'placeholder' => 'Get a token....',
		                    'value' => (empty($user_data['dribble']['access_token'])) ? '' : ($user_data['dribble']['access_token'])
	                    ]);

                        ?>
                         <div><?php echo __('Please add below redirect in your app settings', 'elementsKit-lite') ?> <a href="https://i.imgur.com/mtOlSif.png" target="_blank"><?php esc_html_e('how?', 'elementsKit-lite') ?></a></div>
                        <div style="font-weight: bold;font-style: italic;color: blue;padding: 3px;"><?php echo site_url().'/wp-json/elementskit/v1/dribble/redirect_uri' ?></div>
                        <?php

                        if(empty($user_data['dribble']['access_token'])) : ?>
                            <a style="cursor: pointer" class="ekit-admin-access-token" data-rest="<?php echo get_rest_url(); ?>" data-nonce="<?php echo wp_create_nonce('wp_rest'); ?>" id="dribble_access_btn" href="#" target="_blank"> <?php echo esc_html__('Get Access Token', 'elementsKit-lite');?> </a>
	                        <?php

                        else: ?>

                            <a style="cursor: pointer" class="ekit-admin-access-token" data-rest="<?php echo get_rest_url(); ?>" data-nonce="<?php echo wp_create_nonce('wp_rest'); ?>" id="dribble_access_btn" href="#" target="_blank"> <?php echo esc_html__('Refresh Access Token', 'elementsKit-lite');?> </a>
	                        <?php

                        endif;
	                    ?>

                    </div>
                </div>
	        
            </div>

            <!-------------------
                twitter feed
            -------------------->
            <div class="attr-panel ekit_accordion_card">
                <div 
                class="<?php echo $this->utils->is_widget_active_class('twitter-feed', $pro_active);?>"
                data-attr-toggle="modal" 
                data-target="#elementskit_go_pro_modal"
                role="tab" id="twetter_data_headeing">
                    <a class="attr-btn attr-collapsed" role="button" data-attr-toggle="collapse" data-parent="#accordion"
                        href="#twitter_data_control" aria-expanded="false" aria-controls="twitter_data_control">
                        <?php esc_html_e('Twitter User Data', 'elementsKit-lite'); ?>
                    </a>
                </div>
	           
                <div id="twitter_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel"
                    aria-labelledby="twetter_data_headeing">
                    <div class="attr-panel-body">
                        <div class="ekit-admin-user-data-separator"></div>
                        <?php
                            $this->utils->input([
                                'type' => 'text',
                                'name' => 'user_data[twitter][name]',
                                'label' => esc_html__('Twitter Username', 'elementsKit-lite'),
                                'placeholder' => 'gameofthrones',
                                'value' => (!isset($user_data['twitter']['name'])) ? '' : ($user_data['twitter']['name'])

                            ]);
                        ?>
                        <?php
                            $this->utils->input([
                                'type' => 'text',
                                'name' => 'user_data[twitter][access_token]',
                                'label' => esc_html__('Access Token', 'elementsKit-lite'),
                                'placeholder' => '97174059-g10REWwVvI0Mk02DhoXbqpEhh4zQg6SBIP2k8',
                                // 'info' => esc_html__('Yuour', 'elementsKit-lite')
                                'value' => (!isset($user_data['twitter']['access_token'])) ? '' : ($user_data['twitter']['access_token'])
                            ]);
                        ?>
						<a class="ekit-admin-access-token" href="https://token.wpmet.com/index.php?provider=twitter" target="_blank"> <?php echo esc_html__('Get Access Token', 'elementsKit-lite');?> </a>
                    </div>
                </div>
	            
            </div>

            <!-------------------
                instagram-feed
            -------------------->
            <div class="attr-panel ekit_accordion_card">
                <div 
                class="<?php echo $this->utils->is_widget_active_class('instagram-feed', $pro_active);?>"
                data-attr-toggle="modal" 
                data-target="#elementskit_go_pro_modal"
                role="tab" id="instagram_data_headeing">
                    <a class="attr-btn attr-collapsed" role="button" data-attr-toggle="collapse" data-parent="#accordion"
                        href="#instagram_data_control" aria-expanded="false" aria-controls="instagram_data_control">
                        <?php esc_html_e('Instragram User Data', 'elementsKit-lite'); ?>
                    </a>
                </div>
	           
                    <div id="instagram_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel"
                    aria-labelledby="instagram_data_headeing">
                    <div class="attr-panel-body">
                        <div class="ekit-admin-user-data-separator"></div>

                        <?php

                        // $this->utils->input([
                        //     'type' => 'text',
                        //     'name' => 'user_data[instragram][username]',
                        //     'label' => esc_html__('Username', 'elementsKit-lite'),
                        //     'placeholder' => 'my_username',
                        //     'value' => (!isset($user_data['instragram']['username'])) ? '' : ($user_data['instragram']['username'])
                        // ]);

                        $insta_client_id     = (!isset($user_data['instragram']['client_id'])) ? '' : ($user_data['instragram']['client_id']);
                        $insta_client_secret = (!isset($user_data['instragram']['client_secret'])) ? '' : ($user_data['instragram']['client_secret']);

                        $this->utils->input([
                            'type' => 'text',
                            'name' => 'user_data[instragram][client_id]',
                            'label' => esc_html__('Client ID', 'elementsKit-lite'),
                            'placeholder' => '',
                            'value' => $insta_client_id
                        ]);

                        $this->utils->input([
                            'type' => 'text',
                            'name' => 'user_data[instragram][client_secret]',
                            'label' => esc_html__('Client Secret', 'elementsKit-lite'),
                            'placeholder' => '',
                            'value' => $insta_client_secret
                        ]);

                        


                        $redirect_url = get_site_url() . '/wp-json/elementskit/v1/widget/instagram-feed/token';

                        echo '<small>Redirect URL : <br><code>'. $redirect_url . '</code></small>';

                        $insta_login_url = '#';
                        $scope = 'user_profile,user_media';

                        if(!empty($insta_client_id)){
                            $insta_login_url = 'https://api.instagram.com/oauth/authorize?client_id='.$insta_client_id.'&redirect_uri='.$redirect_url.'&scope='.$scope.'&response_type=code';
                        }


                       
                        ?>

                        <a class="ekit-admin-access-token" href="<?php echo $insta_login_url; ?>">
                            <?php echo esc_html__('Connect with Instagram', 'elementsKit-lite');?>
                        </a>

                    </div>
                </div>
	            
            </div>

            <!-------------------
                zoom
            -------------------->

            <div class="attr-panel ekit_accordion_card">
                <div  
                class="<?php echo $this->utils->is_widget_active_class('zoom', $pro_active);?>"
                data-attr-toggle="modal" 
                data-target="#elementskit_go_pro_modal"
                role="tab" id="zoom_data_headeing">
                    <a class="attr-btn attr-collapsed" role="button" data-attr-toggle="collapse" data-parent="#accordion"
                       href="#zoom_data_control" aria-expanded="false" aria-controls="zoom_data_control">
				        <?php esc_html_e('Zoom Data', 'elementsKit-lite'); ?>
                    </a>
                </div>
	            
                    <div id="zoom_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel"
                     aria-labelledby="zoom_data_headeing">
                    <div class="attr-panel-body">
                        <div class="ekit-admin-user-data-separator"></div>
				        <?php
				        $this->utils->input([
					        'type' => 'text',
					        'name' => 'user_data[zoom][api_key]',
					        'label' => esc_html__('Api key', 'elementsKit-lite'),
					        'placeholder' => 'FmOUK_vdR-eepOExMhN7Kg',
					        'value' => (!isset($user_data['zoom']['api_key'])) ? '' : ($user_data['zoom']['api_key'])
				        ]);
				        ?>
				        <?php
				        $this->utils->input([
					        'type' => 'text',
					        'name' => 'user_data[zoom][secret_key]',
					        'label' => esc_html__('Secret Key', 'elementsKit-lite'),
					        'placeholder' => 'OhDwAoNflUK6XkFB8ShCY5R7I8HxyWLMXR2SHK',
					        'value' => (!isset($user_data['zoom']['secret_key'])) ? '' : ($user_data['zoom']['secret_key'])
				        ]);
				        ?>
                        <a class="ekit-admin-access-token ekit-zoom-connection" href="https://token.wpmet.com/index.php?provider=zoom" target="_blank"> <?php echo esc_html__('Check connection', 'elementsKit-lite');?> </a>
                    </div>
                </div>
	           
            </div>

             <!-------------------
                google-map
            -------------------->

            <div class="attr-panel ekit_accordion_card">
                <div
                    class="<?php echo $this->utils->is_widget_active_class('google-map', $pro_active);?>"
                    data-attr-toggle="modal" 
                    data-target="#elementskit_go_pro_modal"
                    role="tab" id="google_map_data_heading">
                    <a class="attr-btn attr-collapsed" role="button" data-attr-toggle="collapse" data-parent="#accordion"
                       href="#google_map_data_control" aria-expanded="false"
                       aria-controls="google_map_data_control">
				        <?php esc_html_e('Google Map', 'elementsKit-lite'); ?>
                    </a>
                </div>
		       
                    <div id="google_map_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel"
                         aria-labelledby="google_map_data_heading" aria-expanded='false'>
                        <div class="attr-panel-body">
                            <div class="ekit-admin-user-data-separator"></div>
					        <?php
					        $this->utils->input([
						        'type' => 'text',
						        'name' => 'user_data[google_map][api_key]',
						        'label' => esc_html__('Api Key', 'elementsKit-lite'),
						        'placeholder' => 'AIzaSyA-10-OHpfss9XvUDWILmos62MnG_L4MYw',
						        'value' => (!isset($user_data['google_map']['api_key'])) ? '' : ($user_data['google_map']['api_key'])
					        ]);
					        ?>

                        </div>
                    </div>
		      
            </div>

            <?php do_action('elementskit/admin/sections/userdata'); ?>

        </div>
    </div>
</div>