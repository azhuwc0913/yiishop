<?php
    /**
     * Created by PhpStorm.
     * User: Dell
     * Date: 2016/7/29
     * Time: 14:57
     */
    header("content-type:text/html;charset=utf-8");
    function dd($data){
        echo '<pre>';
        var_dump($data);
        die;
    }

    //上传单张图片并且生成对应的略缩图
    function uploadFile($model,$thumb=array(), $file=''){
        //$file = \yii\web\UploadedFile::getInstance($model, 'logo');
        // dd($file);
        $rootPath = Yii::getAlias("@app");

        $path = Yii::$app->params['path'];

        $image = [];

        $ext = $file->getExtension();

        $randName = time() . rand(1000, 9999) . "." . $ext;

        $dir = date('Ymd');
        //dd($path.$dir);
        if(!is_dir($rootPath.'/web/'.$path.$dir)){
            mkdir($rootPath.'/web/'.$path.$dir, true, 0777);
        }
        if($file){
            $file->saveAs($rootPath.'/web/'.$path.$dir.'/'.$randName);
            $image[0] = $path.$dir.'/'.$randName;
            if($thumb){
                foreach($thumb as $k=>$v) {

                    \yii\imagine\Image::thumbnail($rootPath . '/web/' . $path . $dir . '/' . $randName, $v[0], $v[1])
                        ->save($rootPath.'/web/'.$path.$dir.'/'.'thumb_'.$k.$randName);
                    $image[$k+1] = $path.$dir.'/'.'thumb_'.$k.$randName;
                }
            }
        }
        return $image;
    }

    function showImage($src, $width='', $height=''){
        $rootPath = Yii::getAlias("@app");
        if($width){
            echo "<img src=/$src width='$width'>";
        } elseif($height){
            echo "<img src=/$src height='$height'>";
        }elseif($width && $height){
            echo "<img src=/$src  width='$width' height='$height'>";
        }else{
            echo "<img src=/$src>";
        }
    }

    //删掉商品图片
    function deleteImage($images=array()){

        $rootPath = Yii::getAlias("@app");

        foreach($images as $k=>$v){
            //chmod($rootPath.'/web/'.$v, 0777);
            unlink($rootPath.'/web/'.$v);
        }
    }
