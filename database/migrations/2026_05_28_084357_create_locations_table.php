<?php

declare(strict_types=1);

use App\Enums\LocationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default(LocationType::City->value);
            $table->unsignedInteger('population')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->timestamps();

            $table->index('parent_id');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
