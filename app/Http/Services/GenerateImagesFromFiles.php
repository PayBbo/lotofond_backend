<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;
use Imagick;
use Intervention\Image\Facades\Image;
use ZipArchive;


class GenerateImagesFromFiles
{
    public function getZipFiles($filename, $path, $s_path, $isImages = false)
    {
        $filename = \storage_path($s_path . '\\' . $filename);
        $destination = \storage_path($s_path);
        $files = array();
        try {
            $zip = new ZipArchive();
            $zip->open($filename);
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = iconv('UTF-8', 'cp437//IGNORE', $zip->getNameIndex($i));
                $name = iconv('cp437', 'cp865//IGNORE', $name);
                $name = iconv('cp866','UTF-8//IGNORE',$name);
                $name = str_replace(' ', '-', $name);
                $zip->renameIndex($i, $name);
            }
            $zip->close();
            $zip = new ZipArchive();
            $zip->open($filename);
            $zip->extractTo($destination);
            $zip->close();
            $zip = new ZipArchive();
            $zip->open($filename);
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = str_replace(' ', '-', $zip->getNameIndex($i));
                $file = Storage::disk('public')->url($path . '/' . $name);
                if ($isImages) {
                    $this->generatePreview($file, $path . '/previews/' . $name);
                    $preview = Storage::disk('public')->url($path . '/previews/' . $name);
                    $files[$i] = ['main' => $file, 'preview' => $preview];
                } else {
                    $files[$i] = $file;
                }
            }
            $zip->close();
            unlink($filename);
        } catch (\Exception $exception) {
            logger($exception);
        }
        return $files;
    }

    public function getImagesFromDoc($filename, $path, $s_path)
    {
        $imageAssets = array();
        try {
            $zip = zip_open(\storage_path($s_path . '\\' . $filename));
            $i = 0;
            if (!$zip || is_numeric($zip)) return false;
            while ($zip_entry = zip_read($zip)) {
                if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

                $zipEntryName = zip_entry_name($zip_entry);

                if (strpos($zipEntryName, 'word/media') !== false) {

                    $imageName = substr($zipEntryName, 11);

                    if (substr($imageName, -3) == 'emf') continue;

                    Storage::disk('public')->put($path . '/' . $imageName,
                        zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
                    $file = Storage::disk('public')->url($path . '/' . $imageName);
                    logger($file);
                    $this->generatePreview($file, $path . '/previews/' . $imageName);
                    $preview = Storage::disk('public')->url($path . '/previews/' . $imageName);
                    $imageAssets[$i] = ['main' => $file, 'preview' => $preview];
                    $i++;
                }
                if ($zipEntryName != "word/document.xml") continue;
                zip_entry_close($zip_entry);
            }
            zip_close($zip);
            unlink(\storage_path($s_path . '\\' . $filename));
        } catch (\Exception $exception) {
            logger($exception);
        }
        return $imageAssets;
    }

    public function getImagesFromPDF($filename, $s_path, $path)
    {
        $images = array();
        try {
            $imagick = new Imagick();
            $imagick->readImage(\storage_path($path . '\\' . $filename));
            $imagick->borderImage("#FFFFFF", 1, 1);
            $imagick->writeImages(\storage_path($path . '\img.jpg'), false);
            $count = $imagick->getNumberImages();
            $i = 0;
            while ($i < $count) {
                $f_name = 'img-' . $i . '.jpg';
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
