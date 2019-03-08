<?php

namespace App\Http\Controllers;

use App\EMailAttachments;
use App\FetchedEmails;
use App\Http\Requests\AddSupporterOrgaRequest;
use App\Http\Requests\AddSupporterPersonRequest;
use App\Http\Requests\DeclineRequest;
use App\Supporters;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = FetchedEmails::getUnreadOrgaMails();
        $data2 = FetchedEmails::getUnreadPersonMails();
        return view('home', ['mails' => $data2, 'persMails' => $data]);
    }

    public function addSupporterOrga(AddSupporterOrgaRequest $request)
    {
        $extension = '.'.$request->file('logo')->getClientOriginalExtension();
        $saveLocation = storage_path().'/app/public';
        $fileName = str_replace(' ', '_', str_replace('/', '', $request->input('name')).'_'.Carbon::now()->toDateString().$extension);
        $fileName = str_replace('#', '', $fileName);
        $request->file('logo')->move($saveLocation, $fileName);
        $url = Storage::url($fileName);
        Supporters::addOrgaSupporter($request->input('name'), $url, $request->input('id'), $request->input('url'));
        FetchedEmails::where('id', $request->input('id'))->update([
            'status' => FetchedEmails::ACCEPTED_EMAIL,
        ]);

        return redirect()->route('home');
    }

    public function addSupporterPerson(AddSupporterPersonRequest $request)
    {
        Supporters::addPersonSupporter($request->input('name'), $request->input('id'));
        FetchedEmails::where('id', $request->input('id'))->update([
            'status' => FetchedEmails::ACCEPTED_EMAIL,
        ]);
        return redirect()->route('home');
    }

    public function declineSupporter(DeclineRequest $request)
    {
        FetchedEmails::where('id', $request->input('id'))->update([
            'status' => FetchedEmails::DECLINED_EMAIL
        ]);
        return redirect()->route('home');
    }

    public function inspect($id)
    {
        $mail = FetchedEmails::find($id);
        return view('inspect', ['mail' => $mail]);
    }

    public function saveAttachment($mail_id, $attachment_id)
    {
        $attachment = EMailAttachments::find($attachment_id);
        $path = $attachment->path;
        $file = $attachment->file_name . "." . $attachment->file_extension;
        Storage::download($path . "/" . $file);
        return redirect()->route('inspect', ['id' => $mail_id]);
    }



}
