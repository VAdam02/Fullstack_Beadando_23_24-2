<x-posts-layout title="Users" :authorsPostCount="$authorsPostCount" :categoriesPostCount="$categoriesPostCount">
    <h1 class="font-semibold mt-5 mb-3 text-3xl">List of users</h1>
    <!-- List of Posts -->
    <div class="my-3 gap-10 flex flex-wrap">
        @foreach ($users as $user)
        @include('users.partials.card')
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="my-3">
        {{ $users->links() }}
    </div>
</x-posts-layout>
