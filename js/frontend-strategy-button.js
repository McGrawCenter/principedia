(function() {





    tinymce.PluginManager.add('principedia_tc_button', function( editor, url ) {


        editor.addButton( 'principedia_tc_button', {
	    title: 'Link to Learning Strategy',
	    image: url+'/images/learning-strategy.png',
            onclick: function() {
                
		//if(editor.selection.getContent() != "") {

				// Calls the pop-up modal
				editor.windowManager.open({
					title: 'Link to Learning Strategy',
					width: 500,
					height:300,
					
					inline: 1,
					id: 'principedia-insert-dialog',
					buttons: [

					   {
						text: 'Insert Link',
						id: 'principedia-button-insert',
						class: 'insert',
						onclick: function( e ) {
							var target_id = jQuery('.strategy-link.selected').attr('rel');
							var markOpen  = '<a href=\"#\" class=\"learning-strategy-link\" rel=\"'+target_id+'\">',markClose = '</a>', highlight = markOpen + editor.selection.getContent() + markClose;

							editor.focus();
							editor.selection.setContent( markOpen + editor.selection.getContent() + markClose );
							editor.windowManager.close();
						},
					    },

					    {
						text: 'Cancel',
						id: 'principedia-button-cancel',
						onclick: 'close'
					    }
					],
				},
 
			        //  Parameters and arguments we want available to the window.
			        {
				    editor: editor,   //    This is a reference to the current editor. We'll need this to insert the shortcode we create.
				    jquery: jQuery,        //    If you want jQuery in the dialog, you must pass it here.                                          
			        });

				appendInsertDialog();

		//}




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
		//var dialogBody = jQuery( '#principedia-insert-dialog-body' ).append( '<img src="images/spinner.gif" />' );
		var dialogBody = jQuery( '#principedia-insert-dialog-body' );
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




	function insertStrategyLink () {
		var markOpen  = '<a href="">',
		    markClose = '</a>',
		    highlight = markOpen + editor.selection.getContent() + markClose;

		editor.focus();
		editor.selection.setContent(
			markOpen + editor.selection.getContent() + markClose
		);
	}


})();


/************** END TEXT EDITOR *****************************/



;
