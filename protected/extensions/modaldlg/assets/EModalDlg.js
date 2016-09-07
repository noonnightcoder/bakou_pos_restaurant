/**
 * EModalDlg extension file.
 *
 * @author Lux Sok <sok.lux@gmail.com>
 * @copyright Copyright &copy; 2013 Lux Sok
 * @license Licensed under MIT license.
 * @version 1.0
 */

/**
 * UpdateDialog object.
 */
var updateDialog = {
  
  /**
   * @var string CSRF token for CSRF validation.
   */
  csrfToken : '',
      
  /**
   * @var string Default title to use then data attribute is not set.
   */
  defaultTitle : 'Dialog',
          
  /**
   * @var int The timeout for callback function in milliseconds.
   */
  timeout: 1000,
    
  /**
   * Add loaded contents to UpdateDialog.
   * @param string url the url of the page to load. 
   */
  addContent : function( url ){
    // Make an AJAX call to get contents
    $.ajax({
      'url': url,
      'data': this.csrfToken,
      'type': 'post',
      'dataType': 'json',
      'success': function( data ){
        // Remove loading indicator
        updateDialog.removeLoader();
        
        // Add returned contents to UpdateDialog
        updateDialog.dialogContent.html( data.div );
      
      },
      'cache': false
    });
  },

  /**
    * Get CSRF token for CSRF validation.
    * @return string CSRF token if CSRF validation is enabled.
    */
  getCsrfToken : function(){
    if( ( jQuery.cookie ) && ( this.csrfTokenName != null ) )
    {
      return ( '&' + this.csrfTokenName + '=' + $.cookie( this.csrfTokenName ) );
    }
  }, 
  
  /**
   * Initialize UpdateDialog.
   */
  init : function(){
    // Set dialog
    this.dialog = $( '#myModal' );
   
    // Set dialog content
    //this.dialogContent = this.dialog.children('.modal-body');
    this.dialogContent = $('#myModal div.modal-body');
    
    // Set CSRF token
    this.csrfToken = this.getCsrfToken();
  
    // Attach a handler for all submit buttons in dialog content
    //$('#myModal div.modal-body form button[type=submit]')
    //.live('click', function( e ){
    $('#myModal div.modal-body')
      //.off()
      .on('click', 'form button[type=submit]' , function( e ){
        // Prevent default action
        e.preventDefault();
   
        // Submit form data together with clicked button name
        updateDialog.submit( $( this ).attr( 'name' ) );
      });
      
       // Attach a handler for all cancel buttons in dialog content
    $( '.update-dialog-content .close' )
      .live( 'click', function( e ){
        // Prevent default action
        e.preventDefault();
        
        // Close the UpdateDialog
        updateDialog.close();
      });
    },
  
  /**
   * Open UpdateDialog and load contents for it.
   * @param string url the href attribute value of clicked link.
   */
  open : function( url ){
    // Clean UpdateDialog contents.
    //this.cleanContents();
    
     // Use default title for UpdateDialog if it's not set
    if( typeof this.title === 'undefined' )
    {
      this.title = this.defaultTitle;
    }
    
    // Update modal dialog title
    $('.modal-header h4').text(this.title);
         
    // Open jQuery UI dialog
    this.dialog.modal('show');
    
    // Add loading indicator for feedback
    this.addLoader();
      
    // Add the contents to UpdateDialog
    this.addContent( url );
    
  },
          
  /**
   * Add loading indicator for feedback.
   */
  addLoader : function(){
    //this.dialogContent.html( 'Loading...' );
    $('.load-indicator').show();
  },
  
  /**
   * Remove loading indicator.
   */
  removeLoader : function(){
    $('.load-indicator').hide();
  },
          
  
  /**
   * Callback on render.
   */
  renderCallback : function(){},
  
  /**
   * Set callback function based on status.
   * @param string status the status returned by form submit.
   */
  callback : function( status ){
   // Switch between callback status
    switch( status )
    {    
      // Callback on render
      case 'render':
        setTimeout( this.renderCallback, this.timeout );
        break;
      
      // Callback on success
      case 'success':
        setTimeout( this.successCallback, this.timeout );
        break;
      
      // Callback on delete
      case 'deleted':
        setTimeout( this.deletedCallback, this.timeout );
        break;
      
      // Callback on cancel
      case 'canceled':
        setTimeout( this.canceledCallback, this.timeout );
        break;
      
      // Callback on image delete
      case 'imagedeleted':
        setTimeout( this.imageDeletedCallback, this.timeout );
        break;
      
      // Callback on image delete
      default:
        setTimeout( this.defaultCallback, this.timeout );
        break;
    }
  },
          
  /**
   * Clean the contents of UpdateDialog.
   */
  cleanContents : function(){
    // Empty UpdateDialog contents.
    this.dialogContent.empty();
  },
  
  /**
   * Close UpdateDialog.
   */
  close : function(){
    // Clean UpdateDialog contents
    this.cleanContents();
    
    // Close UpdateDialog
    this.dialog.modal( 'hide' );
  },
  
  /**
   * Submit form from UpdateDialog.
   * @param string submitName the name parameter value of the clicked button.
   */
  submit : function( submitName ){
    // Set full submit name
    submitName = '&' + submitName + '=true';
    
    // Get form from UpdateDialog
    var form = this.dialogContent.find( 'form' );
    
    // Get form data
    var formData = form.serialize() + submitName;
    
    // Add loading indicator for feedback
    //this.addLoader();
    
    // Make an AJAX call to submit form data
    $.ajax({
      'url': form.attr( 'action' ),
      'data': formData,
      'type': 'post',
      'dataType': 'json',
      'success': function( data ){
        // Remove loading indicator
        updateDialog.removeLoader();
        
        // Add returned contents to UpdateDialog
        updateDialog.dialogContent.html( data.div );
       
        // Run the callback function
        updateDialog.callback( data.status );
        
      },
      'cache': false
    });
  },
  
   /**
   * Callback then submit was successful.
   */
  successCallback : function(){
    
    /* console.log(updateDialog.gridId + ' : '  + updateDialog.title); */
    
    if( typeof updateDialog.gridId === 'undefined' )
    {  
          
          updateDialog.close();
          location.reload(true); 
    }
    else 
    {
       $.fn.yiiGridView.update(updateDialog.gridId);
       updateDialog.close();
    }
    
  
  }
 
  
};



/**
 * Open UpdateDialog for clicked link.
 * @param object e the event for clicked link.
 */
function updateDialogOpen( $e )
{
  // Set title for dialog using data attribute
  updateDialog.title = $(this).data('update-dialog-title');
  
  // Set refreshId for dialog using data attribute
  updateDialog.gridId = $(this).data('refresh-grid-id');
  
  //console.log(updateDialog.gridId);
  
  // Prevent default action
  $e.preventDefault();
    
  // Initialize update dialog if it's the first run
  if( typeof updateDialog.dialog === 'undefined' )
  {
    updateDialog.init();
    //console.log('Initializing...');
  }
 
  // Open update dialog
  updateDialog.open( $( this ).attr( 'href' ) );
}