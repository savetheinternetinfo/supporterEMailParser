<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supporters extends Model
{
    protected $table = 'supporters';

    protected $fillable = ['name', 'logoURL', 'type'];

    public static function addOrgaSupporter(string $name, string $url, int $id)
    {
        return self::create([
            'logoURL' => $url,
            'name' => $name,
            'type' => FetchedEmails::TYPE_ORGA,
            'fetchedEmailsId' => $id
        ]);
    }

    public static function addPersonSupporter(string $name, int $id)
    {
        return self::create([
            'name' => $name,
            'type' => FetchedEmails::TYPE_PERSON,
            'fetchedEmailsId' => $id
        ]);
    }

    public static function getOrgaSupporters()
    {
        return self::where('type', FetchedEmails::TYPE_ORGA)->get();
    }

    public static function getPersonSupporters()
    {
        return self::where('type', FetchedEmails::TYPE_PERSON)->get();
    }
}
