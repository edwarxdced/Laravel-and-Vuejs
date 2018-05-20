@extends('app')

@section('content')

<div id="crud" class="row">
	<div class="col-12 text-center">
		<div class="font-size-h2 py-30 mb-20 text-center border-b">
            <span class="text-secundary font-w700">
            	CRUD con Laravel y Vue.js
            </span>
        </div>
	</div>

	<div class="col-7">
		<div class="block block-bordered block-rounded">
			<div class="block-header">
				<h3 class="block-title">
					<i class="fa fa-list-ol"> </i>
					Lista de tareas
				</h3>
				<div class="block-options">
					<button class="btn btn-primary" data-toggle="modal" data-target="#create">
						<i class="fa fa-plus-square"> </i>
						Nueva tarea
					</button>
				</div>
			</div>

			<div class="block-content">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th v-for="column in columns">

					          <i v-if="column != '' " v-bind:class="[column.toLowerCase() == isSort ?  currentSortDir == 'asc' ? 'fa fa-long-arrow-down' : 'fa fa-long-arrow-up' : 'fa fa-arrows-v text-primary-lighter']"></i>
					          <a href="#" @click.prevent="sort(column.toLowerCase())" v-text="column"> </a>
					        </th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="keep in sortedKeeps" v-if="loading == false">
							<td width="50px" v-text="keep.id"></td>
							<td v-text="keep.keep"></td>
							<td>
								<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent='editKeep(keep)'>
									<i class="fa fa-edit"></i> Editar
								</a>
							</td>
							<td>
								<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="deleteKeep(keep)">
									<i class="fa fa-trash"></i>	Borrar
								</a>
							</td>
						</tr>
						
						<tr v-if="loading">
							<td colspan="3" class="text-center bg-body-dark">
								<span class="text-info"> 
									  <i class="fa fa-refresh fa-spin"> </i> Cargando.
								</span>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="row item-push">
					<div class="col-md-5 text-left">
						<span class="text-dark">
							Total de registros <span v-text="paginate.total"></span>
						</span>
					</div>
					<div class="col-md-7 text-right">
						<nav aria-label="Page navigation keeps">
							<ul class="pagination">
								<li v-if="paginate.current_page > 1" class="page-item">
									<a class="page-link" href="#" @click.prevent="changePage(paginate.current_page - 1)" >
										<span>Atras</span>
									</a>
								</li>
								
								<li v-for="page in pagesNumber" v-bind:class="[page == isActive ? 'page-item active' : 'page-item']">
									<a class="page-link" href="#" @click.prevent="changePage(page)">
										<span v-text="page"></span>
									</a>
								</li>

								<li v-if="paginate.current_page < paginate.last_page" class="page-item">
									<a class="page-link" href="#" @click.prevent="changePage(paginate.current_page + 1)">
										<span>Siguiente</span>
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>

			@include('create')
			@include('edit')
		</div>
	</div>
	<div class="col-5">
	<pre class="pre-sh">
		<code class="php hljs">
		  sort=@{{currentSort}}, dir=@{{currentSortDir}}
			@{{ $data }}
		</code>
	</pre>
</div>
</div>
@endsection