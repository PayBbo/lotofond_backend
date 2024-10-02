<?php

namespace App\Http\Services\Parse;

use App\Models\Setting;
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
        $filename = substr(File::name($filename), 0, 200) . '.' . $extension;
        $time = $this->getTimeNow();
        $root_path = 'auction-files' . $this->slash . 'auction-' . $auction->id . $this->slash . $time;
        if (!File::exists(Storage::disk('public')->path($root_path . $this->slash . $filename)))
            Storage::disk('public')->put($root_path . $this->slash . $filename, base64_decode($invitation[$prefix . 'Attach'][$prefix . 'Blob']));
        if ($isImages) {
            logger('Images from type ' . $extension);
            logger('Auction id: ' . $auction->id);
            $this->parseImages($root_path, $filename, $extension);
            $files = $this->createPreview($root_path);
            logger('----------------------');
        }
        else
            $files = ['storage' . $this->slash . $root_path . $this->slash . $filename];
        return $files;
    }

    public function downloadFileByLink($arrayFiles, $auctionId, $is_content=false): array
    {
        $time = $this->getTimeNow();
        $root_path = 'auction-files' . $this->slash . 'auction-' . $auctionId . $this->slash . $time;
        $images = array();
        $files = array();
        $hasImages = false;
        foreach ($arrayFiles as $file) {
            $content = $is_content ? $file['content'] : $this->getContentWithCookiesFile($file['link']);
            $filename = str_replace(' ', '-', $file['filename']);
            $filenameExtension = File::extension($filename) ? '.' . File::extension($filename) : File::extension($filename);
            $extension = File::extension($filename);
            $filename = substr(File::name($filename), 0, 200) . $filenameExtension;
            if (mb_stripos($filename, 'фото') !== false || $this->is_image_extension($filename)) {
                logger('LINKS. Images from type ' . $extension);
                logger('Auction id: ' . $auctionId);
                Storage::disk('public')->put($root_path . $this->slash . $filename, $content);
                $this->parseImages($root_path, $filename, $extension);
                $hasImages = true;
                logger('----------------------');
            } else {
                Storage::disk('public')->put($root_path . $this->slash . $filename, $content);
                $files[] = 'storage' . $this->slash . $root_path . $this->slash . $filename;
                try {
                    if($extension == 'pdf') {
                        logger('LINKS. PDF from type ' . $extension);
                        $pages = $this->convertPdfToImage($root_path . $this->slash . $filename, $root_path, $filename.'_');
                        if(count($pages)) {
                            foreach ($pages as $page) {
                                $pageFilename = substr(File::name($page), 0, 200) . '.jpg';
                                $this->parseImages(
                                    'auction-files/auction-15/14-08-2024-21-22',
                                    $pageFilename,
                                    'jpg');
                            }
                        }
                    }
                }
                catch (\Exception $e) {
                    logger('PDF error ' . $e->getMessage());
                }
            }
        }
        if ($hasImages)
            $images = $this->createPreview($root_path);
        return ['images' => $images, 'files' => $files];
    }

    public function parseImages($root_path, $filename, $extension)
    {
        $temp_dir = $this->createTempDir($root_path . $this->slash . "TempDir");
        if (File::exists(Storage::disk('public')->path($root_path . $this->slash . $filename)))
            Storage::disk('public')->move($root_path . $this->slash . $filename, $temp_dir . $this->slash . $filename);
        $filename = $this->renameRootFile($temp_dir, $filename);
        if ($extension === 'doc' || $extension === 'pdf' || $extension === 'docx' || $extension === 'zip' || $extension === 'rar')
            $this->setExecCommand($temp_dir, $filename, $extension);
        $this->getImagesFrom($root_path, $temp_dir, $filename, $extension);
    }

    private function getImagesFrom($root_path, $temp_dir, $filename, $type)
    {
        $this->searchAllFilesImagesForExtract($temp_dir);
        $this->deleteAllFilesForExtract($temp_dir, null, $filename);
        /*if ($type === 'pdf')
            $this->binwalkNotFindImages($temp_dir, $filename);*/
        $this->copyAllFilesImagesForExtract($temp_dir, $root_path);
        $this->deleteAllFilesForExtract($temp_dir, 'yes');
    }

   /* private function binwalkNotFindImages($temp_dir, $filename)
    {
        $allFiles = Storage::disk('public')->allFiles($temp_dir);
        if (count($allFiles) <= 1) {
            $filename = Storage::disk('public')->path($temp_dir . $this->slash . $filename);
            $comm_dir = Storage::disk('public')->path($temp_dir) . $this->slash;
            $comm = "pdfimages -all " . $filename . " " . $comm_dir;
            $this->execCommand($comm);
            $this->searchAllFilesImagesForExtract($temp_dir);
        }
    }*/

    private function setExecCommand($temp_dir, $filename, $extension, $comm = null)
    {
        $filename = Storage::disk('public')->path($temp_dir . $this->slash . $filename);
        $temp_dir = Storage::disk('public')->path($temp_dir) . $this->slash;
        switch ($extension) {
            case 'doc':
                $comm = "binwalk --dd 'jpeg image:jpeg' --dd 'png image:png' --dd 'jpg image:jpg' --dd 'bmp image:bmp' " . $filename . " --directory " . $temp_dir . " --rm  --run-as=root";
                break;
            case 'pdf':
                $comm = "pdfimages -all " . $filename . " " . $temp_dir;
                break;
            case 'docx':
            case 'zip':
            case 'rar':
                $comm = "unar -no-directory " . $filename . " -output-directory " . $temp_dir;
                break;
        }
        $this->execCommand($comm);
    }

    private function execCommand($comm = null)
    {
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
            $path = dirname($object);
            $filename = $this->addNewExtension($path, File::basename($object));
            $filenameExtension = File::extension($filename) ? '.' . File::extension($filename) : File::extension($filename);
            $newName = 'image-' . $key . $this->getRandomNameWithTime() . $filenameExtension;
            if ($this->is_image_extension($filename) && $this->is_image($path, $filename)) {
                if (File::exists(Storage::disk('public')->path($temp_dir . $this->slash . $newName)))
                    $newName = 'image-' . $key . $this->getRandomNameWithTime() . $filenameExtension;
                Storage::disk('public')->move($path . $this->slash . $filename, $temp_dir . $this->slash . $newName);
            }
        }
    }

    private function copyAllFilesImagesForExtract($temp_dir, $root_path)
    {
        foreach (Storage::disk('public')->allFiles($temp_dir) as $object) {
            if ($this->is_image_extension(File::basename($object)) && $this->is_image(dirname($object), File::basename($object))) {
                Storage::disk('public')->move($object, $root_path . $this->slash . File::basename($object));
            }
        }
    }

    private function deleteAllFilesForExtract($temp_dir, $delRootPath = null, $file = null)
    {
        foreach (Storage::disk('public')->allFiles($temp_dir) as $object) {
            $path = dirname($object);
            $filename = File::basename($object);
            if (!$this->is_image($path, $filename) && !$this->is_image_extension($filename) && $object !== $temp_dir . $this->slash . $file)
                Storage::disk('public')->delete($object);
        }
        foreach (Storage::disk('public')->allDirectories($temp_dir) as $object)
            Storage::disk('public')->deleteDirectory($object);
        if (is_null($file) && !is_null($delRootPath))
            Storage::disk('public')->deleteDirectory($temp_dir);
    }

    public function createPreview($path): array
    {
        logger('createPreview '.$path);
        $imageAssets = array();
        foreach (Storage::disk('public')->files($path) as $key => $object) {
            $path = dirname($object);
            $filename = File::basename($object);
            logger('createPreview $filename '.$filename);
            if ($this->is_image($path, $filename) && $this->is_image_extension($filename)) {
                $imageAssets[$key] = [
                    'main' => 'storage' . $this->slash . $path . $this->slash . $filename,
                    'preview' => 'storage' . $this->slash . $this->generatePreview($path, $filename)
                ];
                $this->generateWatermark($path . $this->slash . $filename);
            }
        }
        logger('end createPreview');
        return $imageAssets;
    }

    public function generatePreview($path, $filename, $isUserFile = false): string
    {
        logger('generatePreview '.$filename);
        $previewPath = $path . $this->slash . 'previews' . $this->slash;
        $thumbnail = Image::make(Storage::disk('public')->get($path . $this->slash . $filename))->fit(960, 480);
        Storage::disk('public')->put($previewPath . $filename, $thumbnail);
        $thumbnail->save(Storage::disk('public')->path($previewPath . $filename));
        if (!$isUserFile)
            $this->generateWatermark($previewPath . $filename);
        logger('end generatePreview');
        return $previewPath . $filename;
    }

    public function generateWatermark($img) {
        logger('generateWatermark '.$img);
            $thumbnail = Image::make(Storage::disk('public')->get($img));
            $thumbnailWidth = $thumbnail->getWidth();
            $thumbnailHeight = $thumbnail->getHeight();
            if ($thumbnailWidth > $thumbnailHeight)
                $waterMarkSize = (int)($thumbnailHeight * 0.15);
            else
                $waterMarkSize = (int)($thumbnailHeight * 0.1);
            if($thumbnailWidth == 0 || $thumbnailHeight == 0)
                return;
            $settings = Setting::all()->pluck('value', 'variable')->toArray();
        logger('center generateWatermark ');
            $waterMarkUrl = Image::make(Storage::disk('public')->path('watermark/' . $settings['watermark_image']))->fit($waterMarkSize, $waterMarkSize);
            $thumbnail->insert($waterMarkUrl, 'bottom-left', 10, 10);
            $fontSize = $waterMarkSize / 4;
            // Создаем копию изображения, ограниченную границами левой нижней части
            $leftBottomImage = Image::make(Storage::disk('public')->get($img));
            $bottom = $waterMarkSize + 10;
            $left = $thumbnailWidth;
            if ($thumbnailWidth > $thumbnailHeight)
                $left = (int)($left * 0.15);
            else
                $left = (int)($left * 0.1);
            $colors = [];
            $leftBottomImage = $leftBottomImage->crop($left, $bottom, $waterMarkSize + 10, $thumbnailHeight - $waterMarkSize - 10);
            for ($x = 0; $x < $leftBottomImage->getWidth() - 1; $x++) {
                for ($y = 0; $y < $leftBottomImage->getHeight() - 1; $y++) {
                    $color = $leftBottomImage->pickColor($x, $y, 'array');
                    $colorString = sprintf('#%02x%02x%02x', $color[0], $color[1], $color[2]);
                    $colors[] = $colorString;
                }
            }
            // Считаем количество каждого уникального цвета в массиве
            $colorCounts = array_count_values($colors);
            // Находим самый распространенный цвет
            arsort($colorCounts);
            $mainColor = key($colorCounts);
            // Конвертируем цвет из RGB в HSL
            list($r, $g, $b) = sscanf($mainColor, "#%02x%02x%02x");
            $hsl = $this->rgbToHsl($r, $g, $b);
            // Определяем, светлое это изображение или темное
            if ($hsl[2] >= 0.5) {
                $textColor = '#2953ff';
            } else {
                $textColor = '#FFFFFF';
            }
            $x = $waterMarkSize + 10;
            $y = $thumbnailHeight - 10 - ($waterMarkSize / 2) + ($fontSize / 2);
            $text = $settings['watermark_text'];
            $thumbnail->text($text, $x, $y, function ($font) use ($fontSize, $textColor) {
                $font->file(Storage::disk('public')->path('watermark/Inter-Bold.ttf'));
                $font->size($fontSize);
                $font->color($textColor);
                $font->align('left');
                $font->valign('middle');
            });
            Storage::disk('public')->put($img, $thumbnail);
            $thumbnail->save(Storage::disk('public')->path($img));
        logger('end generateWatermark ');
    }

    // Функция для конвертирования цвета из RGB в HSL
    private function rgbToHsl($r, $g, $b) {
        $r /= 255;
        $g /= 255;
        $b /= 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        $h = 0;
        $s = 0;
        $l = ($max + $min) / 2;

        if ($max == $min) {
            $h = $s = 0;
        } else {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

            switch ($max) {
                case $r:
                    $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
                    break;
                case $g:
                    $h = ($b - $r) / $d + 2;
                    break;
                case $b:
                    $h = ($r - $g) / $d + 4;
                    break;
            }

            $h /= 6;
        }

        return array($h, $s, $l);
    }

    private function renameRootFile($path, $filename): string
    {
        if (File::exists(Storage::disk('public')->path($path . $this->slash . $filename))) {
            $extension = File::extension($filename) ? '.' . File::extension($filename) : File::extension($filename);
            $newFilename = "file-" . $this->getRandomNameWithTime() . $extension;
            if (File::exists(Storage::disk('public')->path($path . $this->slash . $newFilename)))
                $newFilename = "file-" . $this->getRandomNameWithTime() . $extension;
            Storage::disk('public')->move($path . $this->slash . $filename, $path . $this->slash . $newFilename);
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
        return Carbon::now()->valueOf() . rand(0, 100000);
    }

    public function is_image($path, $filename): bool
    {
        return Str::contains(Storage::disk('public')->mimeType($path . $this->slash . $filename), 'image');
    }

    public function is_image_extension($filename): bool
    {
        return in_array(strtolower(File::extension($filename)), array_map('strtolower', array("jpeg", "jpg", "png", "bmp")));
    }

    private function addNewExtension($path, $filename): string
    {
        $fullPath = Storage::disk('public')->path($path . $this->slash . $filename);
        $filenameWithoutExtension = File::name($filename);
        $fileGuessExtension = File::guessExtension($fullPath) ? '.' . File::guessExtension($fullPath) : File::guessExtension($fullPath);
        if ($filename !== $filenameWithoutExtension . $fileGuessExtension) {
            if (File::exists(Storage::disk('public')->path($path . $this->slash . $filenameWithoutExtension . $fileGuessExtension)))
                $filenameWithoutExtension .= $this->getRandomNameWithTime();
            Storage::disk('public')->move($path . $this->slash . $filename, $path . $this->slash . $filenameWithoutExtension . $fileGuessExtension);
        }
        return $filenameWithoutExtension . $fileGuessExtension;
    }

    public function createTempDir($path)
    {
        if (Storage::disk('public')->exists($path)) {
            if (File::isDirectory(Storage::disk('public')->path($path)))
                $this->deleteAllFilesForExtract($path, 'yes');
            else
                Storage::disk('public')->delete($path);
        }
        if (!Storage::disk('public')->exists($path))
            File::makeDirectory(Storage::disk('public')->path($path), 0755, true);
        return $path;
    }

    private function getContentWithCookiesFile($file)
    {
        $content = $this->getContentFile($file);
        preg_match_all('/(?<=a=toNumbers\(").*(?="\),b)|(?<=b=toNumbers\(").*(?="\),c)|(?<=c=toNumbers\(").*(?="\),now)/', $content, $matches);
        return $this->getContentFile($file, $matches[0][0], $matches[0][1], $matches[0][2]);
    }

    private function getContentFile($file, $a = '8b3d7f4e9ab55daee9fb89016f8a76a9', $b = 'a9ee0b0a96986edc98bfe6a739b457a6', $c = '535a97a4d149ee29ac533ad1ebf746d4')
    {
        $cookieService = new CookieService($a, $b, $c);
        $options = $cookieService->getFedresursHeadersOptions();
        $ch = curl_init($file);
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // added to return the response instead of printing it
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    public function convertPdfToImage($pathToPdf, $pathToStorage, $prefix='') {
        $pathToPdf = Storage::disk('public')->path($pathToPdf);
        $pathToStorage = \storage_path('app' . $this->slash . 'public' . $this->slash .$pathToStorage);
        $pdf = new \Spatie\PdfToImage\Pdf($pathToPdf);
        return $pdf->saveAllPagesAsImages($pathToStorage, $prefix);
    }
}
