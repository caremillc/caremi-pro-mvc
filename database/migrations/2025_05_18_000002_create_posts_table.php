<?php 

use Careminate\Database\Schema\Schema;
use Careminate\Database\Blueprint\Blueprint;
use Careminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    public function up(): void
    {
        $schema = new Schema();
        $schema->create('posts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('body')->unique('body');
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
        echo "Migration up: CreatePostsTable\n";
    }

    public function down(): void
    {
        $schema = new Schema();
        $schema->drop('posts');
        echo "Migration down: CreatePostsTable\n";
    }


    // Add column
// $schema->table('users', function(Blueprint $table) {
//     $table->addColumn('phone', 'VARCHAR(20)');
// });

// Drop column
// $schema->table('users', function(Blueprint $table) {
//     $table->dropColumn('role');
// });

// Rename column
// $schema->table('users', function(Blueprint $table) {
//     $table->renameColumn('status', 'account_status');
// });


}