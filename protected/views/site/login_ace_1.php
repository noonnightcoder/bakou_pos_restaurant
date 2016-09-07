<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle=Yii::app()->name . ' - Login';
?>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="login-container">
            <div class="center">
                <h1>
                    <i class="ace-icon fa fa-leaf green"></i>
                    <span class="red">POS</span>
                    <span class="white" id="id-text2">Application</span>
                </h1>
                <h4 class="blue" id="id-company-text">&copy; Bakou System</h4>
            </div>
           
            <div class="space-6"></div>
            
            <div class="position-relative">
                <div id="login-box" class="login-box visible widget-box no-border">
                    <div class="widget-body">
                        <div class="widget-main">
                            <h4 class="header blue lighter bigger">
                                    <i class="ace-icon fa fa-coffee green"></i>
                                    Please Enter Your Information
                            </h4>

                            <div class="space-6"></div>

                            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                                    'id'=>'login-form',
                                    //'layout'=>TbHtml::FORM_LAYOUT_INLINE,
                           )); ?>

                                <fieldset>
                                    <?php //echo $form->textFieldControlGroup($model,'username',array('class'=>'span12','maxlength'=>30,'placeholder'=>'Username')); ?>

                                    <div class="control-group info">
                                    <label class="block clearfix required" for="LoginForm_username">
                                        <span class="block input-icon input-icon-right required">
                                            <?php echo $form->textField($model,'username',array('class'=>'form-control','maxlength'=>30,'placeholder'=>Yii::t('app','Username'),'autocomplete'=>'off')); ?>
                                            <i class="ace-icon fa fa-user"></i>
                                            <div class="control-group error">
                                            <?php echo $form->error($model,'username'); ?>
                                            </div>
                                        </span>
                                    </label>
                                    </div>

                                    <div class="control-group info">
                                    <label class="block clearfix required">
                                        <span class="block input-icon input-icon-right">
                                            <?php echo $form->passwordField($model,'password',array('value'=>'','class'=>'span12','maxlength'=>30,'placeholder'=>Yii::t('app','Password'),'autocomplete'=>'off')); ?>
                                            <i class="ace-icon fa fa-lock"></i>
                                            <div class="control-group error">
                                            <?php echo $form->error($model,'password'); ?>
                                            </div>
                                        </span>
                                    </label>
                                    </div>
                                    <div class="space"></div>
                                    
                                    <div class="clearfix">
                                         <?php //echo TbHtml::checkBox($model,'rememberMe', array('label' => 'Remember me')); ?>
                                         <label class="inline">
                                                <input type="checkbox" />
                                                <span class="lbl"> Remember Me</span>
                                        </label>
                                         <?php echo TbHtml::submitButton(Yii::t('app', 'Login'),array(
                                            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                                            'size'=>TbHtml::BUTTON_SIZE_SMALL,
                                            'class'=>'width-35 pull-right btn btn-sm',
                                            'icon'=>'ace-icon fa fa-key',
                                        )); ?>
                                    </div>
                                </fieldset>

                            <?php $this->endWidget(); ?>



                                <div class="social-or-login center">
                                        <span class="bigger-110">Or Login Using</span>
                                </div>
                                
                                <div class="space-6"></div>

                                <div class="social-login center">
                                        <a class="btn btn-primary">
                                                <i class="ace-icon fa fa-facebook"></i>
                                        </a>

                                        <a class="btn btn-info">
                                                <i class="ace-icon fa fa-twitter"></i>
                                        </a>

                                        <a class="btn btn-danger">
                                                <i class="ace-icon fa fa-google-plus"></i>
                                        </a>
                                </div>
                        </div><!--/widget-main-->

                        <div class="toolbar clearfix">
                            <div>
                                <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                    <i class="ace-icon fa fa-arrow-left"></i>
                                    I forgot my password
                                </a>
                            </div>

                            <div>
                                <a href="#" class="user-signup-link">
                                    I want to register
                                    <i class="ace-icon fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div><!--/widget-body-->
                </div><!--/login-box-->

                <div id="forgot-box" class="forgot-box widget-box no-border">
                        <div class="widget-body">
                                <div class="widget-main">
                                        <h4 class="header red lighter bigger">
                                                <i class="icon-key"></i>
                                                Retrieve Password
                                        </h4>

                                        <div class="space-6"></div>
                                        <p>
                                                Enter your email and to receive instructions
                                        </p>

                                        <form />
                                                <fieldset>
                                                        <label>
                                                                <span class="block input-icon input-icon-right">
                                                                        <input type="email" class="span12" placeholder="Email" />
                                                                        <i class="icon-envelope"></i>
                                                                </span>
                                                        </label>

                                                        <div class="clearfix">
                                                                <button onclick="return false;" class="width-35 pull-right btn btn-small btn-danger">
                                                                        <i class="icon-lightbulb"></i>
                                                                        Send Me!
                                                                </button>
                                                        </div>
                                                </fieldset>
                                        </form>
                                </div><!--/widget-main-->

                                <div class="toolbar center">
                                        <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                                Back to login
                                                <i class="icon-arrow-right"></i>
                                        </a>
                                </div>
                        </div><!--/widget-body-->
                </div><!--/forgot-box-->

                <div id="signup-box" class="signup-box widget-box no-border">
                        <div class="widget-body">
                                <div class="widget-main">
                                        <h4 class="header green lighter bigger">
                                                <i class="icon-group blue"></i>
                                                New User Registration
                                        </h4>

                                        <div class="space-6"></div>
                                        <p> Enter your details to begin: </p>

                                        <form />
                                                <fieldset>
                                                        <label>
                                                                <span class="block input-icon input-icon-right">
                                                                        <input type="email" class="span12" placeholder="Email" />
                                                                        <i class="icon-envelope"></i>
                                                                </span>
                                                        </label>

                                                        <label>
                                                                <span class="block input-icon input-icon-right">
                                                                        <input type="text" class="span12" placeholder="Username"/>
                                                                        <i class="icon-user"></i>
                                                                </span>
                                                        </label>

                                                        <label>
                                                                <span class="block input-icon input-icon-right">
                                                                        <input type="password" class="span12" placeholder="Password" />
                                                                        <i class="icon-lock"></i>
                                                                </span>
                                                        </label>

                                                        <label>
                                                                <span class="block input-icon input-icon-right">
                                                                        <input type="password" class="span12" placeholder="Repeat password" />
                                                                        <i class="icon-retweet"></i>
                                                                </span>
                                                        </label>

                                                        <label>
                                                                <input type="checkbox" />
                                                                <span class="lbl">
                                                                        I accept the
                                                                        <a href="#">User Agreement</a>
                                                                </span>
                                                        </label>

                                                        <div class="space-24"></div>

                                                        <div class="clearfix">
                                                                <button type="reset" class="width-30 pull-left btn btn-small">
                                                                        <i class="icon-refresh"></i>
                                                                        Reset
                                                                </button>

                                                                <button onclick="return false;" class="width-65 pull-right btn btn-small btn-success">
                                                                        Register
                                                                        <i class="icon-arrow-right icon-on-right"></i>
                                                                </button>
                                                        </div>
                                                </fieldset>
                                        </form>
                                </div>

                                <div class="toolbar center">
                                        <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                                <i class="icon-arrow-left"></i>
                                                Back to login
                                        </a>
                                </div>
                        </div><!--/widget-body-->
                </div><!--/signup-box-->
            </div><!--/position-relative-->
        </div>
    </div><!--/.span-->
</div><!--/.row-fluid-->

<?php Yii::app()->clientScript->registerScript('setFocus',  '$("#LoginForm_username").focus();'); ?>