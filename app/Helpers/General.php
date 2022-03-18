<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon; // format date
use Illuminate\Support\Facades\Crypt;
use App\Models\Kenji\Employee\EmployeeContact;
use Session;


class General
{
    public function __construct()
    {
        Carbon\Carbon::setLocale('id');
    }

    public static function connection($db){
        switch (env('APP_ENV')) {
            case 'local':
                $connection = \strtolower($db).'_development';
                break;
            case 'staging':
                $connection =  \strtolower($db).'_staging';
                break;
            case 'production':
                $connection =  \strtolower($db).'_production';
                break;
            case 'backup':
                $connection =  \strtolower($db).'_backup';
                break;
            default:
                $connection =  \strtolower($db).'_development';
                break;
        }
        return $connection ;
    }

    public static function SqlWithBindings($queryBuilder)
    {
        $sql = str_replace('?', '%s', $queryBuilder->toSql());

        $handledBindings = array_map(function ($binding) {
            if (is_numeric($binding)) {
                return $binding;
            }

            if (is_bool($binding)) {
                return ($binding) ? 'true' : 'false';
            }

            return "'{$binding}'";
        }, $queryBuilder->getBindings());

        return vsprintf($sql, $handledBindings);
    }

    public static function DateNow()
    {
        return Carbon\Carbon::now()->format('Y-m-d H:i:s');
    }

    public static function FormatDate($date,$format="d-m-Y")
    {
        if($date){
            return Carbon\Carbon::parse($date)->format($format);
        }
        else{
            return NULL;
        }
    }

    public static function FormatDateTime($datetime,$format="Y-m-d H:i:s")
    {
        if($datetime){
            return Carbon\Carbon::parse($datetime)->format($format);
        }
        else{
            return NULL;
        }
    }

    public static function FormatTime($time, $format="H:i:s")
    {
        if($time){
            //return Carbon\Carbon::parse($time)->format($format);
            return date($format,strtotime($time));
        }
        else{
            return NULL;
        }
    }

    public static function CompareDate($dateFirst,$dateSecond,$format=3)
    {
        $hasil = '';

        if(empty($dateSecond)){
            $dateSecond = Carbon\Carbon::now();
        }
        else{
            $dateSecond = Carbon\Carbon::createFromFormat('Y-m-d', $dateSecond) ;
        }

        $date_one = Carbon\Carbon::createFromFormat('Y-m-d', $dateFirst);

        if($format==1){
            $hasil = $date_one->diff($dateSecond)->format('%y years');
        }
        else if($format==2){
            $hasil = $date_one->diff($dateSecond)->format('%y years, %m months');
        }
        else if($format==3){
            $hasil = $date_one->diff($dateSecond)->format('%y years, %m months , %d days');
        }

        return $hasil;
    }

    //230518 - fakhri untuk replace file lama dengan yg baru
    //060618 - Updated to fileName for empty validating
    public static function UnlinkImage($filepath,$fileName)
    {
        $OldFile = $filepath.$fileName;
        if (file_exists($OldFile)) {
           unlink($OldFile);
        }
    }

    // 05062018 - Febri - list marital status
    public static function ListMarital()
    {
        $data = [];

        $data = array(
                    'TK' => 'TK',
                    'K0' => 'K0',
                    'K1' => 'K1',
                    'K2' => 'K2',
                    'K3' => 'K3',
                    'K4' => 'K4',
                    'K5' => 'K5'
                );

        return $data;
    }

    public static function ListLevelSchool()
    {
        $data = [];

        $data = array(
                    'SD' => 'SD / Primary School',
                    'SMP' => 'SMP / Junior High School',
                    'SMA' => 'SMA / Senior High School',
                    'Diploma' => 'Diploma / College',
                    'S1' =>"S1 / Bachelor's Degree",
                    'S2' =>"S2 / Master's Degree",
                    'S3' =>"S3 / Doctorate's Degree" //babeh request
                );

        return $data;
    }

    public static function ListCriteriaScore()
    {
        $data = [];

        $data = array(
                    'EXCELLENT' => 'EXCELLENT',
                    'GOOD' => 'GOOD',
                    'POOR' => 'POOR',
                    'AVERAGE' => 'AVERAGE'
                );

        return $data;
    }

    //210618 - Fakhri add format IDR Currency
    public static function FormatIDR($amount)
    {
        $rupiah=number_format($amount,2,'.',',');
        // $rupiah=number_format(str_replace('.00','',$amount),0,'.',',');
        return $rupiah;
    }

    public static function viewFormatIDR($amount)
    {
        // $rupiah=number_format($amount,2,'.',',');
        $rupiah=number_format(str_replace('.00','',$amount),0,'.',',');
        return $rupiah;
    }

    public static function FormatAmount($amount)
    {
        $rupiah=number_format($amount,2,',','.');
        return $rupiah;
    }

    public static function FormatCurrency($amount)
    {
        $rupiah=number_format($amount,2,'.',',');
        return $rupiah;
    }

    public static function FormatCurrencyToValue($amount)
    {
        try{
            $value = $amount;
            if(substr_count($amount, '.') == 1 && substr_count($amount, ',')> 0){
                $value = floatval(str_replace(',','', $amount));
            }
            else if(substr_count($amount, '.') > 0 && substr_count($amount, ',') == 1){
                $value = floatval(str_replace(',','.',str_replace('.','', $amount)));
            }
            return floatval($value);
        }
        catch(\Exception  $e){
            throw $e;
        }
    }

    public static function HashGen($value, $mode){
        $hash = null;
        if(!empty(isset($mode))){
            if($mode == "encode"){
                $hash = Crypt::encryptString($value); 
            }else{
                $hash = Crypt::decryptString($value); 
            }
        }
        return $hash;
    }

    public static function HashId($value, $mode){
        $hash = null;
        if(!empty(isset($mode))){
            if($mode == "encode"){
                $hash = \Hashids::encode($value); 
            }else{
                $hash = \Hashids::decode($value); 
            }
        }
        return $hash;
    }

    public static function PenyebutNumber($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = \General::PenyebutNumber($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = \General::PenyebutNumber($nilai/10)." puluh". \General::PenyebutNumber($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . \General::PenyebutNumber($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = \General::PenyebutNumber($nilai/100) . " ratus" . \General::PenyebutNumber($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . \General::PenyebutNumber($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = \General::PenyebutNumber($nilai/1000) . " ribu" . \General::PenyebutNumber($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = \General::PenyebutNumber($nilai/1000000) . " juta" . \General::PenyebutNumber($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = \General::PenyebutNumber($nilai/1000000000) . " milyar" . \General::PenyebutNumber(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = \General::PenyebutNumber($nilai/1000000000000) . " trilyun" . \General::PenyebutNumber(fmod($nilai,1000000000000));
		}
		return $temp;
    }

    public static function TerbilangNumber($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(\General::PenyebutNumber($nilai));
		} else {
			$hasil = trim(\General::PenyebutNumber($nilai));
		}
		return $hasil;
    }

    public static function getTextHighlight($keyword, $string, $limit = null)
    {
        if(!empty($limit)){
            $cleanString = strip_tags(html_entity_decode($string));
            $param = explode(' ', $cleanString);
            $panjang = 25;
            $match_key = array_search(strtolower($keyword), array_map('strtolower', $param));

            if(!empty($match_key)){
                foreach($param as $key=>$value){
                    if($key > $match_key-$panjang AND $key < $match_key+$panjang){
                        $stringCut [] = $value;
                    }
                }
                $cleanString = implode(' ',$stringCut);
            }
            $highlight = preg_replace("/($keyword)/i", "<b><i>$1</i></b>", \Illuminate\Support\Str::limit($cleanString, $limit));
        }else{
            $highlight = preg_replace("/($keyword)/i", "<b><i>$1</i></b>", $string);
        }
        return $highlight;
    }

    public static function limitText($string, $word_limit=35)
    {
        $string = strip_tags($string);
        if (strlen($string) > $word_limit) {

            $stringCut = substr($string, 0, $word_limit);
            $endPoint = strrpos($stringCut, ' ');

            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= ' ...';
        }
        return $string;
    }

    public static function formatSizeUnits($bytes) {
		if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function base64Image($path,$imageName){
        $TypeImage = pathinfo($path.$imageName, PATHINFO_EXTENSION);
        $isImage = file_get_contents($path.$imageName);
        return 'data:image/' . $TypeImage . ';base64,' . base64_encode($isImage);        
    }

    public static function CountChatUnread(){
         $chatUnread = DB::table('dev_chatify.Messages as Messages')->where([['ToEmployeeID', Session::get('USER_ID')], ['Seen', '0']])->count();

         return $chatUnread;
    }

    public static function ChatNavbar(){

          // get all users that received/sent message from/to [Auth user]
         $users = DB::table('dev_chatify.Messages as Messages')->join('dev_kenji.Master_Employee as Master_Employee',  function ($join) {
             $join->on('Messages.CreatedByID', '=', 'Master_Employee.EmployeeID')
                 ->orOn('Messages.ToEmployeeID', '=', 'Master_Employee.EmployeeID');
         })
             ->where('Messages.CreatedByID', Session::get('USER_ID'))
             ->orWhere('Messages.ToEmployeeID', Session::get('USER_ID'))
             ->orderBy('Messages.CreatedDate', 'desc')
             ->get()
             ->unique('EmployeeID');

             $html = null;
          if ($users->count() > 0) {
               //fetch contacts
              foreach ($users as $user) {
                  if ($user->EmployeeID != Session::get('USER_ID')) {
                      // Get user data
                      $userCollection = EmployeeContact::where('EmployeeID', $user->EmployeeID)->first();
                     //  $contacts .= (new ChatifyMessenger)->getContactItem($request['messenger_id'], $userCollection);

                     //user 
                     $userData = $userCollection;

                     //lastMessage
                     $lastMessageData = DB::table('dev_chatify.Messages')->where('CreatedByID',Session::get('USER_ID'))->where('ToEmployeeID',$userCollection->EmployeeID)
                                         ->orWhere('CreatedByID',$userCollection->EmployeeID)->where('ToEmployeeID',Session::get('USER_ID'))->orderBy('CreatedDate','DESC')->first();

                    //unseenCounter
                     $unseenCounterData = DB::table('dev_chatify.Messages as Messages')->where('CreatedByID',$userCollection->EmployeeID)->where('ToEmployeeID',Session::get('USER_ID'))->where('Seen',0)->count();

                     $contacts[] = array('user' => $userData, 'lastMessage' => $lastMessageData, 'unseenCounter' => $unseenCounterData);

                  }
              }
              $hasil = $contacts;

          }

         if(!empty($contacts)){

             foreach($contacts as $key => $value){

                 if($value['unseenCounter'] > 0){
                     $unseenhtml = '<span class="badge headerBadgeColor2" style="display : inline-block !important;">
                                 <b>'.$value['unseenCounter'].'</b>
                                 </span>';
                     $unseenbg = 'style="background-color: #fff2e3 !important;"';
                 }else{
                     $unseenhtml = '';
                     $unseenbg = '';
                 }
                
                 $EmployeeName = strlen($value['user']->EmployeeName) > 15 ? '['.$value['user']->DivisiID.'] '.trim(substr($value['user']->EmployeeName,0,15)).'...' : '['.$value['user']->DivisiID.'] '.$value['user']->EmployeeName;
                
                $message = self::limitText($value['lastMessage']->Body);
                
                $html .= '<li '.$unseenbg.'>
                            <a href="'.route(config('chatify.path')).'">
                                <span class="photo">
                                    <img src="'.asset('/images/'.$value['user']->Gender.'.png').'" class="img-circle" alt="">
                                </span>

                                <span class="subject">
                                    <span class="from"> '.$EmployeeName.' </span>
                                    <span class="time">'.\Carbon\Carbon::parse($value['lastMessage']->CreatedDate)->diffForHumans().' 
                                    '.$unseenhtml.'
                                    </span>
                                </span>
                                <span class="message"> '.$message.' </span>
                            </a>
                        </li>';
             }

         }else{

            $html .= '<li class="mt-5">
                        <span class="message" style="text-align: center;padding-right:50px"> -No messages here yet- </span>
                    </li>';
         }

         return $html;
        

     }

     public static function FormatNumber($nilai,$decimal=0,$point=".",$thousands=",", $type_data=""){

        $return = 0;
        if(is_numeric($nilai)){
            if($type_data=="ind"){
                $return = number_format($nilai, $decimal, ",", ".");
            }
            else{
                $return = number_format($nilai, $decimal, $point, $thousands);
            }
        }

        return $return;
    }
    
}
?>