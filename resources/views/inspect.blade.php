@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row h-100 align-middle">
                            <div class="col-md"><h2>{{$mail->name}}</h2></div>
                            <div class="col-md text-right my-auto"><a class="" href="mailto:{{$mail->mail}}">{{$mail->mail}}</a></div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h3>{{$mail->title}}</h3>
                        <p>{{$mail->body}}</p>
                        
                        <div class="form-inline float-right">
                            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#acceptModal">Accept</button>
                            
                            <form class="form-inline" action="{{route('declineSupporter')}}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$mail->id}}"/>
                                <button type="submit" class="btn btn-danger">Decline</button>
                            </form>
                        </div>
                    </div>
                    
                    
                    <!-- Modal -->
                    <div class="modal fade" id="acceptModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{$mail->name}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @if ($mail->type)
                                    <form class="form" action="{{route('addSupporterPerson')}}" method="post">
                                @else
                                    <form class="form" action="{{route('addSupporterOrga')}}" method="post" enctype="multipart/form-data">
                                @endif
                                        <div class="modal-body">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required/>
                                        @if(!$mail->type)
                                            <label for="logo" class="mt-3">Upload logo:</label>
                                            <input type="file" class="form-control-file" id="logo" name="logo" accept="image/jpeg,image/gif,image/svg+xml,image/png" required/>
                                        @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary  mr-2" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{$mail->id}}"/>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->
                </div>
            </div>
        </div>
    </div>
@endsection
