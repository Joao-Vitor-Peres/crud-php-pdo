<?php 

Class Pessoa{

    private $pdo;
 
    //Conexão com o Banco de Dados
     public function __construct($dbname, $host, $user,$senha)
     {
         try
        {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
        }
        catch(PDOException $e)
        {
            echo "Erro com o Banco de Dados: ".$e->getMessage();
        }catch(Exception $e){
            echo "Erro Generico: ".$e->getMessage();
        }

     }

    //Função que Busca os dados e retornam na Tabela a direita
     public function buscarDados()
     {
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY id");
        //Converte os Dados buscados da Tabela Pessoa em array
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
     }

     
     //Cadastra Pessoa no Banco de Dados
     public function cadastrarPessoa($nome,$telefone,$email){

        //Antes de cadastrar verifica se existe o Email
         $cmd = $this->pdo->prepare("SELECT id from pessoa WHERE email = :e");
         $cmd->bindValue(":e",$email);
         $cmd->execute();
         if($cmd->rowCount()>0) //email já existe no banco
         {
            return false;
         }else //Não foi encontrado o email
         
         {
            $cmd = $this->pdo->prepare("INSERT INTO pessoa(nome,telefone,email)VALUES(:n, :t , :e)");
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            return true;
         }

     }

     //Excluir Pessoa
     public function excluirPessoa($id){

        $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute(); 
    }

    
    //Buscar os dados de uma Pessoa
    public function buscarDadosPessoa($id){
    $res = array();
    $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
    $cmd->bindValue(":id",$id);
    $cmd->execute();
    $res = $cmd->fetch(PDO::FETCH_ASSOC);
    return $res;
    }

    //Atualizar dados no Banco de dados
    public function atualizarDadosPessoa($id,$nome,$telefone,$email)
    {
        $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, 
        telefone = :t, email = :e WHERE id = :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":e", $email);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    
    }

}





?>