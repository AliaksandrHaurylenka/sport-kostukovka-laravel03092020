<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class Gomelglass
 *
 * @package App
 * @property string $photo
 * @property text $description
 * @property string $sport
*/
class Gomelglass extends Model
{
    use SoftDeletes;

    protected $fillable = ['photo', 'description', 'sport'];
    protected $hidden = [];

    const PATH = '/images/gomelglasses/';

    //    БЛОК УДАЛЕНИЯ =====================================
    /**
     * Удаление фото при удалении записи в базе
     */
    public function removeImg()
    {
        if ($this->photo != null) {
            Storage::delete(Gomelglass::PATH . $this->photo);
        }
    }

    public function remove()
    {
        $this->removeImg();
        $this->forceDelete();
    }
    //    КОНЕЦ БЛОК УДАЛЕНИЯ =====================================
    
}
