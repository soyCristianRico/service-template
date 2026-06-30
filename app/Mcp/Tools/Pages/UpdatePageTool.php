<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Pages;

use App\Models\Page;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class UpdatePageTool extends Tool
{
    protected string $description = 'Update an existing Page. Provide id (or slug) + any subset of fields to change.';

    public function handle(Request $request): Response
    {
        $data = $request->all();

        // Allow lookup by slug instead of id
        if (empty($data['id'] ?? null) && ! empty($data['slug_lookup'] ?? null)) {
            $page = Page::where('slug', $data['slug_lookup'])->first();
            if (! $page instanceof Page) {
                return Response::error("Page not found with slug: {$data['slug_lookup']}");
            }
            $data['id'] = $page->id;
        }

        $validator = Validator::make($data, [
            'id' => ['required', 'integer', 'exists:pages,id'],
            'title' => ['sometimes', 'string', 'max:200'],
            'slug' => ['sometimes', 'string', 'max:200', 'regex:/^[a-z0-9-]+$/', Rule::unique('pages', 'slug')->ignore($data['id'] ?? null)],
            'body' => ['sometimes', 'nullable', 'string'],
            'meta_title' => ['sometimes', 'nullable', 'string', 'max:200'],
            'meta_description' => ['sometimes', 'nullable', 'string', 'max:320'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $valid = $validator->validated();
        $page = Page::findOrFail($valid['id']);
        unset($valid['id']);
        $page->update($valid);

        return Response::json([
            'id' => $page->id,
            'slug' => $page->slug,
            'title' => $page->title,
            'public_url' => url('/'.$page->slug),
            'is_active' => $page->is_active,
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('Page id (or use slug_lookup)'),
            'slug_lookup' => $schema->string()->description('Slug to find the page (alternative to id)'),
            'title' => $schema->string()->description('Page title'),
            'slug' => $schema->string()->description('Change the slug (URL changes!)'),
            'body' => $schema->string()->description('HTML body'),
            'meta_title' => $schema->string()->description('SEO title override'),
            'meta_description' => $schema->string()->description('SEO meta description'),
            'is_active' => $schema->boolean()->description('Public visibility'),
        ];
    }
}
