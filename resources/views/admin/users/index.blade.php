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
        <button class="bg-cyan-500 ml-2 my-4 hover:bg-cyan-700 px-3 py-2 rounded text-white flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-1" viewBox="0 0 512 512">
                <path fill="currentColor"
                    d="M8 256c0 137 111 248 248 248s248-111 248-248S393 8 256 8S8 119 8 256m448 0c0 110.5-89.5 200-200 200S56 366.5 56 256S145.5 56 256 56s200 89.5 200 200m-72-20v40c0 6.6-5.4 12-12 12H256v67c0 10.7-12.9 16-20.5 8.5l-99-99c-4.7-4.7-4.7-12.3 0-17l99-99c7.6-7.6 20.5-2.2 20.5 8.5v67h116c6.6 0 12 5.4 12 12" />
            </svg>
            Back to Admin Panel
        </button>
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
