<?php
/**
 * Created by PhpStorm.
 * User: klajdi
 * Date: 18-04-11
 * Time: 12.05.MD
 */

namespace App\Helpers;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Imagick;

class ThumbnailGenerator
{


    public function thumbnailGenerator(UploadedFile $file, $fileUrl){

        $extension = $file->getClientOriginalExtension();
        $pdfExtensions = ["pdf","PDF"];
        $docExtensions = ["doc","docx", "DOC", "DOCX"];
        $imgExtensions = ["png","jpeg", "jpg", "tiff", "PNG", "JPEG", "JPG", "TIFF"];

        switch ($extension){
            case (in_array($extension,$pdfExtensions )):
                return $this->pdfImageGeneratorWrapper($fileUrl);

            case (in_array($extension, $docExtensions)):
                return $this->docImageGeneratorWrapper($fileUrl, $file);

            case (in_array($extension, $imgExtensions)):
                return $this->imgImageGeneratorWrapper($fileUrl);

        }

    }


    /**
     * @param $fileUrl
     * @return bool|\Exception
     */
    private function pdfImageGeneratorWrapper($fileUrl){
        try{
            $doc = new Imagick($fileUrl); //Get image from url

            foreach ($doc as $page){
                $fileName = "thumb_".str_random(5).".png"; //Create name for thumbnail
                $page->scaleImage(400,400, true); //Fit image to 400px
                $page->writeImage("storage/".$fileName); //Save image to storage
                break; //Get only first page
            }

            $path = "thumbnails/".$fileName;
            $move = Storage::disk("public")->move($fileName, $path); //Move thumbnail to thumbnail dir

            if($move){
                return Storage::url($path); //Get url of thumbnail
            }

        }catch (\Exception $exception){
            return $exception;
        }

        return false;
    }


    /**
     * @param $fileUrl
     * @param UploadedFile $file
     * @return bool|\Exception
     */
    private function docImageGeneratorWrapper($fileUrl, UploadedFile $file){

        $fileDir = explode(".", $file->getClientOriginalName())[0]."-".date("YmdHis"); //Set dir name for new file doc that will be converted
        $tempOutputDir = "storage/temp/".$fileDir."/"; //Create dir for output file converted
        $command = "lowriter --headless --convert-to png ".$fileUrl." --outdir ". $tempOutputDir; // Write command that will convert file doc to png

        exec($command); // Execute command


        $file = Storage::disk("public")->allFiles("temp/".$fileDir); //Get the file from dir

        if(count($file) > 0){
            $url = Storage::disk("public")->path($file[0]); //Get file url

            $getImage = $this->imgImageGeneratorWrapper($url); //Get image

            if($getImage){
                Storage::disk("public")->deleteDirectory("temp/".$fileDir); // Delete file dir from temp

                return $getImage; //Return image url
            }
        }



        return false;
    }


    /**
     * @param $fileUrl
     * @return \Exception
     */
    private function imgImageGeneratorWrapper($fileUrl){

        $fileName = "thumb_".str_random(5).".png"; //Create name for thumbnail

        try{
            $doc = new Imagick($fileUrl); //Get image from url
            $doc->scaleImage(400,400, true); //Fit image to 400px
            $doc->writeImage("storage/".$fileName); //Save image to storage
            $path = "thumbnails/".$fileName;

            $move = Storage::disk("public")->move($fileName, $path); //Move thumbnail to thumbnail dir

            if($move){
                return Storage::url($path); //Get url of thumbnail
            }
        }catch (\Exception $exception){
            return $exception;
        }


    }

}