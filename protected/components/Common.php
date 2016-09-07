<?php
/* 
 * All common functions will be listed here
 * 
 */
Class Common 
{
    public static function Discount($discount) {
        if (substr($discount, 0, 1) == '$') {
            $discount_amount = substr($discount, 1);
            $discount_type = '$';
        } else {
            $discount_amount = $discount;
            $discount_type = '%';
        }
        
        return array($discount_amount, $discount_type);
    }
    
    public static function GroupAlias($group_id) {
        switch ($group_id) {
            case 1:
                $group_name='A';
                break;
            case 2:
                $group_name='B';
                break;
            case 3:
                $group_name='C';
                break;
            case 4:
                $group_name='D';
                break;
            case 5:
                $group_name='E';
                break; 
        }
        
        return $group_name;
    }

    public static function timeAgo($date,$granularity=2) {
        $retval = '';
        $date = strtotime($date);
        $difference = time() - $date;
        $periods = array('decade' => 315360000,
            'year' => 31536000,
            'month' => 2628000,
            'week' => 604800,
            'day' => 86400,
            'hour' => 3600,
            'min' => 60,
            'sec' => 1);
        if ($difference < 5) { // less than 5 seconds ago, let's say "just now"
            $retval = "Just now";
            return $retval;
        } else {
            foreach ($periods as $key => $value) {
                if ($difference >= $value) {
                    $time = floor($difference/$value);
                    $difference %= $value;
                    $retval .= ($retval ? ' ' : '').$time.' ';
                    $retval .= (($time > 1) ? $key.'s' : $key);
                    $granularity--;
                }
                if ($granularity == '0') { break; }
            }
            return $retval.' ago';
        }
    }

    public static function arrayFactory($type, $code = null)
    {

        $_items = array(
            'day' => array(
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '13' => '13',
                '14' => '14',
                '15' => '15',
                '16' => '16',
                '17' => '17',
                '18' => '18',
                '19' => '19',
                '20' => '20',
                '21' => '21',
                '22' => '22',
                '23' => '23',
                '24' => '24',
                '25' => '25',
                '26' => '26',
                '27' => '27',
                '28' => '28',
                '29' => '29',
                '30' => '30',
                '31' => '31',
            ),
            'month' => array(
                '01' => Yii::t('app','January'),
                '02' => Yii::t('app','February'),
                '03' => Yii::t('app','March'),
                '04' => Yii::t('app','April'),
                '05' => Yii::t('app','May'),
                '06' => Yii::t('app','June'),
                '07' => Yii::t('app','July'),
                '08' => Yii::t('app','August'),
                '09' => Yii::t('app','September'),
                '10' => Yii::t('app','October'),
                '11' => Yii::t('app','November'),
                '12' => Yii::t('app','December'),
            ),
            'year' => array_combine(range(date("Y"), 1910), range(date("Y"), 1910)),  //http://stackoverflow.com/questions/2807394/php-years-array
            'page_size' => array(
                10 => 10,
                20 => 20,
                50 => 50,
                100 => 100,
                200 => 200,
                500 => 500,
                1000 => 1000,
            )
        );

        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else {
            return isset($_items[$type]) ? $_items[$type] : false;
        }
    }

    public static function defaultPageSize()
    {
        return Yii::app()->user->getState('pageSize', Yii::app()->settings->get('item', 'itemNumberPerPage'));
    }

    // Convention over configuration principle
    public static function getDecimalPlace()
    {
        return Yii::app()->settings->get('system', 'decimalPlace') == '' ? 2 : Yii::app()->settings->get('system', 'decimalPlace');
    }

    public static function getCurLocationID()
    {
        return Yii::app()->getsetSession->getLocationId();
    }
    
}


