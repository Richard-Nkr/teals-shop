<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210405172222 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_23A0E6682EA2E54 ON article (commande_id)');
        $this->addSql('ALTER TABLE commande ADD live_id INT NOT NULL, ADD client_id INT NOT NULL, ADD quantite INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D1DEBA901 FOREIGN KEY (live_id) REFERENCES live (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D1DEBA901 ON commande (live_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EEAA67D19EB6921 ON commande (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6682EA2E54');
        $this->addSql('DROP INDEX IDX_23A0E6682EA2E54 ON article');
        $this->addSql('ALTER TABLE article DROP commande_id');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D1DEBA901');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('DROP INDEX IDX_6EEAA67D1DEBA901 ON commande');
        $this->addSql('DROP INDEX UNIQ_6EEAA67D19EB6921 ON commande');
        $this->addSql('ALTER TABLE commande DROP live_id, DROP client_id, DROP quantite');
    }
}
