-- agenda_desenv.relatorioAgendas source

CREATE OR REPLACE
ALGORITHM = UNDEFINED VIEW `relatorioAgendas` AS
select
    `linha`.`descricao` AS `LINHA`,
    `usuario`.`id_usuario` AS `USUARIO`,
    `usuario`.`nome` AS `NOME`,
    `agenda`.`empresa` AS `EMPRESA`,
    `calendar`.`id_data` AS `DATACAL`,
    `feriado`.`descricao` AS `FERIADO`,
    `agenda`.`id_evento` AS `AGENDA`,
    `agenda`.`tipo_periodo` AS `tipo_periodo`,
    `agenda`.`tipo_alocacao` AS `tipo_alocacao`,
    case
        when `agenda`.`status` = '0' then concat('*** ', `agenda`.`title`)
        else `agenda`.`title`
    end AS `DESCRICAO`,
    `agenda`.`tipo_trabalho` AS `TIPOTRABALHO`,
    `trabalho`.`descricao` AS `TRABALHO`,
    `agenda`.`status` AS `STATUS`,
    case
        when `agenda`.`status` = '0' then 'red'
        else concat('#', `trabalho`.`cor`)
    end AS `COR`
from
    (((((`usuario`
join `linha_produto` `linha` on
    (`linha`.`id_linha_produto` = `usuario`.`id_linha_produto`))
left join `calendar` on
    (`calendar`.`id_data` > '2000-01-01'))
left join `feriados` `feriado` on
    (`feriado`.`data` = `calendar`.`id_data`))
left join `events` `agenda` on
    (`agenda`.`start` <= `calendar`.`id_data`
        and `agenda`.`end` >= `calendar`.`id_data`
        and `agenda`.`id_usuario` = `usuario`.`id_usuario`))
left join `trabalho` on
    (`trabalho`.`id_trabalho` = `agenda`.`tipo_trabalho`
        and `trabalho`.`status` = '0'))
where
    `usuario`.`status` = '0'
    and `agenda`.`deleted_at` is null
    and `usuario`.`nome` not like 'admin%';
