<?php

namespace App\Console;

use App\EMailAttachments;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Webklex\IMAP\Attachment;
use Webklex\IMAP\Client;
use App\FetchedEmails;
use Webklex\IMAP\Message;
use Webklex\IMAP\Support\FolderCollection;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $this->addUnseenOrgaEmails($this->getOrgaEmailFolders());
            $this->addUnseenPersonEmails($this->getPersonEmailFolders());
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * @param FolderCollection $folders
     * @throws \Soundasleep\Html2TextException
     * @throws \Webklex\IMAP\Exceptions\ConnectionFailedException
     */
    private function addUnseenPersonEmails(FolderCollection $folders)
    {
        $this->addUnseenEmailsByType($folders, FetchedEmails::TYPE_PERSON);
    }

    /**
     * @param FolderCollection $folders
     * @throws \Soundasleep\Html2TextException
     * @throws \Webklex\IMAP\Exceptions\ConnectionFailedException
     */
    private function addUnseenOrgaEmails(FolderCollection $folders)
    {
        $this->addUnseenEmailsByType($folders, FetchedEmails::TYPE_ORGA);
    }

    /**
     * @param FolderCollection $folders
     * @param int $type
     * @throws \Soundasleep\Html2TextException
     * @throws \Webklex\IMAP\Exceptions\ConnectionFailedException
     */
    private function addUnseenEmailsByType(FolderCollection $folders, int $type)
    {
        foreach ($folders as $folder) {
            if (strpos($folder->path, 'INBOX')) {
                $msg = $folder->getMessages('UNSEEN');
                foreach ($msg as $m) {
                    $senderInfo = array_pop($m->sender);
                    /** @var \Webklex\IMAP\Message $m */
                    $m->setFlag('SEEN');
                    FetchedEmails::addEmail($senderInfo->personal, $senderInfo->mail,
                        $m->getSubject(), \Soundasleep\Html2Text::convert($m->getHTMLBody(true), ['ignore_errors' => true]),
                        $type);
                    $this->saveEmailAttachmentsIfPresent($m);
                }


            }
        }
    }

    /**
     * @return FolderCollection
     * @throws \Webklex\IMAP\Exceptions\ConnectionFailedException
     */
    private function getOrgaEmailFolders()
    {
        $client = new Client([
            'host' => env('MAIL_ORGA_HOST'),
            'port' => env('MAIL_ORGA_PORT'),
            'encryption' => env('MAIL_ORGA_ENCRYPTION'),
            'validate_cert' => env('MAIL_ORGA_VALIDATE_CERT'),
            'username' => env('MAIL_ORGA_USERNAME'),
            'password' => env('MAIL_ORGA_PASSWORD'),
            'protocol' => env('MAIL_ORGA_PROTOCOL')
        ]);

        $client->connect();

        return $folders = $client->getFolders('INBOX');
    }

    /**
     * @return FolderCollection
     * @throws \Webklex\IMAP\Exceptions\ConnectionFailedException
     */
    private function getPersonEmailFolders()
    {
        $client = new Client([
            'host' => env('MAIL_PERSON_HOST'),
            'port' => env('MAIL_PERSON_PORT'),
            'encryption' => env('MAIL_PERSON_ENCRYPTION'),
            'validate_cert' => env('MAIL_PERSON_VALIDATE_CERT'),
            'username' => env('MAIL_PERSON_USERNAME'),
            'password' => env('MAIL_PERSON_PASSWORD'),
            'protocol' => env('MAIL_PERSON_PROTOCOL')
        ]);

        $client->connect();

        return $folders = $client->getFolders('INBOX');
    }

    private function saveEmailAttachmentsIfPresent(Message $m)
    {
        if ($m->hasAttachments()) {
            $aAttachment = $m->getAttachments();
            foreach ($aAttachment as $oAttachment){
                /** @var \Webklex\IMAP\Attachment $oAttachment */
                $path = $m->getMessageId();
                EMailAttachments::addAttachment($oAttachment, $path);
            }
        }
    }

}
