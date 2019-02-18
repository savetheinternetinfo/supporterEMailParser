<?php

namespace App\Http\Controllers;

use App\FetchedEmails;
use App\Http\Requests\AddSupporterOrgaRequest;
use App\Http\Requests\AddSupporterPersonRequest;
use App\Supporters;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        return view('home', ['mails' => $data, 'persMails' => $data2]);
    }

    public function addSupporterOrga(AddSupporterOrgaRequest $request)
    {
        $saveLocation = storage_path().'/app/';
        $fileName = str_replace(' ', '_', $request->input('name').'_'.Carbon::now());
        $request->file('logo')->move($saveLocation, $fileName);
        Supporters::addOrgaSupporter($request->input('name'), $saveLocation);

        return redirect()->back();
    }

    public function addSupporterPerson(AddSupporterPersonRequest $request)
    {
        Supporters::addPersonSupporter($request->input('name'));
        return redirect()->back();
    }
}
