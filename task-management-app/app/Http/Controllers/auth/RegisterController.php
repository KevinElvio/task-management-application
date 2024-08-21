<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 201;

        try {
            $validatedData = $request->validate([
                'email' => 'required|string|unique:users',
                'password' => 'required|string',
                'name' => 'required|string|unique:users',
                'avatar' => 'required|string',
            ]);

            $newUser = User::create([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'name' => $validatedData['name'],
                'avatar' => $validatedData['avatar'],
            ]);

            if ($newUser) {
                $status = 'success';
                $message = 'Berhasil Mendaftar';
                $data = $newUser;
                $status_code = 201;
            } else {
                $status = 'failed';
                $message = 'Gagal Mendaftar';
                $status_code = 400;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $status = 'failed';
            $message = 'Validasi gagal: ' . implode(", ", array_map(function ($errors) {
                return implode(", ", $errors);
            }, $e->errors()));
            $status_code = 422;
        } catch (\Exception $e) {
            $status = 'failed';
            $message = 'Gagal Menjalankan Request' . $e->getMessage();
            $status_code = 500;
        } finally {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ], $status_code);
        }

    }
}
