@if ($mails->isEmpty())
    <ul class="list-group">
        <li class="list-group-item"><b>Nobody here but us chickens.</b></li>
    </ul>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th><th>E-Mail</th><th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($mails as $mail)
            <tr>
                <td>{{$mail->name}}</td>
                <td><a href="mailto:{{$mail->mail}}">{{$mail->mail}}</a></td>
                <td class="text-right"><a href="{{route('inspect', ['id' => $mail->id])}}" class="btn btn-primary" >Inspect</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif