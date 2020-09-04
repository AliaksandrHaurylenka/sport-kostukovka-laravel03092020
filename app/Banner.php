<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class Banner
 *
 * @package App
 * @property string $banner
 * @property string $link
*/
class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = ['banner', 'link'];
    protected $hidden = [];

    const PATH = '/images/links/';

    //    БЛОК УДАЛЕНИЯ =====================================
    /**
     * Удаление фото при удалении записи в базе
     */
    public function removeImg()
    {
        if ($this->banner != null) {
            Storage::delete(Banner::PATH . $this->banner);
        }
    }

    public function remove()
    {
        $this->removeImg();
        $this->forceDelete();
    }
    //    КОНЕЦ БЛОК УДАЛЕНИЯ =====================================
    
}
