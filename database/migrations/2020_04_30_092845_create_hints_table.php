
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateHintsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("hints", function (Blueprint $table) {

						$table->increments('id');
						$table->integer('user_id');
						$table->integer('user_paper_order');
						$table->text('q_1')->nullable();
						$table->text('q_2')->nullable();
						$table->text('q_3')->nullable();
						$table->text('q_4')->nullable();
						$table->text('q_5')->nullable();
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
                Schema::dropIfExists("hints");
            }
        }
    