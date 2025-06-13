<?php include('../cod/header.php'); ?>

<form action="" method="">

	<h4>Registrar Saída</h4></br>

	<div class="form-group">

		<label for="cod">Código Interno</label>

		<input type="text" class="form-control col-lg-3" id="cod">

	</div>

	<div class="form-group">

		<label for="nome">Nome <small>(Opcional)</small></label>

		<input type="text" class="form-control" id="nome">

	</div>

	<div class=text-right>

		<input type="submit" value="Cancelar" class="btn btn-default text-right mt-1" />

		<input type="submit" value="Cadastrar" class="btn btn-info text-right mt-1" />

	</div>

</form>

<hr>

<div class="p-2 col-lg-6 mx-auto">

	<form action="" method="">

		<div class="form-group">

			<label for="produto">Produto</label>

			<select id="produto" class="form-control" disabled>

				<option selected>Escolha...</option>

				<option>Mouse</option>

				<option>Teclado</option>

				<option>Monitor</option>

			</select>

		</div>

		<div class="form-group">

			<label for="setor">Setor</label>

			<select id="setor" class="form-control" disabled>

				<option selected>Escolha...</option>

				<option>Almoxerifado</option>

				<option>Administração</option>

				<option>CGAE</option>

			</select>

		</div>

		<div class="form-row">

			<div class="form-group col-md-6">

				<label for="quantidade">Qnt.</label>

				<input type="text" class="form-control" id="quantidade" disabled />

			</div>

			<div class="form-group col-md-6">

				<label for="valor">Valor Unitário</label>

				<input type="text" class="form-control" id="valor" disabled />

			</div>

		</div>

		<div class=text-right>

			<input type="submit" value="Adicionar item" class="btn btn-info text-right mt-1" disabled />

		</div>

	</form>

</div>

<div>

	<p><i>Prévia do Registro nº 00000 (nome):</i></p>

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

						<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm"
							value="100,00" disabled>

					</div>

				</td>

				<td><!--AÇÃO-->

					<button class="btn btn-sm btn-light float-left" title="Excluir" disabled><img src="../img/lixeira.png" alt="Excluir"></button>

					<button class="btn btn-sm btn-light float-left" title="Editar" disabled><img src="../img/Edit.png" alt="Editar"></button>

				</td>

			</tr>

			<tr>

				<td><!--QUANTIDADE-->

					<div class="input-group input-group-sm">

						<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="25"
							disabled>

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

						<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm"
							value="180,00" disabled>

					</div>

				</td>

				<td><!--AÇÃO-->

					<button class="btn btn-sm btn-light float-left" title="Excluir" disabled><img src="../img/lixeira.png" alt="Excluir"></button>

					<button class="btn btn-sm btn-light float-left" title="Editar" disabled><img src="../img/Edit.png" alt="Editar"></button>

				</td>

			</tr>

		</tbody>

	</table>

	<div class=text-right>

		<input type="submit" value="Cancelar" class="btn btn-default text-right mt-1" disabled />

		<input type="submit" value="Finalizar" class="btn btn-info text-right mt-1" disabled />

	</div>

</div>

<?php include('../cod/footer.php'); ?>