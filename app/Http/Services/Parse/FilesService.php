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
            $document = \storage_path($dest . $this->slash . $name_file);
            $full_path = \storage_path($dest);
            $comm = null;
            logger('Images from type '. $invitation[$prefix . 'Attach'][$prefix . 'Type']);
            switch ($invitation[$prefix . 'Attach'][$prefix . 'Type']) {
                case 'doc':
                case 'pdf':
                {
                    $comm = "binwalk --dd 'jpeg image:jpeg' --dd 'png image:png' --dd 'jpg image:jpg' --dd 'bmp image:bmp' " . $document . " --directory " . $full_path . $this->slash . " --rm";
                    break;
                }
                case 'docx':
                case 'zip':
                case 'rar':
                {
                    $comm = "unar -D " . $document . " -o " . $full_path . $this->slash;
                    break;
                }

            }
            if (!is_null($comm)) {
                try {
                    exec(`$comm`);
                    $files = $this->getImagesFrom($full_path, $path);
                    logger('Auction id: '.$auction->id);
                    logger('----------------------');
                } catch (\Exception $exception) {
                    logger($exception);
                }
            }
        } else {
            $files = ['storage/' . $path . '/' . $name_file];
        }
        return $files;

    }

    public function getImagesFrom($full_path, $path)
    {
        $this->searchAllFilesImagesForExtract($full_path, $full_path);
        $this->copyAllFilesImagesForExtract($full_path);
        $this->deleteAllFilesForExtract($full_path, $full_path);
        return $this->createPreview($full_path, $path);
    }

    public function createPreview($full_path, $path)
    {
        $imageAssets = array();
        $result_files = File::files($full_path . $this->slash);
        foreach ($result_files as $key => $f) {
            $name = pathinfo($f, PATHINFO_FILENAME);
            $extension = pathinfo($f, PATHINFO_EXTENSION);
            if ($this->is_image_extension($name . '.' . $extension) && $this->is_image($full_path, $name . '.' . $extension)) {
                $object_time = Carbon::now()->valueOf();
                $object_time_new = $object_time * 3;
                $file = 'storage' . $this->slash . $path . $this->slash . 'image-' . $key . $object_time_new . '.' . $extension;
                $this->generatePreview($f, $path . $this->slash . 'previews' . $this->slash . 'image-' . $key . $object_time_new . '.' . $extension);
                $preview = 'storage' . $this->slash . $path . $this->slash . 'previews' . $this->slash . 'image-' . $key . $object_time_new . '.' . $extension;
                $imageAssets[$key] = ['main' => $file, 'preview' => $preview];
            }
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
                    if (is_dir($dir . $this->slash . $object) && !is_link($dir . "/" . $object)) {
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

    public function searchAllFilesImagesForExtract($current_dir, $root_path)
    {
        $temp_dir = $root_path . $this->slash . 'searchAllFilesImagesForExtract';
        if ($current_dir === $root_path)
            $this->createTempDir($temp_dir);
        if (is_dir($current_dir)) {
            $all_objects = scandir($current_dir);
            foreach ($all_objects as $key => $object) {
                if ($object === '.' or $object === '..') continue;
                if (is_dir($current_dir . $this->slash . $object) && !is_link($current_dir . "/" . $object)) {
                    if ($current_dir . $this->slash . $object != $temp_dir && $current_dir . $this->slash . $object != $current_dir . $this->slash . 'previews')
                        $this->searchAllFilesImagesForExtract($current_dir . $this->slash . $object, $root_path);
                } else {
                    $object = $this->addNewExtension($current_dir, $object);
                    $object_extension = pathinfo($object, PATHINFO_EXTENSION);
                    $object_time = Carbon::now()->valueOf();
                    $object_time_new = $object_time * 3;
                    if ($this->is_image_extension($object) && $this->is_image($current_dir, $object))
                        rename($current_dir . $this->slash . $object, $temp_dir . $this->slash . 'image-' . $key . $object_time_new . '.' . $object_extension);
                }
            }
        }
    }

    public function copyAllFilesImagesForExtract($root_path)
    {
        $temp_dir = $root_path . $this->slash . 'searchAllFilesImagesForExtract';
        if (is_dir($temp_dir)) {
            $all_objects = scandir($temp_dir);
            foreach ($all_objects as $key => $object) {
                if ($object === '.' or $object === '..') continue;
                if ($this->is_image_extension($object) && $this->is_image($temp_dir, $object))
                    rename($temp_dir . $this->slash . $object, $root_path . $this->slash . $object);
            }
        }
    }

    public function createTempDir($temp_dir)
    {
        if (file_exists($temp_dir)) {
            if (is_dir($temp_dir))
                $this->deleteAllFilesForExtract($temp_dir, $temp_dir);
            else
                unlink($temp_dir);
        }
        if (!file_exists($temp_dir))
            mkdir($temp_dir);
    }

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
}
