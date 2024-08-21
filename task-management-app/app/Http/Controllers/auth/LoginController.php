<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $status = '';
        $message = '';
        $data = null;
        $api_token = null;
        $status_code = '201';

        try {
            $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $status = 'failed';
                $message = 'Data Tidak Terdaftar';
                $status_code = 404;
            } else if (!Hash::check($request->password, $user->password)) {
                $status = 'failed';
                $message = 'Data Tidak Terdaftar';
                $status_code = 404;
            } else {
                $api_token = $user->createToken('token')->plainTextToken;
                $status = 'success';
                $message = 'Login Berhasil';
                $data = $user;
                $status_code = 200;
            }
        } catch (\Exception $e) {
            $status = 'failed';
            $message = 'Gagal Menjalankan Request' . $e->getMessage();
            $status_code = 500;
        } finally {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
                'token' => $api_token
            ], $status_code);
        }


    }
}
