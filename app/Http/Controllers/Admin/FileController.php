<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadFileRequest;
use App\Http\Services\Parse\FilesService;
use App\Models\AdditionalLotInfo;
use App\Models\Lot;
use App\Models\LotFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            $path = Storage::disk('public')->put($dest, $request->image);
            $fileService = new FilesService();
            $fileService->generatePreview($request->file('image'),
                $dest. '/previews/' . basename($path));
            $preview = 'storage/' . $dest. '/previews/' . basename($path);
            $imageAssets = ['main' => 'storage/' . $path, 'preview' => $preview];
            $lotFile->type = 'image';
            $lotFile->url = json_encode($imageAssets);
            $lotFile->save();
        }
        if ($request->hasFile('file')) {
            $path = Storage::disk('public')->put($dest, $request->file);
            $lotFile->type = 'file';
            $lotFile->url = 'storage/' . $path;
            $lotFile->save();

        }
        return response(null, 200);
    }

    public function delete($id){
        $lotFile = LotFile::find($id);
        if (!$lotFile) {
            return response(null, 404);
        }
        $lotFile->delete();
        return response(null, 200);
    }
}
