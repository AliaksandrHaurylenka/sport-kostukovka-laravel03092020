<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.01.2019
 * Time: 20:37
 */

namespace App\Http\Controllers\Traits;


use Illuminate\Support\Facades\Storage;

trait FileDelTrait
{
//    БЛОК УДАЛЕНИЯ =====================================
    /**
     * Удаление фото при удалении записи из базы
     * @param $path - string: путь к файлу
     * @param $column - var: колонка в таблице
     */
    public function deleteImg($path, $column)
    {
        if ($column != null) {
            Storage::delete($path.$column);
        }
    }

    public function delFull($path, $column)
    {
        $this->deleteImg($path, $column);
        $this->forceDelete();
    }
    //    КОНЕЦ БЛОК УДАЛЕНИЯ =====================================
}