<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 22.05.17
 * Time: 15:03
 */
require_once 'app/src/abstract/ActiveRecord.php';
require_once 'app/src/util/Db.php';

$files = glob('app/src/model/*.php');

foreach ($files as $file){
    require_once ($file);
}