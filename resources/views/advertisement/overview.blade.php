@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="/">overview</a></li>

    </ul>
    @endsection    
    
    @section ('body')

    <p>welkom</p>
    
    <p>overview</p>

    
    
    @foreach ($premium_advertisements as $premium_advertisement)

        <div class="advertisement premium">
            <p class="title">{{ $premium_advertisement->title }}</p>
            <p>Seller: {{ $premium_advertisement->user->username}}</p>
            <p class="body">{{ $premium_advertisement->body }}</p>
            <div class="rubric"> <p>Rubrics:
                @foreach ($premium_advertisement->rubric as $rubric)
                    {{ $rubric->name }}    
                @endforeach
            </p>
            </div>
            <p>Advertisement created at {{ $premium_advertisement->created_at }}</p>
            <a href="/">view advertisement details</a>
        </div>
    @endforeach

    
    
    @foreach ($advertisements as $advertisement)

        <div class="advertisement">
            <p class="title">{{ $advertisement->title }}</p>
            <p>Seller: {{ $advertisement->user->username}}</p>
            <p class="body">{{ $advertisement->body }}</p>
            <p>Advertisement created at {{ $advertisement->created_at }}</p>
            <a href="/">view advertisement details</a>
        </div>
    @endforeach

    @foreach ($sold_advertisements as $sold_advertisement)

        <div class="advertisement sold">
            <p class="sold_text">SOLD, not available anymore</p>
            <p class="title">{{ $sold_advertisement->title }}</p>
            <p>Seller: {{ $sold_advertisement->user->username}}</p>
            <p class="body">{{ $sold_advertisement->body }}</p>
            <p>Advertisement sold at {{ $sold_advertisement->updated_at }}</p>
            <a href="/">view advertisement details</a>
        </div>
    @endforeach

    @endsection