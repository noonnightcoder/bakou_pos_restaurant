<p class="text-info">Employee Full Name : <?php echo $full_name; ?> </p>

<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'sale-item-grid',
	'dataProvider'=>$model->search($employee_id),
	'columns'=>array(
		'employee_id',
                'login_time',
                'logout_time',
                'last_action'
               
	),
)); ?>

