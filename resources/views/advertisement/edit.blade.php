@extends ('layout.app')

    @section ('header')

    <ul>
        <li><a href="{{ route('authentication.logout') }}">logout</a></li>
        <li><a href="{{ route('advertisement.index', ['page_number' => 1]) }}">overview</a></li>
        <li><a href="{{ route('advertisement.create') }}">create advertisement</a></li>
        <li><a href="{{ route('advertisement.personal_index') }}">my advertisements</a></li>
    </ul>
    @endsection    
    
    @section ('body')

    <form action="{{ route('advertisement.update', ['advertisement' => $advertisement->id] )}}" method="post">
    @csrf
    <p>title</p>
    <div>
        <input class ="input" type="text" name="title" id="title" placeholder="title" value="{{  old('title', $advertisement->title) }}">
        <p class="help is-danger">{{ $errors->first('title') }}</p>
    </div>
    <p>body</p>
    <div>
        <textarea class ="input" type="text" name="body" id="body" placeholder="Write here your body.">{{  old('body', $advertisement->body) }}</textarea>
        <p class="help is-danger">{{ $errors->first('body') }}</p>
    </div>
    <p>rubric</p>
    <div>        
        @foreach ($rubrics as $rubric)
        
        <input type="checkbox" class ="input" id="{{ $rubric->name }}" name="rubric[]" value="{{ $rubric->id }}"
        <?php
        $checked = false;

        foreach ($advertisement->rubric as $advertisement_rubric) {
            if ($rubric->id == $advertisement_rubric->id) {
                $checked = true;
            }
        }
        if ($checked == true) {
            print 'checked="true"';
        }
        ?>
        >
        <label for="{{ $rubric->name }}">{{ $rubric->name }}</label><br>
        @endforeach

        <input class ="input" type="text" name="new_rubric" class ="input" placeholder="Add a new rubric">
        <p class="help is-danger">{{ $errors->first('new_rubric') }}</p>

    </div>
    <p>status:</p>
    <div>
        <select name="status" id="status">
            <option value="available" <?php if($advertisement->status == 'available') {print 'selected';} ?>>available</option>
            <option value="sold" <?php if($advertisement->status == 'sold') {print 'selected';} ?>>sold</option>
        </select>
    </div>

    <p>premium advertisement?</p>
    <div>
        <input class ="input" type="checkbox" name="premium" id="premium" placeholder="premium" value="true"
        <?php
        if ($advertisement->premium) {
            print 'checked="true"';
        }
        ?> 
        >
        <p class="help is-danger">{{ $errors->first('premium') }}</p>
    </div>  
    <br>
    <input class ="input" type="submit" value="submit">
</form>

    @endsection