    <?php

use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->boolean('active')->default(1);
            $table->text('description')->nullable();
            $table->datetime('login_at')->nullable();
            $table->datetime('logout_at')->nullable();
        });

        Schema::create('userservices', function ($table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('billit')->nullable();
            $table->string('clef')->nullable();
            $table->string('braintree')->nullable();

            $table->foreign('user_id')
              ->references('id')->on('users')
              ->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('active');
            $table->dropColumn('description');
            $table->dropColumn('login_at');
            $table->dropColumn('logout_at');
        });

        Schema::drop('userservices');
    }
}
