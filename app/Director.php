<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class Director
 *
 * @package App
 * @property string $name
 * @property string $photo
 * @property text $description
*/
class Director extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'photo', 'description', 'department'];
    protected $hidden = [];

    const PATH = '/images/directors/';

    //    БЛОК УДАЛЕНИЯ =====================================
    /**
     * Удаление фото при удалении записи в базе
     */
    public function removeImg()
    {
        if ($this->photo != null) {
            Storage::delete(Director::PATH . $this->photo);
        }
    }

    public function remove()
    {
        $this->removeImg();
        $this->forceDelete();
    }
    //    КОНЕЦ БЛОК УДАЛЕНИЯ =====================================
    
    
    
}
