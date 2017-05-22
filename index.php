<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 22.05.17
 * Time: 15:02
 */
require_once ('autoloader.php');

$user2 = new User();
$user2->setUsername('user');
$user2->setEmail('user@user.pl');
$user2->setPasswordHash('user');
$user2->save();
$user2 = User::loadByEmail('user@user.pl');
var_dump($user2);
$user4 = new User();
$user4->setUsername('user3');
$user4->setEmail('user3@user3');
$user4->setPasswordHash('user3');
$user4->save();
$user4 = User::loadById('3');
var_dump($user4);
$users = User::loadAll();
var_dump($users);

$user3 = User::loadById('2');
var_dump($user3);

$user5 = User::loadById('2');

$user5->setUsername('misiek');
$user5->save();
