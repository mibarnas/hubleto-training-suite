<?php

namespace Hubleto\App\External\TrainingSuite\Trainings\Models\Migrations;

class Training_0001 extends \Hubleto\App\External\TrainingSuite\Common\Migration
{

  public function upgradeSchema(): void
  {
    $this->db->execute("set foreign_key_checks = 0;
drop table if exists `trainings`;
set foreign_key_checks = 1;");
    $this->db->execute("SET foreign_key_checks = 0;
create table `trainings` (
 `id` int(8) primary key auto_increment,
 `name` varchar(255) ,
 `number` varchar(255) ,
 `price` decimal(14, 2) ,
 `id_currency` int(8) NULL default NULL,
 `interval` int(255) ,
 `id_company` int(8) NULL default NULL,
 `template` varchar(255) ,
 `template_params` text ,
 `name_validator` varchar(255) ,
 `external_number` varchar(255) ,
 `date_external_issued` date ,
 `is_active` int(1) ,
 `description` text ,
 `id_owner` int(8) NULL default NULL,
 `id_manager` int(8) NULL default NULL,
 `shared_with` text ,
 index `id` (`id`),
 index `id_currency` (`id_currency`),
 index `interval` (`interval`),
 index `id_company` (`id_company`),
 index `date_external_issued` (`date_external_issued`),
 index `is_active` (`is_active`),
 index `id_owner` (`id_owner`),
 index `id_manager` (`id_manager`)) ENGINE = InnoDB;
SET foreign_key_checks = 1;");
  }

  public function downgradeSchema(): void
  {
    $this->db->execute("set foreign_key_checks = 0;
drop table if exists `trainings`;
set foreign_key_checks = 1;");
  }

  public function upgradeForeignKeys(): void
  {
    // Foreign keys are added only after all schema migrations have run, and
    // Training_0002 drops id_currency, id_owner and id_manager -- so on a fresh
    // install those columns are already gone and their constraints are skipped.
    $foreignKeys = [
      'fk_0a44a3c592fe54aca1eafe3eb4b4c476' => ['id_currency', 'currencies'],
      'fk_bc966702113505bffd335c0353407712' => ['id_company', 'companies'],
      'fk_bfb936af5cf6925e5241c5e2fef0d3a1' => ['id_owner', 'users'],
      'fk_06dacaa323a455103d945fe5b22bacdf' => ['id_manager', 'users'],
    ];

    foreach ($foreignKeys as $name => [$column, $referencedTable]) {
      if (!$this->hasColumn('trainings', $column)) continue;
      $this->db->execute("ALTER TABLE `trainings`
          ADD CONSTRAINT `{$name}`
          FOREIGN KEY (`{$column}`)
          REFERENCES `{$referencedTable}` (`id`)
          ON DELETE RESTRICT
          ON UPDATE RESTRICT;");
    }
  }

  public function downgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `trainings`
          DROP FOREIGN KEY `fk_0a44a3c592fe54aca1eafe3eb4b4c476`; ALTER TABLE `trainings`
          DROP FOREIGN KEY `fk_bc966702113505bffd335c0353407712`; ALTER TABLE `trainings`
          DROP FOREIGN KEY `fk_bfb936af5cf6925e5241c5e2fef0d3a1`; ALTER TABLE `trainings`
          DROP FOREIGN KEY `fk_06dacaa323a455103d945fe5b22bacdf`;");
  }
}