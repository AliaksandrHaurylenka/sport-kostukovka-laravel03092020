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
}
