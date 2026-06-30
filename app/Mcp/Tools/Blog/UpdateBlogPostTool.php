<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Blog;

use App\Models\BlogPost;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class UpdateBlogPostTool extends Tool
{
    protected string $description = 'Update an existing blog post. Provide id (or slug_lookup) + any subset of fields.';

    public function handle(Request $request): Response
    {
        $data = $request->all();

        if (empty($data['id'] ?? null) && ! empty($data['slug_lookup'] ?? null)) {
            $post = BlogPost::where('slug', $data['slug_lookup'])->first();
            if (! $post instanceof BlogPost) {
                return Response::error("Blog post not found with slug: {$data['slug_lookup']}");
            }
            $data['id'] = $post->id;
        }

        $validator = Validator::make($data, [
            'id' => ['required', 'integer', 'exists:blog_posts,id'],
            'title' => ['sometimes', 'string', 'max:200'],
            'slug' => ['sometimes', 'string', 'max:200', 'regex:/^[a-z0-9-]+$/', Rule::unique('blog_posts', 'slug')->ignore($data['id'] ?? null)],
            'excerpt' => ['sometimes', 'nullable', 'string', 'max:320'],
            'body' => ['sometimes', 'nullable', 'string'],
            'meta_title' => ['sometimes', 'nullable', 'string', 'max:200'],
            'meta_description' => ['sometimes', 'nullable', 'string', 'max:320'],
            'author_name' => ['sometimes', 'nullable', 'string', 'max:160'],
            'tags' => ['sometimes', 'nullable', 'array'],
            'tags.*' => ['string', 'max:60'],
            'published_at' => ['sometimes', 'nullable', 'date'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $valid = $validator->validated();
        $post = BlogPost::findOrFail($valid['id']);
        unset($valid['id']);
        $post->update($valid);

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
            'id' => $schema->integer()->description('Post id (or use slug_lookup)'),
            'slug_lookup' => $schema->string()->description('Slug to find the post (alternative to id)'),
            'title' => $schema->string()->description('Post title'),
            'slug' => $schema->string()->description('Change URL slug (URL changes!)'),
            'excerpt' => $schema->string()->description('Short excerpt'),
            'body' => $schema->string()->description('Full HTML body'),
            'meta_title' => $schema->string()->description('SEO title override'),
            'meta_description' => $schema->string()->description('SEO meta description'),
            'author_name' => $schema->string()->description('Author byline'),
            'tags' => $schema->array()->items($schema->string())->description('Replace tag list'),
            'published_at' => $schema->string()->description('ISO datetime. Past=published, future=scheduled, null=draft'),
            'is_active' => $schema->boolean()->description('Public visibility'),
        ];
    }
}
