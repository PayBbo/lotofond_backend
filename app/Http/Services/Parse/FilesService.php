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
    protected $slash = DIRECTORY_SEPARATOR;

    public function parseFiles($invitation, $auction, $prefix, $isImages = false)
    {
        $filename = $invitation[$prefix . 'Attach'][$prefix . 'FileName'];
        if (strpos($filename, '.'))
            $name_file = str_replace(' ', '-', $filename);
        else
            $name_file = str_replace(' ', '-', $filename . '.' . $invitation[$prefix . 'Attach'][$prefix . 'Type']);
        $time = Carbon::now()->format('d-m-Y-H-i');
        $path = 'auction-files'.$this->slash.'auction-' . $auction->id . $this->slash . $time;
        if (!Storage::disk('public')->exists($path . $this->slash . $name_file)) {
            Storage::disk('public')->put($path . $this->slash . $name_file,
                base64_decode($invitation[$prefix . 'Attach'][$prefix . 'Blob']));
        }
        $dest = 'app'.$this->slash.'public'.$this->slash.'auction-files'.$this->slash.'auction-' . $auction->id . $this->slash . $time;
        if ($isImages) {
            logger('Images from type '. $invitation[$prefix . 'Attach'][$prefix . 'Type']);
            logger('Auction id: '.$auction->id);
            $full_path = \storage_path($dest);
            $name_file = $this->renameRootFile($full_path, $name_file);
            $document = \storage_path($dest . $this->slash . $name_file);

            $this->execCommand($full_path, $document, $invitation[$prefix . 'Attach'][$prefix . 'Type']);
            $files = $this->getImagesFrom($full_path, $path, $invitation[$prefix . 'Attach'][$prefix . 'Type'], $document);

            logger('----------------------');
        } else {
            $files = ['storage'.$this->slash . $path . $this->slash . $name_file];
        }
        return $files;
    }

    public function downloadFileByLink($files, $auctionId){
        $time = Carbon::now()->format('d-m-Y-H-i');
        $path = 'auction-files'.$this->slash.'auction-' . $auctionId . $this->slash . $time;
        $dest = 'app'.$this->slash.'public'.$this->slash.'auction-files'.$this->slash.'auction-' . $auctionId . $this->slash . $time;
        $full_path = \storage_path($dest);
        $images = [];
        $assets_files = [];
        $hasImages = false;
        foreach($files as $file) {
            $content = $this->getContentWithCookiesFile($file['link']);
            $filename = str_replace(' ', '-', $file['filename']);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = substr(pathinfo($filename, PATHINFO_FILENAME), 0, 200) . '.' . $extension;
            if(mb_stripos($filename, 'фото') !== false || $this->is_image_extension($filename)) {
                logger('LINKS. Images from type '. $extension);
                logger('Auction id: '.$auctionId);
                $temp_dir = $full_path . $this->slash . 'TEMP-DIR';
                $path_1 = $path . $this->slash . 'TEMP-DIR';
                Storage::disk('public')->put($path_1. $this->slash . $filename, $content);
                $document = $temp_dir.$this->slash.$filename;
                if($extension === 'doc' || $extension === 'pdf' || $extension === 'docx' || $extension === 'zip' || $extension === 'rar') {
                    $filename = $this->renameRootFile($full_path . $this->slash . 'TEMP-DIR', $filename);
                    $document = $temp_dir.$this->slash.$filename;
                    $this->execCommand($temp_dir, $document, $extension);
                }
                $this->getImagesFrom($temp_dir, $path_1, $extension, $document, true);
                logger('----------------------');
                $this->copyAllFilesImagesForExtract($full_path, $temp_dir.$this->slash);
                rmdir($temp_dir.$this->slash);
                $hasImages = true;
            } else {
                Storage::disk('public')->put($path . $this->slash . $filename, $content);
                $assets_files[] = 'storage' . $this->slash . $path . $this->slash . $filename;
            }
        }
        if($hasImages) {
            $images = $this->createPreview($full_path, $path);
        }
        return ['images'=>$images, 'files'=>$assets_files];
    }

    public function getContentWithCookiesFile($file) {
        $content = $this->getContentFile($file);
        $pattern = '/(?<=a=toNumbers\(").*(?="\),b)|(?<=b=toNumbers\(").*(?="\),c)|(?<=c=toNumbers\(").*(?="\),now)/';
        preg_match_all($pattern, $content, $matches);
        return $this->getContentFile($file, $matches[0][0],$matches[0][1], $matches[0][2]);
    }

    public function getContentFile($file, $a = '8b3d7f4e9ab55daee9fb89016f8a76a9', $b = 'a9ee0b0a96986edc98bfe6a739b457a6', $c = '535a97a4d149ee29ac533ad1ebf746d4') {
        $cookieService = new CookieService($a, $b, $c);
        $options = $cookieService->getFedresursHeadersOptions();
        $ch = curl_init($file);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    public function execCommand($path, $document, $extension) {
        $comm = null;
        switch ($extension) {
            case 'doc':
            case 'pdf':
            {
                $comm = "binwalk --dd 'jpeg image:jpeg' --dd 'png image:png' --dd 'jpg image:jpg' --dd 'bmp image:bmp' ".$document." --directory ".$path.$this->slash." --rm  --run-as=root";
                break;
            }
            case 'docx':
            case 'zip':
            case 'rar':
            {
                $comm = "unar -no-directory ".$document." -output-directory ".$path . $this->slash;
                break;
            }

        }
        if (!is_null($comm)) {
            try {
                exec(`$comm`);
            } catch (\Exception $exception) {
                //logger($exception);
            }
        }
    }

    public function renameRootFile($full_path, $file_name) {
        if (file_exists($full_path . $this->slash . $file_name)) {
            $extension = pathinfo($full_path . $this->slash . $file_name, PATHINFO_EXTENSION);
            $new_name = "tempfile.".$extension;
            rename($full_path . $this->slash . $file_name, $full_path . $this->slash . $new_name);
            return $new_name;
        }
        return $file_name;
    }

    public function getImagesFrom($full_path, $path, $type, $document, $is_array = false) {
        $this->searchAllFilesImagesForExtract($full_path, $full_path, $path);
        $this->deleteAllFilesForExtract($full_path. $this->slash . 'searchAllFilesImagesForExtract', $full_path. $this->slash . 'searchAllFilesImagesForExtract');
        if($type === 'pdf')
            $this->binwalkNotFindImages($full_path, $document, $path);
        $this->copyAllFilesImagesForExtract($full_path, $full_path . $this->slash . 'searchAllFilesImagesForExtract');
        $this->deleteAllFilesForExtract($full_path, $full_path);
        if ($is_array)
            return true;
        return $this->createPreview($full_path, $path);
    }

    function is_dir_empty($dir) {
        if (!is_readable($dir)) return null;
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry !== '.' && $entry !== '..') {
                closedir($handle);
                return false;
            }
        }
        closedir($handle);
        return true;
    }

    public function createPreview($full_path, $path)
    {
        $imageAssets = array();
        $result_files = File::files($full_path . $this->slash);
        foreach ($result_files as $key => $f) {
            $name = pathinfo($f, PATHINFO_FILENAME);
            $extension = pathinfo($f, PATHINFO_EXTENSION);
            if ($this->is_image_extension($name . '.' . $extension) && $this->is_image($full_path, $name . '.' . $extension)) {
                $file = 'storage' . $this->slash . $path . $this->slash . $name . '.' . $extension;
                $this->generatePreview($f, $path . $this->slash . 'previews' . $this->slash . $name . '.' . $extension);
                $preview = 'storage' . $this->slash . $path . $this->slash . 'previews' . $this->slash . $name . '.' . $extension;
                $imageAssets[$key] = ['main' => $file, 'preview' => $preview];
            }
        }
        return $imageAssets;
    }

    public function binwalkNotFindImages($full_path, $document, $path) {
        $temp_dir_search = $full_path . $this->slash . 'searchAllFilesImagesForExtract';
        $temp_dir = $path.$this->slash.'pdfimagesAllFilesImagesForExtract';
        Storage::disk('public')->makeDirectory($temp_dir);
        if (is_dir($temp_dir_search) && $this->is_dir_empty($temp_dir_search)) {
            $comm = "pdfimages -png ".$document." ".$temp_dir.$this->slash;
            try {exec(`$comm`);} catch (\Exception $exception) {}
            $this->searchAllFilesImagesForExtract($full_path, $full_path, $path);
            $this->copyAllFilesImagesForExtract($full_path, $full_path . $this->slash . 'searchAllFilesImagesForExtract');
        }
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
                    if (is_dir($dir . $this->slash . $object) && !is_link($dir . $this->slash . $object)) {
                        $this->deleteAllFilesForExtract($dir . $this->slash . $object, $s_path);
                    } else {
                        $extension = pathinfo($dir . $this->slash . $object, PATHINFO_EXTENSION);
                        if ($dir != $s_path) {
                            unlink($dir . $this->slash . $object);
                        } else {
                            if ($extension != 'jpeg' && $extension != 'bmp' && $extension != 'png' && $extension != 'jpg') {
                                unlink($dir . $this->slash . $object);
                            }
                        }
                    }
                }
            }
            if ($dir !== $s_path && $dir !== $s_path . $this->slash . 'previews') {
                rmdir($dir);
            }
        }
    }

    public function searchAllFilesImagesForExtract($current_dir, $root_path, $path)
    {
        $temp_dir = $root_path . $this->slash . 'searchAllFilesImagesForExtract';
        if ($current_dir === $root_path)
            Storage::disk('public')->makeDirectory($path. $this->slash . 'searchAllFilesImagesForExtract');
        if (is_dir($current_dir)) {
            $all_objects = scandir($current_dir);
            foreach ($all_objects as $key => $object) {
                if ($object === '.' or $object === '..') continue;
                if (is_dir($current_dir . $this->slash . $object) && !is_link($current_dir . $this->slash . $object)) {
                    if ($current_dir . $this->slash . $object != $temp_dir && $current_dir . $this->slash . $object != $current_dir . $this->slash . 'previews')
                        $this->searchAllFilesImagesForExtract($current_dir . $this->slash . $object, $root_path, $path);
                } else {
                    $object = $this->addNewExtension($current_dir, $object);
                    $object_extension = pathinfo($object, PATHINFO_EXTENSION);
                    $object_time = Carbon::now()->valueOf();
                    $random = rand(0,10000);
                    $object_time_new = $object_time . $random;
                    if ($this->is_image_extension($object) && $this->is_image($current_dir, $object))
                        rename($current_dir . $this->slash . $object, $temp_dir . $this->slash . 'image-' . $key . $object_time_new . '.' . $object_extension);
                }
            }
        }
    }

    public function copyAllFilesImagesForExtract($root_path, $temp_dir)
    {
        if (is_dir($temp_dir)) {
            $all_objects = scandir($temp_dir);
            foreach ($all_objects as $key => $object) {
                if ($object === '.' or $object === '..') continue;
                if ($this->is_image_extension($object) && $this->is_image($temp_dir, $object))
                    rename($temp_dir . $this->slash . $object, $root_path . $this->slash . $object);
            }
        }
    }

   /* public function createTempDir($temp_dir)
    {
        if (file_exists($temp_dir)) {
            if (is_dir($temp_dir))
                $this->deleteAllFilesForExtract($temp_dir, $temp_dir);
            else
                unlink($temp_dir);
        }
        if (!file_exists($temp_dir))
            mkdir($temp_dir);
    }*/

    public function is_image($full_path, $file)
    {
        $object_mime_type = mime_content_type($full_path . $this->slash . $file);
        if (strpos($object_mime_type, "image") !== false)
            return true;
        return false;
    }

    public function is_image_extension($file)
    {
        $object_extension = pathinfo($file, PATHINFO_EXTENSION);
        if ($object_extension == 'jpeg' || $object_extension == 'png' || $object_extension == 'bmp' || $object_extension == 'jpg')
            return true;
        return false;
    }

    public function get_image_extension($full_path, $file)
    {
        $extension = '';
        if ($this->is_image($full_path, $file)) {
            $object_mime_type = mime_content_type($full_path . $this->slash . $file);
            if (strpos($object_mime_type, "jpeg") !== false)
                $extension = '.jpeg';
            elseif (strpos($object_mime_type, "png") !== false)
                $extension = '.png';
            elseif (strpos($object_mime_type, "bmp") !== false)
                $extension = '.bmp';
        }
        return $extension;
    }

    public function addNewExtension($current_dir, $object)
    {
        $object_name = pathinfo($object, PATHINFO_FILENAME);
        $object_extension = pathinfo($object, PATHINFO_EXTENSION);
        $new_extension = $this->get_image_extension($current_dir, $object);
        if ($this->is_image($current_dir, $object) || $this->is_image_extension($object)) {
            rename($current_dir . $this->slash . $object, $current_dir . $this->slash . $object_name . $new_extension);
            return $object_name . $new_extension;
        }
        if ($object_extension == null || $object_extension == '')
            return $object_name;
        return $object_name . '.' . $object_extension;
    }

    public function deleteFile($file){
        if($file->type == 'file'){
            $path = \storage_path('app'.$this->slash.'public'.$this->slash.stristr($file->url, 'auction-files'));
            File::delete($path);
        }else{
            $main = \storage_path('app'.$this->slash.'public'.$this->slash.stristr($file->url[0], 'auction-files'));
            $preview = \storage_path('app'.$this->slash.'public'.$this->slash.stristr($file->url[1], 'auction-files'));
            File::delete([$main, $preview]);
        }
    }
}
