<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190423204802 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tag_meal (id INT AUTO_INCREMENT NOT NULL, tag_id INT DEFAULT NULL, meal_id INT DEFAULT NULL, INDEX IDX_70F9312ABAD26311 (tag_id), INDEX IDX_70F9312A639666D6 (meal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_trans (id INT AUTO_INCREMENT NOT NULL, tag_id INT DEFAULT NULL, language_code VARCHAR(2) NOT NULL, translation VARCHAR(40) NOT NULL, INDEX IDX_52CD07BBBAD26311 (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredeint_trans (id INT AUTO_INCREMENT NOT NULL, ingredient_id INT DEFAULT NULL, language_code VARCHAR(2) NOT NULL, translation VARCHAR(40) NOT NULL, INDEX IDX_951B6AE6933FE08C (ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient_meal (id INT AUTO_INCREMENT NOT NULL, ingredient_id INT DEFAULT NULL, meal_id INT DEFAULT NULL, INDEX IDX_C0A73E0A933FE08C (ingredient_id), INDEX IDX_C0A73E0A639666D6 (meal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, slug VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(20) NOT NULL, slug VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_64C19C1989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE languages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, code VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(50) NOT NULL, desctription VARCHAR(50) NOT NULL, status VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9EF68E9C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_trans (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, language_code VARCHAR(2) NOT NULL, translation VARCHAR(40) NOT NULL, INDEX IDX_981251F412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, slug VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag_meal ADD CONSTRAINT FK_70F9312ABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE tag_meal ADD CONSTRAINT FK_70F9312A639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
        $this->addSql('ALTER TABLE tag_trans ADD CONSTRAINT FK_52CD07BBBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE ingredeint_trans ADD CONSTRAINT FK_951B6AE6933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE ingredient_meal ADD CONSTRAINT FK_C0A73E0A933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE ingredient_meal ADD CONSTRAINT FK_C0A73E0A639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category_trans ADD CONSTRAINT FK_981251F412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE meal_trans ADD CONSTRAINT FK_CAEBF66B639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tag_meal DROP FOREIGN KEY FK_70F9312ABAD26311');
        $this->addSql('ALTER TABLE tag_trans DROP FOREIGN KEY FK_52CD07BBBAD26311');
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C12469DE2');
        $this->addSql('ALTER TABLE category_trans DROP FOREIGN KEY FK_981251F412469DE2');
        $this->addSql('ALTER TABLE meal_trans DROP FOREIGN KEY FK_CAEBF66B639666D6');
        $this->addSql('ALTER TABLE tag_meal DROP FOREIGN KEY FK_70F9312A639666D6');
        $this->addSql('ALTER TABLE ingredient_meal DROP FOREIGN KEY FK_C0A73E0A639666D6');
        $this->addSql('ALTER TABLE ingredeint_trans DROP FOREIGN KEY FK_951B6AE6933FE08C');
        $this->addSql('ALTER TABLE ingredient_meal DROP FOREIGN KEY FK_C0A73E0A933FE08C');
        $this->addSql('DROP TABLE tag_meal');
        $this->addSql('DROP TABLE tag_trans');
        $this->addSql('DROP TABLE ingredeint_trans');
        $this->addSql('DROP TABLE ingredient_meal');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE category_trans');
        $this->addSql('DROP TABLE ingredient');
    }
}
