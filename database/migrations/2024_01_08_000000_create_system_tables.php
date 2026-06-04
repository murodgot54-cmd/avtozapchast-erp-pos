<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('symbol');
            $table->decimal('exchange_rate', 18, 6)->default(1);
            $table->boolean('is_base')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->index('created_at');
        });

        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();
            $table->string('backup_name');
            $table->string('backup_path');
            $table->unsignedBigInteger('backup_size');
            $table->enum('backup_type', ['manual', 'automatic'])->default('manual');
            $table->enum('status', ['success', 'failed'])->default('success');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('telegram_settings', function (Blueprint $table) {
            $table->id();
            $table->string('bot_token')->nullable();
            $table->string('chat_id')->nullable();
            $table->boolean('send_daily_report')->default(false);
            $table->boolean('send_low_stock_alert')->default(true);
            $table->boolean('send_overdue_debt_alert')->default(true);
            $table->time('daily_report_time')->default('09:00');
            $table->timestamps();
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_website')->nullable();
            $table->string('company_tax_id')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->string('currency_code')->default('UZS');
            $table->text('receipt_footer')->nullable();
            $table->integer('receipt_print_width')->default(80);
            $table->boolean('enable_barcode')->default(true);
            $table->boolean('enable_credit')->default(true);
            $table->timestamps();
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->json('permissions');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('telegram_settings');
        Schema::dropIfExists('backup_logs');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('currencies');
    }
};
