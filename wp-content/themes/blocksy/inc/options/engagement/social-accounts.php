<?php
/**
 * Social Accounts
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'social_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_rand_md5() => [
				'label' => __( 'Social Network Accounts', 'blocksy' ),
				'type' => 'ct-title',
				'desc' => __( 'Set your social network accounts here and then enable them where you want.', 'blocksy' ),
			],

			'facebook' => [
				'label' => __( 'Facebook', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'twitter' => [
				'label' => __( 'Twitter', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'instagram' => [
				'label' => __( 'Instagram', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'pinterest' => [
				'label' => __( 'Pinterest', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'dribbble' => [
				'label' => __( 'Dribbble', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'behance' => [
				'label' => __( 'Behance', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'linkedin' => [
				'label' => __( 'LinkedIn', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'wordpress' => [
				'label' => __( 'WordPress', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'parler' => [
				'label' => __( 'Parler', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'medium' => [
				'label' => __( 'Medium', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'slack' => [
				'label' => __( 'Slack', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'codepen' => [
				'label' => __( 'CodePen', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'reddit' => [
				'label' => __( 'Reddit', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'twitch' => [
				'label' => __( 'Twitch', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'tiktok' => [
				'label' => __( 'TikTok', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'snapchat' => [
				'label' => __( 'Snapchat', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'spotify' => [
				'label' => __( 'Spotify', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'soundcloud' => [
				'label' => __( 'SoundCloud', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'apple_podcast' => [
				'label' => __( 'Apple Podcasts', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'patreon' => [
				'label' => __( 'Patreon', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'skype' => [
				'label' => __( 'Skype', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'github' => [
				'label' => __( 'GitHub', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'gitlab' => [
				'label' => __( 'GitLab', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'youtube' => [
				'label' => __( 'YouTube', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'vimeo' => [
				'label' => __( 'Vimeo', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'dtube' => [
				'label' => __( 'DTube', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'vk' => [
				'label' => __( 'VK', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'ok' => [
				'label' => __( 'Odnoklassniki', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'rss' => [
				'label' => __( 'RSS', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'facebook_group' => [
				'label' => __( 'Facebook Group', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'discord' => [
				'label' => __( 'Discord', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'tripadvisor' => [
				'label' => __( 'TripAdvisor', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'foursquare' => [
				'label' => __( 'Foursquare', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'yelp' => [
				'label' => __( 'Yelp', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'xing' => [
				'label' => __( 'Xing', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'whatsapp' => [
				'label' => __( 'WhatsApp', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'viber' => [
				'label' => __( 'Viber', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'telegram' => [
				'label' => __( 'Telegram', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'tumblr' => [
				'label' => __('Tumblr', 'blocksy'),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => ['transport' => 'postMessage'],
			],

			'weibo' => [
				'label' => __( 'Weibo', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'qq' => [
				'label' => __( 'QQ', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'wechat' => [
				'label' => __( 'WeChat', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'strava' => [
				'label' => __( 'Strava', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'flickr' => [
				'label' => __( 'Flickr', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'phone' => [
				'label' => __( 'Phone', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'email' => [
				'label' => __( 'Email', 'blocksy' ),
				'type' => 'text',
				'design' => 'inline',
				'value' => '',
				'setting' => [ 'transport' => 'postMessage' ],
			],

		],
	],
];
