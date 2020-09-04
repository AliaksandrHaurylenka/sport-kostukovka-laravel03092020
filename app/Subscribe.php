<?php
namespace App;

use App\Notifications\NewEvent;
use App\Notifications\NewComment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Illuminate\Notifications\Notifiable;
use Notification;

/**
 * Class Subscribe
 *
 * @package App
 * @property string $email
 * @property string $token
*/
class Subscribe extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = ['email', 'token'];
    protected $hidden = [];


    public static function add($email)
    {
        $sub = new static;
        $sub->email = $email;
        $sub->save();

        return $sub;
    }

    public function generateToken()
    {
        $this->token = str_random(100);
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    /**
     * @return mixed
     */
    public static function viewSubscriber()
    {
        $obj = Auth::user();
//        dd($obj);

        if(!empty($obj)){
            $email = $obj->email;
//            dd($email);
            return self::where('email', $email)->first();
        }

    }

    /**
     * Отправляет всем пользователям увдомление о новом посте
     * @param $event
     */
    public static function allSubscribe($event)
    {
        Notification::send(Subscribe::all(), new NewEvent($event));
    }

    /**
     * Отправка почты пользователям, либо админу
     * в зависимости от статуса поста
     * @param $event
     * @return
     */
    public static function mailNotification($event)
    {
        if($event->status){
            Subscribe::allSubscribe($event);
        }

//        dd($event->folder);
        $folder = $event->folder;
        return $folder;
    }


    /**
     * Отправляет всем пользователям увдомление о новом комментарии
     * @param $comment
     */
    public static function allSubscribeComment($comment)
    {
        Notification::send(Subscribe::all(), new NewComment($comment));
    }

    /**
     * Отправка почты пользователям
     * в зависимости от статуса 
     * @param $comment
     * @return
     */
    public static function mailNotificationComment($comment)
    {
        if($comment->status){
            Subscribe::allSubscribeComment($comment);
        }
    }
}
