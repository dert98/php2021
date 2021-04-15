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
    caducado:false,
    vendido:false,
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
      searchProd: function() {
        return this.searchCategory.filter((p) => p.nombre.includes(this.name));
      },

      searchCategory: function() {
        return this.productos.filter((p) => (p.idCategoriaProducto == this.categoria))
      },

      searchCaducado: function() {
        if (this.caducado) {
          return this.searchProd .filter((p) => (p.caducidad >  this.getfecha()))
        }
      },

      searchVendido: function() {
        if (this.vendido) {
          return this.productos.filter((p) => (p.idUsuarioComprador == 0))
        }
      },
  
      UsuariosVacio: function () {			
        return this.getTotalUsuarios == 0;
      },
      getfecha: function() {
        let fecha = new Date(Date.now());
        let dia = fecha.getDate().toString();
        let mes = fecha.getMonth()+1;
        mes = mes.toString().padStart(2, "0")
        let ano = fecha.getFullYear().toString();
        let date = ano +'-'+mes+'-'+dia;
        // const time = fecha.getHours() + ":" + fecha.getMinutes() + ":" + fecha.getSeconds();
        // const dateTime = date;
        return date;
      },
    },
  })