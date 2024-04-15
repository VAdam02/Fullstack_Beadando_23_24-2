<div class="sm:w-96 w-full grow rounded-lg p-4 bg-gray-200 shadow-md hover:shadow-lg hover:scale-105 transform transition duration-300 ease-in-out">
    <a href="{{ route('users.show', $user->id) }}" class="hover:text-gray-500">
        <h2 class="truncate font-semibold text-lg mb-2">{{ $user->name }}</h2>
        <div class="text-sm text-gray-500 mt-2">Age: {{ $user->email }}</div>
        <div class="text-sm text-gray-500 mt-2">Age: {{ $user->age }}</div>
        <div class="text-sm text-gray-500 mt-2">Phone: {{ $user->phone }}</div>
        <div class="text-sm text-gray-500 mt-2">Admin: {{ $user->isadmin ? 'Yes' : 'No' }}</div>
        <div class="text-sm text-gray-500 mt-2">Created at {{ $user->created_at->diffForHumans() }}</div>
        <div class="text-sm text-gray-500 mt-2">Updated at {{ $user->updated_at->diffForHumans() }}</div>
    </a>
</div>
