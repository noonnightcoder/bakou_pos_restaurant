<?php
/*
 * @author Lux Sok <lux.lyny@gmail.com>
 * @copyright 2013 
 * @license New BSD License
 * @version 1.0
 * @package ext.modaldlg
 * @since 1.0
 */

class EModalDlg extends CWidget
{
    
    /**
     * The title of the dialog
     * @var string
     */
    public $dialogTitle;
    
    /**
     * The string open update dialog after clicking these elements. 
     * @var 
    */
    public $target = '.update-dialog-open-link';
    
    /**
    * @var string message category used for Yii::t method.
    */
    public $tCategory = 'app';
    
    /**
    * Add the update dialog to current page.
    */
    public function run()
    { 
        $this->widget('bootstrap.widgets.TbModal', array(
            'id' => 'myModal',
            'header' => 'Modal Heading',
            'content' =>TbHtml::animatedProgressBar(99),
            /* 
            'footer' => array(
                TbHtml::button('Close', array('data-dismiss' => 'modal')),
             ),
             * 
            */
        ));

        // Publish extension assets
        $assets = Yii::app()->getAssetManager()->publish( Yii::getPathOfAlias(
          'ext.modaldlg' ) . '/assets' );

        // Register extension assets
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile( $assets . '/EModalDlg.js',CClientScript::POS_END );

        // Open update dialog the clicking target elements
        $cs->registerScript( 'eupdatedialog', "
          jQuery( '{$this->target}' ).on( 'click', updateDialogOpen );",
          CClientScript::POS_END );
     
    }
}
?>
