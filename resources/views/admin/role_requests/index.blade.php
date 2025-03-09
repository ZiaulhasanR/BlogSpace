@extends('layouts.app')

@section('content')
    <div class="container mx-auto my-10">
        <h1 class="text-3xl font-bold mb-6">User Role Upgrade Requests</h1>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">User</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr class="border">
                        <td class="border px-4 py-2">{{ $request->user->name }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($request->status) }}</td>
                        <td class="border px-4 py-2">
                            <form action="{{ route('admin.role-requests.approve', $request->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Approve</button>
                            </form>
                            <form action="{{ route('admin.role-requests.reject', $request->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
