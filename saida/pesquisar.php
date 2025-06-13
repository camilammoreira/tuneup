<?php include('../cod/header.php'); ?>

<form action="" method="">

	<h4>Pesquisar Registro de Saída</h4>

	<div class="form-row">

		<div class="form-group col-md-10">

			<input type="text" class="form-control" id="usr">

		</div>

		<div class="form-group">

			<button type="button" class="btn btn-info float-right">Pesquisar</button></br>

		</div>

	</div>

	<div class="list-group">

		<i>Resultados correspondentes:</i>

		<a href="#" class="list-group-item list-group-item-action">Saída 1<button type="button"
				class="btn btn-sm btn-link float-right">Alterar</button></a>

		<a href="#" class="list-group-item list-group-item-action">Saída 2<button type="button"
				class="btn btn-sm btn-link float-right">Alterar</button></a>

		<a href="#" class="list-group-item list-group-item-action">Saída 3<button type="button"
				class="btn btn-sm btn-link float-right">Alterar</button></a>

		<nav aria-label="Search Results pages">

			<ul class="pagination text-center">

				<li class="page-item">

					<a class="page-link" href="#" aria-label="Previous">

						<span aria-hidden="true">&laquo;</span>

						<span class="sr-only">Previous</span>

					</a>

				</li>

				<li class="page-item"><a class="page-link" href="#">1</a></li>

				<li class="page-item"><a class="page-link" href="#">2</a></li>

				<li class="page-item"><a class="page-link" href="#">3</a></li>

				<li class="page-item">

					<a class="page-link" href="#" aria-label="Next">

						<span aria-hidden="true">&raquo;</span>

						<span class="sr-only">Next</span>

					</a>

				</li>

			</ul>

		</nav>

	</div>

</form>

<?php include('../cod/footer.php'); ?>