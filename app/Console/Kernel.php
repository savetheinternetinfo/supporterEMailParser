<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Webklex\IMAP\Client;
use App\FetchedEmails;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
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
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
