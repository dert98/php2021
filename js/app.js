var app = new Vue({
  el: "#app",
  data: {
    productos: [],
    categorias: [],
    usuarios: [],
    buscado:[],
    details: [],
    name: '',
    categoria: [],
    checkCaducado: '',
    checkVendido: '',

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

    compareDates: function(dd) {
      const cd = new Date(); // current date
      // const dd = "2021-04-13"; // database date
      const ddp = dd.split("-"); // database date pre-processed
      const ddf = new Date(ddp[0], ddp[1]-1, ddp[2]); // database date formatted
      const state = (cd > ddf) ? "Caducado" : "En fecha";
      return state;
    },


  },
  computed: {

      currentDate: function() {
        // Obtenemos la fecha actual (new Date()) y la formateamos como 30/12/2021 
        return new Intl.DateTimeFormat('en-AU').format(new Date());
      },

      searchCategory: function() {
        // Retorno el filtrado por categoría del array de productos 
        return this.productos.filter((p) => (p.idCategoriaProducto == this.categoria))
      },
      
      searchName: function() {
        // Retorno el filtrado por nombre del array resultado del filtado por categoría
        return this.searchCategory.filter((p) => p.nombre.includes(this.name));
      },

      filterExpired: function() {
        // Si checkCaducado es true retorno el array filtrado con los productos caducados, sino, retorno el filtrado por nombre 
        return (this.checkCaducado ? this.searchName.filter((p) => this.compareDates(p.caducidad) == 'Caducado') : this.searchName);
      },

      filterProds: function() {
        // Retorno el filtrado a mostrar en el index
        return this.filterExpired;
      },
      
      getTotalusuarios: function () {
        return this.Usuarios.length;
      },
  
      UsuariosVacio: function () {			
        return this.getTotalUsuarios == 0;
      },
  
    },
  })