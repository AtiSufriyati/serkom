<?php

namespace App\Helpers;

use Validator;
use Carbon\Carbon;

class GoogleDrive
{
    protected $CloudListContents;

    public function __construct(){
        $this->CloudListContents= $this->getListContents();
    }
    public function downloadFile(){
        try{
            $file = collect($this->CloudListContents)->where('path', $this->request->get('path'))->first();
            $rawData = \Storage::cloud()->get($this->request->get('path'));
            return response($rawData, 200)
                ->header('ContentType', $file['mimetype'])
                ->header('Content-Disposition', 'attachment; filename='.$file['name'].' ');
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getStructuredListContents($path = null){
        try{
            $data = [];
            if(!empty(isset($path))){
                $arr = collect($this->CloudListContents)
                ->where('dirname','==',$path)
                ->all();
                foreach ($arr as $item) {
                    if(collect($this->CloudListContents)->where('dirname','==',$item['path'])->count() > 0){
                        //have a child
                        $data[$item['path']] = $item;
                        $data[$item['path']]['child'] = $this->getStructuredListContents($item['path']);
                    }else{
                        $data[$item['path']] = $item;
                    }
                }
            }else{
                //first
                $arr = collect($this->CloudListContents)
                ->where('dirname','==','')
                ->all();
                foreach ($arr as $item) {
                    if(collect($this->CloudListContents)->where('dirname','==',$item['path'])->count() > 0){
                        //have a child
                        $data[$item['path']] = $item;
                        $data[$item['path']]['child'] = $this->getStructuredListContents($item['path']);
                    }else{
                        $data[$item['path']] = $item;
                    }
                }
            }
            return $data;
        }catch(Exceptin $e){
            throw $e;
        }
    }
    public function getTreeViewContents($path = null){
        try{
            $data = [];
            if(!empty(isset($path))){
                $arr = collect($this->CloudListContents)
                ->where('dirname','==',$path)
                ->all();
                foreach ($arr as $item) {
                    if(collect($this->CloudListContents)->where('dirname','==',$item['path'])->count() > 0){
                        //have a child
                        $data[] = [
                            'title' => $item['name'],
                            'key' => $item['path'],
                            'url' => ($item['type'] == 'file') ? \Storage::cloud()->url($item['path']) : '',
                            'isFolder' => ($item['type'] == 'dir') ? true : false,
                            'type' => $item['type'],
                            'unselectable' => ($item['type'] == 'dir') ? true : false,
                            'children' => $this->getTreeViewContents($item['path'])
                        ];
                    }else{
                        $data[] = [
                            'title' => $item['name'],
                            'key' => $item['path'],
                            'url' => ($item['type'] == 'file') ? \Storage::cloud()->url($item['path']) : '',
                            'type' => $item['type'],
                            'isFolder' => ($item['type'] == 'dir') ? true : false,
                            'unselectable' => ($item['type'] == 'dir') ? true : false,
                        ];
                    }
                }
            }else{
                //first
                $arr = collect($this->CloudListContents)
                ->where('dirname','==','')
                ->all();
                foreach ($arr as $item) {
                    if(collect($this->CloudListContents)->where('dirname','==',$item['path'])->count() > 0){
                        //have a child
                        $data[] = [
                            'title' => $item['name'],
                            'key' => $item['path'],
                            'type' => $item['type'],
                            'url' => ($item['type'] == 'file') ? \Storage::cloud()->url($item['path']) : '',
                            'isFolder' => ($item['type'] == 'dir') ? true : false,
                            'unselectable' => ($item['type'] == 'dir') ? true : false,
                            'children' => $this->getTreeViewContents($item['path']),
                        ];
                    }else{
                        $data[] = [
                            'title' => $item['name'],
                            'key' => $item['path'],
                            'type' => $item['type'],
                            'url' => ($item['type'] == 'file') ? \Storage::cloud()->url($item['path']) : '',
                            'isFolder' => ($item['type'] == 'dir') ? true : false,
                            'unselectable' => ($item['type'] == 'dir') ? true : false,
                        ];
                    }
                }
            }
            return $data;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getAjaxContents($path = null){
        try{
            if($this->request->ajax()){
                return response()->json($this->getTreeViewContents(), 200);
            }
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getListContents(){
        try{
            $contents = \Storage::cloud()->listContents('/', true);
            return $contents;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getListFiles(){
        try{
            $contents = collect(\Storage::cloud()->listContents('/', true))
            ->where('type','file')
            ->all();

            dd($contents);
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getFiles(string $file){
        $contents = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','file')
        ->where('name', $file)
        ->first();

        // dd($contents);
    }
    public function getListDirectories(){
        $contents = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','dir')
        ->all();

        dd($contents);
    }
    public function getDirectories(string $directories){
        $contents = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','dir')
        ->where('name', $directories)
        ->first();

        dd($contents);
    }
    public function hasDirectories(string $directories){
        $contents = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','dir')
        ->where('name', $directories)
        ->count();

        dd($contents > 0 ? true : false);
    }
    public function hasFiles(string $file){
        $contents = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','file')
        ->where('name', $file)
        ->count();

        dd($contents > 0 ? true : false);
    }
    public function storeFiles($directories, $file){
        $directories = (strpos($directories, '/') !== false) ? (explode('/', $directories))[count(explode('/', $directories)) - 1] : $directories;
        $directories = (!empty(isset($directories)) && $directories !== '/') ? collect(\Storage::cloud()->listContents('/', true))
        ->where('type','dir')
        ->where('name',$directories)
        ->first() : '';

        $contents = \Storage::cloud()->put((!empty(isset($directories))) ? $directories.'/'.$file->getClientOriginalName() : $file->getClientOriginalName(), $file);

        dd($contents);
    }
    public function copyFiles(string $source, string $to){ //method may be used to copy an existing file to a new location on the disk:
        $file = (explode('/', $source))[count(explode('/', $source)) - 1];
        $source = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','file')
        ->where('name',$file)
        ->first();
        $location = (strpos($to, '/') !== false) ? (explode('/', $to))[count(explode('/', $to)) - 2] : null;
        $file = (explode('/', $to))[count(explode('/', $to)) - 1];
        $location = (!empty(isset($location))) ? $this->getDirectories($location) : null;
        $contents = \Storage::cloud()->copy($source['path'],(!empty(isset($location['path']))) ? $location['path'].'/'.$file : $file);

        dd($contents);
    }
    public function moveFiles(string $source, string $to){ //method may be used to rename or move an existing file to a new location:
        $file = (explode('/', $source))[count(explode('/', $source)) - 1];
        $source = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','file')
        ->where('name',$file)
        ->first();
        $location = (explode('/', $to))[count(explode('/', $to)) - 2];
        $file = (explode('/', $to))[count(explode('/', $to)) - 1];
        $location = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','dir')
        ->where('name',$location)
        ->first();
        $contents = \Storage::cloud()->move($source['path'],$location['path'].'/'.$file);

        dd($contents);
    }
    public function deleteFiles(array $files){ //method accepts a single filename or an array of files to remove from the disk
        foreach ($files as $item) {
            $file[] = (collect(\Storage::cloud()->listContents('/', true))
            ->where('type','file')
            ->where('name',$file)
            ->first())['path'];
        }
        $contents = \Storage::cloud()->delete($file);

        dd($contents);
    }
    public function getFilesFromDirectories(string $directories){ //method returns an array of all of the files in a given directory.
        $directories = $this->getDirectories($directories);
        $contents = collect(\Storage::cloud()->files($directories['path']))->all();

        dd($contents);
    }
    public function getAllFilesFromDirectories(string $directories){ //retrieve a list of all files within a given directory including all sub-directories
        $directories = $this->getDirectories($directories);
        $contents = collect(\Storage::cloud()->allFiles($directories['path']))->all();

        dd($contents);
    }
    public function getDirectoriesFromDirectories(string $directories){ //method returns an array of all the directories within a given directory. Additionally
        $directories = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','dir')
        ->where('name',$directories)
        ->first();
        $contents = collect(\Storage::cloud()->directories($directories['path']))->all();

        dd($contents);
    }
    public function getAllDirectoriesFromDirectories(string $directories){ //method to get a list of all directories within a given directory and all of its sub-directories:
        $directories = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','dir')
        ->where('name',$directories)
        ->first();
        $contents = collect(\Storage::cloud()->allDirectories($directories['path']))->all();

        dd($contents);
    }
    public function createDirectories(string $location, string $directories){ //The makeDirectory method will create the given directory, including any needed sub-directories:
        $parent = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','dir')
        ->where('name',$location)
        ->first();
        $contents = \Storage::cloud()->makeDirectory($parent['path'].'/'.$directories);

        dd($contents);
    }
    public function deleteDirectories(string $directories){ //The makeDirectory method will create the given directory, including any needed sub-directories:
        $parent = collect(\Storage::cloud()->listContents('/', true))
        ->where('type','dir')
        ->where('name',$directories)
        ->first();
        $contents = \Storage::cloud()->deleteDirectory($parent['path']);

        dd($contents);
    }
    public function getUrlFiles(string $files){
        // try{
            $contents = collect(\Storage::cloud()->listContents('/', true))
                ->where('type','file')
                ->where('name', $files)
                ->first();
            $contents = \Storage::cloud()->url($contents['path']);
            return $contents;
        // }catch(Exception $e){
        //     throw $e;
        // }
    }

    public static function download($path)
    {
        try{
            $file = collect(\Storage::cloud()->listContents('/', true))
                            ->where('path', $path)
                            ->first();
            $rawData = \Storage::cloud()->get($path);
            return response($rawData, 200)
                ->header('ContentType', $file['mimetype'])
                ->header('Content-Disposition', 'attachment; filename='.$file['name'].' ');
        }catch(Exception $e){
            throw $e;
        }
    }

    public static function getFileGoogleDriveByName($nameFile)
    {
        $hasil = collect(\Storage::cloud()->listContents('/', true))
                        ->where('type','file')
                        ->where('name', $nameFile)
                        ->first();

        return $hasil;
    }

    public static function getFolderGoogleDriveByDirName($dirName)
    {
        $hasil = collect(\Storage::cloud()->listContents('/', true))
                ->where('type','dir')
                ->where('name','==',$dirName)
                ->first();

        return $hasil;
    }

    public static function getFolderGoogleDriveByNameDirName($dirName,$nameFile)
    {
        $hasil = collect(\Storage::cloud()->listContents('/', true))
                ->where('type','dir')
                ->where('name', $nameFile)
                ->where('dirname','==',$dirName)
                ->first();

        return $hasil;
    }

    public static function createFolderGoogleDrive($dirName,$folder)
    {
        $data = array();

        if(\Storage::cloud()->makeDirectory($dirName.'/'.$folder)){
            $data = GoogleDrive::getFolderGoogleDriveByNameDirName($dirName,$folder);
        }

        return $data;
    }

    public static function delFileGoogleDriveByName($nameFile)
    {
        $hasil = false;

        $data = GoogleDrive::getFileGoogleDriveByName($nameFile);
        if($data){
            $hasil = \Storage::cloud()->delete($data['path']);
        }

        return $hasil;
    }

    //untuk get file dengan folder id spesific selain root folder kenji
    public static function getFileGoogleDriveByNameWithFolderId($nameFile, $folderId)
    {
        $hasil = collect(\Storage::cloud()->listContents($folderId, true))
                        ->where('type','file')
                        ->where('name', $nameFile)
                        ->first();
        return $hasil;
    }
}
