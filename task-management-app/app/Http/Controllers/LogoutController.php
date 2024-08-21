<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 200;

        try {

            $user = Auth::user();
            $deleteToken = $user->tokens()->delete();
            if ($deleteToken) {
                $status = "success";
                $message = "Berhasil Logout";
                $data = $user;
                $status_code = 200;
            } else {
                $status = "failed";
                $message = "Gagal Logout";
            }

        } catch (\Exception $e) {
            $status = "failed";
            $message = "Gagal Menjalankan Request" . $e->getMessage();
            $status_code = 500;

        } finally {
            return response()->json([
                "status" => $status,
                "message" => $message,
                "data" => $data
            ], $status_code);
        }
    }
}
