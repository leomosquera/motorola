<div class="modal fade text-left modal-size-sm" id="modal-usuario-rol" data-rol-set="{{empty(Session::get('role_id'))}}" tabindex="-1" role="dialog"
  aria-labelledby="myModalLabel17" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h4 class="modal-title" id="myModalLabel17">Elegir tipo de rol</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>Su usuario posee más de un rol asignado. Elija con que rol desea continuar:</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="usuario-logout"><i class="feather icon-power"></i> Salir</button>
      </div>
    </div>
  </div>
</div>
