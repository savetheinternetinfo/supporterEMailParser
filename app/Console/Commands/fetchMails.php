<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Client;
use App\FetchedEmails;

class fetchMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches Emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client([
            'host'          => env('MAIL_ORGA_HOST'),
            'port'          => env('MAIL_ORGA_PORT'),
            'encryption'    => env('MAIL_ORGA_ENCRYPTION'),
            'validate_cert' => env('MAIL_ORGA_VALIDATE_CERT'),
            'username'      => env('MAIL_ORGA_USERNAME'),
            'password'      => env('MAIL_ORGA_PASSWORD'),
            'protocol'      => env('MAIL_ORGA_PROTOCOL')
        ]);

        $client->connect();

        $folders = $client->getFolders('INBOX');

        foreach ($folders as $folder)
        {
            if(strpos($folder->path, 'INBOX'))
            {
                $msg = $folder->getMessages('UNSEEN');
                foreach ($msg as $m)
                {
                    $senderInfo = array_pop($m->sender);
                    $m->setFlag('SEEN');
                    FetchedEmails::addEmail($senderInfo->personal, $senderInfo->mail,
                        $m->getSubject(), \Soundasleep\Html2Text::convert($m->getHTMLBody(true), ['ignore_errors' => true]),
                        FetchedEmails::TYPE_ORGA);
                }


            }
        }


        $client = new Client([
            'host'          => env('MAIL_PERSON_HOST'),
            'port'          => env('MAIL_PERSON_PORT'),
            'encryption'    => env('MAIL_PERSON_ENCRYPTION'),
            'validate_cert' => env('MAIL_PERSON_VALIDATE_CERT'),
            'username'      => env('MAIL_PERSON_USERNAME'),
            'password'      => env('MAIL_PERSON_PASSWORD'),
            'protocol'      => env('MAIL_PERSON_PROTOCOL')
        ]);

        $client->connect();

        $folders = $client->getFolders('INBOX');

        foreach ($folders as $folder)
        {
            if(strpos($folder->path, 'INBOX'))
            {
                $msg = $folder->getMessages('UNSEEN');
                foreach ($msg as $m)
                {
                    $senderInfo = array_pop($m->sender);
                    $m->setFlag('SEEN');
                    FetchedEmails::addEmail($senderInfo->personal, $senderInfo->mail,
                        $m->getSubject(), \Soundasleep\Html2Text::convert($m->getHTMLBody(true), ['ignore_errors' => true]),
                        FetchedEmails::TYPE_PERSON);
                }

            }
        }
    }
}
