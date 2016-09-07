<div class="table-header">
    <?= $title ?>
</div>

<?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'id' => $grid_id,
    'fixedHeader' => true,
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $data_provider,
    'template' => "{items}",
    'columns' => $grid_columns,
));
