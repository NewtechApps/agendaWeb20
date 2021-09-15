CREATE 
VIEW `consultaagendas` AS
    SELECT 
        `agenda`.`id` AS `id`,
        `agenda`.`id_evento` AS `id_geral`,
        `agenda`.`title` AS `descricao`,
        
        (CASE
            WHEN
                (`agenda`.`status` = '0')
            THEN
                CONCAT('*** ',
                        CONVERT( `agenda_desenv`.`usuario`.`nome` USING UTF8),
                        ' - ',
                        `agenda`.`title`)
            ELSE CONCAT(CONVERT( `agenda_desenv`.`usuario`.`nome` USING UTF8),
                    ' - ',
                    `agenda`.`title`)
        END) AS `title`,
        
        (CASE
            WHEN (`agenda`.`status` = '0') THEN 'red'
            ELSE CONCAT('#', `agenda_desenv`.`trabalho`.`cor`)
        END) AS `backgroundColor`,
        (CASE
            WHEN (`agenda`.`status` = '0') THEN 'red'
            ELSE CONCAT('#', `agenda_desenv`.`trabalho`.`cor`)
        END) AS `borderColor`,
        
        `linha_produto`.`id_linha_produto` AS `linhaAtuacao`,
        `linha_produto`.`descricao`        AS `descAtuacao`,
        
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
        `trabalho`.`descricao` AS `descTrabalho`,
        
        (CASE
            WHEN (`agenda`.`tipo_periodo` = '2') THEN 'Extra'
            WHEN (`agenda`.`tipo_periodo` = '1') THEN 'Part-Time'
            ELSE 'Integral'
        END) AS `periodo`,
        
        (SELECT   `usuario`.`nome`
            FROM  `usuario`
            WHERE `usuario`.`id_usuario` = `agenda`.`id_creator`) AS `nomeGestor`
    FROM
        `events` `agenda`
        JOIN `usuario`       ON `usuario`.`id_usuario` = `agenda`.`id_usuario`
        JOIN `trabalho`      ON `trabalho`.`id_trabalho` = `agenda`.`tipo_trabalho`
		JOIN `linha_produto` ON `linha_produto`.`id_linha_produto`=`usuario`.`id_linha_produto`
    WHERE
        ((`usuario`.`status` = '0')
            AND (`agenda`.`deleted_at` IS NULL)
            AND (`trabalho`.`status` = '0'))