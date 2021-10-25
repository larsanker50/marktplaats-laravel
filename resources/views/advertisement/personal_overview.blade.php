@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="{{ route('authentication.logout') }}">logout</a></li>
        <li><a href="{{ route('advertisement.index') }}">overview</a></li>
        <li><a href="{{ route('advertisement.create') }}">create advertisement</a></li>
        <li><b><a href="{{ route('advertisement.personal_index') }}">my advertisements</a></b></li>
    </ul>
    @endsection    
    
    @section ('body')

    <p>advertisements from you: {{ Session::get('current_username') }}</p>
    
    <p>overview personal advertisements</p>
  
    
    @foreach ($advertisements as $advertisement)

        @if ($advertisement->status == 'sold')
        <div class="advertisement sold">
        <p class="sold_text">SOLD, not available anymore</p>
        @elseif($advertisement->premium == true)
            <div class="advertisement premium">
        @elseif($advertisement->premium == false)
            <div class="advertisement">
        @endif
            <p class="title">{{ $advertisement->title }}</p>
            <p>Seller: {{ $advertisement->user->username}}</p>
            <p class="body">{{ $advertisement->body }}</p>
            @if ($advertisement->status == 'available')
            <p>Advertisement created at {{ $advertisement->created_at }}</p>
            @elseif ($advertisement->status == 'sold')
            <p>Advertisement sold at {{ $advertisement->updated_at }}</p>
            @endif
            <a href="{{ route('advertisement.show', ['advertisement' => $advertisement->id] ) }}">view advertisement details</a>
        </div>
    @endforeach

    @endsection