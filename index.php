<?php

include 'classes.php';

$db = new DB();

//создаём пустой объект
$obj = new stdClass();

$obj->surname = 'Фуников';
$obj->name = 'Андрей';
$obj->patronymic = 'Дмитриевич';
$obj->email = 'funikov.1997@mail.ru';
$obj->country = 'Россия';
$obj->city = 'Белгород';
$obj->login = 'Andre';
$obj->password = '0000';

echo $db->insertRecord('bsu',$obj);
