<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function getProject()
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 200;

        try {
            $project = Project::with('task')->get();
            if ($project) {
                $status = "success";
                $message = "Berhasil Mendapatkan Data";
                $status_code = 200;
            } else {
                $status = "failed";
                $message = "Data tidak ditemukan";
                $status_code = 404;
            }
            $data = $project;
        } catch (\Exception $e) {
            $status = "failed";
            $message = "Gagal Menjalankan Request " . $e->getMessage();
            $status_code = 500;
        } finally {
            return response()->json([
                "status" => $status,
                "message" => $message,
                "data" => $data
            ], $status_code);
        }
    }

    public function createProject(Request $request)
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 201;

        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'description' => 'string',
                'user_id' => 'required|exists:users,id'
            ]);
            $newproject = Project::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'user_id' => $validatedData['user_id']
            ]);
            if ($newproject) {
                $status = 'success';
                $message = 'Berhasil Menambahkan Project';
                $data = $newproject;
                $status_code = 201;
            } else {
                $status = 'failed';
                $message = 'Gagal Menambahkan Data';
                $status_code = 400;
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
            ], $status_code);
        }
    }

    public function updateProject(Request $request, $id)
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 201;

        try {
            $Project = Project::findOrFail($id);
            $validatedData = $request->validate([
                'name' => 'required|string',
                'description' => 'string',
                'user_id' => 'required|exists:users,id'
            ]);
            $Project->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'user_id' => $validatedData['user_id']

            ]);
            if ($Project) {
                $message = 'Berhasil Memperbaharui Data';
                $status_code = 201;
            } else {
                $status = 'failed';
                $message = 'Gagal Memperbaharui Data';
            }
            $status = 'success';
            $data = $Project;

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

    public function destroyProject(Request $request, $id)
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 200;

        try {
            $Project = Project::findOrFail($id);
            if ($Project) {
                $Project->delete();
                $message = 'Data Berhasil Dihapus';
                $status_code = 200;
            } else {
                $message = 'Data tidak ditemukan';
                $status_code = 404;
            }
            $status = 'success';
            $data = $Project;
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
