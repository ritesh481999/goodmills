<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class CkeditorController extends Controller
{
    public function uploadImages(Request $request)
    {
        if ($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            // $filenametostore = $filename . '_' . time() . '.' . $extension;

            //Upload File

            //return (787);


            $image = $request->file('upload');

            // return $image;


            $imageName = $filename . '_' . time() . '.' . $extension;
            $destinationPath = public_path('uploads/ckeditor/images/');
            ($image->move($destinationPath, $imageName));
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = URL::to('/') . "/uploads/ckeditor/images/" . $imageName;
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output 
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }
}
