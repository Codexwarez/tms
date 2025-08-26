@extends('layouts.app')

@section('content')
    <div class="bg-white p-4 rounded-lg shadow">
        <a href="{{ route('admin.staff.create') }}"
            class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Add New Staff
        </a>

        <h2 class="text-xl font-bold mb-4">Staff Members</h2>

        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Name</th>
                    <th class="p-2 text-left">Email</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                    <tr class="border-t">
                        <td class="p-2">{{ $member->name }}</td>
                        <td class="p-2">{{ $member->email }}</td>
                        <td class="p-2 space-x-2">
                            <a href="{{ route('admin.staff.edit', $member) }}"
                                class="text-blue-600 hover:underline inline-flex items-center">
                                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                            </a>

                            <form action="{{ route('admin.staff.destroy', $member) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline inline-flex items-center"
                                    onclick="return confirm('Are you sure you want to delete this staff?')">
                                    <i class="fa-solid fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-2 text-center">No staff found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $staff->links() }}</div>
    </div>
@endsection
