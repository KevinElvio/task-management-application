<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getProfile()
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 200;

        try {
            $user = Auth::user();

            if ($user) {
                $status = 'success';
                $message = 'Berhasil Mendapatkan Data';
                $data = $user;
                $status_code = 200;
            } else {
                $status = 'failed';
                $message = 'Gagal Mendapatkan Data';
                $status_code = 404;
            }
        } catch (\Exception $e) {
            $status = 'failed';
            $message = 'Gagal manjalankan request' . $e->getMessage();
        } finally {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $status_code);
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 201;

        try {
            $user = User::findOrFail($id);
            if ($user) {
                $user->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'avatar' => $request['avatar'],

                ]);
                $message = 'Berhasil Memperbaharui Data';
                $status_code = 201;
            } else {
                $status = 'failed';
                $message = 'Gagal Memperbaharui Data';
            }
            $status = 'success';
            $data = $user;

        } catch (Exception $e) {
            $status = 'failed';
            $message = 'Gagal Menjalankan Request ' . $e->getMessage();
            $status_code = 500;
        } finally {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $status_code);
        }
    }

    public function destroyProfile(Request $request, $id)
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 200;

        try {
            $user = User::findOrFail($id);
            if ($user) {
                $user->delete();
                $message = 'Data Berhasil Dihapus';
                $status_code = 200;
            } else {
                $message = 'Data tidak ditemukan';
                $status_code = 404;
            }
            $status = 'success';
            $data = $user;
            $status_code = 200;
        } catch (Exception $e) {
            $status = 'failed';
            $message = 'Gagal Menjalankan Request' . $e->getMessage();
            $status_code = 500;
        } finally {
            return response()->json([
                'status' => $status,
                'message' => $message
            ], $status_code);
        }
    }

}
