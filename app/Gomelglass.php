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
}
