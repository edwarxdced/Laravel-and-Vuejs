var urlUsers = 'https://jsonplaceholder.typicode.com/users';

new Vue({
	el: '#crud',
	created: function() {
		this.getKeeps();
	},
	data: {
		keeps: [],
		paginate:{
			'total':0,     
            'current_page':0,
            'per_page':0, 
            'last_page':0,  
            'from':0,      
            'to':0,        
            'total':0     
		},
		newKeep:null,
		fillKeep:{id:'',keep:''},
		errors:[],
		offset: 3,
		loading:false,
		columns:['Id','Tarea','',''],
		currentSort:'id',
  		currentSortDir:'desc'
	},
	computed:{
		isActive: function(){
			return this.paginate.current_page;
		},
		pagesNumber: function(){
			if(!this.paginate.to){
				return [];
			}

			var from = this.paginate.current_page - this.offset;
			if (from < 1) {
				from = 1;
			}

			var to = from + (this.offset*2);
			if (to >= this.paginate.last_page) {
				to = this.paginate.last_page;
			}

			var pagesArray = [];
			while (from <= to) {
				pagesArray.push(from);
				from++;
			}
			return pagesArray;
		},
		sortedKeeps: function() {
		    return this.keeps.sort((a,b) => {
		      let modifier = 1;
		      if(this.currentSortDir === 'desc') modifier = -1;
		      if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
		      if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
		      return 0;
		    });
		}
	},
	methods: {
		getKeeps:function(numberPage=1){
			this.loading = true;
			
			var urlKeeps = 'task?page='+numberPage;
			axios.get(urlKeeps).then(response => {
				this.keeps    = response.data.tasks.data;
				this.paginate = response.data.paginate;
				this.loading  = false;
			});
		},
		editKeep: function(keep){
			this.fillKeep.id = keep.id;
			this.fillKeep.keep = keep.keep;
			$('#edit').modal('show');
		},
		updateKeep: function(id){
			var url = 'task/'+id;
			axios.put(url,this.fillKeep).then(response => {
				this.getKeeps();
				this.fillKeep.id   = '';
				this.fillKeep.name = '';
				this.error         = [];
				$('#edit').modal('hide');
				toastr.success('Tarea '+id+' actualizada con exito.');
			}).catch(error => {
				this.error = error.response.data;
			});
		},
		deleteKeep:function(keep){
			if (!confirm("¿Está seguro de eliminar?")) {
            	return false;
          	}
			var url = 'task/'+keep.id;
			axios.delete(url).then(response => {
				this.getKeeps();
				toastr.success('Eliminado correctamente.');
			});
		},
		createKeep: function(){
			var urlKeep = 'task';
			axios.post(urlKeep,{
				keep:this.newKeep
			}).then((response) => {
				this.getKeeps();
				this.newKeep = null;
				this.errors = [];

				$('#create').modal('hide');
				toastr.success('Nueva tarea creada con exito.');
			}).catch((error) => {
				this.errors = error.response.data;
			})
		},
		changePage: function(numberPage){
			this.paginate.current_page = numberPage;
			this.getKeeps(numberPage);
		},
		sort:function(s) {
			s = s == 'tarea' ? 'keep' : s;
		    //if s == current sort, reverse
		    if(s === this.currentSort) {
		      this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
		    }
		    this.currentSort = s;
		}
	}
});