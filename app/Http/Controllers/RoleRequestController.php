<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoleRequestController extends Controller
{
    public function requestUpgrade()
    {
        $user = Auth::user();

        // Check if request already exists
        if (RoleRequest::where('user_id', $user->id)->where('status', 'pending')->exists()) {
            return back()->with('error', 'You already have a pending request.');
        }

        RoleRequest::create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your request has been sent to the admin.');
    }

    public function index()
    {
        $requests = RoleRequest::with('user')->where('status', 'pending')->get();
        return view('admin.role_requests.index', compact('requests'));
    }

    public function approve($id)
    {
        $request = RoleRequest::findOrFail($id);
        $user = $request->user;

        $user->update(['role' => 'author']);
        $request->update(['status' => 'approved']);

        return back()->with('success', 'User role upgraded to author.');
    }

    public function reject($id)
    {
        $request = RoleRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);

        return back()->with('success', 'Request rejected.');
    }
}

