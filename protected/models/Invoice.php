<?php

/**
 * This is the model class for table "invoice".
 *
 * The followings are the available columns in table 'invoice':
 * @property integer $id
 * @property integer $client_id
 * @property string $invoice_number
 * @property string $date_issued
 * @property string $payment_term
 * @property string $taxt1_rate
 * @property string $tax1_desc
 * @property string $tax2_rate
 * @property string $tax2_desc
 * @property string $note
 * @property integer $day_payment_due
 * @property boolean $flag
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property InvoiceItem[] $invoiceItems
 * @property InvoicePayment[] $invoicePayments
 */
class Invoice extends CActiveRecord
{
	public $work_description;
        public $amount;
        public $discount; // give away
        public $amount_paid;
        public $client_search;
        public $mobile_search;
        public $give_away;
        public $outstanding;
        public $debter;
        public $from_date;
        public $to_date;
        
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Invoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_id, invoice_number, amount', 'required'),
			//array('invoice_number','unique'),
                        array('client_id, day_payment_due', 'numerical', 'integerOnly'=>true),
			array('invoice_number', 'length', 'max'=>50),
			array('payment_term, tax1_desc, tax2_desc', 'length', 'max'=>100),
			array('taxt1_rate, tax2_rate', 'length', 'max'=>6),
                        array('amount', 'type', 'type'=>'float'),
			array('date_issued, note, work_description, flag', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, client_id, invoice_number, date_issued, amount, work_description,payment_term, taxt1_rate, tax1_desc, tax2_rate, tax2_desc, note, day_payment_due, client_search, mobile_search, flag', 'safe', 'on'=>'search'),
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
			'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
			'invoiceItems' => array(self::HAS_MANY, 'InvoiceItem', 'invoice_id'),
			'invoicePayments' => array(self::HAS_MANY, 'InvoicePayment', 'invoice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'client_id' => 'Client',
			'invoice_number' => 'Invoice Number',
			'date_issued' => 'Issued Date',
                        'amount' => 'Amount',
                        'work_description' => 'Work Description',
			'payment_term' => 'Payment Term',
			'taxt1_rate' => 'Taxt1 Rate',
			'tax1_desc' => 'Tax1 Desc',
			'tax2_rate' => 'Tax2 Rate',
			'tax2_desc' => 'Tax2 Desc',
			'note' => 'Note',
			'day_payment_due' => 'Day Payment Due',
                        'amount'=>'Amount',
                        'work_description'=>'Work Description',
                        'client_search'=>'Client',
                        'mobile_search' =>'Mobile No',
                        'flag'=>'Invoice Cancel',
                        'debter'=>'Collector',
		);
	}
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('client');

		$criteria->compare('id',$this->id);
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('invoice_number',$this->invoice_number,true);
		$criteria->compare('date_issued',$this->date_issued,true);
		$criteria->compare('payment_term',$this->payment_term,true);
		$criteria->compare('taxt1_rate',$this->taxt1_rate,true);
		$criteria->compare('tax1_desc',$this->tax1_desc,true);
		$criteria->compare('tax2_rate',$this->tax2_rate,true);
		$criteria->compare('tax2_desc',$this->tax2_desc,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('day_payment_due',$this->day_payment_due);
                $criteria->compare('client.fullname', $this->client_search, true);
                $criteria->compare('flag',$this->flag, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                        'attributes'=>array(
                            'client_search'=>array(
                                'asc'=>'client.fullname',
                                'desc'=>'client.fullname DESC',
                                ),
                                '*',
                             ),
                        ),      
		));
	}
        
        
        /*
         * To get common criteria for reporting
         */
        protected function getCommonCriteria()
        {
                $criteria=new CDbCriteria;
                $criteria->mergeWith(array('join'=>'left join invoice_payment t2 on t2.invoice_id=t.id'));
                $criteria->addCondition('date_issued >= :fromDate');
                $criteria->addCondition('date_issued <= :toDate');
                $criteria->addCondition('(IFNULL(t.amount,0)-IFNULL(t2.amount_paid,0)-IFNULL(t2.give_away,0))<>0');
                $criteria->params=array(':fromDate'=> $this->from_date,':toDate'=> $this->to_date);
                
                
                //$criteria->addBetweenCondition('date_issued', $this->from_date, $this->to_date, 'AND');
                //$criteria->addCondition="(IFNULL(t.amount,0)-IFNULL(t2.amount_paid,0)-IFNULL(t2.give_away,0))<>0";
                
                return $criteria;
        }
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function dailyInvoice()
	{
		$criteria=$this->getCommonCriteria();
                //$criteria->mergeWith(array('join'=>'left join invoice_payment t2 on t2.invoice_id=t.id'));
            
                $criteria->select = 'date_format(date_issued,"%Y-%m-%d") as date_issued,t.invoice_number,client_id,sum(amount) amount,sum(t2.give_away) give_away,sum(t2.amount_paid) amount_paid,sum(IFNULL(amount,0))-sum(IFNULL(t2.amount_paid,0))-sum(IFNULL(t2.give_away,0)) outstanding';
                //$criteria->addCondition="(IFNULL(t.amount,0)-IFNULL(t2.amount_paid,0)-IFNULL(t2.give_away,0))<>0";
                //$criteria->select = 'date_format(date_issued,"%Y-%m-%d") as date_issued,client_id,sum(amount) amount';
                //$criteria->addBetweenCondition('date_issued', $this->from_date, $this->to_date, 'AND');
                $criteria->group = 'date_format(date_issued,"%Y-%m-%d"),t.invoice_number,client_id';
                $criteria->order = 'date_issued';
               
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));

		
	}
         
        public function dailyInvoiceTotalAmount()
        {
            $criteria=$this->getCommonCriteria();
            $criteria->select='SUM(amount) total_amount';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function dailyInvoiceTotalAmountPaid()
        {
            $criteria=$this->getCommonCriteria();
            //$criteria->mergeWith(array('join'=>'left join invoice_payment t2 on t2.invoice_id=t.id'));
            $criteria->select='SUM(t2.amount_paid) total_amount_paid';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
         public function dailyInvoiceTotalGiveAway()
        {
            $criteria=$this->getCommonCriteria();
            //$criteria->mergeWith(array('join'=>'left join invoice_payment t2 on t2.invoice_id=t.id'));
            $criteria->select='SUM(t2.give_away) total_give_away';
            $criteria->condition="(IFNULL(t.amount,0)-IFNULL(t2.amount_paid,0)-IFNULL(t2.give_away,0))<>0";
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function dailyInvoiceTotalOutstanding()
        {
            $criteria=$this->getCommonCriteria();
            //$criteria->mergeWith(array('join'=>'left join invoice_payment t2 on t2.invoice_id=t.id'));
            $criteria->select='sum(IFNULL(amount,0))-sum(IFNULL(t2.amount_paid,0))-sum(IFNULL(t2.give_away,0)) total_outstanding';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
     
        
        public function totals()
        {
            $criteria=$this->getSearchCriteria();
            $criteria->select='SUM(amount) total_amount';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function getTotalGiveAway($ids)
        {
                $ids = implode(",",$ids);
                
                $connection=Yii::app()->db;
                $command=$connection->createCommand("SELECT SUM(give_away)
                                                     FROM `invoice_payment` where invoice_id in ($ids)");
                return $command->queryScalar();
        }
        
        public function getTotalAmountPaid($ids)
        {
                $ids = implode(",",$ids);
                
                $connection=Yii::app()->db;
                $command=$connection->createCommand("SELECT SUM(amount_paid)
                                                     FROM `invoice_payment` where `invoice_id` in ($ids)");
                return $command->queryScalar();
        }
        
        // http://www.yiiframework.com/forum/index.php/topic/41383-yii-cgridview-footer-with-sum-of-column-values/
        // http://www.yiiframework.com/forum/index.php?/topic/9636-cgridview-totals-or-summary-row/
        // http://www.yiiframework.com/extension/gridcolumns/
        public function getTotalOutstanding($ids)
        {
                $ids = implode(",",$ids);
                
                $connection=Yii::app()->db;
                $command=$connection->createCommand("SELECT sum(amount-(give_away+amount_paid)) outstanding_balance
                                                     FROM (
                                                          SELECT id,
                                                            IFNULL(amount,0) amount,
                                                            IFNULL((SELECT SUM(give_away) give_away FROM invoice_payment t2 WHERE t2.invoice_id=t1.id),0) give_away,
                                                            IFNULL((SELECT SUM(amount_paid) amount_paid FROM invoice_payment t2 WHERE t2.invoice_id=t1.id),0) amount_paid
                                                          FROM invoice t1
                                                          WHERE id in ($ids)
                                                    ) t");
                    
                return $command->queryScalar();
        }
        
        public function getOutstanding($invoice_id)
        {
            $sql="SELECT id,(amount-(give_away+amount_paid)) outstanding_balance
                  FROM (
                        SELECT id,
                           IFNULL(amount,0) amount,
                           IFNULL((SELECT SUM(give_away) give_away FROM invoice_payment t2 WHERE t2.invoice_id=t1.id),0) give_away,
                           IFNULL((SELECT SUM(amount_paid) amount_paid FROM invoice_payment t2 WHERE t2.invoice_id=t1.id),0) amount_paid
                    FROM invoice t1
                    WHERE id=:invoiceId
                  ) t";
            
            return Yii::app()->db->createCommand($sql)->queryAll(true, array(':invoiceId' => $invoice_id));
        }
}