<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FoldersSystem extends Model
{
    //    Работа с файловой структурой проекта
    /**
     * Метод для добавления номера папки изображений поста
     * Используется в views->posts->create.blade.php
     * @param $rule - прописывается в контроллере
     * @return mixed
     */
    public static function folder_id($rule)
    {
        $folder_id = $rule;

        return $folder_id;
    }

    /**
     * Создание папки поста
     * для того, чтобы загрузить туда фото
     * Используется в PostsController->create()
     * @param $path
     * @param $rule
     * @return mixed
     */
    public static function add_folder_for_img($path, $rule)
    {
        $folder_id = self::folder_id($rule);
        $folder = Storage::makeDirectory($path.$folder_id);

        return $folder;
    }

    /**
     * Добавление папки поста при редактировании
     * @param $id - приходит с конроллера
     * @param $path
     * @param $rule
     * @return mixed
     */
    public static function add_folder_for_img_edit($id, $path, $rule)
    {
//        $folder_id = $rule;
        $folder_id = $rule->value('folder');
        $folder = Storage::makeDirectory($path.$folder_id);

        return $folder;
    }

    /**
     * Удаление папки поста если она пустая
     * @param $path
     */
    public static function del_dir_if_empty($path)
    {
        $directories = Storage::directories($path);
        for ($i=0; $i<count($directories); $i++)
        {
            if ([] === (array_diff(scandir($directories[$i]), array('.', '..'))))
            {
                rmdir($directories[$i]);
            }
        }
    }

    /**
     * Remove empty directories
     * @ param string $root Directory path
     * @ param bool $remove_root Also remove root
     * @param $root
     * @param bool $remove_root
     */
    /*function rmdir_empty($root, $remove_root = false)
    {
        //$root = Storage::directories($root);
        if ($root AND is_dir($root))
        {
            foreach (scandir($root) AS $file)
            {
                if ($file == '.' OR $file == '..')
                    continue;

                if (is_dir($root . DIRECTORY_SEPARATOR . $file))
                    rmdir_empty($root . DIRECTORY_SEPARATOR . $file, true);
            }

            if ($remove_root)
                @rmdir($root);

        }
    }*/

    /**
     * Удаление папки поста с изображениями
     * при полном удалении поста
     * @param $id
     * @param $table
     * @param $path
     */
    public static function del_folder_img($id, $table, $path)
    {
        $folder = DB::table($table)->where('id', $id)->value('folder');
//        dd($folder);
        Storage::deleteDirectory($path.$folder);
    }


//=============================================

//========== ПАПКИ ПОЛЬЗОВАТЕЛЯ ===============
    /**
     * @param $path
     * @param $rule
     * @return mixed
     */
    public static function add_folder_user($path, $rule)
    {
        $folder_user = self::folder_id($rule);
        $folder = Storage::makeDirectory($path.$folder_user);

        return $folder;
    }

    public static function add_folder_user_img($path, $rule)
    {
        $folder_user = self::folder_id($rule);
        $folder = Storage::makeDirectory($path.$folder_user);

        return $folder;
    }

//========== КОНЕЦ ПАПКИ ПОЛЬЗОВАТЕЛЯ =========
}
