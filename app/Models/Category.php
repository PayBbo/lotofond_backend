<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['label'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'label',
        'parent_id',
        'code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
    ];

    public function lotCategories()
    {
        return $this->belongsToMany(Lot::class,'lot_categories');
    }

    public function parent(){
        return Category::find($this->parent_id);
    }

    public function subcategories(){
        return Category::where('parent_id', $this->id)->get();
    }
}
