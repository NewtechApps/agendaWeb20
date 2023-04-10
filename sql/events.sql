-- agenda_desenv.events definition

ALTER TABLE `events` ALTER COLUMN `tipo_periodo` char(1) NOT NULL;
ALTER TABLE `events` ADD `tipo_alocacao` smallint(6) DEFAULT 0;
