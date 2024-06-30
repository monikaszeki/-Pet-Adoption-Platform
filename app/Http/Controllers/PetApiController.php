<?php

namespace App\Http\Controllers;

use App\Http\Resources\PetApiResource;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class Pet
 * @author mSzekely
 * @package App\Models\
 */
class PetApiController extends Controller
{
    const HTTP_NO_CONTENT = '204 No Content';

    public function __construct()
    {
        $this->middleware(function($request,$next){
            Auth::user(); // here the user should exist from the session
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $pets = Pet::paginate();
        return PetApiResource::collection($pets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\PetApiResource
     */
    public function store(Request $request): PetApiResource
    {
        $this->validation($request);
        $pet = Pet::create($request->all());
        if ($pet) {
            DB::table('user_pets')->insert([
                //'user_id' => Auth::id(),
                'user_id' => 1,
                'pet_id' => $pet->id
            ]);
        }
        return new PetApiResource($pet);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \App\Http\Resources\PetApiResource
     */
    public function show(Pet $pet): PetApiResource
    {
        return new PetApiResource($pet);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pet  $pet
     * @return \App\Http\Resources\PetApiResource
     */
    public function update(Request $request, Pet $pet): PetApiResource
    {
        $pet->update($this->validation($request));
        return new PetApiResource($pet);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        $deletedConnection = DB::table('user_pets')
            ->where('user_id', '=', Auth::id())
            ->where('pet_id', '=', $pet->id)
            ->delete();
        $pet->delete();
        return response(null, self::HTTP_NO_CONTENT);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
}
