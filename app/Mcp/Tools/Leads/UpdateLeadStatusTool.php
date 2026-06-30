<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Leads;

use App\Enums\LeadStatus;
use App\Models\Lead;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class UpdateLeadStatusTool extends Tool
{
    protected string $description = 'Mark a lead as contacted, qualified or lost (or back to new). The only mutating action on Leads.';

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => ['required', 'integer', 'exists:leads,id'],
            'status' => ['required', Rule::enum(LeadStatus::class)],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $lead = Lead::findOrFail($data['id']);
        $lead->update(['status' => LeadStatus::from($data['status'])]);

        return Response::json([
            'id' => $lead->id,
            'status' => $lead->status->value,
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('Lead id')->required(),
            'status' => $schema->string()
                ->enum(array_map(fn (LeadStatus $s): string => $s->value, LeadStatus::cases()))
                ->description('New status')
                ->required(),
        ];
    }
}
