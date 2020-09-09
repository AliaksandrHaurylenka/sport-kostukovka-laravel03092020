<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


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
}
