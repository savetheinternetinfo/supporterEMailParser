<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FetchedEmails extends Model
{
    protected $table = 'fetchedEmails';
    protected $fillable = ['name', 'mail', 'title', 'body', 'type'];

    const UNREAD_EMAIL = 0;
    const DECLINED_EMAIL = 1;
    const ACCEPTED_EMAIL = 2;

    const TYPE_ORGA = 0;
    const TYPE_PERSON = 1;


    public static function addEmail(string $name, string $mail, string $title, string $body, int $type)
    {
        return self::create([
            'name' => $name,
            'mail' => $mail,
            'title' => $title,
            'body' => $body,
            'type' => $type
        ]);
    }

    public static function getUnreadOrgaMails()
    {
        return self::where(['status' => self::UNREAD_EMAIL, 'type' => self::TYPE_ORGA])->get();
    }

    public static function getUnreadPersonMails()
    {
        return self::where(['status' => self::UNREAD_EMAIL, 'type' => self::TYPE_PERSON])->get();
    }

    public function getAttachments()
    {
        return $this->hasMany('App\EMailAttachments');
    }
}
