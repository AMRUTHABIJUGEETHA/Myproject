<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Input;
use File;
use Session;
use App\Models\FileModel;

class ListController extends Controller
{
    public function fetch(Request $request)
    {
        $rec = FileModel::all();
        return View::make('list')->with('rec', $rec);
    }

    public function save(Request $request)
    {
        try { 
            $data = array();
            $message = '';
            $id = '';
            $date = date('Y-m-d_H-i-s');
            $fileName = $request->file('file')->getClientOriginalName(); 
            $extension = $request->file('file')->getClientOriginalExtension(); 
            if ($extension  == "pdf" || $mime == "jpeg" || $mime == "png" || $mime == "txt" || $mime == "gif") { 
                $destinationPath = config('app.temp_document_path'); // upload file to temp folder path
                if (!file_exists($destinationPath)) {
                    //create directory import
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }

                $randomFileName = $fileName. uniqid();
                $uploadSuccess = $request->file('file')->move($destinationPath, $randomFileName);
                if($uploadSuccess){
                    $path = $destinationPath.$randomFileName; 
                    $insert = array('file_name' => $fileName, 'path' => $path, 'created_at' => $date, 'updated_at' => $date);
                    $id = FileModel::insertGetId($insert);  
                    Session::put('highlight', $id);
                    $message = 'File uploaded successfully';
                }else{
                    $message = 'Unable to upload the file. Please try again'; 
                } 
            }  
            $data['id'] = $id;
            $data['message'] = $message; 
        } catch (\Exception $e) { 
            if($e->getMessage()){ 
                $message = 'This file extention is not allowed'; 
                $data['id'] = '';
                $data['message'] = $message; 
            }
        } 
           
        return $data;
            
    }

    public function delete($id){
        $delete = FileModel::where('id', $id)->delete();
        return redirect('/')->with('message', 'successfully deleted');
    }
}
