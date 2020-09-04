<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class History
 *
 * @package App
 * @property string $title
 * @property string $photo
 * @property text $description
*/
class History extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'photo', 'description'];
    protected $hidden = [];

    const PATH = '/images/history/';

    //    БЛОК УДАЛЕНИЯ =====================================
    /**
     * Удаление фото при удалении записи в базе
     */
    public function removeImg()
    {
        if ($this->photo != null) {
            Storage::delete(History::PATH . $this->photo);
        }
    }

    public function remove()
    {
        $this->removeImg();
        $this->forceDelete();
    }
    //    КОНЕЦ БЛОК УДАЛЕНИЯ =====================================
    
}
