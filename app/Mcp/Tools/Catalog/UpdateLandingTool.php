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

class UpdateLandingTool extends Tool
{
    protected string $description = <<<'MARKDOWN'
        Update an existing landing. Provide id + any subset of fields.
        Status: draft | scheduled | published. Only published landings respond 200 and appear in the sitemap.
        Setting `publish_at` schedules the landing (status=scheduled); clearing it on a scheduled landing reverts to draft.
        Use this to drip-publish: list drafts, then set publish_at on the ones you want to go live on a given day.
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => ['required', 'integer', 'exists:landings,id'],
            'slug' => ['sometimes', 'string', 'max:200', 'regex:/^[a-z0-9-]+$/', Rule::unique('landings', 'slug')->ignore($data['id'] ?? null)],
            'title' => ['sometimes', 'nullable', 'string', 'max:200'],
            'meta_description' => ['sometimes', 'nullable', 'string', 'max:320'],
            'content' => ['sometimes', 'nullable', 'array'],
            'status' => ['sometimes', Rule::enum(LandingStatus::class)],
            'publish_at' => ['sometimes', 'nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $valid = $validator->validated();
        $landing = Landing::findOrFail($valid['id']);
        unset($valid['id']);

        $statusProvided = array_key_exists('status', $valid);
        $publishProvided = array_key_exists('publish_at', $valid);

        $status = $statusProvided ? LandingStatus::from($valid['status']) : $landing->status;
        $publishAt = $publishProvided ? $valid['publish_at'] : $landing->publish_at?->toIso8601String();

        if ($publishProvided && ! $statusProvided) {
            $status = filled($valid['publish_at'])
                ? LandingStatus::Scheduled
                : ($landing->status === LandingStatus::Scheduled ? LandingStatus::Draft : $landing->status);
        }

        if ($status === LandingStatus::Scheduled && blank($publishAt)) {
            return Response::error('A scheduled landing requires publish_at.');
        }

        $valid['status'] = $status;
        $valid['publish_at'] = $status === LandingStatus::Scheduled ? $publishAt : null;

        $landing->update($valid);

        return Response::json([
            'id' => $landing->id,
            'slug' => $landing->slug,
            'public_url' => url('/'.$landing->slug),
            'status' => $landing->status->value,
            'publish_at' => $landing->publish_at?->toIso8601String(),
            'title' => $landing->title,
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('Landing id to update')->required(),
            'slug' => $schema->string()->description('Custom slug'),
            'title' => $schema->string()->description('Title override'),
            'meta_description' => $schema->string()->description('Meta description (≤320 chars)'),
            'content' => $schema->object()->description('Section content (jsonb)'),
            'status' => $schema->string()->description('draft | scheduled | published'),
            'publish_at' => $schema->string()->description('Publish date (ISO 8601). Setting it schedules the landing; null reverts a scheduled one to draft'),
        ];
    }
}
