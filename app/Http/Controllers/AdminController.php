<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Example: show list of all users
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function activate(User $user)
    {
        $user->is_active = true;
        $user->save();
        return back()->with('success', 'User activated.');
    }

    public function deactivate(User $user)
    {
            if (auth()->user()->role?->RoleName !== 'Admin') {
        abort(403, 'Unauthorized');
    }
        $user->is_active = false;
        $user->save();
        return back()->with('success', 'User deactivated.');
    }

        public function userTodos(User $user)
    {
        // List To-Do items created by this user
        $todos = $user->todos; // assuming User model has todos() relation
        return view('admin.users.todos', compact('user', 'todos'));
    }

    public function dashboard()
    {
        $users = User::with('todos')->get(); // Get all users with their todos
        $todos = \App\Models\Todo::with('user')->get();
        return view('admin.dashboard', compact('users', 'todos')); // Make sure you have this Blade file
    }
public function storeTask(Request $request, User $user)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $user->todos()->create([
        'title' => $request->title,
        'description' => $request->description,
        // Add other fields as needed
    ]);

    return back()->with('success', 'Task created for ' . $user->name);
}
}
