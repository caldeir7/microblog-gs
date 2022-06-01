<?php 
require "../inc/funcoes-usuarios.php";
require "../inc/cabecalho-admin.php"; 

$lerUsuarioS = lerUsuarios($conexao);
$quantidade = count($lerUsuarioS);


?>
<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Usuários <span class="badge badge-primary"><?=$quantidade?></span>
		</h2>

		<p class="lead text-right">
				<a class="btn btn-primary" href="usuario-insere.php">Inserir novo usuário</a>
		</p>
				
		<div class="table-responsive">
		
			<table class="table table-hover">
				<thead class="thead-light">
					<tr>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Tipo</th>
						<th colspan="2" class="text-center">Operações</th>
					</tr>
				</thead>

				<tbody>
<?php foreach($lerUsuarioS as $lerUsuario) { ?>
					<tr>
						<td><?=$lerUsuario['nome']?></td>
						<td><?=$lerUsuario['email']?></td>
						<td><?=$lerUsuario['tipo']?> </td>
						<td class="text-center">
							<a class="btn btn-warning btn-sm" 
							href="usuario-atualiza.php?id=<?=$lerUsuario['id']?>">
								Atualizar
							</a>
						</td>
						<td class="text-center">
							<a class="btn btn-danger btn-sm excluir" 
							href="usuario-exclui.php?id=<?=$lerUsuario['id']?>">
								Excluir
							</a>
						</td>
					</tr>
<?php } ?>
				</tbody>                
			</table>
	</div>
		
	</article>
</div>

<?php require "../inc/rodape-admin.php"; ?> 