<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LotUploadFileRequest;
use App\Http\Requests\Admin\UploadFileRequest;
use App\Http\Resources\FileResource;
use App\Http\Services\Parse\FilesService;
use App\Models\AdditionalLotInfo;
use App\Models\Lot;
use App\Models\LotFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(UploadFileRequest $request){
        $lotFile = new LotFile();
        $time = Carbon::now()->format('d-m-Y-H-i');
        if($request->type == 'additions'){
            $addition = AdditionalLotInfo::find($request->id);
            if(!$addition){
                return response(null, 404);
            }
            $lotFile->additional_lot_info_id = $addition->id;
            $lotFile->lot_id = $addition->lot_id;
            $dest = 'auction-files/auction-' . $addition->lot->auction_id .'/' . $time;
        }

        if($request->type == 'lot'){
            $lot = Lot::find($request->id);
            if(!$lot){
                return response(null, 404);
            }
            $lotFile->lot_id = $request->id;
            $dest = 'auction-files/auction-' . $lot->auction_id .'/' . $time;
        }
        if ($request->hasFile('image')) {
            $this->saveImage($dest, $request->image, $lotFile);
        }
        if ($request->hasFile('file')) {
            $this->saveFile($dest, $request->file, $lotFile);

        }
        return response(null, 200);
    }

    public function uploadLotFiles(LotUploadFileRequest $request)
    {
        try {
            ini_set('max_execution_time', 6000);
            $lot = Lot::find($request->lotId);
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach ($files as $file) {
                    $lotFile = new LotFile();
                    $lotFile->lot_id = $request->lotId;
                    $time = Carbon::now()->format('d-m-Y-H-i');
                    $dest = 'auction-files/auction-' . $lot->auction_id . '/' . $time;
                    $this->saveImage($dest, $file, $lotFile);
                }
            }

            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $file) {
                    $lotFile = new LotFile();
                    $lotFile->lot_id = $request->lotId;
                    $time = Carbon::now()->format('d-m-Y-H-i');
                    $dest = 'auction-files/auction-' . $lot->auction_id . '/' . $time;
                    $this->saveFile($dest, $file, $lotFile);
                }
            }
            return response(new FileResource($lot), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 500]);
        }
    }

    private function saveImage($dest, $image, $lotFile){
        $path = Storage::disk('public')->put($dest, $image);
        $fileService = new FilesService();
        $fileService->generatePreview($dest, basename($path));
        $preview = 'storage/' . $dest. '/previews/' . basename($path);
        $fileService->generateWatermark($path);
        $imageAssets = ['main' => 'storage/' . $path, 'preview' => $preview];
        $lotFile->type = 'image';
        $lotFile->url = json_encode($imageAssets);
        $lotFile->save();
    }

    private function saveFile($dest, $file, $lotFile)
    {
        $path = Storage::disk('public')->put($dest, $file);
        $isVideo = strtok($file->getClientMimeType(), '/') === 'video';
        $lotFile->type = $isVideo ? 'video' : 'file';
        $lotFile->url = 'storage/' . $path;
        if ($isVideo) {
            $imageAssets = ['main' => 'storage/' . $path, 'preview' => 'storage/watermark/video-preview.jpg'];
            $lotFile->type = 'video';
            $lotFile->url = json_encode($imageAssets);
        }
        $lotFile->save();
    }

    public function delete($id){
        $lotFile = LotFile::find($id);
        if (!$lotFile) {
            return response(null, 404);
        }
        $lot = Lot::find($lotFile->lot_id);
        $lotFile->delete();
        return response(new FileResource($lot), 200);
    }
}
