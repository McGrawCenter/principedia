(function() {
    tinymce.PluginManager.add('principedia_tc_button', function( editor, url ) {
        editor.addButton( 'principedia_tc_button', {
            text: 'Link to Learning Stategy',
	    tooltip : 'Insert Link to Learning Strategy',
            icon: false,
            onclick: function() {
                

				// Calls the pop-up modal
				editor.windowManager.open({
					// Modal settings
					title: 'Link to Learning Strategy',
					//width: jQuery( window ).width() * 0.7,
					// minus head and foot of dialog box
					//height: (jQuery( window ).height() - 36 - 50) * 0.7,
					width: 500,
					height:300,
					
					inline: 1,
					id: 'principedia-insert-dialog',
					buttons: [{
						text: 'Insert Learning Strategy Link',
						id: 'principedia-button-insert',
						class: 'insert',
						onclick: function( e ) {
							//insertShortcode();
							//alert('blah');
							editor.insertContent(' Hello ');
						},
					    },
					    {
						text: 'Cancel',
						id: 'principedia-button-cancel',
						onclick: 'close'
					    }
					],
				});

				appendInsertDialog();






/*
		var markOpen  = '<a href="">',
		    markClose = '</a>',
		    highlight = markOpen + editor.selection.getContent() + markClose;

		editor.focus();
		editor.selection.setContent(
			markOpen + editor.selection.getContent() + markClose
		);
*/

            }
        });
    });






	function appendInsertDialog () {
		var dialogBody = jQuery( '#principedia-insert-dialog-body' ).append( '<img src="images/spinner.gif" />' );

		// Get the form template from WordPress
		jQuery.post( ajaxurl, {
			action: 'principedia_insert_dialog'
		}, function( response ) {
			template = response;

			dialogBody.children( '.loading' ).remove();
			dialogBody.append( template );
			jQuery( '.spinner' ).hide();
		});
	}


})();


/************** END TEXT EDITOR *****************************/



;
