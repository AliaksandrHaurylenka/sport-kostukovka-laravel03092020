<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class Timetable
 *
 * @package App
 * @property string $photo
 * @property text $timetable
*/
class Timetable extends Model
{
    use SoftDeletes;

    protected $fillable = ['photo', 'timetable'];
    protected $hidden = [];

    //    БЛОК УДАЛЕНИЯ =====================================
    /**
     * Удаление фото при удалении записи в базе
     */
    public function removeImg()
    {
        if ($this->photo != null) {
            Storage::delete('/images/timetable/' . $this->photo);
        }
    }

    public function remove()
    {
        $this->removeImg();
        $this->forceDelete();
    }
    //    КОНЕЦ БЛОК УДАЛЕНИЯ =====================================
    
}
