@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="{{ route('advertisement.index') }}">overview</a></li>
        <li><b><a href="{{ route('advertisement.create') }}">create advertisement</a></b></li>

    </ul>
    @endsection    
    
    @section ('body')

    <form action="/advertisement/store" method="post">
    @csrf
    <p>title</p>
    <div>
        <input class ="input" type="text" name="title" id="title" placeholder="title" value="{{ old('title') }}">
        <p class="help is-danger">{{ $errors->first('title') }}</p>
    </div>
    <p>body</p>
    <div>
        <textarea class ="input" type="text" name="body" id="body" placeholder="Write here your body." value="{{ old('body') }}"> </textarea>
        <p class="help is-danger">{{ $errors->first('body') }}</p>
    </div>
    <p>rubric</p>
    <div>        
        @foreach ($rubrics as $rubric)
        
        <input type="checkbox" class ="input" id="{{ $rubric->name }}" name="rubric[]" value="{{ $rubric->id }}">
        <label for="{{ $rubric->name }}">{{ $rubric->name }}</label><br>
        @endforeach

        <input class ="input" type="text" name="new_rubric" class ="input" placeholder="Add a new rubric">
        <p class="help is-danger">{{ $errors->first('new_rubric') }}</p>

    </div>
    <p>premium advertisement?</p>
    <div>
        <input class ="input" type="checkbox" name="premium" id="premium" placeholder="premium" value="true">
        <p class="help is-danger">{{ $errors->first('premium') }}</p>
    </div>  
    <br>
    <input class ="input" type="submit" value="submit">
</form>

    @endsection