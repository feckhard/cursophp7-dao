<?php

$connpdo = new PDO("mysql:dbname=dbphp7;host=localhost","root","root");
$connpdo->beginTransaction();

echo "<br/>"."Teste banco de dados cap 62 25/02/2020"."<br/>";

$stmt = $connpdo->prepare("
SELECT `tb_usuarios`.`idusuario`,
    `tb_usuarios`.`deslogin`,
    `tb_usuarios`.`dessenha`,
    `tb_usuarios`.`dtcadastro`
FROM `dbphp7`.`tb_usuarios`	
	");

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	foreach ($results as $row) {
		foreach ($row as $key => $value) {
			echo "<strong>".$key.":</strong>".$value."<br/>";
		}

		echo "******************************************<br>";
}

echo "<br/>"."FIM Teste banco de dados cap 62 25/02/2020"."<br/>";

?>