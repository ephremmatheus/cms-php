<?php 
    class Database {
        private static $conn;

        public static function getConnection(){
            if(empty(self::$conn)){
                try{
                    $conexao = parse_ini_file('../config/livro.ini');
                    $host = $conexao['host'];
                    $name = $conexao['name']; 
                    $user = $conexao['user'];
                    $pass = $conexao['pass'];

                    self::$conn = new PDO("mysql:host={$host};name={$name};user={$user};pass={$pass}");
                    self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    echo 'feito';
                } catch(Exception $e){
                    echo $e->getMessage();
                }
                
            } else {
                return self::$conn;
            }
        }

    }

    //teste para saber se está funcionando:
    // Database::getConnection();
?>