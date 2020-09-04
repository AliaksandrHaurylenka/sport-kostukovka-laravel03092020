<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class Main
 *
 * @package App
 * @property string $photo
*/
class Main extends Model
{
    use SoftDeletes;

    protected $fillable = ['photo', 'description', 'block', 'class', 'position', 'for_indicators'];
    protected $hidden = [];

    const PATH = '/images/main/';

    //    БЛОК УДАЛЕНИЯ =====================================
    /**
     * Удаление фото при удалении записи в базе
     */
    public function removeImg()
    {
        if ($this->photo != null) {
            Storage::delete(Main::PATH . $this->photo);
        }
    }

    public function remove()
    {
        $this->removeImg();
        $this->forceDelete();
    }
    //    КОНЕЦ БЛОК УДАЛЕНИЯ =====================================
    
    
}
