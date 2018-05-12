<form action="POST" v-on:submit.prevent="updateKeep(fillKeep.id)">
	<div class="modal fade" id="edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<span class="text-secundary font-size-h4 font-w700">
						<i class="fa fa-edit"></i> Editar
					</span>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label for="keep">Tarea</label>
					<input type="text"  name="keep" class="form-control" v-model="fillKeep.keep">
					<span class="text-danger" v-for="error in errors" v-text="error"></span>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="Actualizar">
				</div>
			</div>
		</div>
	</div>
</form>