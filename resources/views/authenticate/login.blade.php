@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="/">home</a></li>
        <li><b><a href="{{ route('authentication.login') }}">login</a></b></li>
        <li><a href="{{ route('user.create') }}">create an account</a></li>
    </ul>
    @endsection    
    
    @section ('body')
    {{ $errors->first('username') }}
    <br>
    <form action="/authentication/authenticate" method="post">
        @csrf
        <div>
            <input class ="input" type="text" name="username" id="username" placeholder="username" required>
            
        </div>
        <div>
            <input class ="input" type="text" name="password" id="password" placeholder="password" required>
        </div>
      
        <input class ="input" type="submit" value="submit">
    </form>

    @endsection