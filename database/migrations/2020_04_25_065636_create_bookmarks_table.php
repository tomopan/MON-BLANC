<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateBookmarksTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("bookmarks", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('user_id');
						$table->integer('paper_novel_id');
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
                    Schema::dropIfExists("bookmarks");
                }
            }
        