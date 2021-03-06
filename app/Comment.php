<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected static $commentAbleFor = ['Post'];
    protected $guarded = [];
    protected $hidden = ['email', 'ip'];
    protected $appends = ['email_md5', 'ip_md5'];

    public function getEmailMd5Attribute()
    {
        return md5($this->attributes['email']);
    }
    public function getIpMd5Attribute()
    {
        return md5($this->attributes['ip']);
    }

    public static function allFor($model_id, $model)
    {
        $records =  self::where(['comment_id' => $model_id, 'comment_type' => $model])->get();
        $comments = [];
        $by_id = [];
        foreach ($records as $record)
        {
            if ($record->reply)
            {
                $by_id[$record->reply]->attributes['replies'][] = $record;
            }
            else
            {
                $record->attributes['replies'] = [];
                $by_id[$record->id] = $record;
                $comments[] = $record;
            }
        }
        return  array_reverse($comments);
    }

    public static function isCommentAble($model, $model_id)
    {
        if(!in_array($model, self::$commentAbleFor))
        {
            return false;
        }
        else
        {
            $model = "\\App\\$model";
            return $model::where(['id' => $model_id])->exists();
        }
    }
}
