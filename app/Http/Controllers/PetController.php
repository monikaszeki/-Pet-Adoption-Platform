<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Throwable;

/**
 * Class Pet
 * @author mSzekely
 * @package App\Models\
 */
class PetController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request,$next){
            Auth::user(); // here the user should exist from the session
            return $next($request);
        });
    }
    /**
     * Get user pet's list
     * @return View
     * @params Request
     */
    public function index(Request $request): View
    {
        return view('pets.show')->with([
            'pets' => $this->getPetList()
        ]);
    }

    /**
     * Add pet to user pet's list
     * @return RedirectResponse
     * @params Request
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $params = $request->all();
            unset($params['_token']);

            $this->validation($request);

            DB::beginTransaction();

            $insertedId = DB::table('pets')->insertGetId($params);
            if ($insertedId) {
                DB::table('user_pets')->insert([
                    'user_id' => Auth::id(),
                    'pet_id' => $insertedId
                ]);
            }
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
        }
        return redirect(url('pets'));
    }
    /**
     * Update user's pet's data
     * @return RedirectResponse
     * @params Request
     * @throws Throwable
     */
    public function update(Request $request): RedirectResponse
    {
        $pet_id = $request->get('pet_id');
        $params = $request->all();
        try {
            $this->validation($request);
            Pet::findOrFail($pet_id)
                ->update($params);
            return redirect(url('pets'));
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
    /**
     * Get pets data to update
     * @return View
     * @params int $id
     */
    public function updatePetList(int $id=null): View
    {
        if($id !== null) {
            $pet = Pet::findOrFail($id);
            return view('pets.form')->with([
                'pet' => $pet
            ]);
        }
        return view('pets.form');
    }

    /**
     * Delete user pets list
     * @return View
     * @params int $pet_id
     * @throws Throwable
     */
    public function deletePetList(int $pet_id): View
    {
        if($pet_id !== null) {
            try {
                DB::beginTransaction();
                $deletedConnection = DB::table('user_pets')
                    ->where('user_id', '=', Auth::id())
                    ->where('pet_id', '=', $pet_id)
                    ->delete();
                if($deletedConnection){
                   $pet = Pet::findOrFail($pet_id)->delete();
                }
                DB::commit();
            } catch (Throwable $exception) {
                DB::rollBack();
            }
        }
        return View('pets.show')->with([
            'pets' => $this->getPetList()
        ]);
    }
    /**
     * Get user's pets list
     * @return Collection
     * @throws Throwable
     */
    private function getPetList(): Collection
    {
        return  Pet::query()
            ->select(['*'])
            ->leftJoin('user_pets', 'user_pets.pet_id', '=', 'pets.id')
            ->where('user_pets.user_id','=', Auth::id())
            ->get();
    }
}
