<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateMarkersTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("markers", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('user_id')->nullable();
						$table->integer('paper_novel_id')->nullable();
						$table->integer('story_paper_id')->nullable();
						$table->text('text')->nullable();
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
                    Schema::dropIfExists("markers");
                }
            }
        