<?php
namespace Wpmet\Libs;

defined( 'ABSPATH' ) || exit;

if(!class_exists('\Wpmet\Libs\Banner')):

class Banner {

    protected $script_version = '2.0.0';

    protected $key = 'wpmet_banner';
    protected $data;
    protected $last_check;
    protected $check_interval = (3600 * 6);
    
    protected $plugin_screens;
    
    protected $text_domain;
    protected $filter_string;
    protected $filter_array = [];
    protected $api_url;


    public function get_version(){
        return $this->script_version;
    }

    public function get_script_location(){
        return __FILE__;
    }

	public function call(){
        add_action( 'admin_head', [$this, 'show_banner'] );
    }
    
    public function show_banner(){
        $this->get_banner();

		if(!empty($this->data->error)) {
			return;
		}

		if(empty($this->data)) {
			return;
        }
        
        foreach($this->data as $banner) {
            
            if($banner->type != 'banner') {
                continue;
            }
            
			if(!empty($this->filter_array) && $this->in_blacklist($banner, $this->filter_array)) {
                continue;
			}

            if($banner->start <= time() && time() <= $banner->end) {
                $screen = get_current_screen();
                if($this->is_correct_screen_to_show($banner->screen, $screen->id) && class_exists('\Oxaim\Libs\Notice')) {
        
                    $inline_css = '';
                    $banner_unique_id = ((isset($banner->data->unique_key) && $banner->data->unique_key != '') ? $banner->data->unique_key : $banner->id );
        
                    if(!empty($banner->data->style_css)) {
                        $inline_css =' style="'.$banner->data->style_css.'"';
                    }
        
                    $contents = '<a target="_blank" '.$inline_css.' class="wpmet-jhanda-href" href="'.$banner->data->banner_link.'"><img style="display: block;margin: 0 auto;" src="'.$banner->data->banner_image.'" /></a>';
        
                    \Oxaim\Libs\Notice::instance('wpmet-jhanda', $banner_unique_id)
                    ->set_dismiss('global', (3600 * 24 * 15))
                    ->set_gutter(false)
                    ->set_html($contents)
                    ->call();
                }
            }
		}
    }


	private function in_whitelist($conf, $list) {

		$match = $conf->data->whitelist;

		if(empty($match)) {
			return true;
		};

		$match_arr = explode(',', $match);

		foreach($list as $word) {
			if(in_array($word, $match_arr)) {
				return true;
			}
		}

		return false;
	}


	private function in_blacklist($conf, $list) {

		$match = $conf->data->blacklist;

		if(empty($match)) {
			return false;
		};

		$match_arr = explode(',', $match);

		foreach($match_arr as $idx => $item) {

			$match_arr[$idx] = trim($item);
		}

		foreach($list as $word) {
			if(in_array($word, $match_arr)) {
				return true;
			}
		}

		return false;
	}


    public function is_test($is_test = false) {
        if($is_test === true){
            $this->check_interval = 1;
        }

        return $this;
    }


    public function set_text_domain($text_domain) {
        $this->text_domain = $text_domain;

        return $this;
    }


    public function set_filter($filter_string) {
        $this->filter_string = $filter_string;
		if(!empty($filter_string)) {

			$filter = explode(',', $this->filter_string);

			foreach ($filter as $id => $item) {
				$this->filter_array[$id] = trim($item);
			}
		}

        return $this;
    }


    public function set_api_url($url) {
        $this->api_url = $url;
        
        return $this;
    }

    public function set_plugin_screens($screen) {
        $this->plugin_screens[] = $screen;

        return $this;
    }


    private function get_banner() {
        $this->data = get_option($this->text_domain . '__banner_data');
        $this->data = $this->data == '' ? [] : $this->data;

        $this->last_check = get_option($this->text_domain . '__banner_last_check');
        $this->last_check = $this->last_check == '' ? 0 : $this->last_check;

        if(($this->check_interval + $this->last_check) < time()){
            $response = wp_remote_get( $this->api_url . '/cache/'.$this->text_domain.'.json?nocache='.time(),
                [
                    'timeout'     => 10,
                    'httpversion' => '1.1',
                ]
            );
            // print_r($response['body']); exit;
            if(!is_wp_error($response) && isset($response['body']) && $response['body'] != ''){

                $response = json_decode($response['body']);

                if(!empty($response)) {
                    $this->data = $response;
                    update_option($this->text_domain . '__banner_last_check', time());
                    update_option($this->text_domain . '__banner_data', $this->data);
                }

                return;
            }
        }
    }


    public function is_correct_screen_to_show($b_screen, $screen_id) {

        if(in_array($b_screen, [$screen_id, 'all_page'])) {
            return true;
        }


        if($b_screen == 'plugin_page') {
            return in_array($screen_id, $this->plugin_screens);
        }

        return false;
    }

	private static $instance;

	public static function instance($text_domain = '') {

        self::$instance = new static();            
        return self::$instance->set_text_domain($text_domain);
    }
}

endif;
