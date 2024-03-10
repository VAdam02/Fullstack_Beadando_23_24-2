<x-general-layout title="Blog - Posts">
    @include('post.partials.carousel')

    <div class="flex flex-wrap gap-10 p-5 my-3">
        <!-- Content -->
        <div class="grow lg:w-96 w-full" style="min-width:62%">
            <h1 class="font-semibold mt-5 mb-3 text-3xl">Latest posts</h1>
            <!-- List of Posts -->
            <div class="my-3 gap-10 flex flex-wrap">
                @foreach ($posts as $post)
                @include('post.partials.card')
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="my-3">
                {{ $posts->links() }}
            </div>
        </div>

        <div class="flex flex-wrap gap-10 h-fit w-full xl:w-96">
            <div class="mx-auto xl:mx-0 xl:w-full">
                <h1 class="font-semibold mt-5 mb-3 text-3xl">Top authors</h1>
                @include('general.table', [
                    'title' => 'Top authors',
                    'tableHeaders' => ['Name', 'Posts'],
                    'tableData' => $authorsPostCount->map(fn($author) => [$author->name, $author->posts_count])->toArray()
                ])
            </div>

            <div class="mx-auto xl:mx-0 xl:w-full">
                <h1 class="font-semibold mt-5 mb-3 text-3xl">Top categories</h1>
                @include('general.table', [
                    'title' => 'Top categories',
                    'tableHeaders' => ['Name', 'Posts'],
                    'tableData' => $categoriesPostCount->map(fn($category) => [$category->name, $category->posts_count])->toArray()
                ])
            </div>
        </div>
    </div>
</x-general-layout>
