<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateStoryPapersTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("story_papers", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('paper_novel_id');
						$table->integer('story_number');
						$table->text('text');
						$table->integer('status');
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
                    Schema::dropIfExists("story_papers");
                }
            }
        