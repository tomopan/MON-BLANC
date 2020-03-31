<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateNovelsTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("novels", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('hero_id')->nullable();
						$table->integer('user_id')->nullable();
						$table->text('title')->nullable();
						$table->text('first_sentence')->nullable();
						$table->integer('viewer_count')->nullable();
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
                    Schema::dropIfExists("novels");
                }
            }
        