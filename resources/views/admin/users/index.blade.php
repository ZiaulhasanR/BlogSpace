@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Manage Users</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Role</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr id="user-{{ $user->id }}" class="border">
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2 capitalize">{{ ucfirst($user->role) }}</td>  <!-- Display role properly -->
                <td class="px-4 py-2 flex">
                    <!-- Edit Button -->
                    <a href="{{ route('admin.users.edit', $user->id) }}" class=" text-white"><button class="bg-orange-500 ml-2 hover:bg-orange-700 px-3 py-1 text-white rounded">Edit</button></a>

                    <!-- Delete Button (AJAX) -->
                    <button class="delete-user bg-red-500 ml-2 hover:bg-red-700 px-3 py-1 rounded text-white" data-user-id="{{ $user->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.home') }}" class="flex justify-end">
        <button class="bg-cyan-500 ml-2 my-4 hover:bg-cyan-700 px-3 py-1 rounded text-white">Back to Admin Panel</button>
    </a>
</div>

<!-- AJAX for Deleting User Without Page Reload -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function() {
            let userId = this.getAttribute('data-user-id');
            if (!confirm("Are you sure you want to delete this user?")) return;

            fetch(`/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    "X-CSRF-TOKEN": '{{ csrf_token() }}',
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`user-${userId}`).remove();
                } else {
                    alert("Failed to delete the user!");
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
</script>
@endsection
