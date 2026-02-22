<?php

namespace Ncw\Models;

class ThaiTime {

    // สำหรับแสดงเวลาภาษาไทย
    public function dateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
    }

    // สำหรับแสดงเวลาภาษาไทย
    public function dateThaiNoTime($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    // สำหรับแสดงเวลาภาษาไทย
    public function dateThaiFullMonth($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array('','&nbsp;มกราคม&nbsp;','&nbsp;กุมภาพันธ์&nbsp;','&nbsp;มีนาคม&nbsp;','&nbsp;เมษายน&nbsp;','&nbsp;พฤษภาคม&nbsp;','&nbsp;มิถุนายน&nbsp;','&nbsp;กรกฎาคม&nbsp;','&nbsp;สิงหาคม&nbsp;','&nbsp;กันยายน&nbsp;','&nbsp;ตุลาคม&nbsp;','&nbsp;พฤศจิกายน&nbsp;','&nbsp;ธันวาคม&nbsp;');
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    
}

// $strDate = "2008-08-14 13:42:44";
// echo "ThaiCreate.Com Time now : ".DateThai($strDate);

?>