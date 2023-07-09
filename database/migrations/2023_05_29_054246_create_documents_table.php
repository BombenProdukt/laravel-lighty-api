<?php

declare(strict_types=1);

use App\Models\Language;
use App\Models\Team;
use App\Models\Theme;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Team::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Language::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Theme::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('hash');
            $table->longText('body');
            $table->longText('html');
            $table->timestamps();

            $table->unique(['team_id', 'hash']);
        });
    }
};
