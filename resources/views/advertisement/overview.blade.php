@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="/">overview</a></li>

    </ul>
    @endsection    
    
    @section ('body')

    <p>welkom</p>
    
    <p>overview</p>
  
    
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
            <a href="/">view advertisement details</a>
        </div>
    @endforeach

    @endsection