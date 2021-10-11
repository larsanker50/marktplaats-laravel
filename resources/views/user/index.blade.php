@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="/"><b>home</b></a></li>
        <li><a href="/">login</a></li>
        <li><a href="user/create">create an account</a></li>
    </ul>
    @endsection    
    
    @section ('body')
    
    <p>welkom op de site Marktplaats</p>
    <a href="/">klik hier om in te loggen</a>

    @endsection
