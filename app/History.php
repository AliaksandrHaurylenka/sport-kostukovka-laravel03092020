<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class History
 *
 * @package App
 * @property string $title
 * @property string $photo
 * @property text $description
*/
class History extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'photo', 'description'];
    protected $hidden = [];

    const PATH = '/images/history/';
    
}
