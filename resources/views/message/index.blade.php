@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="{{ route('authentication.logout') }}">logout</a></li>
        <li><a href="{{ route('advertisement.index') }}">overview</a></li>
        <li><a href="{{ route('advertisement.create') }}">create advertisement</a></li>
        <li><a href="{{ route('advertisement.personal_index') }}">my advertisements</a></li>
    </ul>
    @endsection    
    
    @section ('body')

    <p>chatbox with {{ $user->username }}</p>

    @foreach ($messages as $message)

        <div
        @if ($message->from_user_id == $user->id)
            class="message received"
        @else
            class="message send"
        @endif
        >
        @if ($message->from_user_id == $user->id)
            <p><b>{{$user->username}}</b></p>
        @else
            <p><b>{{ Session::get('current_username') }}</b></p>
        @endif
            <p>time send: {{ $message->created_at }}</p>
            <div class="body">
                <p>{{ $message->body }}</p>
            </div>
            
        </div>
    @endforeach

    <div class="center">
        <p>submit a message:</p>
            <form action="{{ route('message.store', ['user' => $user->id] ) }}" method="post">
            @csrf
            <div>
                <textarea class ="input" type="text" name="body" id="body" value="{{ old('body') }}"> </textarea>
            </div>
            <p class="help is-danger">{{ $errors->first('message') }}</p>
            <input class ="input" type="submit" value="submit bidding">
            </form>
    </div>
    

        

    @endsection