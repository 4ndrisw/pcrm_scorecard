<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'scorecards')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "scorecards` (
      `id` int(11) NOT NULL,
      `rel_id` int(11) NOT NULL DEFAULT 0,
      `rel_type` varchar(20) DEFAULT NULL,
      `staff_id` int(11) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'scorecards`
      ADD PRIMARY KEY (`id`),
      ADD UNIQUE KEY `staff_rel_id` (`rel_id`,`rel_type`,`staff_id`) USING BTREE,
      ADD KEY `staff_id` (`staff_id`),
      ADD KEY `schedule_id` (`rel_id`) USING BTREE,
      ADD KEY `rel_type` (`rel_type`);'
    );

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'scorecards`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1');
}

if (!$CI->db->table_exists(db_prefix() . 'scorecards_tasks_duration')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "scorecards_tasks_duration` (

      `id` int(11) NOT NULL,
      `task_id` int(11) DEFAULT NULL,
      `name` mediumtext DEFAULT NULL,
      `rel_id` int(11) DEFAULT NULL,
      `rel_type` varchar(20) DEFAULT NULL,
      `client_id` int(11) DEFAULT NULL,
      `dateadded` datetime DEFAULT NULL,
      `datefinished` datetime DEFAULT NULL,
      `duration` smallint(3) DEFAULT NULL,
      `staff_id` int(1) DEFAULT NULL,
      `firstname` varchar(30) DEFAULT NULL,
      `lastname` varchar(30) DEFAULT NULL

    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'scorecards_tasks_duration`
      ADD PRIMARY KEY (`id`),
      ADD UNIQUE KEY `task_id` (`task_id`),
      ADD KEY `rel_id` (`rel_id`),
      ADD KEY `duration` (`duration`),
      ADD KEY `staff_id` (`staff_id`),
      ADD KEY `client_id` (`client_id`);'
    );

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'scorecards_tasks_duration`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1');
}


/*

DROP TABLE `tblscorecards`;
DROP TABLE `tblscorecards_tasks_duration`;

delete FROM `tbloptions` WHERE `name` LIKE '%jobreport%';
DELETE FROM `tblemailtemplates` WHERE `type` LIKE 'jobreport';

*/