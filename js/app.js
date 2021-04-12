var app = new Vue({
  el: "#app",
  data: {
    productos: [],
    categorias: [],
    usuarios: [],
    buscado:[],
    details: [],
    name: '',
    category: 1,
  },
  
  mounted: function () {
    this.getProductos();
    this.getCategorias();
    this.getUsers();
  },
  
  methods: {
    openDetails(p) {
      this.details = p;
    },
    closeDetails() {
      this.details = [];
    },
    getProductos: function () {
      axios.get("php/api.php?action=readp")
      .then(function (response) {
        if (response.data.error) {
          app.errorMessage = response.data.message;
        } else {
          app.productos = response.data.productos;
        }
      })
    },
    getUsers: function () {
      axios.get("php/api.php?action=readu")
      .then(function (response) {
        if (response.data.error) {
          app.errorMessage = response.data.message;
        } else {
          app.usuarios = response.data.usuarios;
        }
      })
    },
    getCategorias: function () {
      axios.get("php/api.php?action=readc")
      .then(function (response) {
        if (response.data.error) {
          app.errorMessage = response.data.message;
        } else {
          app.categorias = response.data.categorias;
        }
      })
    },
  },
  computed: {

      searchUser: function() {
        return this.searchCategory.filter((p) => p.nombre.includes(this.name));
      },

      searchCategory: function() {
        return this.productos.filter((p) => (p.idCategoriaProducto == this.category))
      },

      getTotalusuarios: function () {
        return this.Usuarios.length;
      },
  
      UsuariosVacio: function () {			
        return this.getTotalUsuarios == 0;
      },
  
      busqueda: function () {
          return this.filtrados.filter((item) => item.busqueda.includes(this.busqueda));
      },
      busquedaid: function () {
        return this.filtrados.filter((item) => item.busqueda.includes(this.busqueda));
      }
  
    },
  })
    