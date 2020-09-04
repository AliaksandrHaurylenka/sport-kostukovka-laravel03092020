<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * Class Category
 *
 * @package App
 * @property string $title
 * @property string $slug
*/
class Category extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['title'];
    protected $hidden = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function coaches() {
        return $this->hasMany(Coach::class);
    }
}
