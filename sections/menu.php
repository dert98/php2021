<section class="row col-md-12 m-5" id="app">
<div class="text-center m-auto t5">
        <p class="">
            Caducado<input type="checkbox" name="" id=""> 
            Sin vender<input type="checkbox" name="" id="">
        </p>
        <p class="">
            Categoria:
            <select name="categoria" id="" v-model="category">
                <option value="0">Totas</option>
                <option v-for="c in categorias" v-bind:value="c.value">{{c.nombre}}
            </select>
            Nombre: <input type="text" maxlength="20" v-model="name">
        </p>
    </div>
    <div class="col-md-12 row text-center m-auto">
        .<div class="col-md-3 card m-4" v-for="p in productos">
          <!-- <img class="card-img-top" src="holder.js/100px180/" alt=""> -->
          <div class="card-body">
            <h4 class="card-title">{{p['nombre']}}</h4>
            <p class="card-text">{{p['descripcion']}}</p>
            <p class="card-text">{{p['precio']}}</p>
            <!-- <p><a :href="'view/vermas.php?id=' + p.idProducto" class="btn btn-success m-2">Ver</a><a href="" class="btn btn-success">Comprar</a></p> -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDetails" @click="openDetails(p)"> Ver </button>
            <p class="card-text">Fecha Publicacion: {{p['publicacion']}}</p>
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
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</section>