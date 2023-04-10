-- agenda_desenv.consultaAgendas source

CREATE OR REPLACE
ALGORITHM = UNDEFINED VIEW `consultaAgendas` AS
select
    `agenda`.`id` AS `id`,
    `agenda`.`id_evento` AS `id_geral`,
    `agenda`.`title` AS `descricao`,
    case
        when `agenda`.`status` = '0' then concat('*** ', convert(`usuario`.`nome` using utf8mb3), ' - ', `agenda`.`title`)
        else concat(convert(`usuario`.`nome` using utf8mb3), ' - ', `agenda`.`title`)
    end AS `title`,
    case
        when `agenda`.`status` = '0' then 'red'
        else concat('#', `trabalho`.`cor`)
    end AS `backgroundColor`,
    case
        when `agenda`.`status` = '0' then 'red'
        else concat('#', `trabalho`.`cor`)
    end AS `borderColor`,
    `linha_produto`.`id_linha_produto` AS `linhaAtuacao`,
    `linha_produto`.`descricao` AS `descAtuacao`,
    `usuario`.`nome` AS `nome`,
    `usuario`.`id_usuario` AS `usuario`,
    `agenda`.`empresa` AS `empresa`,
    `agenda`.`status` AS `status`,
    `agenda`.`start` AS `dataInicial`,
    `agenda`.`start` AS `start`,
    `agenda`.`end` AS `end`,
    `agenda`.`tipo_data` AS `tipo_data`,
    `agenda`.`tipo_periodo` AS `tipo_periodo`,
    `agenda`.`tipo_trabalho` AS `tipo_trabalho`,
    `agenda`.`tipo_alocacao` AS `tipo_alocacao`,
    `trabalho`.`descricao` AS `descTrabalho`,
    case
        when `agenda`.`tipo_periodo` = '2' then 'Extra'
        when `agenda`.`tipo_periodo` = '1' then 'Part-Time: Manhã'
        when `agenda`.`tipo_periodo` = '3' then 'Part-Time: Tarde'
        else 'Integral'
    end AS `periodo`,
    case
        when `agenda`.`tipo_alocacao` = '1' then 'Remota'
        else 'Presencial'
    end AS `alocacao`,
    (
    select
        `usuario`.`nome`
    from
        `usuario`
    where
        `usuario`.`id_usuario` = `agenda`.`id_creator`) AS `nomeGestor`
from
    (((`events` `agenda`
join `usuario` on
    (`usuario`.`id_usuario` = `agenda`.`id_usuario`))
join `trabalho` on
    (`trabalho`.`id_trabalho` = `agenda`.`tipo_trabalho`))
join `linha_produto` on
    (`linha_produto`.`id_linha_produto` = `usuario`.`id_linha_produto`))
where
    `usuario`.`status` = '0'
    and `agenda`.`deleted_at` is null
    and `trabalho`.`status` = '0';
