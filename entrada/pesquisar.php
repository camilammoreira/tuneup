<?php include('../cod/header.php');?>
	<form action="" method="">
		<h4>Pesquisar Registro de Entrada</h4>
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
			<a href="#" class="list-group-item list-group-item-action">Entrada 1<button type="button" class="btn btn-sm btn-link float-right">Alterar</button></a>
			<a href="#" class="list-group-item list-group-item-action">Entrada 2<button type="button" class="btn btn-sm btn-link float-right">Alterar</button></a>
			<a href="#" class="list-group-item list-group-item-action">Entrada 3<button type="button" class="btn btn-sm btn-link float-right">Alterar</button></a>
		</div>
		<nav aria-label="Search Result Pages">
			<ul class="pagination">
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
	</form>    
<?php include('../cod/footer.php');?>