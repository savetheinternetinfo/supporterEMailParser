@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="nav nav-tabs" id="mailTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="personen-tab" data-toggle="tab" href="#personen" role="tab">Personen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="organisationen-tab" data-toggle="tab" href="#organisationen" role="tab">Organisationen</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="mailsTabContent">
                        <div class="tab-pane fade show active" id="personen" role="tabpanel">
                            @include('fetchedEmails', ['mails' => $mails])
                        </div>
                        
                        <div class="tab-pane fade" id="organisationen" role="tabpanel">
                            @include('fetchedEmails', ['mails' => $persMails])
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
