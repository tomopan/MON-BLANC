<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateEpisodesTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("episodes", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('novel_id')->nullable();
						$table->integer('episode_number')->nullable();
						$table->text('episode_title')->nullable();
						$table->text('text')->nullable();
						$table->integer('status')->nullable();
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
                    Schema::dropIfExists("episodes");
                }
            }
        