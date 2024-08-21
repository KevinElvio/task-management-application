<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getTask()
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 200;

        try {
            $tasks = Task::get();
            if ($tasks) {
                $status = "success";
                $message = "Berhasil Mendapatkan Data";
                $data = $tasks;
                $status_code = 200;
            } else {
                $status = "failed";
                $message = "Data tidak ditemukan";
                $status_code = 404;
            }
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

    public function createTask(Request $request)
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 201;

        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'description' => 'string',
                'user_id' => 'required|exists:users,id',
                'project_id' => 'required|exists:projects,id'
            ]);
            $newTask = Task::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'user_id' => $validatedData['user_id'],
                'project_id' => $validatedData['project_id']
            ]);
            if ($newTask) {
                $status = 'success';
                $message = 'Berhasil Menambahkan Project';
                $data = $newTask;
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

    public function updateTask(Request $request, $id)
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 201;

        try {
            $Task = Task::findOrFail($id);
            $validatedData = $request->validate([
                'name' => 'required|string',
                'description' => 'string',
                'user_id' => 'required|exists:users,id',
                'project_id' => 'required|exists:projects,id'
            ]);
            $Task->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'user_id' => $validatedData['user_id'],
                'project_id' => $validatedData['project_id']
            ]);
            if ($Task) {
                $message = 'Berhasil Memperbaharui Data';
                $status_code = 201;
            } else {
                $status = 'failed';
                $message = 'Gagal Memperbaharui Data';
            }
            $status = 'success';
            $data = $Task;

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

    public function destroyTask(Request $request, $id)
    {
        $status = '';
        $message = '';
        $data = null;
        $status_code = 200;

        try {
            $Task = Task::findOrFail($id);
            if ($Task) {
                $Task->delete();
                $message = 'Data Berhasil Dihapus';
                $status_code = 200;
            } else {
                $message = 'Data tidak ditemukan';
                $status_code = 404;
            }
            $status = 'success';
            $data = $Task;
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
