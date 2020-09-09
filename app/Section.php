<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;


/**
 * Class Section
 *
 * @package App
 * @property string $title
 * @property string $photo
 * @property text $description
*/
class Section extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['title', 'photo', 'description', 'photo_section_menu', 'description_main_page', 'photo_sport'];
    protected $hidden = [];

    const PATH = '/images/sections/';

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


    
    public function coaches() {
        return $this->hasMany(Coach::class);
    }

    
    public function posts() {
        return $this->hasMany(Post::class);
    }

    
    public function pride() {
        return $this->hasMany(Pride::class);
    }


    
    
    
}
