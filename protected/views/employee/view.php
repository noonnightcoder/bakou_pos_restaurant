<?php 
$this->breadcrumbs=array(
	'Employees'=>array('admin'),
	$model->id,
);
?>
<div class="page-content">
<div class="row">
    <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <div class="clearfix">
                    <div class="pull-left alert alert-success inline no-margin">
                            <button type="button" class="close" data-dismiss="alert">
                                    <i class="icon-remove"></i>
                            </button>

                            <i class="icon-umbrella bigger-120 blue"></i>
                            Click on profile fields to edit them
                    </div>
            </div>

            <div class="hr dotted"></div>

            <div>
                <div id="user-profile-1" class="user-profile row-fluid">
                    <!--
                    <div class="span3 center">
                            <div>
                                    <span class="profile-picture">
                                        <?php //echo TbHtml::image(Yii::app()->theme->baseUrl . '/avatars/profile-pic.jpg','Avatar\'s photo',array('class'=>'editable')); ?>
                                        <?php /*
                                        $this->widget('yiiwheels.widgets.fineuploader.WhFineUploader', array(
                                                'name'  => 'image',
                                                'model' => $model,
                                                'uploadAction'  => $this->createUrl('employee/uploadImage', array('employee_id' => $model->id)),
                                                'pluginOptions' => array(
                                                    'validation'=>array(
                                                        'allowedExtensions' => array('jpeg', 'jpg'),
                                                        'sizeLimit'     => '102400',
                                                    )
                                                )
                                            ));
                                         * 
                                         */
                                        ?>
                                    </span>
                                    <div class="space-4"></div>
                            </div>
                            <div class="space-6"></div>
                    </div>
                    -->

                    <div class="span9">

                           <?php /*$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                                    'id'=>'employee-form',
                                    'enableAjaxValidation'=>false,
                                    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
                            )); */?>

                            <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                            <div class="profile-info-name"> User Name </div>
                                            <div class="profile-info-value">
                                            <i class="icon-key light-orange bigger-110"></i>        
                                            <?php echo $user->user_name; ?>
                                            </div>
                                    </div>
                                    <div class="profile-info-row">
                                            <div class="profile-info-name"> First Name </div>
                                            <div class="profile-info-value">
                                            <?php
                                            $this->widget('yiiwheels.widgets.editable.WhEditableField', array(
                                                    'type'      => 'text',
                                                    'model'     => $model,
                                                    'attribute' => 'first_name',
                                                    'url'       => $this->createUrl('employee/InlineUpdate'),
                                                    'success'   => 'js: function(data) {
                                                                        if(typeof data == "object" && !data.success) return data.msg;
                                                                    }'
                                            ));
                                            ?>
                                            </div>
                                    </div>
                                    <div class="profile-info-row">
                                            <div class="profile-info-name"> Last Name </div>
                                            <div class="profile-info-value">
                                            <?php
                                            $this->widget('yiiwheels.widgets.editable.WhEditableField', array(
                                                    'type'      => 'text',
                                                    'model'     => $model,
                                                    'attribute' => 'last_name',
                                                    'url' => $this->createUrl('employee/InlineUpdate'),
                                            ));
                                            ?>
                                            </div>
                                    </div>
                                    <div class="profile-info-row">
                                            <div class="profile-info-name"> Mobile No </div>
                                            <div class="profile-info-value">
                                            <?php
                                            $this->widget('yiiwheels.widgets.editable.WhEditableField', array(
                                                    'type'      => 'text',
                                                    'model'     => $model,
                                                    'attribute' => 'mobile_no',
                                                    'url'       => $this->createUrl('employee/InlineUpdate'),
                                            ));
                                            ?>
                                            </div>
                                    </div>  
                                    <div class="profile-info-row">
                                            <div class="profile-info-name"> Address1 </div>
                                            <div class="profile-info-value">
                                            <i class="icon-map-marker light-orange bigger-110"></i>    
                                            <?php
                                            $this->widget('yiiwheels.widgets.editable.WhEditableField', array(
                                                    'type'      => 'text',
                                                    'model'     => $model,
                                                    'attribute' => 'adddress1',
                                                    'url'       => $this->createUrl('employee/InlineUpdate'),
                                            ));
                                            ?>
                                            </div>
                                    </div> 
                                    <div class="profile-info-row">
                                            <div class="profile-info-name"> Address2 </div>
                                            <div class="profile-info-value">
                                            <i class="icon-map-marker light-orange bigger-110"></i>    
                                            <?php
                                            $this->widget('yiiwheels.widgets.editable.WhEditableField', array(
                                                    'type'      => 'text',
                                                    'model'     => $model,
                                                    'attribute' => 'address2',
                                                    'url'       => $this->createUrl('employee/InlineUpdate'),
                                            ));
                                            ?>
                                            </div>
                                    </div> 

                            </div>
                                
                            <?php //$this->endWidget(); ?>

                        </div>
                </div>
            </div>

            <!--PAGE CONTENT ENDS-->
    </div><!--/.span-->
</div><!--/.row-fluid-->
</div><!--/.page-content-->

<!--<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
     <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>-->

<script type="text/javascript">
/*    
$(function() {
        $('#profile-feed-1').slimScroll({
        height: '250px',
        alwaysVisible : true
        });


});
*/
</script>