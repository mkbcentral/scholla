  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="CreateUserModal" tabindex="-1" role="dialog" aria-labelledby="CreateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="CreateUserModalLabel">CREATION D'UN NOUVEL UTILISATEUR</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit=''>
            <div class="modal-body">
                <div class="form-group">
                    <x-label value="{{ __('Nom') }}" />
                    <x-input placeholder="Nom de l'utilisateur" wire:model.defer='state.name'/>
                </div>
                <div class="form-group">
                    <x-label value="{{ __('Email') }}" />
                    <x-input placeholder="Adresse email" wire:model.defer='state.email'/>
                </div>
                <div class="form-group">
                    <x-label value="{{ __('Roles') }}" />
                    <x-select wire:model='roles_id' multiple>
                        @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </x-select>
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
