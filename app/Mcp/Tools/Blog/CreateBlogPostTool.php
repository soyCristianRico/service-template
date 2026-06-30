<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Blog;

use App\Models\BlogPost;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class CreateBlogPostTool extends Tool
{
    protected string $description = <<<'MARKDOWN'
        Create a new blog post.
        Set published_at in the past + is_active=true to publish immediately, in the future to schedule,
        or omit/null for a draft. Tags is an array of strings.
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        if (empty($data['slug'] ?? null) && ! empty($data['title'] ?? null)) {
            $data['slug'] = Str::slug($data['title']);
        }

        $validator = Validator::make($data, [
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'max:200', 'regex:/^[a-z0-9-]+$/', 'unique:blog_posts,slug'],
            'excerpt' => ['nullable', 'string', 'max:320'],
            'body' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'author_name' => ['nullable', 'string', 'max:160'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:60'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $post = BlogPost::create([
            ...$validator->validated(),
            'is_active' => $data['is_active'] ?? true,
        ]);

        return Response::json([
            'id' => $post->id,
            'slug' => $post->slug,
            'title' => $post->title,
            'public_url' => url('/blog/'.$post->slug),
            'published_at' => $post->published_at?->toIso8601String(),
            'is_active' => $post->is_active,
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->description('Post title')->required(),
            'slug' => $schema->string()->description('URL slug (auto from title if omitted)'),
            'excerpt' => $schema->string()->description('Short excerpt (≤320 chars)'),
            'body' => $schema->string()->description('Full body (HTML)'),
            'meta_title' => $schema->string()->description('SEO title override'),
            'meta_description' => $schema->string()->description('SEO meta description (≤320 chars)'),
            'author_name' => $schema->string()->description('Author byline'),
            'tags' => $schema->array()->items($schema->string())->description('Tag list'),
            'published_at' => $schema->string()->description('ISO datetime. Past = published, future = scheduled, omit = draft'),
            'is_active' => $schema->boolean()->description('Defaults to true'),
        ];
    }
}
