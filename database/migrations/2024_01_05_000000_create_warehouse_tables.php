<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0);
            $table->integer('available_quantity')->virtualAs('quantity - reserved_quantity');
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->unique(['product_id', 'warehouse_id']);
            $table->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->integer('quantity_change');
            $table->enum('type', ['in', 'out', 'return', 'adjustment', 'transfer'])->default('in');
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->text('notes')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('warehouse_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number')->unique();
            $table->unsignedBigInteger('from_warehouse_id');
            $table->unsignedBigInteger('to_warehouse_id');
            $table->unsignedBigInteger('created_by');
            $table->enum('status', ['pending', 'sent', 'received', 'cancelled'])->default('pending');
            $table->date('transfer_date');
            $table->date('received_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreign('from_warehouse_id')->references('id')->on('warehouses')->onDelete('restrict');
            $table->foreign('to_warehouse_id')->references('id')->on('warehouses')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('warehouse_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transfer_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->integer('received_quantity')->default(0);
            $table->text('notes')->nullable();
            $table->foreign('transfer_id')->references('id')->on('warehouse_transfers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('inventory_audits', function (Blueprint $table) {
            $table->id();
            $table->string('audit_number')->unique();
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('created_by');
            $table->dateTime('started_at');
            $table->dateTime('completed_at')->nullable();
            $table->enum('status', ['in_progress', 'completed', 'cancelled'])->default('in_progress');
            $table->integer('total_items')->default(0);
            $table->integer('audited_items')->default(0);
            $table->integer('discrepancies')->default(0);
            $table->text('notes')->nullable();
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('inventory_audit_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audit_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('system_quantity');
            $table->integer('actual_quantity');
            $table->integer('discrepancy')->virtualAs('actual_quantity - system_quantity');
            $table->text('notes')->nullable();
            $table->foreign('audit_id')->references('id')->on('inventory_audits')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_audit_items');
        Schema::dropIfExists('inventory_audits');
        Schema::dropIfExists('warehouse_transfer_items');
        Schema::dropIfExists('warehouse_transfers');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('stock');
        Schema::dropIfExists('warehouses');
    }
};
