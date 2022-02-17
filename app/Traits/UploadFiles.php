<?php
namespace App\Traits;
use Illuminate\Support\Facades\Storage;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Intervention\Image\Facades\Image;
use SoareCostin\FileVault\Facades\FileVault;

trait UploadFiles{
    public function uploadS3File($file, $dir, $one_size=false, $width=200, $height=200)
    {
        //get file extension
        $extension = $file->getClientOriginalExtension();

        //filename to store
        $FileNameToStore = '/file_'.uniqid().'_'.time().'.'.$extension;

        //Upload File to s3
        if ($one_size){
//            if ($extension != 'svg') {
//                $file = Image::make($file)->encode($extension, 100)
//                    ->fit($width, $height)->stream()->__toString();
//            }else{
                $file = file_get_contents($file);
//            }

            $this->uploadToDisk($dir . $FileNameToStore, $file);

            $FileNameToStore = $dir . $FileNameToStore;

        }else{
            $this->upload($file, $dir, $FileNameToStore);
        }

        //Store $FileNameToStore in the database
        return $FileNameToStore;
    }

    public function UpdateS3File($file, $dir,$oldFile=null, $one_size=false, $width=200, $height=200)
    {
        if ($oldFile){
            if(!$one_size){
                $this->deleteFile($dir.'/tinder_thumb'.$oldFile);
                $this->deleteFile($dir.'/main_thumb'.$oldFile);
                $this->deleteFile($dir.'/view_all_thumb'.$oldFile);
                $this->deleteFile($dir.'/details_thumb'.$oldFile);
                $this->deleteFile($dir.'/details_all_thumb'.$oldFile);
            }else{
                $this->deleteFile($oldFile);
            }
        }

        //get file extension
        $extension = $file->getClientOriginalExtension();

        //filename to store
        $FileNameToStore = '/file_'.uniqid().'_'.time().'.'.$extension;

            //Upload File to s3
            if ($one_size) {
//                if ($extension != 'svg') {
//                    $file = Image::make($file)->encode($extension, 100)
//                        ->fit($width, $height)->stream()->__toString();
//                }else{
                    $file = file_get_contents($file);
//                }
                $this->uploadToDisk($dir . $FileNameToStore, $file);

                $FileNameToStore = $dir . $FileNameToStore;
            } else {
                $this->upload($file, $dir, $FileNameToStore);
            }


        //Store $FileNameToStore in the database
        return $FileNameToStore;
    }

    /**
     * @throws \Exception
     */
    public function uploadAudio($file, $dir)
    {
        //get file extension
        $extension = $file->getClientOriginalExtension();

        //filename to store
        $FileNameToStore = 'file_'.uniqid().'_'.time().'.'.$extension;

        //Upload File to s3
        $this->uploadToDisk($dir.'/'.$FileNameToStore, fopen($file, 'r+'));

        //Store $FileNameToStore in the database
        return $FileNameToStore;
    }

    public function UpdateAudio($file, $dir,$oldFile=null)
    {
        if ($oldFile){
            $this->deleteFile($oldFile);
        }

        //get file extension
        $extension = $file->getClientOriginalExtension();

        //filename to store
        $FileNameToStore = 'file_'.uniqid().'_'.time().'.'.$extension;

        //Upload File to s3
        $this->uploadToDisk($dir.'/'.$FileNameToStore, fopen($file, 'r+'));

        //Store $FileNameToStore in the database
        return $FileNameToStore;
    }


    public function deleteFile($filePath)
    {
        if (Storage::disk('s3')->exists($filePath)){
            Storage::disk('s3')->delete($filePath);
        }
    }

    public function uploadToDisk($path, $file)
    {
        Storage::disk('s3')->put($path, $file, 'public');
    }

    public function getFileUrl($file_path){
        return Storage::disk('s3')->url($file_path);
    }

    private function uploadBookSizes($file, $dir, $FileNameToStore, $extension)
    {
//            $tinder = $this->resizeImage($file,215, 318);
//            $main = $this->resizeImage($file,192, 285);
//            $viewAll = $this->resizeImage($file,80, 117);
//            $details = $this->resizeImage($file,167, 248);
//            $detailsAll = $this->resizeImage($file,159, 231);

            $tinder = Image::make($file)->encode($extension, 100)->resize(215, null,function ($constraint) {
                $constraint->aspectRatio();
             })->stream()->__toString();
            $main = Image::make($file)->encode($extension, 100)->resize(192, null,function ($constraint) {
                $constraint->aspectRatio();
             })->stream()->__toString();
//            $viewAll = Image::make($file)->encode($extension, 100)->resize(80, null,function ($constraint) {
//                $constraint->aspectRatio();
//             })->stream()->__toString();
            $details = Image::make($file)->encode($extension, 100)->resize(167, null,function ($constraint) {
                $constraint->aspectRatio();
             })->stream()->__toString();
            $detailsAll = Image::make($file)->encode($extension, 100)->resize(159, null,function ($constraint) {
                $constraint->aspectRatio();
             })->stream()->__toString();

        $this->uploadToDisk($dir . '/tinder_thumb/' . $FileNameToStore, $tinder);
        $this->uploadToDisk($dir . '/main_thumb/' . $FileNameToStore, $main);
//        $this->uploadToDisk($dir . '/view_all_thumb/' . $FileNameToStore, $viewAll);
        $this->uploadToDisk($dir . '/details_thumb/' . $FileNameToStore, $details);
        $this->uploadToDisk($dir . '/details_all_thumb/' . $FileNameToStore, $detailsAll);
    }

    public function resizeImage($file, $dw=null, $dh=null){
        // d = desired dimensions
        // o = old dimensions

        // get image size of img
        $x = @getimagesize($file);
        // image width
        $ow = $x[0];
        // image height
        $oh = $x[1];

        if ($oh > $ow) {
            $h = $dh;
            $w = ($dh/$oh) * $ow;
        }
        else {
            $w = $dw;
            $h = ($dw/$ow) * $oh;
        }

        $im = @ImageCreateFromJPEG ($file) or // Read JPEG Image
        $im = @ImageCreateFromPNG ($file) or // or PNG Image
        $im = @ImageCreateFromGIF ($file) or // or GIF Image
        $im = false; // If image is not JPEG, PNG, or GIF

        if (!$im) {
            // We get errors from PHP's ImageCreate functions...
            // So let's echo back the contents of the actual image.
            readfile ($file);
        } else {
            // Create the resized image destination
            $thumb = @ImageCreateTrueColor ($w, $h);
            // Copy from image source, resize it, and paste to image destination
            @ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $w, $h, $ow, $oh);
            // Output resized image
            $newFielName = tempnam(sys_get_temp_dir(), "tempfilename");
            @ImageJPEG ($thumb, $newFielName,100);
            return $newFielName;
        }
    }


    function upload($file, $dir, $FileNameToStore){

        $imagine = new Imagine();
        $tinder = $imagine->open($file)->resize(new Box(215, 318));
        $main = $imagine->open($file)->resize(new Box(192, 285));
        $viewAll = $imagine->open($file)->resize(new Box(80, 117));
        $details = $imagine->open($file)->resize(new Box(167, 248));
        $detailsAll = $imagine->open($file)->resize(new Box(159, 231));

        Storage::disk('s3')->put($dir.'/tinder_thumb'.$FileNameToStore, $tinder, 'public');
        Storage::disk('s3')->put($dir.'/main_thumb'.$FileNameToStore, $main, 'public');
        Storage::disk('s3')->put($dir.'/view_all_thumb'.$FileNameToStore, $viewAll, 'public');
        Storage::disk('s3')->put($dir.'/details_thumb'.$FileNameToStore, $details, 'public');
        Storage::disk('s3')->put($dir.'/details_all_thumb'.$FileNameToStore, $detailsAll, 'public');
    }

    public function uploadFile($file, $dir, $oldFile=null): void
    {
        if ($oldFile){
            $this->deleteFile($oldFile);
        }

        $file = file_get_contents($file);
        $this->uploadToDisk($dir, $file);
    }
}
