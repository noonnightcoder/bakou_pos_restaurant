<?php
class RequestController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
			'ajaxOnly -uploadFile'
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array(
					'suggestItem','suggestClient','suggestSupplier','suggestGiftcard','treePath','loadContent','suggestAuPlaces',
					'suggestAuHierarchy','suggestLastname','fillAuTree','viewUnitPath','viewUnitLabel','initPerson',
					'suggestPerson','suggestPersonGroupCountry','listPersonsWithSameFirstname',
					'addTabularInputs','addTabularInputsAsTable','uploadFile'
				),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * @return array actions
	 */
	public function actions()
	{
		return array(
			'suggestItem'=>array(
				'class'=>'ext.actions.XSuggestAction',
				'modelName'=>'Item',
				'methodName'=>'suggest',
			),
                        'suggestClient'=>array(
				'class'=>'ext.actions.XSuggestAction',
				'modelName'=>'Client',
				'methodName'=>'suggest',
			),
                        'suggestSupplier'=>array(
				'class'=>'ext.actions.XSuggestAction',
				'modelName'=>'Supplier',
				'methodName'=>'suggest',
			),
                        'suggestGiftcard'=>array(
				'class'=>'ext.actions.XSuggestAction',
				'modelName'=>'Giftcard',
				'methodName'=>'suggest',
			),
			'uploadFile'=>array(
				'class'=>'ext.actions.XHEditorUpload',
			),
			'suggestAuPlaces'=>array(
				'class'=>'ext.actions.XSuggestAction',
				'modelName'=>'AdminUnit',
				'methodName'=>'suggestPlaces',
				'limit'=>30
			),
			'suggestAuHierarchy'=>array(
				'class'=>'ext.actions.XSuggestAction',
				'modelName'=>'AdminUnit',
				'methodName'=>'suggestHierarchy',
				'limit'=>30
			),
			'suggestLastname'=>array(
				'class'=>'ext.actions.XSuggestAction',
				'modelName'=>'Person',
				'methodName'=>'suggestLastname',
				'limit'=>30
			),
			'fillAuTree'=>array(
				'class'=>'ext.actions.XFillTreeAction',
				'modelName'=>'AdminUnit',
				'showRoot'=>false,
			),
			'viewUnitPath'=>array(
				'class'=>'ext.actions.XAjaxEchoAction',
				'modelName'=>'AdminUnit',
				'attributeName'=>'rootlessPath',
			),
			'viewUnitLabel'=>array(
				'class'=>'ext.actions.XAjaxEchoAction',
				'modelName'=>'AdminUnit',
				'attributeName'=>'label',
			),
			'initPerson'=>array(
				'class'=>'ext.actions.XSelect2InitAction',
				'modelName'=>'Person',
				'textField'=>'fullname',
			),
			'suggestPerson'=>array(
				'class'=>'ext.actions.XSelect2SuggestAction',
				'modelName'=>'Person',
				'methodName'=>'suggestPerson',
				'limit'=>30
			),
			'suggestPersonGroupCountry'=>array(
				'class'=>'ext.actions.XSelect2SuggestAction',
				'modelName'=>'Person',
				'methodName'=>'suggestPersonGroupCountry',
				'limit'=>30
			),
			'addTabularInputs'=>array(
				'class'=>'ext.actions.XTabularInputAction',
				'modelName'=>'Person',
				'viewName'=>'/site/extensions/_tabularInput',
			),
			'addTabularInputsAsTable'=>array(
				'class'=>'ext.actions.XTabularInputAction',
				'modelName'=>'Person',
				'viewName'=>'/site/extensions/_tabularInputAsTable',
			),
		);
	}

	/**
	 * Displays list on persons that have same firstname as person with given id
	 */
	public function actionListPersonsWithSameFirstname()
	{
		if(isset($_GET['id']))
                    $model=Person::model()->findbyPk($_GET['id']);
		if($model!==null)
		{
                    $models=Person::model()->findAll("firstname='{$model->firstname}'");
                    $data=array();
                    foreach($models as $model)
                    $data[] = $model->fullname;
                    echo Yii::t('ui','Persons with same firstname: ').implode(', ', $data);
		}

	}
}