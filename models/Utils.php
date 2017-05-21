<?php
namespace app\models;

use Yii;

class Utils {
    
    public function timeline($tablename,$colname){
        $connection  = Yii::$app->db;
        $sql     = "SELECT `" . $colname . "` as name ,DATE_FORMAT(`datetime`,'%Y-%m-%d') as date,COUNT(*) as count FROM `" . $tablename . "` GROUP BY DATE_FORMAT( `datetime`, '%Y-%m-%d' ),`".$colname."`";
        $command = $connection->createCommand($sql);
        $res     = $command->queryAll();
        $user  =array();
        $date   = array();
        foreach(array_unique(array_column($res,'date')) as $idate){
            array_push($date,$idate);
        }
        foreach(array_unique(array_column($res,'name')) as $name){
            $iuser['name']=$name;
            $iuser['data']=[];
            array_push($user,$iuser);
        }
        foreach($res as $item){
            $dpos = array_search($item['date'],$date);
            $upos = array_search($item['name'],array_column($user,'name'));
            $user[$upos]['data'][$dpos] = \intval($item['count']);
        }
        foreach($user as &$u){
            if(count($u['data']) < count($date)){
                for($i = 0; $i<count($date);$i++){
                    if(!isset($u['data'][$i])){
                        $u['data'][$i] = 0;
                    }
                }
            }
            ksort($u['data']);
        }
        return ['date' => $date,'user' => $user];
        }
    public function rate($tablename,$colname){
        $connection  = Yii::$app->db;
        $sql     = "SELECT `" . $colname . "` as name ,COUNT(*) as data FROM `" . $tablename . "` GROUP BY `".$colname."`";
        $command = $connection->createCommand($sql);
        $res     = $command->queryAll();
        $rates   = [];
        foreach($res as $item){
            $rates[] = [$item['name'], \intval($item['data'])];
        }
        return $rates;
        }        
}
?>
