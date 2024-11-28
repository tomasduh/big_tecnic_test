<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'project_id' => 'nullable|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
        ]);
        
        if ($validator->fails()) {
            return Inertia::back()  
                ->withErrors($validator)
                ->with('form', $request->all()); 
        }
    
        $project = Task::create([
            'project_id' => $request->project_id,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 0,
        ]);
    
        return redirect()->route('project.edit', ['id' => $request->project_id])->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:0,1,2', 
            'user_id' => 'required|exists:users,id',
        ]);
    
        $task = Task::findOrFail($id); 
    
        $task->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
            'user_id' => $validated['user_id'],
        ]);
    
        return redirect()->route('project.edit', $task->project_id)  // O la ruta a la que desees redirigir
        ->with('success', 'Task updated successfully!')
        ->setStatusCode(303);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Task::findOrFail($id);
    
            $user->delete();
    
            return redirect()->back()->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error deleting user. Please try again later.']);
        }
    }
}
