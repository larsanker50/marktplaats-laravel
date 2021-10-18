@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="{{ route('advertisement.index') }}">overview</a></li>
        <li><a href="{{ route('advertisement.create') }}">create advertisement</a></li>

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
    <p class="title">{{ $advertisement->title }}</p>
    <p>Seller: {{ $advertisement->user->username}} <a href="">message user</a></p>
    <p class="body">{{ $advertisement->body }}</p>
    @if ($advertisement->status == 'available')
        <p>Advertisement created at {{ $advertisement->created_at }}</p>
    @elseif ($advertisement->status == 'sold')
        <p>Advertisement sold at {{ $advertisement->updated_at }}</p>
    @endif
    </div>

    <div class="biddings">
        <p>Biddings:</p>
        @foreach ($biddings as $bidding)
        <p>{{ $bidding->user->username }} €{{ $bidding->bidding }} <a href="">message user</a></p>
        @endforeach
    </div>


    @endsection