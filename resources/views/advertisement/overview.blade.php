@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="/">overview</a></li>

    </ul>
    @endsection    
    
    @section ('body')
    
    <p>overview</p>

    
    
    @foreach ($premium_advertisements as $premium_advertisement)

        <div class="advertisement premium">
            <p class="title">{{ $premium_advertisement->title }}</p>
        </div>
    @endforeach

    
    
    @foreach ($advertisements as $advertisement)

        <div class="advertisement">
            <p class="title">{{ $advertisement->title }}</p>
        </div>
        </div>
    @endforeach

    @endsection