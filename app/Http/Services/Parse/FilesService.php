<?php

namespace App\Http\Services\Parse;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Intervention\Image\Facades\Image;
use ZipArchive;
use function logger;
use function public_path;


class FilesService
{
    public function getZipFiles($filename, $path, $s_path)
    {
        $filename = \storage_path($s_path . '\\' . $filename);
        $destination = \storage_path($s_path);
        $files = array();
        logger('ZIP');
        logger($path);
        try {
            $zip = new ZipArchive();
            $zip->open($filename);
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filenames = $zip->getNameIndex($i);
                $name = 'image-' . $i . '.' . substr($zip->getNameIndex($i),strrpos($zip->getNameIndex($i),'.') + 1,strlen($zip->getNameIndex($i)));
                $zip->renameName($filenames, $name);
            }
            $zip->close();
            $zip2 = new ZipArchive();
            $zip2->open($filename);
            $zip2->extractTo($destination);
            $zip2->close();
           // unlink($filename);


            $all_files = File::files($destination);
            //$i = 0;
            foreach($all_files as $f) {
                $name = substr($f,strrpos($f,'\\') + 1,strlen($f));
                //if ($isImages) {
                /*     $extension= substr($old_name,strrpos($old_name,'.') + 1,strlen($old_name));
                    $name = 'image-' . $i . '.' . $extension;
                }else {
                    $name = str_replace(' ', '-', $old_name);
                }*/
                //rename($destination.'\\'.$old_name, $destination.'\\'.$name);
                $file = Storage::disk('public')->url($path . '/' . $name);
                //if ($isImages && preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|bmp))$)", $name)) {
                if (preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|bmp))$)", $name)) {
                    $this->generatePreview($file, $path . '/previews/' . $name);
                    $preview = Storage::disk('public')->url($path . '/previews/' . $name);
                    $files[] = ['main' => $file, 'preview' => $preview];
                } /*elseif (!$isImages) {
                    $files[] = $file;
                }*/
                //$i++;
            }
            logger($files);

        } catch (\Exception $exception) {
            logger($exception);
        }
        return $files;
    }
    public function getRarFiles($filename, $path, $s_path)
    {
        $filename = \storage_path($s_path . '\\' . $filename);
        $destination = \storage_path($s_path);
        $files = array();
        logger('RAR');
        logger($path);
        try {
            $RarName = 'archive.rar';
            rename($filename, $destination . '\\' . $RarName);
            $archive = \RarArchive::open($destination . '\\' . $RarName);
            $entries = $archive->getEntries();
            $i = 1;
            foreach ($entries as $entry) {
                $entry->extract(public_path($destination), $destination.'\\'.'image-' . $i . '.' . substr($entry->getName(),strrpos($entry->getName(),'.') + 1,strlen($entry->getName())));
                $i++;
            }
            $archive->close();
            // unlink($destination . '\\' . $RarName);
            $all_files = File::files($destination);
            foreach($all_files as $f) {
                $name = substr($f,strrpos($f,'\\') + 1,strlen($f));
                $file = Storage::disk('public')->url($path . '/' . $name);
                if (preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|bmp))$)", $name)) {
                    $this->generatePreview($file, $path . '/previews/' . $name);
                    $preview = Storage::disk('public')->url($path . '/previews/' . $name);
                    $files[] = ['main' => $file, 'preview' => $preview];
                }
            }
            logger($files);
        } catch (\Exception $exception) {
            logger($exception);
        }
        return $files;
    }

    public function getImagesFromDoc($filename, $path, $s_path)
    {
        $imageAssets = array();
        logger('DOC');
        logger($path);
        try {
            $document = \storage_path($s_path . '\\' . $filename);
            $zip = new ZipArchive;
            if (true === $zip->open($document)) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $zip_element = $zip->statIndex($i);
                    if (preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|bmp))$)", $zip_element["name"])) {
                        $extension = substr($zip_element["name"],strrpos($zip_element["name"],'.') + 1,strlen($zip_element["name"]));
                        Storage::disk('public')->put($path . '/' . 'image-' . $i . '.' . $extension, $zip->getFromIndex( $i ) );
                        $file = Storage::disk('public')->url($path . '/' . 'image-' . $i . '.' . $extension);
                        //logger($file);
                        $this->generatePreview($file, $path . '/previews/' . 'image-' . $i . '.' . $extension);
                        $preview = Storage::disk('public')->url($path . '/previews/' . 'image-' . $i . '.' . $extension);
                        $imageAssets[$i] = ['main' => $file, 'preview' => $preview];
                    }
                }
            }
            $zip->close();
            //unlink(\storage_path($s_path . '\\' . $filename));
        } catch (\Exception $exception) {
            logger($exception);
        }
        logger($imageAssets);
        return $imageAssets;
    }

    public function getImagesFromPDF($filename, $s_path, $path)
    {
        $images = array();
        logger('PDF');
        logger($path);
        try {
            $imagick = new Imagick();
            $imagick->readImage(\storage_path($path . '\\' . $filename));
            $imagick->borderImage("#FFFFFF", 1, 1);
            $imagick->writeImages(\storage_path($path . '\img.jpg'), false);
            $count = $imagick->getNumberImages();
            $i = 0;
            while ($i < $count) {
                if ($count>1) {
                    $f_name = 'img-' . $i . '.jpg';
                }else{
                    $f_name = 'img.jpg';
                }
                $img = new Imagick(\storage_path($path .'\\'. $f_name));
                $img->trimImage(0);

                $ip = $img->getImagePage();
                list($x, $y) = array($ip['x'], $ip['y']);
                $img->setImagePage(0, 0, 0, 0);
                list($width, $height) = array($img->width, $img->height);

                $img = new Imagick(\storage_path($path .'\\'. $f_name));
                $img->cropImage($width, $height, $x, $y);

                $img->writeImages(\storage_path($path .'\\'. $f_name), true);
                $img->destroy();

                $file = Storage::disk('public')->url($s_path . '/' . $f_name);
               // logger($file);
              //  logger($s_path . '/previews/' . $f_name);
                $this->generatePreview($file, $s_path . '/previews/' . $f_name);
                $preview = Storage::disk('public')->url($s_path . '/previews/' . $f_name);
                $images[$i] = ['main' => $file, 'preview' => $preview];
                $i++;
            }
            $imagick->destroy();
            unlink(\storage_path($path . '\\' . $filename));
        } catch (\Exception $exception) {
            logger($exception);
        }
        logger($images);
        return $images;
    }

    public function generatePreview($image, $path)
    {
        $thumbnail = Image::make($image);
        $thumbnail->fit(960, 480);
        Storage::disk('public')->put($path, $thumbnail);
        $thumbnail->save(public_path('storage/' . $path));

    }


}
