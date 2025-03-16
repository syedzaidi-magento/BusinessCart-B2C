<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Configuration;

class CreateConfigurationsTable extends Migration
{
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->string('group');
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['store_id', 'group', 'key']);
        });

        // Seed configurations
        $configs = [];
        foreach (Configuration::getPredefinedKeys() as $key) {
            $definition = Configuration::getDefinition($key);
            $value = Configuration::getDefault($key);
            if ($definition['type'] === 'json' || is_array($value)) {
                $value = json_encode($value);
            }
            $configs[] = [
                'store_id' => null,
                'group' => $definition['group'],
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        Configuration::insert($configs);
    }

    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
