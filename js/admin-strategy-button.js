(function() {

jQuery( ".strategy-link" ).click(function() {
  alert( "Handler for .click() called." );
});
	



    tinymce.PluginManager.add('principedia_tc_button', function( editor, url ) {


        editor.addButton( 'principedia_tc_button', {
	    title: 'Link to Learning Strategy',
	    image: '../wp-content/plugins/principedia/images/learning-strategy.png',
            onclick: function() {
                
		//if(editor.selection.getContent() != "") {

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
					buttons: [
					   {
						text: 'Insert Learning Strategy Link',
						id: 'principedia-button-insert',
						class: 'insert',
						onclick: function( e ) {
							//insertShortcode();
							//alert('blah');
							//editor.insertContent(' Hello ');
							var markOpen  = '<a href="">', markClose = '</a>', highlight = markOpen + editor.selection.getContent() + markClose;

							editor.focus();
							editor.selection.setContent( markOpen + editor.selection.getContent() + markClose ); 
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
			dialogBody.append( "<a href='#' class='strategy-link'>Something</a>" );
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
