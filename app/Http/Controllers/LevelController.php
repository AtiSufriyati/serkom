<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterLevel;
use App\Models\MasterGeneral;

class LevelController extends Controller
{

    protected $model;
    protected $request;
    // protected $table = 'Master_Client';
    public function __construct(){
    //     parent::__construct();
        // $this->middleware('auth.menu');
        $this->request = request();
        $this->model                    = new MasterLevel();
        $this->model_general            = new MasterGeneral();
    }

    public function index(){
        try{
            $tes = $this->request->all();
            $this->data['route_url'] = \Request::route()->getName();
            $this->data['level'] = $this->model->pagingData(5, (object) $this->request->all());
            if($this->request->ajax()){
                return response()->json(view('pages.level.table')->with($this->data)->render(), 200);
            }

            return view('pages.level.page')->with($this->data);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_level(){
        if($this->request->ajax())
        {
            $Level= $this->model->get_level($this->request->IndexLevel);
            $data['Level'] = $Level;

        }
        return response()->json($data);
    }

    public function submit(){
        try{
            if($this->request->action == 'add'){
                $fields = array(
                    'LevelID'           => $this->request->LevelID, 
                    'LevelName'         => $this->request->LevelName, 
                    
                );
                $insert  = $this->model_general->insert_data('Master_Level', $fields);
    
                if($insert != null){
                    $data = [
                            'respon' => 'success',
                            'flag' => 'success',
                            'message' => 'You are successfully saved',
                            'url' => route('level')
                        ];
                }else{
                    $data = [
                            'respon' => 'failed',
                            'flag' => 'failed',
                            'message' => 'Data save has failed',
                        ];
                }
            }elseif($this->request->action == 'edit'){
                $fields = array(
                    'LevelName'         => $this->request->LevelName, 
                );
                $arr_index = array(
                    array('IndexLevel','=',$this->request->IndexLevel),
                );
                $update  = $this->model_general->update_data('Master_Level', $fields,$arr_index);
    
                if($update != null){
                    $data = [
                            'respon' => 'success',
                            'flag' => 'success',
                            'message' => 'Data saved successfully',
                        ];
                }else{
                    $data = [
                            'respon' => 'failed',
                            'flag' => 'failed',
                            'message' => 'Data save has failed',
                        ];
                }
            }
            

            return response()->json($data, 200);
        }catch(Exception $e){
            throw $e;
        }
    }
}
