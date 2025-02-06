<?php
declare(strict_types=1);

$cfg['blowfish_secret'] = '';

$i = 0;

$i++;
/* Server parameters */
$cfg['Servers'][$i]['host'] = 'localhost';
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = '';
/* $cfg['Servers'][$i]['only_db'] = 'wordpress'; */
$cfg['Servers'][$i]['AllowNoPassword'] = true;

$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';