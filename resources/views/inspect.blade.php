@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                            <p>{{$mail->id}}</p>
                            <p>{{$mail->name}}</p>
                            <p>{{$mail->mail}}</p>
                            <p>{{$mail->title}}</p>
                            <p>{{$mail->body}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
