<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class Board
 *
 * @package App
 * @property string $name
 * @property string $photo
 * @property text $description
*/
class Board extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'photo', 'description'];
    protected $hidden = [];

    const PATH = '/images/board/';

    //    БЛОК УДАЛЕНИЯ =====================================
    /**
     * Удаление фото при удалении записи в базе
     */
    public function removeImg()
    {
        if ($this->photo != null) {
            Storage::delete(Board::PATH . $this->photo);
        }
    }

    public function remove()
    {
        $this->removeImg();
        $this->forceDelete();
    }
    //    КОНЕЦ БЛОК УДАЛЕНИЯ =====================================
    
}
