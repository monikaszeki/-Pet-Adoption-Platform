@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center font-weight-bold">
                       Edit Pet
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(isset($pet))
                            <form name="add-blog-post-form" id="add-blog-post-form" method="POST" action="{{url(route('update', ['id' => $pet->id]))}}">
                                <input name="_method" type="hidden" value="PATCH">
                                <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                                @else
                                <form name="add-blog-post-form" id="add-blog-post-form" method="POST" action="{{url(route('store'))}}">
                        @endif
                            @csrf
                            <div class="form-group">
                                <label for="name">Pet's name</label>
                                <input type="text" id="name" name="name" class="form-control" required="" value="{{ isset($pet) ? $pet->name : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" id="age" name="age" class="form-control" required="" value="{{ isset($pet) ? $pet->age : '' }}" >
                            </div>
                            <div class="form-group">
                                <label for="species">Species</label>
                                <select name="species" class="form-select"  id="species">
                                    <option value='dog' {{ (isset($pet) && $pet->species === 'dog')  ? 'selected' : ''}}>Dog</option>
                                    <option value='cat'  {{ (isset($pet) && $pet->species === 'cat')  ? 'selected' : ''}}>Cat</option>
                                    <option value='bird'  {{ (isset($pet) && $pet->species === 'bird')  ? 'selected' : ''}}>Bird</option>
                                    <option value='other'  {{ (isset($pet) && $pet->species === 'other')  ? 'selected' : ''}}>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="breed">Breed</label>
                                <input type="text" id="breed" name="breed" class="form-control" required="" value="{{ isset($pet) ? $pet->breed : '' }}" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea name="description" class="form-control" required="">
                                    {{ isset($pet) ? $pet->description : "" }}
                                </textarea>
                            </div>
                            <div style="margin-top: 15px">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                <a class="btn btn-primary btn-sm" href="{{ url(route('pets'))}}">Back to my pet's list</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
