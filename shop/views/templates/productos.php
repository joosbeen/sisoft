<!-- Container (Pricing Section) -->
<div id="pricing" class="container-fluid">
    <div class="text-center">
        <h2>Pricing</h2>
    </div>
    <div class="text-center" id="loading">
        <img src="views/img/util/loader.gif" class=" bg-success img-circle" width="150" height="150">
    </div>
    <div id="datosProductos">
        <form class="row pl-3 pr-3" method="post">
            <div class="input-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <input type="text" class="form-control" placeholder="Buscar">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                    <i class="glyphicon glyphicon-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <br>
        <div class="row" id="productos">
            <div class=" col-lg-2">
                <div class="form-group">
                    <label for="categoria">Categoria:</label>
                    <select class="form-control" id="categoria">
                    </select>
                </div>
            </div>
            <div class=" col-lg-2">
                <div class="form-group">
                    <label for="marca">Marca:</label>
                    <select class="form-control" id="marca">
                    </select>
                </div>
            </div>
            <div class=" col-lg-2">
                <div class="form-group">
                    <label for="ordenarpor">Ordenar por:</label>
                    <select class="form-control" id="ordenarpor">
                    </select>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row" id="listaProducto">
            <div class="col-sm-3 col-xs-12">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h1>Basic</h1>
                    </div>
                    <div class="panel-body">
                        <p><strong>5</strong> Dolor</p>
                        <p><strong>2</strong> Sit</p>
                        <p><strong>Endless</strong> Amet</p>
                    </div>
                    <div class="panel-footer">
                        <h3>$19</h3>
                        <h4>per month</h4>
                        <button class="btn btn-lg">Sign Up</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h1>Pro</h1>
                    </div>
                    <div class="panel-body">
                        <p><strong>10</strong> Dolor</p>
                        <p><strong>5</strong> Sit</p>
                        <p><strong>Endless</strong> Amet</p>
                    </div>
                    <div class="panel-footer">
                        <h3>$29</h3>
                        <h4>per month</h4>
                        <button class="btn btn-lg">Sign Up</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h1>Premium</h1>
                    </div>
                    <div class="panel-body">
                        <p><strong>25</strong> Dolor</p>
                        <p><strong>10</strong> Sit</p>
                        <p><strong>Endless</strong> Amet</p>
                    </div>
                    <div class="panel-footer">
                        <h3>$49</h3>
                        <h4>per month</h4>
                        <button class="btn btn-lg">Sign Up</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h1>Premium</h1>
                    </div>
                    <div class="panel-body">
                        <p><strong>25</strong> Dolor</p>
                        <p><strong>10</strong> Sit</p>
                        <p><strong>Endless</strong> Amet</p>
                    </div>
                    <div class="panel-footer">
                        <h3>$49</h3>
                        <h4>per month</h4>
                        <button class="btn btn-lg">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--input class="form-control" id="myInput" type="text" placeholder="Search.."-->
</div>
<script type="text/javascript">
function cargarProductos(cate, marc, mode, opci) {
document.getElementById("datosProductos").style.display = "none";
document.getElementById("loading").style.display = "block";
$.ajax({
url: "views/ajax/cargarProductos.php",
type: "POST",
dataType: "JSON",
data: {
categoria: cate,
opcion: opci,
marca: marc,
modelo: mode
},
success: function(result){
document.getElementById("loading").style.display = "none";
document.getElementById("datosProductos").style.display = "block";
},
error(result){
document.getElementById("loading").style.display = "none";
document.getElementById("datosProductos").style.display = "block";
}/*,
complete(xhr,status){
}*/
});
}
cargarProductos("param 1", "", "marca 3", "");
$(document).ready(function(){
$("#myInput").on("keyup", function() {
var value = $(this).val().toLowerCase();
$("#listaProducto div").filter(function() {
$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
});
});
});
</script>