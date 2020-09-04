<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

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

//   БЛОК УДАЛЕНИЯ =====================================
    /**
     * Удаление фото при удалении записи в базе
     */
    public function removeImg()
    {
        if ($this->photo || $this->photo_section_menu || $this->photo_sport != null) {
            Storage::delete([
            	'/images/sections/' . $this->photo,
            	'/images/sections/' . $this->photo_section_menu,
            	'/images/sections/' . $this->photo_sport
            ]);
        }
    }

    public function remove()
    {
        $this->removeImg();
        $this->forceDelete();
    }
//    КОНЕЦ БЛОК УДАЛЕНИЯ =====================================

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coaches() {
        return $this->hasMany(Coach::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts() {
        return $this->hasMany(Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pride() {
        return $this->hasMany(Pride::class);
    }


    
    
    
}
