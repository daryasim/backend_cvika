<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        echo 22;
    }

    public function testPost(Request $request)
    {
        $name = $request->post('meno', null);
        $surname = $request->post('priezvisko', null);
        $age = $request->post('vek', 0);

        if($age < 18) {
            return response()->json("Unable to join under 18", 422);
        } else {
            return response()->json([
                'status' => 200,
                'message' => $name . " " . $surname . " was correctly assigned",
            ]);
        }
    }

    public function testUpload(Request $request)
    {
        $number = $request->post('number', 0);
        file_put_contents("file.txt", $number);

        return response()->json("juchuchu");
    }

    public function findUserById(int $id): JsonResponse
    {
        $user = User::find($id);
        //$user = User::where('email', '=', $email)->first();

        if($user) {
            return response()->json($user);
        } else {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }

    public function findUserByPhone(Request $request): JsonResponse
    {
        $phoneNumber = $request->post('phone', null);

        if($phoneNumber) {
            $phone = Phone::query()->where("phone", '=', $phoneNumber)->first();
            if($phone) {
                /** @var User $user */
                $user = $phone->user;
                return response()->json($user);
            }

            return response()->json([
                'message' => 'Phone not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Incorrect data'
        ], 422);
    }

    public function getUserAddress(string $email): JsonResponse
    {
        $user = User::query()->where("email", '=', $email)->first();
        if($user) {
            /** @var Collection $address */
            $address = $user->address()->orderBy("street_number")->get();
            return response()->json($address);
        }

        return response()->json([
            'message' => 'User not found'
        ], 404);

    }

    public function saveUser(Request $request): JsonResponse
    {
        $name = $request->post('name', false);
        $email = $request->post('email', false);
        $phoneNumber = $request->post('phone', false);

        if($email && $name && $phoneNumber) {
            $newUser = new User();
            $newUser->meno = $name;
            $newUser->email = $email;
            $newUser->save();

            $newPhone = new Phone();
            $newPhone->phone = $phoneNumber;
            $newPhone->user_id = $newUser->id;
            $newPhone->save();

            return response()->json([
                'id' => $newUser->id,
                'meno' => $newUser->meno,
                'email' => $newUser->email,
                'tel.kontakt' => $newUser->phone->phone
            ]);
        }

        return response()->json([
            'message' => 'Incorrect data'
        ], 422);
    }

    public function saveUserAddress(int $id, Request $request): JsonResponse
    {
        $user = User::query()->find($id);
        if($user) {
            $street = $request->input('street', null);
            $streetNumber = $request->input('street_number', null);
            $city = $request->input('city', null);
            $zip = $request->input('zip', null);

            if($street && $streetNumber && $city && $zip) {
                $newAddress = new Address();
                $newAddress->street = $street;
                $newAddress->street_number = $streetNumber;
                $newAddress->city = $city;
                $newAddress->zip = $zip;
                $newAddress->user_id = $user->id;
                $newAddress->save();

                return response()->json([
                    'id' => $user->id,
                    'meno' => $user->meno,
                    'email' => $user->email,
                    'tel.kontakt' => $user->phone->phone,
                    'addr' => $user->address
                ]);
            } else {
                return response()->json([
                    'message' => 'Incorrect data'
                ], 422);
            }
        } else {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }

    public function deletePhoneNumber(Request $request): JsonResponse
    {
        $phoneNumber = $request->input('phone', null);
        if($phoneNumber) {
            $phone = Phone::query()->where('phone', '=', $phoneNumber)->first();
            if($phone) {
                $phone->delete();
                return response()->json([
                    'message' => 'Phone deleted'
                ], 200);
            }

            return response()->json([
                'message' => 'Phone not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Incorrect data'
        ], 422);

    }

    public function updatePhoneNumber(int $userId, Request $request): JsonResponse
    {
        $phoneNumber = $request->input('phone', null);
        if($phoneNumber) {
            /** @var Phone $userPhone */
            $userPhone = User::query()->find($userId)->phone;
            if($userPhone) {
                $userPhone->update([
                    'phone' => $phoneNumber
                ]);
                return response()->json([
                    'message' => 'Phone update'
                ], 200);
            }

            return response()->json([
                'message' => 'Phone not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Incorrect data'
        ], 422);

    }

    public function showHome()
    {
        $users = User::all();
        return view('home', ['users' => $users]);
    }
    public function showForm()
    {
        return view('form');
    }

    public function deleteUserFromWeb(int $id)
    {
        $user = User::query()->find($id);

        if($user) {
            foreach ($user->address as $address) {
                $address->delete();
            }

            $phone = $user->phone;
            $phone->delete();

            $user->delete();
        }

        //1. moznost
        /*
        $users = User::all();
        return view('home', ['users' => $users]);
        */

        //2.moznost
        //$this->showHome();

        //3.moznost
        return redirect()->route('home');
    }
    public function createUser(Request $request)
    {

            User::create([
                'meno' => $request->fmeno, // Map 'fname' to 'name' column
                'email' => $request->femail, // Map 'lname' to 'email' column
            ]);


        return redirect()->route('home');
    }

}
