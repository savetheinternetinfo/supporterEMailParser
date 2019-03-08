<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webklex\IMAP\Attachment;

class EMailAttachments extends Model
{
    protected $table = 'emailAttachments';
    protected $fillable = ['path', 'type', 'file_name', 'mime_type', 'disposition', 'id', 'content_type', 'file_extension'];

    public static function addAttachment(Attachment $attachment, string $path)
    {
        $attachment->save($path, $attachment->getName());
        return self::create([
            'path' => $path,
            'file_name' => $attachment->getName(),
            'type' => $attachment->getType(),
            'mime_type' => $attachment->getMimeType(),
            'disposition' => $attachment->getDisposition(),
            'id' => $attachment->getId(),
            'content_type' => $attachment->getContentType(),
            'file_extension' => $attachment->getExtension()
        ]);
    }

    public function getEmail()
    {
        return $this->belongsTo('App\FetchedEmails');
    }
}
