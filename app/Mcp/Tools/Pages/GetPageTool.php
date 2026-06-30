<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Pages;

use App\Models\Page;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
class GetPageTool extends Tool
{
    protected string $description = 'Get a Page by id OR slug, including the full body HTML.';

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

        $page = match (true) {
            ! empty($data['id'] ?? null) => Page::find($data['id']),
            ! empty($data['slug'] ?? null) => Page::where('slug', $data['slug'])->first(),
            default => null,
        };

        if (! $page instanceof Page) {
            return Response::error('Page not found. Provide either id or slug.');
        }

        return Response::json([
            'id' => $page->id,
            'slug' => $page->slug,
            'title' => $page->title,
            'body' => $page->body,
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'is_active' => $page->is_active,
            'public_url' => url('/'.$page->slug),
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('Page id (or use slug)'),
            'slug' => $schema->string()->description('Page slug (or use id)'),
        ];
    }
}
