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
            logger('IS IMAGE!');
            logger($invitation[$prefix . 'Attach'][$prefix . 'Type']);
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
        $document = \storage_path($s_path . '/' . $filename);
        $full_path = \storage_path($s_path . '/');
        logger('DOC и PDF');
        logger($path);
        try {
            $comm = `binwalk --dd 'jpeg image:jpeg' --dd 'png image:png' --dd 'jpg image:jpg' --dd 'bmp image:bmp' ` . $document . ` --directory ` . $full_path . ` --rm`;
            exec($comm);
            $results = scandir($full_path);
            foreach ($results as $result) {
                if ($result === '.' or $result === '..') continue;
                if (is_dir($full_path . $result) || preg_match("([^\s]+(\.(?i)extracted)$)", $result)) {
                    $result_files = File::files($full_path . $result);
                    foreach ($result_files as $key => $f) {
                        $name = substr($f, strrpos($f, '\\') + 1, strlen($f));
                        $extension = substr($name, strrpos($name, '.') + 1, strlen($name));
                        if (preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|bmp))$)", $name) && $this->is_image($f)) {
                            rename(\storage_path($s_path . '\\' . $result . '\\' . $name), \storage_path($s_path . '\\' . 'image-' . $key . '.' . $extension));
                        }
                    }
                }
            }
            //  $this->deleteAllFilesForExtractDocx(\storage_path($s_path), \storage_path($s_path));
            $result_files = File::files($full_path);
            foreach ($result_files as $key => $f) {
                $name = substr($f, strrpos($f, '\\') + 1, strlen($f));
                $extension = substr($name, strrpos($name, '.') + 1, strlen($name));
                $file = 'storage/' . $path . '/' . 'image-' . $key . '.' . $extension;
                $this->generatePreview($file, $path . '/previews/' . 'image-' . $key . '.' . $extension);
                $preview = 'storage/' . $path . '/previews/' . 'image-' . $key . '.' . $extension;;
                $imageAssets[$key] = ['main' => $file, 'preview' => $preview];
            }
        } catch (\Exception $exception) {
            logger($exception);
        }
        logger($imageAssets);
        return $imageAssets;
    }

    public function getImagesFromDocx($filename, $path, $s_path)
    {
        $imageAssets = array();
        $filename = \storage_path($s_path . '/' . $filename);
        $full_path = \storage_path($s_path . '/');
        logger('DOCX');
        logger($path);
        logger($filename);
        logger($full_path);
        try {
            if (file_exists($filename)) {
                echo "Файл $filename существует";
            } else {
                echo "Файл $filename не существует";
            }
            $comm = `unar -D ` . $filename . ` -o ` . $full_path;
            exec($comm, $output, $return_var);
            logger($output);
            logger($return_var);
            if (is_dir($full_path . 'word\\')) {
                $results = scandir($full_path . 'word\\');
                foreach ($results as $result) {
                    if ($result === '.' or $result === '..') continue;
                    if (is_dir($full_path . 'word\\' . $result) || preg_match("(^media$)", $result)) {
                        $resurl_files = File::files($full_path . 'word\\' . $result);
                        foreach ($resurl_files as $key => $f) {
                            $name = substr($f, strrpos($f, '\\') + 1, strlen($f));
                            $extension = substr($name, strrpos($name, '.') + 1, strlen($name));
                            if (preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|bmp))$)", $name) && $this->is_image($f)) {
                                rename(\storage_path($s_path . '\word\\' . $result . '\\' . $name), \storage_path($s_path . '\\' . 'image-' . $key . '.' . $extension));
                            }
                        }
                    }
                }
            }
            // $this->deleteAllFilesForExtractDocx(\storage_path($s_path), \storage_path($s_path));
            $all_files = File::files($full_path);
            foreach ($all_files as $key => $f) {
                $name = substr($f, strrpos($f, '\\') + 1, strlen($f));
                $extension = substr($name, strrpos($name, '.') + 1, strlen($name));
                if (preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|bmp))$)", $name) && $this->is_image($f)) {
                    $file = 'storage/' . $path . '/' . 'image-' . $key . '.' . $extension;;
                    $this->generatePreview($file, $path . '/previews/' . 'image-' . $key . '.' . $extension);
                    $preview = 'storage/' . $path . '/previews/' . 'image-' . $key . '.' . $extension;
                    $imageAssets[] = ['main' => $file, 'preview' => $preview];
                }
            }
        } catch (\Exception $exception) {
            logger($exception);
        }
        logger($imageAssets);
        return $imageAssets;
    }

    public function getImagesFromZipOrRar($filename, $path, $s_path)
    {
        $filename = \storage_path($s_path . '/' . $filename);
        $destination = \storage_path($s_path . '/');
        $files = array();
        logger('ZIP И RAR');
        try {
            $comm = `unar -D ` . $filename . ` -o ` . $destination;
            exec($comm);
            //  $this->deleteAllFilesForExtractDocx(\storage_path($s_path), \storage_path($s_path));
            $all_files = File::files($destination);
            foreach ($all_files as $key => $f) {
                $name = substr($f, strrpos($f, '\\') + 1, strlen($f));
                $extension = substr($name, strrpos($name, '.') + 1, strlen($name));
                if (preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|bmp))$)", $name) && $this->is_image($f)) {
                    rename($destination . $name, $destination . 'image-' . $key . '.' . $extension);
                    $file = 'storage/' . $path . '/' . 'image-' . $key . '.' . $extension;;
                    $this->generatePreview($file, $path . '/previews/' . 'image-' . $key . '.' . $extension);
                    $preview = 'storage/' . $path . '/previews/' . 'image-' . $key . '.' . $extension;;
                    $files[] = ['main' => $file, 'preview' => $preview];
                }
            }
        } catch (\Exception $exception) {
            logger($exception);
        }
        logger($files);
        return $files;
    }

    public function is_image($path)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $image_type = finfo_file($finfo, $path);
        if (mb_substr($image_type, 0, 6) == "image/") {
            return true;
        }
        return false;
    }

    public function generatePreview($image, $path)
    {
        $thumbnail = Image::make($image);
        $thumbnail->fit(960, 480);
        Storage::disk('public')->put($path, $thumbnail);
        $thumbnail->save(public_path('storage/' . $path));

    }

    public function deleteAllFilesForExtractDocx($dir, $s_path)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object)) {
                        $this->deleteAllFilesForExtractDocx($dir . DIRECTORY_SEPARATOR . $object, $s_path);
                    } else {
                        $name = substr($dir . DIRECTORY_SEPARATOR . $object, strrpos($dir . DIRECTORY_SEPARATOR . $object, '\\') + 1, strlen($dir . DIRECTORY_SEPARATOR . $object));
                        if (!preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|bmp))$)", $name) && !$this->is_image($dir . DIRECTORY_SEPARATOR . $object)) {
                            unlink($dir . DIRECTORY_SEPARATOR . $object);
                        }
                    }
                }
            }
            if ($dir !== $s_path && $dir !== $s_path . '\previews') {
                rmdir($dir);
            }
        }
    }

}
