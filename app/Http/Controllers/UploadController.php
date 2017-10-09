<?php
/**
 * Created by PhpStorm.
 * User: shaoyun
 * Date: 2017/3/25
 * Time: 下午12:43
 */

namespace App\Http\Controllers;

use App\Http\Utils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UploadController extends Controller
{
    public function uploadImage(){

        $FileData    = $_FILES['file'];

        if(isset($_REQUEST['type'])){
            if($_REQUEST['type'] == 'productCategory'){
                $upload_path = "/upload/image/category/";
            }elseif ($_REQUEST['type'] == 'product'){
                $upload_path = "/upload/image/product/";
            }else{
                $upload_path = "/upload/image/";
            }
        }else{
            $upload_path = "/upload/image/";
        }

        $return_path = '';
        $target_path = Utils::CreateDir( PROJECT_ROOT."/public".$upload_path,"{y}{m}/{d}",$return_path );

        $filename   = $FileData['name'];
        $extension  = pathinfo($filename,PATHINFO_EXTENSION);

        $file_array = array();
        //$file_array['pic_name'] = $filename;
        //$file_array['filename'] = str_replace(".".$extension, '', $filename);
        $file_array['type']     = $FileData['type'];
        $file_array['size']     = $FileData['size'];
        $file_array['ext']      = $extension;

        srand((double)microtime()*1000000);
        $rnd       = rand(100,999);
        $name      = date("YmdHis",time()).$rnd.'.'.$extension;
        $save_name = $upload_path.$return_path.$name;
        $file_array['path']  = $save_name;
        $file_array['name'] = str_replace(".".$extension, '', $name);
        $file_array['filename'] = $filename;

        move_uploaded_file($FileData['tmp_name'],$target_path.$name );


        return response()->json($file_array, Response::HTTP_OK);
    }

    public function uploadFile(){

        $FileData    = $_FILES['file'];

        $upload_path = "/upload/video/";
        $return_path = '';
        $target_path = Utils::CreateDir( PROJECT_ROOT."/public".$upload_path,"{y}{m}/{d}",$return_path );

        $filename   = $FileData['name'];
        $extension  = pathinfo($filename,PATHINFO_EXTENSION);

        $file_array = array();
        //$file_array['pic_name'] = $filename;
        //$file_array['filename'] = str_replace(".".$extension, '', $filename);
        $file_array['type']     = $FileData['type'];
        $file_array['size']     = $FileData['size'];
        $file_array['ext']      = $extension;

        srand((double)microtime()*1000000);
        $rnd       = rand(100,999);
        $name      = date("YmdHis",time()).$rnd.'.'.$extension;
        $save_name = $upload_path.$return_path.$name;
        $file_array['path']  = $save_name;
        $file_array['name'] = str_replace(".".$extension, '', $name);
        $file_array['filename'] = $filename;

        move_uploaded_file($FileData['tmp_name'],$target_path.$name );

        return response()->json($file_array, Response::HTTP_OK);
    }

    /**
     * CKediter的图片上传
     */
    public function uploadCKImage(Request $request){

        $arrData    = $request->all();
        $callback   = $arrData['CKEditorFuncNum'];

        $FileData   = $_FILES['upload'];

        $filename   = $FileData['name'];
        $extension  = pathInfo($filename,PATHINFO_EXTENSION);

        $file_array = array();
        $file_array['name']     = $FileData['name'];
        $file_array['filename'] = str_replace(".".$extension, '', $filename);
        $file_array['type']     = $FileData['type'];
        $file_array['size']     = $FileData['size'];
        $file_array['ext']      = $extension;

        $allow_image = array("jpg","bmp","gif","png");

        if(!in_array($extension,$allow_image)){
            echo "<font color=\"red\"size=\"2\">*文件格式不正确（必须为.jpg/.gif/.bmp/.png文件）</font>";
            return;
        }else{
            $upload_path = "/upload/image/";
            $return_path = '';
            $target_path = Utils::CreateDir( PROJECT_ROOT."/public".$upload_path,"{y}{m}/{d}",$return_path );
            srand((double)microtime()*1000000);
            $rnd       = rand(100,999);
            $name      = date("YmdHis",time()).$rnd.$extension;
            $save_name = $upload_path.$return_path.$name;
            $file_array['savename'] = $save_name;
            $bret      = move_uploaded_file($_FILES['upload']['tmp_name'],$target_path.$name );
            if(!$bret){
                echo "<font color=\"red\"size=\"2\">图片上传失败。。。</font>";
                return;
            }else{
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback,'".$save_name."','');</script>";
                return;
            }
        }
    }

}