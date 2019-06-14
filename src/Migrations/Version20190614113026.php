<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190614113026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            INSERT INTO `user` (`email`, `roles`, `password`)
            VALUES
                (\'user@getlocale.com\', CONVERT(\'["ROLE_USER"]\' USING UTF8MB4), \'$2y$12$IQsvegTUAyWjH5Ubo/zM0.2Em5jMDchnsra3ywjUKFx2V/MxjqvmC\'),
                (\'admin@getlocale.com\', CONVERT(\'["ROLE_ADMIN"]\' USING UTF8MB4), \'$2y$12$uTzvxZDHcw5E/kOkshRyuetUzvYw1WlGLUIfs0Fd8vHwHRJabzHT2\'),
                (\'user2@getlocale.com\', CONVERT(\'["ROLE_USER"]\' USING UTF8MB4), \'$2y$12$IQsvegTUAyWjH5Ubo/zM0.2Em5jMDchnsra3ywjUKFx2V/MxjqvmC\');
            ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
