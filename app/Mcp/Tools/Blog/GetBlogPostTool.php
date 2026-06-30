<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Blog;

use App\Models\BlogPost;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
class GetBlogPostTool extends Tool
{
    protected string $description = 'Get a blog post by id OR slug, including the full HTML body.';

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => ['nullable', 'integer'],
            'slug' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $post = match (true) {
            ! empty($data['id'] ?? null) => BlogPost::find($data['id']),
            ! empty($data['slug'] ?? null) => BlogPost::where('slug', $data['slug'])->first(),
            default => null,
        };

        if (! $post instanceof BlogPost) {
            return Response::error('Blog post not found. Provide either id or slug.');
        }

        return Response::json([
            'id' => $post->id,
            'slug' => $post->slug,
            'title' => $post->title,
            'excerpt' => $post->excerpt,
            'body' => $post->body,
            'meta_title' => $post->meta_title,
            'meta_description' => $post->meta_description,
            'author_name' => $post->author_name,
            'tags' => $post->tags,
            'published_at' => $post->published_at?->toIso8601String(),
            'is_active' => $post->is_active,
            'public_url' => url('/blog/'.$post->slug),
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('Post id (or use slug)'),
            'slug' => $schema->string()->description('Post slug (or use id)'),
        ];
    }
}
