<?php

//класс базы данных
class DB {

    //свойства для базы
    //адрес БД
    public $db_host;
    //Пользователь БД
    public $db_user;
    //Пароль БД
    public $db_password;
    //Имя БД
    public $db_base;

    public function setConnect() {
        $this->db_user = 'root';
        $this->db_password = '';
        $this->db_base = 'test_db';
        $this->db_host = 'localhost';

        $mysqli = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_base);
        $mysqli->set_charset("utf8");
        if ($mysqli->connect_error) {
            echo "Ошибка подключения к базе данных";
        }
        return $mysqli;
    }

    //метод вставляет запись в базу данных
    function insertRecord($table_name='',$obj='',$print='') {
        $mysqli = $this->setConnect();
        //записываем в массив значения объекта
        $keys = get_object_vars($obj);
        //записываем в массив поля базы данных, в которые вставляем значения
        $keys1 = array_keys($keys);


        //формируем строку полей для запроса к базе данных
        $string_fields = '(`';

        //объявляем цикл по количеству полей базы данных
        for ($i = 0; $i < count($keys1); $i++) {
            $string_fields .= $keys1[$i];
            $string_fields .= '`';
            //если мы не находимся на последнем шаге цикла
            if ($i!=count($keys1)-1) {
                $string_fields .= ', ';
                $string_fields .= '`';
            }
        }
        //в этой строке хранятся имена полей, в которые вставляем значения
        $string_fields .= ')';

        $string_for_insert = "('";
        for ($i = 0; $i < count($keys); $i++) {
            $string_for_insert .= ($obj->{$keys1[$i]});
            $string_for_insert .= "'";
            if ($i!=count($keys)-1) {
                $string_for_insert .= ', ';
                $string_for_insert .= "'";
            }
        }
        $string_for_insert .= ')';

        //считаем крайний ИД в таблице
        $ins = $mysqli->query("INSERT INTO `$table_name` $string_fields VALUES $string_for_insert");
        if (!$ins) {
            echo 'запись не вставлена';
            echo '<pre>';
            echo("INSERT INTO `$table_name` $string_fields VALUES $string_for_insert;");
            echo '</pre>';
        }
        if ($print!='') {
            echo '<pre>';
            echo("INSERT INTO $table_name $string_fields VALUES $string_for_insert;");
            echo '</pre>';
        }
        $last_id = $mysqli->query("SELECT MAX(`id`) FROM $table_name");
        // возвращаем вставленный ИД
        return (mysqli_fetch_assoc($last_id)["MAX(`id`)"]);


    }

}
