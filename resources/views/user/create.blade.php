@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="/">home</a></li>
        <li><a href="{{ route('authentication.login') }}">login</a></li>
        <li><a href="{{ route('user.create') }}"><b>create an account</b></a></li>
    </ul>
    @endsection    
    
    @section ('body')
    
    <form action="{{ route('user.store') }}" method="post">
    @csrf
    <p><b>personal info:</b></p>
    <p>email*:</p>
    <div>
        <input class ="input" type="text" name="email" id="email" placeholder="email" value="{{ old('email') }}" >
        <p class="help is-danger">{{ $errors->first('email') }}</p>
    </div>
    <p>username*:</p>
    <div>
        <input class ="input" type="text" name="username" id="username" placeholder="username" value="{{ old('username') }}" >
        <p class="help is-danger">{{ $errors->first('username') }}</p>
    </div>
    <p>password*:</p>
    <div>
        <input class ="input" type="text" name="password" id="password" placeholder="password" value="{{ old('password') }}" >
        <p class="help is-danger">{{ $errors->first('password') }}</p>
    </div>
    <p><b>residence:</b></p>
    <p>house number*:</p>
    <div>
        <input class ="input" type="text" name="house_number" id="house_number" placeholder="house number" value="{{ old('house_number') }}" >
        <p class="help is-danger">{{ $errors->first('house_number') }}</p>
    </div>
    <p>street name*:</p>
    <div>
        <input class ="input" type="text" name="street_name" id="street_name" placeholder="street name" value="{{ old('street_name') }}" >
        <p class="help is-danger">{{ $errors->first('street_name') }}</p>
    </div>
    <p>unit, or apartment:</p>
    <div>
        <input class ="input" type="text" name="unit_or_apt" id="unit_or_apt" placeholder="unit, or apt (optional)" value="{{ old('unit_or_apt') }}">
        <p class="help is-danger">{{ $errors->first('unit_or_apt') }}</p>
    </div>
    <p>city or town*:</p>
    <div>
        <input class ="input" type="text" name="city" id="city" placeholder="city, or town" value="{{ old('city') }}" >
        <p class="help is-danger">{{ $errors->first('city') }}</p>
    </div>
    <p>postal code*:</p>
    <div>
        <input class ="input" type="text" name="postal_code" id="postal_code" placeholder="postal code" value="{{ old('postal_code') }}" >
        <p class="help is-danger">{{ $errors->first('postal_code') }}</p>
    </div>

   <p><i>* is required</i></p>
    <input class ="input" type="submit" value="submit">

    </form>

    @endsection