<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function index()
     {
        $projects = Project::withCount('tasks')->get();
        $user = Auth::user();
        if($user->role == 1 ){
            $projects = Project::withCount('tasks')->get();
        }else{
            $projects = Project::whereHas('tasks', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->withCount('tasks')->get();
        }
        return Inertia::render('Projects/Projects', [
            'projects' => $projects,  
        ]);
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
        ]);
    
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    
        return redirect()->route('project.edit', ['id' => $project->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $user = Auth::user();
        if($user->role == 1 ){
            $project = Project::with('tasks.user')->findOrFail($id);
        }else{
            $project = Project::with(['tasks' => function ($query) {
                $query->where('user_id', Auth::id()); 
            }])->findOrFail($id);
        }

        $users = User::all();
        return Inertia::render('Projects/Edit', [
            'project' => $project,  
            'users' => $users,
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
        ]);
        
        if ($validator->fails()) {
            return Inertia::render('Projects/Edit', [
                'errors' => $validator->errors(),
                'form' => $request->all(),  
            ]);
        }

        $project = Project::findOrFail($id);
    
        $project->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        return redirect()->route('project.edit', ['id' => $id])->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
