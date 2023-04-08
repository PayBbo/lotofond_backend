<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddEditNewsRequest;
use App\Http\Resources\Admin\NewsCollection;
use App\Http\Resources\Admin\NewsResource;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:news-list', ['only' => ['get']]);
        $this->middleware('permission:news-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:news-add', ['only' => ['add']]);
        $this->middleware('permission:news-delete', ['only' => ['delete']]);
    }

    public function get(Request $request)
    {
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        $news = News::when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
            $query->orderBy($sortParam, $sortDirection);
        })
            ->paginate(20);
        return response(new NewsCollection($news), 200);
    }

    public function edit($id)
    {
        $news = News::find($id);
        if (!$news) {
            return response(null, 404);
        }
        return response(new NewsResource($news), 200);
    }

    public function add(AddEditNewsRequest $request)
    {
        $news = new News();
        $news->description = $request->description;
        $news->is_banner = isset($request->isBanner);
        $news->created_at = Carbon::now()->setTimezone('Europe/Moscow');
        $news->save();
        if ($request->hasFile('imageBinary')) {
            $news->image = $this->changeImage($news, $request->imageBinary);
            $news->save();
        }
        return response(null, 200);

    }

    public function update(AddEditNewsRequest $request)
    {
        $news = News::find($request->id);
        if (!$news) {
            return response(null, 404);
        }
        $news->description = $request->description;
        $news->is_banner = isset($request->isBanner);
        if (strlen($request->image) == 0 && !is_null($news->image)) {
            $this->changeImage($news);
            $news->image = null;
        }
        if ($request->hasFile('imageBinary')) {
            $news->image = $this->changeImage($news, $request->imageBinary);
        }
        $news->created_at = Carbon::now()->setTimezone('Europe/Moscow');
        $news->save();
        return response(null, 200);

    }

    public function changeStatus($id)
    {
        $news = News::find($id);
        if ($news) {
            $news->is_banner = !$news->is_banner;
            $news->save();
            return response(null, 200);
        }
        return response(null, 404);
    }

    public function delete($id)
    {
        $news = News::find($id);
        if (!$news) {
            return response(null, 404);
        }
        $news->delete();
        return response(null, 200);
    }

    private function changeImage($news, $image = null)
    {
        if (!is_null($news->image)) {
            $slash = DIRECTORY_SEPARATOR;
            $path = \storage_path('app' . $slash . 'public' . $slash . stristr($news->image, 'news'));
            File::delete($path);
        }
        if (!is_null($image)) {
            $path = Storage::disk('public')->put('news/item-' . $news->id, $image);
            return 'storage/' . $path;
        }
        return null;
    }
}
