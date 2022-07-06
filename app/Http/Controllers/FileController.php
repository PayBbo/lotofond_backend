<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
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
                $fileService->generatePreview($request->file('file'),
                    '\\users\images\\user-'.auth()->id(). '\\previews\\' . $request->file('file')->getClientOriginalName());
                $preview = 'storage/' . $path . '/previews/' . $request->file('file')->getClientOriginalName();
                $imageAssets = ['main' => 'storage/' . $path, 'preview' => $preview];
                if (!LotFile::where(['url' => implode(",", $imageAssets), 'lot_id' => $request->lotId, 'type' => 'image'])->exists()) {
                    LotFile::create([
                        'url' => implode(",", $imageAssets),
                        'type' => 'image',
                        'lot_id' => $request->lotId,
                        'user_id'=>auth()->id()
                    ]);
                }
                return response(null, 200);
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
                return response(null, 200);
            } else {
                throw new BaseException('ERR_FILE_UPLOAD', 422,  __('validation.file_err'));
            }
        }
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
        $userFiles = null;
        if(auth()->check()){
            $userFiles= $lot->userLotFiles()->select('id', 'url')->get();
        }
        $files =$lot->lotFiles()->pluck('url');
        return response(['files'=>$files, 'userFiles'=>$userFiles], 200);
    }

}
