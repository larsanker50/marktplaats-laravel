@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="/"><b>home</b></a></li>
        <li><a href="{{ route('authentication.login') }}">login</a></li>
        <li><a href="{{ route('user.create') }}">create an account</a></li>
    </ul>
    @endsection    
    
    @section ('body')
    
    <p>welkom op de site Marktplaats</p>

    @endsection
