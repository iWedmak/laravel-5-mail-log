<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MailLogSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for mail logs
        Schema::create('{{ $logTable }}', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->string('to', 255)->index();
            $table->text('subject');
            $table->longText('body');
            $table->boolean('read')->default(false);
            $table->integer('attempt');
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
        Schema::drop('{{ $logTable }}');
    }
}