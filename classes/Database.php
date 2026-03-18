<?php 
    class Database {
        private static $conn;

    public static function getConnection(){
        if(empty(self::$conn)){
            try{
                $conexao = parse_ini_file(__DIR__ . '/../config/livro.ini');
                $host = $conexao['host'];
                $name = $conexao['name'];
                $user = $conexao['user'];
                $pass = $conexao['pass'];

                self::$conn = new PDO("mysql:host={$host};dbname={$name}", $user, $pass); // corrigi a sintaxe
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo 'Conexão feita';
            } catch(Exception $e){
                echo "Erro: " . $e->getMessage();
            }
        }

        return self::$conn;
    }
}

    //teste para saber se está funcionando:
    // Database::getConnection();
?>