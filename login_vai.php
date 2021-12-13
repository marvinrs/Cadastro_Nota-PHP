<?php 
// Conexão com o banco de dados 
require "conexao.php"; 
 
// Inicia sessões 
session_start(); 
 
// Recupera o login 
$login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE; 
// Recupera a senha, a criptografando em Whirlpool
$senha = isset($_POST["senha"]) ? hash('whirlpool',trim($_POST["senha"])) : FALSE; 
// Usuário não forneceu a senha ou o login 
if(!$login || !$senha) 
{ 
	echo "Você deve digitar sua senha e login!"; 
	exit; 
} 
 
/** 
* Executa a consulta no banco de dados. 
* Caso o número de linhas retornadas seja 1 o login é válido, 
* caso 0, inválido. 
*/
$SQL = "SELECT id, login, senha FROM usuarios WHERE login='$login'";
$result_id = @mysqli_query($cx,$SQL) or die("Erro no banco de dados!");
$total = @mysqli_num_rows($result_id); 
// Caso o usuário tenha digitado um login válido o número de linhas será 1.. 
if($total) 
{
	// Obtém os dados do usuário, para poder verificar a senha e passar os demais dados para a sessão 
	$dados = @mysqli_fetch_array($result_id); 
	
	// Agora verifica a senha 
	if(!strcmp($senha, $dados["senha"])) 
	{
	// TUDO OK! Agora, passa os dados para a sessão e redireciona o usuário 
		$_SESSION["id_usuario"]= $dados["id"];
		$_SESSION["nome_usuario"] = stripslashes($dados["login"]); 
		//$_SESSION["permissao"]= $dados["postar"]; 
		header("Location: inclui.php"); 
		exit; 
	}
	// Senha inválida 
	else
	{
		echo "Senha invalida!"; 
		exit; 
	}
}
// Login inválido 
else
{
	echo "O login fornecido por você é inexistente!"; 
	exit; 
}
?>