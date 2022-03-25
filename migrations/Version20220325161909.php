<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220325161909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tvshow_character (tvshow_id INT NOT NULL, character_id INT NOT NULL, INDEX IDX_B107E86E6CD43D7A (tvshow_id), INDEX IDX_B107E86E1136BE75 (character_id), PRIMARY KEY(tvshow_id, character_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tvshow_category (tvshow_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_7902FA776CD43D7A (tvshow_id), INDEX IDX_7902FA7712469DE2 (category_id), PRIMARY KEY(tvshow_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tvshow_character ADD CONSTRAINT FK_B107E86E6CD43D7A FOREIGN KEY (tvshow_id) REFERENCES tvshow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tvshow_character ADD CONSTRAINT FK_B107E86E1136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tvshow_category ADD CONSTRAINT FK_7902FA776CD43D7A FOREIGN KEY (tvshow_id) REFERENCES tvshow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tvshow_category ADD CONSTRAINT FK_7902FA7712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE category_tvshow');
        $this->addSql('DROP TABLE character_tvshow');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_tvshow (category_id INT NOT NULL, tvshow_id INT NOT NULL, INDEX IDX_4B41377D12469DE2 (category_id), INDEX IDX_4B41377D6CD43D7A (tvshow_id), PRIMARY KEY(category_id, tvshow_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE character_tvshow (character_id INT NOT NULL, tvshow_id INT NOT NULL, INDEX IDX_E7EB3E951136BE75 (character_id), INDEX IDX_E7EB3E956CD43D7A (tvshow_id), PRIMARY KEY(character_id, tvshow_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE category_tvshow ADD CONSTRAINT FK_4B41377D6CD43D7A FOREIGN KEY (tvshow_id) REFERENCES tvshow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_tvshow ADD CONSTRAINT FK_4B41377D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_tvshow ADD CONSTRAINT FK_E7EB3E956CD43D7A FOREIGN KEY (tvshow_id) REFERENCES tvshow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_tvshow ADD CONSTRAINT FK_E7EB3E951136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE tvshow_character');
        $this->addSql('DROP TABLE tvshow_category');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `character` CHANGE firstname firstname VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gender gender VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bio bio LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE episode CHANGE title title VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tvshow CHANGE title title VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE synopsis synopsis LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE poster poster VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstname firstname VARCHAR(20) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(20) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
