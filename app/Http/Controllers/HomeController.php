<?php

namespace App\Http\Controllers;

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
        $saveLocation = storage_path().'/app/public';
        $fileName = str_replace(' ', '_', $request->input('name').'_'.Carbon::now());
        $request->file('logo')->move($saveLocation, $fileName);
        $url = Storage::url($fileName);
        Supporters::addOrgaSupporter($request->input('name'), $url);
        FetchedEmails::where('id', $request->input('id'))->update([
            'status' => FetchedEmails::ACCEPTED_EMAIL,
        ]);

        return redirect()->back();
    }

    public function addSupporterPerson(AddSupporterPersonRequest $request)
    {
        Supporters::addPersonSupporter($request->input('name'));
        FetchedEmails::where('id', $request->input('id'))->update([
            'status' => FetchedEmails::ACCEPTED_EMAIL,
        ]);
        return redirect()->back();
    }

    public function declineSupporter(DeclineRequest $request)
    {
        FetchedEmails::where('id', $request->input('id'))->update([
            'status' => FetchedEmails::DECLINED_EMAIL
        ]);
        return redirect()->back();
    }

    public function inspect($id)
    {
        $mail = FetchedEmails::find($id);
        return view('inspect', ['mail' => $mail]);
    }




}
