<?php include('../cod/header.php');?>
	<form action="" method="">
		<h4>Alterar Registro de Saída</h4></br>
		<div class="form-group">
			<label for="cod">Código Interno</label>
			<input type="text" class="form-control col-lg-3" id="cod" disabled>
		</div>
		<div class="form-group">
			<label for="nome">Nome <small>(Opcional)</small></label>
			<input type="text" class="form-control" id="nome">
		</div>
		<div class=text-right>
			<button class="btn btn-default text-right mt-1">Cancelar</button>
			<input type="submit" value="Alterar" class="btn btn-info text-right mt-1" />
		</div>
	</form>
	<hr>
		<div>
			<p><b>Registro nº 00000 (nome):</b></p>
			<table class="table">
				<thead>
					<tr>
						<th>Qnt.</th>
						<th>Produto</th>
						<th>Setor</th>
						<th>V. Total</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody id="registroSaida">
					<tr>
						<td><!--QUANTIDADE-->
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" value="15" disabled>
							</div>
						</td>
						<td><!--PRODUTO-->
							<div class="input-group input-group-sm">
								<select id="produto" class="form-control" disabled>
									<option>Escolha...</option>
									<option selected>Mouse Tal Tal Tal</option>
									<option>Teclado</option>
									<option>Monitor</option>
								</select>
							</div>
						</td>
						<td><!--SETOR-->
							<div class="input-group input-group-sm">
								<select id="setor" class="form-control" disabled>
									<option>Escolha...</option>
									<option selected>Administração</option>
									<option>Almoxerifado</option>
									<option>Docentes</option>
								</select>
							</div>
						</td>
						<td><!--TOTAL-->
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-sm">R$</span>
								</div>
								<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="100,00" disabled>
							</div>
						</td>
						<td><!--AÇÃO-->
							<button class="btn btn-sm btn-light float-left" title="Excluir"><img src="../img/lixeira.png" alt="Excluir"></button>
							<button class="btn btn-sm btn-light float-left" title="Editar"><img src="../img/Edit.png" alt="Editar"></button>
						</td>
					</tr>                       
					<tr>
						<td><!--QUANTIDADE-->
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="25" disabled>
							</div>
						</td>
						<td><!--PRODUTO-->
							<div class="input-group input-group-sm">
								<select id="produto" class="form-control" disabled>
									<option>Escolha...</option>
									<option>Mouse</option>
									<option selected>Teclado</option>
									<option>Monitor</option>
								</select>
							</div>
						</td>
						<td><!--SETOR-->
							<div class="input-group input-group-sm">
								<select id="setor" class="form-control" disabled>
									<option>Escolha...</option>
									<option selected>Administração</option>
									<option>Almoxerifado</option>
									<option selected>Docentes</option>
								</select>
							</div>
						</td>
						<td><!--TOTAL-->
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-sm">R$</span>
								</div>
								<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="180,00" disabled>
							</div>
						</td>
						<td><!--AÇÃO-->
							<button class="btn btn-sm btn-light float-left" title="Excluir"><img src="../img/lixeira.png" alt="Excluir"></button>
							<button class="btn btn-sm btn-light float-left" title="Editar"><img src="../img/Edit.png" alt="Editar"></button>
						</td>
					</tr>
				</tbody>
			</table>
			<input type="submit" value="Excluir Tudo" class="btn btn-danger float-left mt-1"/>
			<div class="text-right">
				<input type="submit" value="Cancelar" class="btn btn-default mt-1"/>
				<input type="submit" value="Finalizar" class="btn btn-info mt-1"/>
			</div>
		</div>
<?php include('../cod/footer.php');?>