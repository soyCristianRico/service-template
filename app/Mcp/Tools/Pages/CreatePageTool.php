<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Pages;

use App\Models\Page;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class CreatePageTool extends Tool
{
    protected string $description = 'Create a new static Page (aviso legal, política, gracias…). Slug auto-generates from title if not provided.';

    public function handle(Request $request): Response
    {
        $data = $request->all();

        if (empty($data['slug'] ?? null) && ! empty($data['title'] ?? null)) {
            $data['slug'] = Str::slug($data['title']);
        }

        $validator = Validator::make($data, [
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'max:200', 'regex:/^[a-z0-9-]+$/', 'unique:pages,slug'],
            'body' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $page = Page::create([...$validator->validated(), 'is_active' => $data['is_active'] ?? true]);

        return Response::json([
            'id' => $page->id,
            'slug' => $page->slug,
            'title' => $page->title,
            'public_url' => url('/'.$page->slug),
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->description('Page title')->required(),
            'slug' => $schema->string()->description('URL slug (auto from title if omitted)'),
            'body' => $schema->string()->description('HTML body (rich content)'),
            'meta_title' => $schema->string()->description('SEO title override'),
            'meta_description' => $schema->string()->description('SEO meta description (≤320 chars)'),
            'is_active' => $schema->boolean()->description('Defaults to true'),
        ];
    }
}
