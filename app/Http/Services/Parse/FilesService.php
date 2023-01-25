<?php

namespace App\Http\Services\Parse;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use function logger;
use function public_path;


class FilesService
{
    protected $slash = '/';

    public function parseFiles($invitation, $auction, $prefix, $isImages = false)
    {
        $filename = $invitation[$prefix . 'Attach'][$prefix . 'FileName'];
        if (strpos($filename, '.')) {
            $name_file = str_replace(' ', '-', $filename);
        } else {
            $name_file = str_replace(' ', '-', $filename . '.' . $invitation[$prefix . 'Attach'][$prefix . 'Type']);
        }
        $time = Carbon::now()->format('d-m-Y-H-i');
        $path = 'auction-files/auction-' . $auction->id . '/' . $time;
        if (!Storage::disk('public')->exists($path . '/' . $name_file)) {
            Storage::disk('public')->put($path . '/' . $name_file,
                base64_decode($invitation[$prefix . 'Attach'][$prefix . 'Blob']));
        }
        $dest = 'app/public/auction-files/auction-' . $auction->id . '/' . $time;
        $files = null;
        if ($isImages) {
            switch ($invitation[$prefix . 'Attach'][$prefix . 'Type']) {
                case 'doc':
                case 'pdf':
                {
                    $files = $this->getImagesFromDocOrPdf($name_file, $path, $dest);
                    break;
                }
                case 'docx':
                {
                    $files = $this->getImagesFromDocx($name_file, $path, $dest);
                    break;
                }
                case 'zip':
                case 'rar':
                {
                    $files = $this->getImagesFromZipOrRar($name_file, $path, $dest);
                    break;
                }

            }
        } else {
            $files = ['storage/' . $path . '/' . $name_file];
        }
        return $files;

    }


    public function getImagesFromDocOrPdf($filename, $path, $s_path)
    {
        $imageAssets = array();
        $document = \storage_path($s_path . $this->slash . $filename);
        $full_path = \storage_path($s_path . $this->slash);
        try {
            $comm = "binwalk --dd 'jpeg image:jpeg' --dd 'png image:png' --dd 'jpg image:jpg' --dd 'bmp image:bmp' " . $document . " --directory " . $full_path . " --rm";
            exec(`$comm`);
            $results = scandir($full_path);
            foreach ($results as $result) {
                if ($result == '.' or $result == '..') continue;
                if (is_dir($full_path . $result) || preg_match("([^\s]+(\.(?i)extracted)$)", $result)) {
                    $result_files = scandir($full_path . $result);
                    foreach ($result_files as $key => $file) {
                        if ($file == '.' or $file == '..') continue;
                        if(pathinfo($file, PATHINFO_EXTENSION) == null || pathinfo($file,PATHINFO_EXTENSION) == '') {
                            $file = $this->get_mime_image_file($full_path . $result, $file);
                        }
                        $name = pathinfo($file, PATHINFO_FILENAME);
                        $extension = pathinfo($file, PATHINFO_EXTENSION);
                        if (($extension == 'jpeg' || $extension == 'bmp' || $extension == 'png' || $extension == 'jpg') && $this->is_image($full_path . $result, $file)) {
                            rename(\storage_path($s_path . $this->slash . $result . $this->slash . $name . '.' . $extension), \storage_path($s_path . $this->slash . 'image-' . $key . '.' . $extension));
                        }

                    }
                }
            }
            $this->deleteAllFilesForExtract(\storage_path($s_path), \storage_path($s_path));
            $imageAssets = $this->createPreview($full_path, $path, $imageAssets);
        } catch (\Exception $exception) {
            logger($exception);
        }
        return $imageAssets;
    }

    public function getImagesFromDocx($filename, $path, $s_path)
    {
        $imageAssets = array();
        $document = \storage_path($s_path . $this->slash . $filename);
        $full_path = \storage_path($s_path . $this->slash);
        try {
            $comm = 'unar -D ' . $document . ' -o ' . $full_path;
            exec(`$comm`);
            if (is_dir($full_path . 'word' . $this->slash)) {
                $results = scandir($full_path . 'word' . $this->slash);
                foreach ($results as $result) {
                    if ($result === '.' or $result === '..') continue;
                    if (is_dir($full_path . 'word' . $this->slash . $result) && $result == "media") {
                        $result_files = scandir($full_path . 'word' . $this->slash . $result);
                        foreach ($result_files as $key => $f) {
                            $name = pathinfo($f, PATHINFO_FILENAME);
                            $extension = pathinfo($f, PATHINFO_EXTENSION);
                            if (($extension == 'jpeg' || $extension == 'bmp' || $extension == 'png' || $extension == 'jpg') && $this->is_image($full_path . 'word' . $this->slash . $result, $f)) {
                                rename(\storage_path($s_path . $this->slash . 'word' . $this->slash . $result . $this->slash . $name . '.' . $extension), \storage_path($s_path  . $this->slash . 'image-' . $key . '.' . $extension));
                            }
                        }
                    }
                }
            }
            $this->deleteAllFilesForExtract(\storage_path($s_path), \storage_path($s_path));
            $imageAssets = $this->createPreview($full_path, $path, $imageAssets);
        } catch (\Exception $exception) {
            logger($exception);
        }
        return $imageAssets;
    }

    public function getImagesFromZipOrRar($filename, $path, $s_path)
    {
        $imageAssets = array();
        $document = \storage_path($s_path . $this->slash . $filename);
        $full_path = \storage_path($s_path . $this->slash);
        try {
            $comm = "unar -D " . $document . " -o " . $full_path;
            exec(`$comm`);
            $results = scandir($full_path);
            foreach ($results as $key => $f) {
                $name = pathinfo($f, PATHINFO_FILENAME);
                $extension = pathinfo($f, PATHINFO_EXTENSION);
                if (($extension == 'jpeg' || $extension == 'bmp' || $extension == 'png' || $extension == 'jpg') && $this->is_image($full_path, $f)) {
                    rename(\storage_path($s_path . $this->slash . $name . '.' . $extension), \storage_path($s_path  . $this->slash . 'image-' . $key . '.' . $extension));
                }
            }
            $this->deleteAllFilesForExtract(\storage_path($s_path), \storage_path($s_path));
            $imageAssets = $this->createPreview($full_path, $path, $imageAssets);
        } catch (\Exception $exception) {
            logger($exception);
        }
        return $imageAssets;
    }

    public function createPreview($full_path, $path, $imageAssets) {
        $result_files = File::files($full_path);
        foreach ($result_files as $key => $f) {
            $name = substr($f, strrpos($f, $this->slash) + 1, strlen($f));
            $extension = substr($name, strrpos($name, '.') + 1, strlen($name));
            $file = 'storage' . $this->slash . $path . $this->slash . 'image-' . $key . '.' . $extension;
            $this->generatePreview($f, $path . $this->slash . 'previews' . $this->slash . 'image-' . $key . '.' . $extension);
            $preview = 'storage' . $this->slash . $path . $this->slash . 'previews' . $this->slash . 'image-' . $key . '.' . $extension;
            $imageAssets[$key] = ['main' => $file, 'preview' => $preview];
        }
        return $imageAssets;
    }

    public function generatePreview($image, $path)
    {
        $thumbnail = Image::make($image);
        $thumbnail->fit(960, 480);
        Storage::disk('public')->put($path, $thumbnail);
        $thumbnail->save(public_path('storage' . $this->slash . $path));

    }

    public function deleteAllFilesForExtract($dir, $s_path)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . $this->slash . $object)) {
                        $this->deleteAllFilesForExtract($dir . DIRECTORY_SEPARATOR . $object, $s_path);
                    } else {
                        $extension = pathinfo($dir . DIRECTORY_SEPARATOR . $object, PATHINFO_EXTENSION);
                        if ($dir != $s_path) {
                            unlink($dir . DIRECTORY_SEPARATOR . $object);
                        } else {
                            if($extension != 'jpeg' && $extension != 'bmp' && $extension != 'png' && $extension != 'jpg') {
                                unlink($dir . DIRECTORY_SEPARATOR . $object);
                            }
                        }
                    }
                }
            }
            if ($dir !== $s_path && $dir !== $s_path . $this->slash .'previews') {
                rmdir($dir);
            }
        }
    }

    public function is_image($full_path, $file) {
        $mime = mime_content_type($full_path.$this->slash.$file);
        if(strpos($mime, "image/jpeg") !== false || strpos($mime, "image/png") !== false || strpos($mime, "image/bmp") !== false)
            return true;
        return false;
    }
    public function get_mime_image_file($full_path, $file) {
        $mime = mime_content_type($full_path.$this->slash.$file);
        $new_file = $file;
        if(strpos($mime, "jpeg") !== false) {
            $new_file .='.jpeg';
            rename($full_path.$this->slash.$file, $full_path.$this->slash.$new_file);
        } elseif (strpos($mime, "png") !== false) {
            $new_file .='.png';
            rename($full_path.$this->slash.$file, $full_path.$this->slash.$new_file);
        } elseif (strpos($mime, "bmp") !== false) {
            $new_file .='.bmp';
            rename($full_path.$this->slash.$file, $full_path.$this->slash.$new_file);
        }
        return $new_file;
    }
}
