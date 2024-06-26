<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Person::factory()->create();
        for ($i = 0; $i < 10; $i++) {
            Person::factory()->create();
        }

        for ($i = 0; $i < 10; $i++) {
            Person::factory()->create([
                'name' => 'name' . $i,
                'email' => 'email' . $i . '@example.com',
                'age' => 20 + $i,
                'phone' => '000-0000-000' . $i,
            ]);
        }

        /*
        User::factory(10)->create();
        for ($i = 0; $i < 10; $i++) {
            User::factory()->create([
                'name' => 'name' . $i,
                'email' => 'email' . $i . '@example.com',
                'age' => 20 + $i,
                'password' => 'password' . $i,
            ]);
        }
        */

        $users = collect();
        $userCount = rand(15, 30);
        for ($i = 0; $i < $userCount; $i++) {
            $users->push(User::factory()->create([
                'email' => 'email' . $i . '@szerveroldali.hu',
                'password' => 'password' . $i,
            ]));
        }
        $users->push(User::factory()->create([
            'email' => 'admin@admin.hu',
            'password'=> 'password',
            'isadmin' => true,
        ]));

        $categories = collect();
        $categoryCount = rand(10, 20);
        for ($i = 0; $i < $categoryCount; $i++) {
            $categories->push(Category::factory()->create());
        }

        $posts = collect();
        $postCount = rand(30, 50);
        for ($i = 0; $i < $postCount; $i++) {
            $post = Post::factory()->make();
            $post->author()->associate($users->random());
            $post->save();

            $selectedCategories = $categories->random(rand(1, 5));
            $post->categories()->attach($selectedCategories->pluck('id'));

            $posts->push($post);
        }
    }
}
