<?php

namespace App\Http\Controllers\Admin\Obj;


use App\Http\Controllers\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Storage;


class CRUDFile extends CRUD
{
    use FileUploadTrait;

    private $nameTable;
    private $model;

    const DELETE = 'delete';
    const CREATE = 'create';
    const EDIT = 'edit';


    public function __construct($name, $model)
    {
        parent::__construct($name, $model);
        $this->nameTable = $name;
        $this->model = $model;
    }


    public function store($request)
    {
        $this->gate(self::CREATE);
        $request = $this->saveFiles($request, $this->model::PATH);
        $this->model::create($request->all());
    }


    public function update_file($request, $id, array $columns)
    {
        $this->gate(self::EDIT);
        $this->check_file($request, $id, $columns);
    }


    private function check_file($request, $id, array $columns)
    {
        $data = $this->model::findOrFail($id);

        foreach ($columns as $column) {
            if ($_FILES[$column]['name']) {
                $request = $this->saveFiles($request, $this->model::PATH);
                $this->removeFile($id, $column, $data);
            }
        }
        $data->update($request->all());
    }

    /**
     * Удаление фото при удалении записи в базе
     * Функция используется в update и perma_del
     * @param $id
     * @param $column
     * @param $method
     */
    private function removeFile($id, $column, $method)
    {
        $data = $method;
        if ($data->$column != null) {
            Storage::delete($this->model::PATH . $data->$column);
        }
    }


    public function perma_del_file($id, array $columns)
    {
        $this->gate(self::DELETE);

        $data = $this->model::onlyTrashed()->findOrFail($id);

        foreach ($columns as $column) {
            $this->removeFile($id, $column, $data);
            $data->forceDelete();
        }

    }

}
