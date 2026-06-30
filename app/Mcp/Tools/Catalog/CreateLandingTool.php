<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Enums\LandingStatus;
use App\Models\Landing;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class CreateLandingTool extends Tool
{
    protected string $description = <<<'MARKDOWN'
        Create a single landing. category_id required, location_id optional.
        Slug auto-generates from category + location when not provided (separator from config('seo.landing_slug_separator')).
        Pass `content` as an associative array of sections that the public view will render its own way.
        Status: draft | scheduled | published (defaults to published). Passing `publish_at` without a status
        schedules it automatically (status=scheduled). A scheduled landing stays hidden until `publish_at` is reached
        and the daily `landings:publish-scheduled` command flips it to published.
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'location_id' => ['nullable', 'integer', 'exists:locations,id'],
            'slug' => ['nullable', 'string', 'max:200', 'regex:/^[a-z0-9-]+$/', 'unique:landings,slug'],
            'title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'content' => ['nullable', 'array'],
            'status' => ['nullable', Rule::enum(LandingStatus::class)],
            'publish_at' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $valid = $validator->validated();

        $status = isset($valid['status'])
            ? LandingStatus::from($valid['status'])
            : (filled($valid['publish_at'] ?? null) ? LandingStatus::Scheduled : LandingStatus::Published);

        if ($status === LandingStatus::Scheduled && blank($valid['publish_at'] ?? null)) {
            return Response::error('A scheduled landing requires publish_at.');
        }

        $landing = Landing::create([
            'category_id' => $valid['category_id'],
            'location_id' => $valid['location_id'] ?? null,
            'slug' => $valid['slug'] ?? null,
            'title' => $valid['title'] ?? null,
            'meta_description' => $valid['meta_description'] ?? null,
            'content' => $valid['content'] ?? null,
            'status' => $status,
            'publish_at' => $status === LandingStatus::Scheduled ? $valid['publish_at'] : null,
        ]);

        return Response::json([
            'id' => $landing->id,
            'slug' => $landing->slug,
            'public_url' => url('/'.$landing->slug),
            'status' => $landing->status->value,
            'publish_at' => $landing->publish_at?->toIso8601String(),
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'category_id' => $schema->integer()->description('Category id')->required(),
            'location_id' => $schema->integer()->description('Location id (omit for a category-only landing)'),
            'slug' => $schema->string()->description('Slug override (auto-generated if omitted)'),
            'title' => $schema->string()->description('Title override (otherwise composed from category + location)'),
            'meta_description' => $schema->string()->description('Meta description (≤320 chars)'),
            'content' => $schema->object()->description('Section content as a JSON object'),
            'status' => $schema->string()->description('draft | scheduled | published (default published)'),
            'publish_at' => $schema->string()->description('Publish date (ISO 8601). Setting it schedules the landing'),
        ];
    }
}
