<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'searchForm',
    'method'=>'get',
    'htmlOptions'=>array('class'=>'well'),
)); ?>
 
<?php echo $form->textFieldControlGroup($model,'id',array('class'=>'span4','maxlength'=>50)); ?>
<?php echo $form->textFieldControlGroup($model, 'client_id', array('class'=>'span4', 'append'=>'<i class="icon-search"></i>')); ?>
<?php /*
$this->widget('bootstrap.widgets.TbSelect2', array(
    'asDropDownList' => false,
    'model'=> $model, 
    'attribute'=>'search',
    'options' => array(
            //'placeholder' => 'Type for hints...',
            'multiple'=>false,
            'width' => '70%',
            'tokenSeparators' => array(',', ' '),
            'allowClear'=>false,
            'minimumInputLength'=>1,
            'ajax' => array(
                'url' => Yii::app()->createUrl('Client/getClient/'), 
                'dataType' => 'json',
                'data' => 'js:function(term,page) {
                            return {
                                term: term, 
                                page_limit: 10,
                                quietMillis: 10,
                                apikey: "e5mnmyr86jzb9dhae3ksgd73" // Please create your own key!
                            };
                        }',
                'results' => 'js:function(data,page){
                    return {results: data.results};
                }',
            ),
    )));
 * 
 */
?>

<?php //$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go')); ?>
 
<?php $this->endWidget(); ?>
