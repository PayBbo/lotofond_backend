<?php

namespace App\Http\Services\Parse;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use function logger;


class FilesService
{
    protected $slash = DIRECTORY_SEPARATOR;

    /*
     * Путь относительно storage public
     * 'auction-files/auction-id/time';
     */

    public function parseFiles($invitation, $auction, $prefix, $isImages = false): array
    {
        $filename = $invitation[$prefix . 'Attach'][$prefix . 'FileName'];
        $extension = $invitation[$prefix . 'Attach'][$prefix . 'Type'];
        if (strpos($filename, '.'))
            $filename = str_replace(' ', '-', $filename);
        else
            $filename = str_replace(' ', '-', $filename . '.' . $extension);
        $filename = substr(File::name($filename), 0, 200) . '.' .  $extension;
        $time = $this->getTimeNow();
        $root_path = 'auction-files' . $this->slash . 'auction-' . $auction->id . $this->slash . $time;
        if (!File::exists(Storage::disk('public')->path($root_path . $this->slash . $filename)))
            Storage::disk('public')->put($root_path . $this->slash . $filename, base64_decode($invitation[$prefix . 'Attach'][$prefix . 'Blob']));
        if ($isImages) {
            logger('Images from type '. $extension);
            logger('Auction id: '.$auction->id);
            $this->parseImages($root_path, $filename, $extension);
            $files = $this->createPreview($root_path);
            logger('----------------------');
        }
        else
            $files = ['storage' . $this->slash . $root_path . $this->slash . $filename];
        return $files;
    }
    public function downloadFileByLink($arrayFiles, $auctionId): array
    {
        $time = $this->getTimeNow();
        $root_path = 'auction-files' . $this->slash . 'auction-' . $auctionId . $this->slash . $time;
        $images = array();
        $files = array();
        $hasImages = false;
        foreach($arrayFiles as $file) {
            $content = $this->getContentWithCookiesFile($file['link']);
            $filename = str_replace(' ', '-', $file['filename']);
            $filenameExtension = File::extension($filename) ? '.'.File::extension($filename) : File::extension($filename);
            $extension = File::extension($filename);
            $filename = substr(File::name($filename), 0, 200) . $filenameExtension;
            if(mb_stripos($filename, 'фото') !== false || $this->is_image_extension($filename)) {
                logger('LINKS. Images from type '. $extension);
                logger('Auction id: '.$auctionId);
                Storage::disk('public')->put($root_path. $this->slash . $filename, $content);
                $this->parseImages($root_path, $filename, $extension);
                $hasImages = true;
                logger('----------------------');
            } else {
                Storage::disk('public')->put($root_path . $this->slash . $filename, $content);
                $files[] = 'storage' . $this->slash . $root_path . $this->slash . $filename;
            }
        }
        if($hasImages)
            $images = $this->createPreview($root_path);
        return ['images'=>$images, 'files'=>$files];
    }

    public function parseImages($root_path, $filename, $extension)  {
        $temp_dir = $this->createTempDir($root_path.$this->slash."TempDir");
        if (File::exists(Storage::disk('public')->path($root_path . $this->slash . $filename)))
            Storage::disk('public')->move($root_path . $this->slash . $filename, $temp_dir . $this->slash . $filename);
        $filename = $this->renameRootFile($temp_dir, $filename);
        if($extension === 'doc' || $extension === 'pdf' || $extension === 'docx' || $extension === 'zip' || $extension === 'rar')
            $this->setExecCommand($temp_dir, $filename, $extension);
        $this->getImagesFrom($root_path, $temp_dir, $filename, $extension);
    }

    private function getImagesFrom($root_path, $temp_dir, $filename, $type) {
        $this->searchAllFilesImagesForExtract($temp_dir);
        $this->deleteAllFilesForExtract($temp_dir, null, $filename);
        if($type === 'pdf')
            $this->binwalkNotFindImages($temp_dir, $filename);
        $this->copyAllFilesImagesForExtract($temp_dir, $root_path);
        $this->deleteAllFilesForExtract($temp_dir, 'yes');
    }

    private function binwalkNotFindImages($temp_dir, $filename) {
        $allFiles = Storage::disk('public')->allFiles($temp_dir);
        if (count($allFiles) <= 1) {
            $filename = Storage::disk('public')->path($temp_dir.$this->slash.$filename);
            $comm_dir = Storage::disk('public')->path($temp_dir) . $this->slash;
            $comm = "pdfimages -png ".$filename." ".$comm_dir;
            $this->execCommand($comm);
            $this->searchAllFilesImagesForExtract($temp_dir);
        }
    }

    private function setExecCommand($temp_dir, $filename, $extension, $comm = null) {
        $filename = Storage::disk('public')->path($temp_dir.$this->slash.$filename);
        $temp_dir = Storage::disk('public')->path($temp_dir) . $this->slash;
        switch ($extension) {
            case 'doc':
            case 'pdf':
                $comm = "binwalk --dd 'jpeg image:jpeg' --dd 'png image:png' --dd 'jpg image:jpg' --dd 'bmp image:bmp' " . $filename . " --directory " . $temp_dir . " --rm  --run-as=root";
                break;
            case 'docx':
            case 'zip':
            case 'rar':
                $comm = "unar -no-directory " . $filename . " -output-directory " . $temp_dir;
                break;
        }
        $this->execCommand($comm);
    }

    private function execCommand($comm = null) {
        if (!is_null($comm)) {
            try {
                exec(`$comm`);
            } catch (\Exception $exception) {
                //logger($exception);
            }
        }
    }

    private function searchAllFilesImagesForExtract($temp_dir)
    {
        foreach (Storage::disk('public')->allFiles($temp_dir) as $key => $object) {
            $path = str_replace($this->slash.File::basename($object),'', $object);
            $filename = $this->addNewExtension($path, File::basename($object));
            $filenameExtension = File::extension($filename) ? '.'.File::extension($filename) : File::extension($filename);
            $newName = 'image-'.$key.$this->getRandomNameWithTime().$filenameExtension;
            if ($this->is_image_extension($filename) && $this->is_image($path, $filename)){
                if (File::exists(Storage::disk('public')->path($temp_dir.$this->slash.$newName)))
                    $newName = 'image-'.$key.$this->getRandomNameWithTime().$filenameExtension;
                Storage::disk('public')->move($path.$this->slash.$filename, $temp_dir.$this->slash.$newName);
            }
        }
    }

    private function copyAllFilesImagesForExtract($temp_dir, $root_path)
    {
        foreach (Storage::disk('public')->allFiles($temp_dir) as $object) {
            if ($this->is_image_extension(File::basename($object)) && $this->is_image(str_replace($this->slash.File::basename($object),'', $object), File::basename($object)))
                Storage::disk('public')->move($object, $root_path.$this->slash.File::basename($object));
        }
    }

    private function deleteAllFilesForExtract($temp_dir, $delRootPath = null, $file = null)
    {
        foreach (Storage::disk('public')->allFiles($temp_dir) as $object) {
            $path = str_replace($this->slash.File::basename($object),'', $object);
            $filename = File::basename($object);
            if (!$this->is_image($path, $filename) && !$this->is_image_extension($filename) && $object !== $temp_dir.$this->slash.$file)
                Storage::disk('public')->delete($object);
        }
        foreach (Storage::disk('public')->allDirectories($temp_dir) as $object)
            Storage::disk('public')->deleteDirectory($object);
        if (is_null($file) && !is_null($delRootPath))
            Storage::disk('public')->deleteDirectory($temp_dir);
    }

    public function createPreview($path): array
    {
        $imageAssets = array();
        foreach (Storage::disk('public')->files($path) as $key => $object) {
            $path = str_replace($this->slash.File::basename($object),'', $object);
            $filename = File::basename($object);
            if ($this->is_image($path, $filename) && $this->is_image_extension($filename)) {
                $imageAssets[$key] = [
                    'main' => 'storage'.$this->slash.$path.$this->slash.$filename,
                    'preview' => 'storage'.$this->slash.$this->generatePreview($path, $filename)
                ];
            }
        }
        return $imageAssets;
    }

    public function generatePreview($path, $filename): string
    {
        $previewPath = $path . $this->slash . 'previews' . $this->slash;
        $thumbnail = Image::make(Storage::disk('public')->get($path . $this->slash . $filename))->fit(960, 480);
        Storage::disk('public')->put($previewPath . $filename, $thumbnail);
        $thumbnail->save(Storage::disk('public')->path($previewPath . $filename));
        return $previewPath . $filename;
    }

    private function renameRootFile($path, $filename): string
    {
        if (File::exists(Storage::disk('public')->path($path.$this->slash.$filename))) {
            $extension = File::extension($filename) ? '.'.File::extension($filename) : File::extension($filename);
            $newFilename = "file-".$this->getRandomNameWithTime().$extension;
            if (File::exists(Storage::disk('public')->path($path.$this->slash.$newFilename)))
                $newFilename = "file-".$this->getRandomNameWithTime().$extension;
            Storage::disk('public')->move($path.$this->slash.$filename, $path.$this->slash.$newFilename);
            return $newFilename;
        }
        return $filename;
    }

    private function getTimeNow(): string
    {
        return Carbon::now()->format('d-m-Y-H-i');
    }

    private function getRandomNameWithTime(): string
    {
        return Carbon::now()->valueOf().rand(0,100000);
    }

    public function is_image($path, $filename): bool
    {
        return Str::contains(Storage::disk('public')->mimeType($path.$this->slash.$filename), 'image');
    }

    public function is_image_extension($filename): bool
    {
        return in_array(strtolower(File::extension($filename)), array_map('strtolower', array("jpeg", "jpg", "png", "bmp")));
    }

    private function addNewExtension($path, $filename): string
    {
        $fullPath = Storage::disk('public')->path($path . $this->slash . $filename);
        $filenameWithoutExtension = File::name($filename);
        $fileGuessExtension = File::guessExtension($fullPath) ? '.'.File::guessExtension($fullPath) : File::guessExtension($fullPath);
        if ($filename !== $filenameWithoutExtension . $fileGuessExtension) {
            if (File::exists(Storage::disk('public')->path($path.$this->slash.$filenameWithoutExtension.$fileGuessExtension)))
                $filenameWithoutExtension .= $this->getRandomNameWithTime();
            Storage::disk('public')->move($path . $this->slash . $filename, $path . $this->slash . $filenameWithoutExtension . $fileGuessExtension);
        }
        return $filenameWithoutExtension . $fileGuessExtension;
    }
    public function createTempDir($path) {
        if (Storage::disk('public')->exists($path)) {
            if (File::isDirectory(Storage::disk('public')->path($path)))
                $this->deleteAllFilesForExtract($path, 'yes');
            else
                Storage::disk('public')->delete($path);
        }
        if (!Storage::disk('public')->exists($path))
            File::makeDirectory(Storage::disk('public')->path($path));
        return $path;
    }

    private function getContentWithCookiesFile($file) {
        $content = $this->getContentFile($file);
        preg_match_all('/(?<=a=toNumbers\(").*(?="\),b)|(?<=b=toNumbers\(").*(?="\),c)|(?<=c=toNumbers\(").*(?="\),now)/', $content, $matches);
        return $this->getContentFile($file, $matches[0][0],$matches[0][1], $matches[0][2]);
    }

    private function getContentFile($file, $a = '8b3d7f4e9ab55daee9fb89016f8a76a9', $b = 'a9ee0b0a96986edc98bfe6a739b457a6', $c = '535a97a4d149ee29ac533ad1ebf746d4') {
        $cookieService = new CookieService($a, $b, $c);
        $options = $cookieService->getFedresursHeadersOptions();
        $ch = curl_init($file);
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // added to return the response instead of printing it
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}
