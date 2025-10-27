<?php // migrations/20230305153000.php

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;

return new class
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('users');
        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('name', Types::STRING, ['length' => 255]);
        $table->addColumn('email', Types::TEXT);
        $table->addColumn('password', Types::TEXT);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default' => 'CURRENT_TIMESTAMP']);
        $table->setPrimaryKey(['id']);
    }

    public function down(): void
    {
        // Table drop / modification code goes here

        echo get_class($this) . ' "down" method called' . PHP_EOL;
    }
};
