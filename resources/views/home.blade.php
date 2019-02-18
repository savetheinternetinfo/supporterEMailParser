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

                    @foreach($mails as $mail)
                        <p>{{$mail->name}}</p>
                        <p>{{$mail->mail}}</p>
                        <p>{{$mail->title}}</p>
                        <p>{{$mail->body}}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
