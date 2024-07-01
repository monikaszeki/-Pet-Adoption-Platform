@extends('layouts.app')

@section('content')
    @auth
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            @if($pets && $pets->isNotEmpty())
                                <h2>My pets</h2>
                                <ul class="list-group">
                                    @foreach($pets as $pet)
                                        <li class="list-group-item d-flex">
                                            <div class="p-0 m-0 flex-grow-1">
                                                {{ $pet->name  }}
                                            </div>
                                            <a class="btn btn-outline-primary btn-sm" style="margin-right: 5px" href="{{ url(route('updatePetList', ['petId' => $pet->id])) }}">Edit</a>
                                            <a class="btn btn-outline-primary btn-sm" href="{{ url(route('delete', ['petId' => $pet->id])) }}">Delete</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>I don't have any pets!</p><br>
                            @endif
                            <a class="btn btn-primary btn-sm" style="margin-top: 15px;" href="{{ url(route('createPetList'))}}">Add new pet</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth
@endsection

