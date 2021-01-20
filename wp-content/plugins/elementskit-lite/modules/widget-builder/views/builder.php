<?php $id = (int) (isset($_GET['post']) ? $_GET['post'] : 0); ?>
<script>
    var ekitWidgetBuilder = {
        api: '<?php echo get_rest_url(); ?>elementskit/v1/widget-builder/',
        pull_id: <?php echo $id ;?>,
        nonce: '<?php echo wp_create_nonce( 'wp_rest' ); ?>',
        live_url: '<?php echo str_replace(['&amp;', 'action=edit'], ['&','action=elementor'], get_edit_post_link($id)); ?>',
        pro: <?php echo \ElementsKit_Lite::package_type() == 'pro' ? 'true' : 'false'; ?>,
        assets: {
            'wysiwyg': '<?php echo $this->url; ?>assets/img/wysiwyg.png',
            'noImagePreview': '<?php echo $this->url; ?>assets/img/no-image.png',
            'imagePreviewTrans': '<?php echo $this->url; ?>assets/img/transparent_bg.png'
        }
    };
</script>


<div id="ekitWidgetBuilderApp"></div>
