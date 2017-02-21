   <!-- Modal Editorial-->
    <div class="modal fade" id="modal_categorias" tabindex="-1" role="dialog" aria-labelledby="modal_busquedaLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_busquedaLabel">Buscar Categoria</h4>
                </div>
                <div class="modal-body" id="body_modal_categorias">
                   <?php    include('clases/HTML/Lista_categorias.php');   ?>
              </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
   