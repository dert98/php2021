<section class="row col-md-12 m-5" id="app">
  <div class="bg1">
    <div>
      Caducado:{{caducado}}
      Sin vender:{{vendido}}
      name : {{name}}
      fecha : {{getfecha}}br
    </div>
    <div>
      {{searchProd()}}
    </div>
  </div>
    <div class="text-center m-auto t5">
        <p class="">
          <input type="checkbox" id="caducado" value="caducado" v-model="caducado">
          <label for="Caducado">Caducado</label>
          <input type="checkbox" id="vendido" value="vendido" v-model="vendido">
          <label for="vendido">Sin vender</label>
        </p>
        <p class="">
            Categoria:
            <select name="categoria" id="" v-model="categoria">
                <option>Totas</option>
                <option v-for="c in categorias" v-bind:value="c.idCategoriaProducto">{{c.nombre}}
            </select>
            Nombre: <input type="text" maxlength="20" v-model="name">
        </p>
    </div>
    <div class="col-md-12 row text-center m-auto">
        .<div class="col-md-3 card m-4" v-for="p in searchProd">
          <!-- <img class="card-img-top" src="p['contenidoimagen']" alt=""> -->
          <div class="card-body">
            <h4 class="card-title">{{p['nombre']}}</h4>
            <p class="card-text">{{p['descripcion']}}</p>
            <p class="card-text">{{p['precio']}}</p>
            <!-- <p><a :href="'view/vermas.php?id=' + p.idProducto" class="btn btn-success m-2">Ver</a><a href="" class="btn btn-success">Comprar</a></p> -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDetails" @click="openDetails(p)"> Ver </button>
            <p class="card-text">Caduca : {{p['caducidad']}}</p>
            <p class="card-text">fecha : {{getfecha}}</p>
            <p class="text-danger" v-if="p['caducidad'] < getfecha">caduco</p>
          </div>
        </div>
    </div>
    <div></div>
    <!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="modalDetailsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{details['nombre']}}</h5>
      </div>
      <div class="modal-body">
        <p class="card-text">{{details['descripcion']}}</p>
        <p class="card-text">{{details['precio']}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click=closeDetails()>Close</button>
        <button type="button" class="btn btn-primary">Comprar</button>
      </div>
    </div>
  </div>
</div>
</section>