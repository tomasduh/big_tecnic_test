<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return Inertia::render('Users/Users', [
            'users' => $users,  
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return Inertia::render('Users/Create', [
                'errors' => $validator->errors(),
                'form' => $request->all(),  
            ]);
        }
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->route('users')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return Inertia::render('Users/Edit', [
            'user' => $user,  
        ]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:1,2',
        ]);
        
        if ($validator->fails()) {
            return Inertia::render('Users/Edit', [
                'errors' => $validator->errors(),
                'form' => $request->all(),  
            ]);
        }
    
        $user = User::findOrFail($id);
    
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);
    
        return redirect()->route('user.edit', ['id' => $id])->with('success', 'User updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
    
            $user->delete();
    
            return redirect()->route('users.index')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error deleting user. Please try again later.']);
        }
    }
}
