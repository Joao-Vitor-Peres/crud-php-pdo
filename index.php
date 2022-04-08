<?php
    require_once 'classPessoa.php';
    $p = new Pessoa("crudpdo","localhost","root","");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <?php
        if(isset($_POST['nome'])) //Clicou no Botão cadastrar ou editar
        {
            //-----------------EDITAR--------------//
            if(isset($_GET['id_up']) && !empty($_GET['id_up']))
            {   
                $id_upd = addslashes($_GET['id_up']);
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                
                if(!empty($nome) && !empty($telefone) && !empty($email))
                {
                
                 //EDITAR
                $p->atualizarDadosPessoa($id_upd,$nome,$telefone,$email);
                header("location: index.php");
                
                }else{
                    ?>
                    <div class="aviso">
                        <img src="imagem/aviso.png">
                        <h4>Preencha Todos os Campos</h4>     
                    </div>
                  <?php  
                }
            }
            else //--------CADASTRAR----------//
            {
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                if(!empty($nome) && !empty($telefone) && !empty($email)){
                    //cadastrar
                if(!$p->cadastrarPessoa($nome,$telefone,$email))
                {
                    ?>
                    <div class="aviso">
                        <img src="imagem/aviso.png">
                        <h4>E-mail já está cadastrado</h4>     
                    </div>
                  <?php   
                }
                
                }else{
                    ?>
                    <div class="aviso">
                        <img src="imagem/aviso.png">
                        <h4>Preencha todos os campos</h4>     
                    </div>
                  <?php                }
            }   

            
        }
    ?>

    <?php
        if(isset($_GET['id_up'])){ //Se a pessoa clicou em Editar

        $id_update = addslashes($_GET['id_up']);
        $res = $p->buscarDadosPessoa($id_update);

     }
    ?>
    <section id ="esquerda">
        <form method="POST">
                <h2>CADASTRO PESSOA</h2>
                <label for="nome">NOME</label>
                <input type="text" name = "nome" id = "nome" 
                value="<?php if(isset($res)){echo $res['nome'];} ?>">

                <label for="telefone">TELEFONE</label>
                <input type="text" name ="telefone" id = "telefone"
                value="<?php if(isset($res)){echo $res['telefone'];} ?>">

                <label for="email">E-MAIL</label>
                <input type="text" name = "email" id = "email"
                value="<?php if(isset($res)){echo $res['email'];} ?>">

                <input type="submit" 
                value = "<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
        </form>
    </section>
    
    <section id = "direita">
        <table class="table">
            
                    <tr id="titulo">
                        <td>Nome</td>
                        <td>Telefone</td>
                        <td colspan="2">E-mail</td>
                    </tr>
                
        <?php 
            $dados = $p->buscarDados();
            if(count($dados)>0) //Se tem pessoas cadastradas no Banco
            {

                for ($i=0; $i < count($dados); $i++) { 
                    echo "<tr>";
                    foreach ($dados[$i] as $k => $v) {
                        
                        if($k != "id")
                        {
                            echo "<td>".$v."</td>";
                        }
                    }
                 ?>
                    <td><a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
                        <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                    </td>
                 <?php
                echo "</tr>";
                }
            }
            else //Banco de dados está vazio
            {
                 ?> 
                    </table>   
                
                    <div class="aviso">
                        <h4>Ainda não há pessoas cadastradas</h4>     
                    </div>
                <?php  
            }
                ?>
    
    </section>

</body>
</html>

<?php 

      if(isset($_GET['id'])){
          $id_pessoa = addslashes($_GET['id']);
          $p->excluirPessoa($id_pessoa);
          header("location: index.php");
      }      

?>