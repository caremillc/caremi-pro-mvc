<?php // migrations/20230306123000.php

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;

return new class
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('comments');
        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('post_id', Types::INTEGER, ['length' => 11]);
        $table->addColumn('user_id', Types::INTEGER);
        $table->addColumn('content', Types::TEXT);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default' => 'CURRENT_TIMESTAMP']);
        $table->setPrimaryKey(['id']);
    }

    public function down(): void
    {
        // Table drop / modification code goes here

        echo get_class($this) . ' "down" method called' . PHP_EOL;
    }
};