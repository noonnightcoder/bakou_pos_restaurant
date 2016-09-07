<?php

/**
 * This is the model class for table "item_image".
 *
 * The followings are the available columns in table 'item_image':
 * @property integer $id
 * @property integer $item_id
 * @property string $photo
 * @property string $thumbnail
 * @property string $filename
 * @property string $filetype
 * @property string $path
 * @property integer $size
 * @property string $width
 * @property string $height
 *
 * The followings are the available model relations:
 * @property Item $item
 */
class ItemImage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, photo, filename', 'required'),
			array('item_id, size', 'numerical', 'integerOnly'=>true),
			array('filename', 'length', 'max'=>30),
			array('filetype', 'length', 'max'=>15),
			array('path', 'length', 'max'=>100),
			array('width, height', 'length', 'max'=>20),
			array('thumbnail', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_id, photo, thumbnail, filename, filetype, path, size, width, height', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_id' => 'Item',
			'photo' => 'Photo',
			'thumbnail' => 'Thumbnail',
			'filename' => 'Filename',
			'filetype' => 'Filetype',
			'path' => 'Path',
			'size' => 'Size',
			'width' => 'Width',
			'height' => 'Height',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('thumbnail',$this->thumbnail,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('filetype',$this->filetype,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('size',$this->size);
		$criteria->compare('width',$this->width,true);
		$criteria->compare('height',$this->height,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemImage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
