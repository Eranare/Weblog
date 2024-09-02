<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        // Fetch a random user who is a writer
        $writer = User::where('is_writer', true)->inRandomOrder()->first();

        return [
            'title' => $this->faker->sentence,
            'content_file_path' => '',
            'banner_image_path' => '',
            'content_preview' => '',
            'user_id' => $writer ? $writer->id : User::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Article $article) {
            // Generate a unique directory for this article
            $articleDir = 'faker/' . Str::slug($article->title) . '-' . Str::random(6);

            // Create random content
            $content = "<h1>{$article->title}</h1><p>" . implode("</p><p>", $this->faker->paragraphs(5)) . "</p>";

            // Strip HTML tags to get plain text content for preview
            $plainTextContent = strip_tags($content);

            // Get the first 100-150 characters for preview
            $contentPreview = Str::limit($plainTextContent, 150);

            // Decide where to place the image(s)
            $imagePlacement = $this->faker->randomElement(['top', 'bottom', 'both', 'none']);

            // Generate random cat image URL
            $imageUrl = 'https://cataas.com/cat?' . Str::random(10);

            // Add the image based on the random placement
            switch ($imagePlacement) {
                case 'top':
                    $content = "<img src='{$imageUrl}' alt='Random Cat' style='width:100%; height:auto; margin-bottom:20px;'>" . $content;
                    break;
                case 'bottom':
                    $content .= "<img src='{$imageUrl}' alt='Random Cat' style='width:100%; height:auto; margin-top:20px;'>";
                    break;
                case 'both':
                    $content = "<img src='{$imageUrl}' alt='Random Cat' style='width:100%; height:auto; margin-bottom:20px;'>" . $content;
                    $content .= "<img src='{$imageUrl}' alt='Random Cat' style='width:100%; height:auto; margin-top:20px;'>";
                    break;
            }

            // Create the content filename
            $filename = $articleDir . '/' . Str::slug($article->title) . date('m-d-Y_hia') . '.html';

            // Store the content file using the 'articles' disk
            Storage::disk('articles')->put($filename, $content);

            // Generate a random banner image URL
            $bannerImageUrl = 'https://cataas.com/cat?' . Str::random(10);

            // Update the article with the correct paths
            $article->update([
                'content_file_path' => $filename,
                'banner_image_path' => $bannerImageUrl,
                'content_preview' => $contentPreview,
            ]);

            // Attach random categories if any exist
            $categories = Category::inRandomOrder()->take(rand(0, 3))->pluck('id');
            $article->categories()->attach($categories);
        });
    }
}
