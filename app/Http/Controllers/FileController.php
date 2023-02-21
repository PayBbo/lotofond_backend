<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\FileResource;
use App\Http\Services\Parse\FilesService;
use App\Models\Favourite;
use App\Models\Lot;
use App\Models\LotFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function storeFile(Request $request){
        $this->validate($request, [
            'fileType' => ['required', 'string'],
            'lotId'=>['required', 'integer', 'exists:lots,id']
        ]);
        if ($request->fileType == 'image') {
            $this->validate($request, [
                'file' => 'required|mimes:jpg,png,jpeg,bmp|max:10240'
            ]);
            if ($request->hasFile('file')) {
                $path = Storage::disk('public')->put('users/images/user-'.auth()->id(), $request->file);
                $fileService =new FilesService();
                $fileService->generatePreview('users/images/user-'.auth()->id(), basename($path));
                $preview = 'storage/users/images/user-'.auth()->id().'/previews/' . basename($path);
                $imageAssets = ['main' => 'storage/' . $path, 'preview' => $preview];
                if (!LotFile::where(['url' =>  $imageAssets, 'lot_id' => $request->lotId, 'type' => 'image'])->exists()) {
                    LotFile::create([
                        'url' => json_encode($imageAssets),
                        'type' => 'image',
                        'lot_id' => $request->lotId,
                        'user_id'=>auth()->id()
                    ]);
                }
            } else {
                throw new BaseException('ERR_IMAGE_UPLOAD', 422, __('validation.image_err'));
            }
        }
        if ($request->fileType == 'file') {
            if ($request->hasFile('file')) {
                $path = Storage::disk('public')->put('users/files/user-'.auth()->id(), $request->file);
                if (!LotFile::where(['url' => $path, 'lot_id' => $request->lotId, 'type' => 'file'])->exists()) {
                    LotFile::create([
                        'url' =>  'storage/' .$path,
                        'type' => 'file',
                        'lot_id' => $request->lotId,
                        'user_id'=>auth()->id()
                    ]);
                }
            } else {
                throw new BaseException('ERR_FILE_UPLOAD', 422,  __('validation.file_err'));
            }
        }

        return $this->getFiles($request->lotId);
    }

    public function deleteUserFile($id){
        $file = LotFile::find($id);
        if (!$file || $file->user_id != auth()->id()) {
            throw new BaseException("ERR_ACCESS_FORBIDDEN", 403, "The user does not have rights to edit the selected path");
        }
        $file->delete();
        return response(null, 200);
    }

    public function getFiles($lotId){
        $lot = Lot::find($lotId);
        if(!$lot){
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $lotId . ' does not exist');
        }
        return response(new FileResource($lot), 200);
    }

}
