@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="{{ route('advertisement.index') }}">overview</a></li>
        <li><a href="{{ route('advertisement.create') }}">create advertisement</a></li>
        <li><a href="{{ route('advertisement.personal_index') }}">my advertisements</a></li>

    </ul>
    @endsection    
    
    @section ('body')
  
    @if ($advertisement->status == 'sold')
        <div class="advertisement sold">
            <p class="sold_text">SOLD, not available anymore</p>
    @elseif($advertisement->premium == true)
        <div class="advertisement premium">
    @elseif($advertisement->premium == false)
        <div class="advertisement">
    @endif

        <p class="title">{{ $advertisement->title }}
        </p>
        <p>Seller: {{ $advertisement->user->username}} 
        @if ($advertisement->user->id !== Session::get('current_user_id'))
            <a href="{{ route('message.index', ['user' => $advertisement->user_id] ) }}">message user</a></p>
        @endif

        <p class="body">{{ $advertisement->body }}</p>
        @if ($advertisement->status == 'available')
            <p>Advertisement created at {{ $advertisement->created_at }}</p>
        @elseif ($advertisement->status == 'sold')
            <p>Advertisement sold at {{ $advertisement->updated_at }}</p>
        @endif
        @if ($advertisement->user->id === Session::get('current_user_id'))
        <a href="{{ route('advertisement.edit', ['advertisement' => $advertisement->id] ) }}">edit advertisement</a> | 
        <a href="{{ route('advertisement.destroy', ['advertisement' => $advertisement->id] ) }}">delete advertisement</a>
        @endif
    </div>

    <div class="biddings">
        <p>Biddings:</p>
        @foreach ($biddings as $bidding)
        <p>{{ $bidding->user->username }} €{{ $bidding->bidding }} 
        @if ($bidding->user->id !== Session::get('current_user_id'))    
        <a href="{{ route('message.index', ['user' => $bidding->user->id] ) }}">message user</a></p>
        @elseif ($bidding->user->id === Session::get('current_user_id'))
        | <a href="{{ route('bidding.destroy', ['advertisement' => $advertisement->id, 'bidding' => $bidding->id] ) }}">delete bidding</a></p>
        @endif

        @endforeach
        <p>submit a bidding:</p>
        <form action="{{ route('bidding.store', ['advertisement' => $advertisement->id] ) }}" method="post">
        @csrf
        <div>
            <input type="text" id="bidding" name="bidding">
        </div>
        <p class="help is-danger">{{ $errors->first('bidding') }}</p>
        <input class ="input" type="submit" value="submit bidding">
        </form>
        <p>please use a ',' and 2 decimal places</p>
    </div>


    @endsection