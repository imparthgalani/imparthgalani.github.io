jQuery(document).ready( function($) { 

    $('.page-title-action').hide();

    // Initialize the CodeMirror editor
    if ( $('#ccj_content').length > 0 ) {
        var content_mode = $("#ccj_content").attr('mode');
        if ( content_mode == 'html' ) {
              var content_mode = {
                name: "htmlmixed",
                scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                mode: null}]
                 };
        }
        var options = {
            lineNumbers: true,
            mode: content_mode,
            matchBrackets: true,
            autoCloseBrackets: true,
            extraKeys: {
                "F11": function(cm) {
                    cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                    fullscreen_buttons( true );
                },
                "Esc": function(cm) {
                    if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                    fullscreen_buttons( false );
                },
                "Ctrl-Space": "autocomplete",
                "Cmd-Space": "autocomplete",
                "Ctrl-F": "findPersistent",
                "Cmd-F": "findPersistent",
                "Ctrl-/": "toggleComment",
                "Cmd-/": "toggleComment",
            },
        };

        var cm_width = $('#title').width() + 16;
        var cm_height = 500;

        var editor = CodeMirror.fromTextArea(document.getElementById("ccj_content"), options);

        editor.setSize(cm_width, cm_height);

        $('.CodeMirror').resizable({
            resize: function() {
                editor.setSize($(this).width(), $(this).height());
            } ,
            maxWidth: cm_width,
            minWidth: cm_width,
            minHeight: 200
            
        });

        $(window).resize(function () { 
            var cm_width = $('#title').width() + 16;
            var cm_height = $('.CodeMirror').height();
            editor.setSize(cm_width, cm_height);
        });

        // Code Beautifier
        $("#ccj-beautifier").click(function(e){
            CodeMirror.commands["selectAll"](editor);
            editor.autoFormatRange(editor.getCursor(true), editor.getCursor(false));
            editor.setCursor(0);
            e.preventDefault();
        });

		// Autocomplete
		if ( CCJ.autocomplete === '1' ) {
			editor.on( "keyup", function ( cm, event ) {
				if ( ! cm.state.completionActive && event.keyCode > 64 && event.keyCode < 91 ) {
					CodeMirror.commands.autocomplete( cm, null, { completeSingle: false } );
				}
			});
		}

        var postID = document.getElementById('post_ID') != null ? document.getElementById('post_ID').value : 0;

        var getCookie = function (name) {
            var value = '; ' + document.cookie;
            var parts = value.split('; ' + name + '=');
            if (parts.length === 2) return parts.pop().split(';').shift();
        };


        // Saving cursor state
        editor.on('cursorActivity', function () {
            var curPos = editor.getCursor();
            document.cookie = 'hesh_plugin_pos=' + postID + ',' + curPos.line + ',' + curPos.ch + '; SameSite=Lax';
        });

        // Restoring cursor state
        var curPos = (getCookie('hesh_plugin_pos') || '0,0,0').split(',');
        if (postID === curPos[0]) {
            editor.setCursor(parseFloat(curPos[1]), parseFloat(curPos[2]));
        }

    }

    // Action for the `fullscreen` button
    $("#ccj-fullscreen-button").click( function() {
        var toggle = editor.getOption("fullScreen");
        editor.setOption("fullScreen", !toggle);
        fullscreen_buttons( !toggle );
    });

    $("#publish").click(function(e){
        if ( editor.getOption("fullScreen") === true ) {
            Cookies.set('fullScreen', 'true');
        }
    });

    // Show fullscreen
    if ( Cookies.get('fullScreen') == 'true' ) {
        var toggle = editor.getOption("fullScreen");
        editor.setOption("fullScreen", !toggle);
        fullscreen_buttons( !toggle );
        Cookies.remove('fullScreen');
    }

    // Enable the tipsy 
    $('span[rel=tipsy].tipsy-no-html').tipsy({fade: true, gravity: 's'});
    $('span[rel=tipsy]').tipsy({fade: true, gravity: 's', html: true});

    // Toggle the buttons when in fullscreen mode
    function fullscreen_buttons( mode ) {
        editor.focus();
        if ( mode === true ) {
            $("#publish").css({
                'position'  : 'fixed',
                'right'     : '40px',
                'bottom'    : '40px',
                'z-index'   : 100005,
            });
        } else {
            $("#publish").css({
                'position'  : 'static',
                'right'     : 'initial',
                'bottom'    : 'initial',
                'z-index'   : 10,
            });
        }
    }


    // For post.php or post-new.php pages show the code's title in the page title
    if ( $('#titlediv #title').length > 0 ) {
        var new_title = $("input[name=custom_code_language]").val().toUpperCase() + ' - ' + $('#titlediv #title').val();
        if( $('#titlediv #title').val().length > 0 ) {
            $(document).prop('title', new_title );
        }
        $('#titlediv #title').change(function() {
            if ( $(this).val().length > 0 ) {
                $(document).prop('title', new_title);
            } 
        });
    }


    // Make the inactive rows opaque
    if ( $('.dashicons-star-empty.ccj_row').length > 0 ) {
        $('.dashicons-star-empty.ccj_row').each(function(){
            $(this).parent().parent().parent().css('opacity', '0.4');
        });
    }

    // Activate/deactivate codes with AJAX
    $(".ccj_activate_deactivate").click( function(e) {
        var url = $(this).attr('href');
        var code_id = $(this).attr('data-code-id');
        e.preventDefault(); 
        $.ajax({
            url: url, 
            success: function(data){
                if (data === 'yes') {
                    ccj_activate_deactivate(code_id, false);
                }
                if (data === 'no') {
                    ccj_activate_deactivate(code_id, true);
                }
            }
        });
    });


	// The "After <body> tag" option cannot go together with the "In Admin" option
	custom_code_type_change();
	$( 'input[name=custom_code_type]' ).on( 'change', custom_code_type_change );
	function custom_code_type_change() {
		if ( $( 'input[name=custom_code_type]:checked' ).val() === 'body_open' ) {
			$( '#custom_code_side-admin' ).prop( 'disabled', true );
			if ( $( 'input[name=custom_code_side]:checked' ).val() === 'admin' ) {
				$( '#custom_code_side-admin' ).prop( 'checked', 'checked' );
			}
		} else {
			$( '#custom_code_side-admin' ).prop( 'disabled', false );
		}
	}
	custom_code_side_change();
	$( 'input[name=custom_code_side]' ).on( 'change', custom_code_side_change );
	function custom_code_side_change() {
		if ( $( 'input[name=custom_code_side]:checked' ).val() === 'admin' ) {
			$( '#custom_code_type-body_open' ).prop( 'disabled', true );
		} else {
			$( '#custom_code_type-body_open' ).prop( 'disabled', false );
			if ( $( 'input[name=custom_code_type]:checked' ).val() === 'body_open' ) {
				$( '#custom_code_type-body_open' ).prop( 'checked', true );
			}
		}
	}


    // Toggle the signs for activating/deactivating codes
    function ccj_activate_deactivate(code_id, action) {
        var row = $('tr#post-'+code_id);
        if ( action === true ) {
            row.css('opacity', '1');
            row.find('.row-actions .ccj_activate_deactivate')
                .text(CCJ.deactivate)
                .attr('title', CCJ.active_title);
            row.find('td.active .dashicons')
                .removeClass('dashicons-star-empty')
                .addClass('dashicons-star-filled');
            row.find('td.active .ccj_activate_deactivate')
                .attr('title', CCJ.active_title);
            $('#activate-action span').text(CCJ.active);
            $('#activate-action .ccj_activate_deactivate').text(CCJ.deactivate);
        } else {
            row.css('opacity', '0.4');
            row.find('.row-actions .ccj_activate_deactivate')
                .text(CCJ.activate)
                .attr('title', CCJ.deactive_title);
            row.find('td.active .dashicons')
                .removeClass('dashicons-star-filled')
                .addClass('dashicons-star-empty');
            row.find('td.active .ccj_activate_deactivate')
                .attr('title', CCJ.deactive_title);
            $('#activate-action span').text(CCJ.inactive);
            $('#activate-action .ccj_activate_deactivate').text(CCJ.activate);
        }
    }


    // Permalink slug
    $( '#titlediv' ).on( 'click', '.ccj-edit-slug', function() {
		var i, 
			$el, revert_e,
			c = 0,
            slug_value = $('#editable-post-name').html(),
			real_slug = $('#post_name'),
			revert_slug = real_slug.val(),
			permalink = $( '#sample-permalink' ),
			permalinkOrig = permalink.html(),
			permalinkInner = $( '#sample-permalink a' ).html(),
            permalinkHref = $('#sample-permalink a').attr('href'),
			buttons = $('#ccj-edit-slug-buttons'),
			buttonsOrig = buttons.html(),
			full = $('#editable-post-name-full');

		// Deal with Twemoji in the post-name.
		full.find( 'img' ).replaceWith( function() { return this.alt; } );
		full = full.html();

		permalink.html( permalinkInner );

		// Save current content to revert to when cancelling.
		$el = $( '#editable-post-name' );
		revert_e = $el.html();

		if ( typeof postL10n === 'undefined' || postL10n.cancel === '' || postL10n.ok === '' ) {
			postL10n = {
				ok     : wp.i18n.__( 'OK' ),
				cancel : wp.i18n.__( 'Cancel' ),
			}
		}

        buttons.html( '<button type="button" class="save button button-small">' + postL10n.ok + '</button> <button type="button" class="cancel button-link">' + postL10n.cancel + '</button>' );


        // Save permalink changes.
		buttons.children( '.save' ).click( function() {
			var new_slug = $el.children( 'input' ).val();

			if ( new_slug == $('#editable-post-name-full').text() ) {
				buttons.children('.cancel').click();
				return;
			}

			$.post(
				ajaxurl,
				{
					action: 'ccj_permalink',
					code_id: $('#post_ID').val(),
					new_slug: new_slug,
                    permalink: permalinkHref, 
					filetype: $('#editable-post-name-full').data('filetype'), 
					ccj_permalink_nonce: $('#ccj-permalink-nonce').val()
				},
				function(data) {
					var box = $('#edit-slug-box');
					box.html(data);
					if (box.hasClass('hidden')) {
						box.fadeIn('fast', function () {
							box.removeClass('hidden');
						});
					}
				}
			);
		});

		// Cancel editing of permalink.
		buttons.children( '.cancel' ).click( function() {
			$('#view-post-btn').show();
			$el.html(revert_e);
			buttons.html(buttonsOrig);
			permalink.html(permalinkOrig);
			real_slug.val(revert_slug);
			$( '.ccj-edit-slug' ).focus();
		});

		$el.html( '<input type="text" name="new_slug" id="new-post-slug" value="' + slug_value + '" autocomplete="off" />' ).children( 'input' ).keydown( function( e ) {
			var key = e.which;
			// On [enter], just save the new slug, don't save the post.
			if ( 13 === key ) {
				e.preventDefault();
				buttons.children( '.save' ).click();
			}
			// On [esc] cancel the editing.
			if ( 27 === key ) {
				buttons.children( '.cancel' ).click();
			}
		} ).keyup( function() {
			real_slug.val( this.value );
		}).focus();


    });


});

