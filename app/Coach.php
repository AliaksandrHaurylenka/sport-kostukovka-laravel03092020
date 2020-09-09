<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class Coach
 *
 * @package App
 * @property string $name
 * @property string $photo
 * @property text $description
 * @property integer $sport_section
 * @property string $work
*/
class Coach extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'photo', 'description', 'section_id', 'work'];
    protected $hidden = [];

    const PATH = '/images/coaches/';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * https://laravel.com/docs/5.7/eloquent-relationships
     */
    public function section()
    {
        //связь один к одному
        return $this->belongsTo(Section::class);
    }
    /**
     * @return string
     * Если категория есть,
     * то выводим название категории,
     * иначе "Нет категории"
     * Используется в views->admin->coaches->index
     */
    public function getSectionTitle()
    {
        return ($this->section != null) ? $this->section->title : 'Вид спорта?';
    }
    /**
     * @return null
     * Используется в views->admin->coaches->edit,
     * т.е при редактировании поста выводит категорию
     */
    public function getSectionID()
    {
        return $this->section != null ? $this->section->id : null;
    }
    
}
