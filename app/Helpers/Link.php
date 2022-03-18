<?php

namespace App\Helpers;

use App\Helpers\ClassFinder;

class Link
{
    private $finder;
    public function __construct(){
        $this->finder = new ClassFinder();
        $this->temp = [];
        // dd([
        //     'arjuna' => $this->arjuna(),
        //     'prv' => $this->prv(),
        //     'ptes' => $this->ptes(),
        //     'hrm' => $this->hrm(),
        // ]);
    }

    public function arjuna(){
        return $this->getClassByPath(base_path().((env('APP_ENV') !== 'development') ? '/app/Models/Arjuna' : '\app\Models\Arjuna'), 'App\Models\Arjuna');
    }

    public function prv(){
        return $this->getClassByPath(base_path().((env('APP_ENV') !== 'development') ? '/app/Models/PRV' : '\app\Models\PRV'), 'App\Models\PRV');
    }

    public function ptes(){
        return $this->getClassByPath(base_path().((env('APP_ENV') !== 'development') ? '/app/Models/PTES' : '\app\Models\PTES'), 'App\Models\PTES');
    }

    public function hrm(){
        return $this->getClassByPath(base_path().((env('APP_ENV') !== 'development') ? '/app/Models/HRM' : '\app\Models\HRM'), 'App\Models\HRM');
    }

    // public function hrd_admin(){
    //     return $this->getClassByPath(base_path().((env('APP_ENV') !== 'development') ? '/app/Models/HRDADMIN' : '\app\Models\HRDADMIN'), 'App\Models\HRDADMIN');
    // }

    public function treasury(){
        return $this->getClassByPath(base_path().((env('APP_ENV') !== 'development') ? '/app/Models/Treasury' : '\app\Models\Treasury'), 'App\Models\Treasury');
    }

    public function dbvisa(){
        return $this->getClassByPath(base_path().((env('APP_ENV') !== 'development') ? '/app/Models/Dbvisa' : '\app\Models\Dbvisa'), 'App\Models\Dbvisa');
    }

    private function getClassByPath($path, $namespace){
        $arrClass = $this->finder->findClasses($path);
        $data = [];
        foreach ($arrClass as $key => $item) { //App\Models\Class
            $potong = str_replace($namespace.'\\', '', $item); //Doa\class / Doa\a\b\class
            foreach (explode('\\', $potong) as $key => $value) { // [Doa,class] / [Doa,a,b,class]
                if(!in_array($item, $this->temp)){
                    //check folder bukan?
                    if($key !== (count(explode('\\', $potong)) - 1)){
                        //folder
                        $data[$value] = (object) $this->getClassByPath($path."/".$value, $namespace."\\".$value); //load lg folder baru
                        array_push($this->temp,$item);
                    }else{
                        //class
                        $data[$value] = new $item();
                        array_push($this->temp,$item);
                    }
                }
            }
        }
        $this->temp = [];
        return (object) $data;
    }
}













































































































?>