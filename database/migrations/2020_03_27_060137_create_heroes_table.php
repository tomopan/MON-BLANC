<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateHeroesTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("heroes", function (Blueprint $table) {
						$table->increments('id');
                        $table->text('img_url');
						$table->text('hero_name');
						$table->text('hero_birth');
						$table->integer('novel_count')->nullable();
						$table->timestamps();
						$table->softDeletes();
                    });
                }
    
                /**
                 * Reverse the migrations.
                 *
                 * @return void
                 */
                public function down()
                {
                    Schema::dropIfExists("heroes");
                }
            }
        