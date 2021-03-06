@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="{{ route('authentication.logout') }}">logout</a></li>
        <li><b><a href="{{ route('advertisement.index', ['page_number' => 1]) }}">overview</a></b></li>
        <li><a href="{{ route('advertisement.create') }}">create advertisement</a></li>
        <li><a href="{{ route('advertisement.personal_index') }}">my advertisements</a></li>
    </ul>

    <form id="search" action="/advertisement/search" method="GET">
        @csrf
        <input type="search" id="search" name="search" placeholder="Search...">
        <select name="rubric" id="rubric">
            <option value="all">Rubric...</option>
            <?php
                foreach ($rubrics as $rubric) {
                print '<option value="' . $rubric->id . '">' . $rubric->name . '</option>';   
                }
            ?>
        </select>
        <select name="distance" id="distance">
            <option value="all">Distance...</option>
            <option value="5">5 km</option>
            <option value="10">10 km</option>
            <option value="15">15 km</option>
            <option value="25">25 km</option>
            <option value="50">50 km</option>
            <option value="100">100 km</option>
            <option value="150">150 km</option>
        </select>
        <button>Search</button>
    </form>
    @endsection    
    
    @section ('body')

    <p>welkom {{ Session::get('current_username') }}</p>
    
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
            <a href="{{ route('advertisement.show', ['advertisement' => $advertisement->id] ) }}">view advertisement details</a>
        </div>
    @endforeach


    @csrf
    @php
        $i = 0
    @endphp
    @foreach ($all_advertisements as $advertisement)
    @if ($loop->index % 10 == 0 )
    @php
        $i++
    @endphp
        <button><a href="{{ route('advertisement.index', ['page_number' => $i] ) }}">{{$i}}</a></button>
    @endif
    @endforeach

    @endsection