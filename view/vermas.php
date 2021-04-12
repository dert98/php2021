<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<div id="app" class="col-md-3 card m-4 bg2">
  <!-- <img class="card-img-top" src="holder.js/100px180/" alt=""> -->
  {{$_GET["id"]}}
  <div class="card-body">
    <h4 class="card-title">{{buscado['nombre']}}</h4>
    <p class="card-text">{{buscado['descripcion']}}</p>
    <p class="card-text">{{buscado['precio']}}</p>
    <p><a href=""
        class="btn btn-success">Comprar</a></p>
    <p class="card-text">Fecha Publicacion: {{buscado['publicacion']}}</p>
  </div>
</div>
<script src="../js/app.js"></script>