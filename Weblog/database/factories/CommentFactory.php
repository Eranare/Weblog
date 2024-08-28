<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\User;
use App\Models\Article;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        // Fetch a random user and a random article
        $user = User::inRandomOrder()->first();
        $article = Article::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'article_id' => $article->id,
            'content' => $this->faker->sentence(),
            'parent_id' => null, // Top-level comment by default
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Comment $comment) {
            // Optionally create a reply to this comment
            if (rand(0, 1)) {
                Comment::factory()->create([
                    'user_id' => User::inRandomOrder()->first()->id,
                    'article_id' => $comment->article_id,
                    'parent_id' => $comment->id, // Set this as the parent comment
                ]);
            }
        });
    }
}