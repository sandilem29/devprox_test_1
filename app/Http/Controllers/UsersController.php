<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    /**
     * Adds a new user into the database.
     *
     * @param $user_data array
     */
    public function add(Request $request)
    {
        // set the validation rules here date of birth doesn't need to be validated as its prepopulated from the correct ID Number
        // laravel supports auto sanitizes inputs based on validation rules
        $request->validate([
            'name' => 'required|min:5|max:255|string',
            'surname' => 'required|min:5|max:255|string',
            'id_number' => 'required|digits:13|unique:users,id_number',
        ]);

        $new_user_object = new User();
        if (count(User::all()) != 3) {
            $new_user_object->name = $request->input('name');
            $new_user_object->surname = $request->input('surname');
            $new_user_object->id_number = $request->input('id_number');
            $new_user_object->date_of_birth = $request->input('date_of_birth');

            if ($new_user_object->save()) {
                session()->flash('message', 'User '.$request->input('name').' was successfully added');

                return redirect()->back();
            }
        } else {
            session()->flash('error', 'Maximum user allowed has exceeded');

            return redirect()->back();
        }
    }
}
