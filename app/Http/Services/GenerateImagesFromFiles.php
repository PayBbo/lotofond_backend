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
        //$filename = \storage_path('app\public\auction-files\auction-695\фото-квартира.zip');
        // $destination = \storage_path('app\public\auction-files\auction-695');
        $filename = \storage_path($s_path . '\\' . $filename);
        $destination = \storage_path($s_path);


        $i = 0;
        $files = array();
        try {
            $zip = new ZipArchive();
            $zip->open($filename);
            $zip->extractTo($destination);
            while ($name = $zip->getNameIndex($i)) {
                $file = Storage::disk('public')->url($path . '/' . $name);
                if ($isImages) {
                    $this->generatePreview($file, $path . '/previews/' . $name);
                    $preview = Storage::disk('public')->url($path . '/previews/' . $name);
                    $files[$i] = ['main' => $file, 'preview' => $preview];
                } else {
                    $files[$i] = $file;
                }
                $i++;
            }

            $zip->close();
        } catch (\Exception $exception) {
            logger($exception);
        }
        return $files;
    }

    public function getImagesFromDoc($filename, $path, $s_path)
    {
        // $filename = \storage_path('app\public\auction-files\auction-50\Фото-авто.docx');
        //  $path = 'auction-files/auction-50';
        $imageAssets = array();
        try {
            $zip2 = new ZipArchive;
            $zip2->open($s_path . '\\' . $filename);
            $zip = zip_open($s_path . '\\' . $filename);
            $zip2->open($s_path . '\\' . $filename);
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
                    $this->generatePreview($file, $path . '/previews/' . $imageName);
                    $preview = Storage::disk('public')->url($path . '/previews/' . $imageName);
                    $imageAssets[$i] = ['main' => $file, 'preview' => $preview];
                    $i++;
                }
                if ($zipEntryName != "word/document.xml") continue;
                zip_entry_close($zip_entry);
            }
            $zip2->close();
        } catch (\Exception $exception) {
            logger($exception);
        }
        return $imageAssets;
    }

    public function getImagesFromPDF($filename, $s_path, $path)
    {
        /*$filename = 'app\public\auction-files\auction-787\фото-КАМАЗ_Прицеп_Калинин.pdf';
        $path = 'app\public\auction-files\auction-787';
        $s_path = 'auction-files/auction-787';*/
        $images = array();
        try {
            $imagick = new Imagick();
            $imagick->readImage(\storage_path($path . '\\' . $filename));
            $imagick->borderImage("#FFFFFF", 1, 1);
            $imagick->writeImages(\storage_path($path . '\img.jpg'), false);
            $count = $imagick->getNumberImages();
            $i = 0;
            while ($i < $count) {
                $f_name = '\img-' . $i . '.jpg';
                $img = new Imagick(\storage_path($path . $f_name));
                $img->trimImage(0);

                $ip = $img->getImagePage();
                list($x, $y) = array($ip['x'], $ip['y']);
                $img->setImagePage(0, 0, 0, 0);
                list($width, $height) = array($img->width, $img->height);

                $img = new Imagick(\storage_path($path . $f_name));
                $img->cropImage($width, $height, $x, $y);

                $img->writeImages(\storage_path($path . $f_name), true);
                $img->destroy();

                $file = Storage::disk('public')->url($s_path . '/' . $f_name);
                $this->generatePreview($file, $s_path . '/previews/' . $f_name);
                $preview = Storage::disk('public')->url($s_path . '/previews/' . $f_name);
                $images[$i] = ['main' => $file, 'preview' => $preview];
                $i++;
            }
            $imagick->destroy();
            logger($images);
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
