  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="CreateRoleModal" tabindex="-1" role="dialog" aria-labelledby="CreateRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="CreateRoleModalLabel">CREATION D'UN NOUVEAU ROLE</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit=''>
            <div class="modal-body">
                <div class="form-group">
                    <x-label value="{{ __('Nom') }}" />
                    <x-input placeholder="Nom du rôle" wire:model.defer='state.name'/>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" wire:click.prevent='store' class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
