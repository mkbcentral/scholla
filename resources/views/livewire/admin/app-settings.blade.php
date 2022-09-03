<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-danger"> &#x1F6E0; AUTRES PARAMETRES</h1>
            </div>
        </div>
        </div>
    </div>
    <div class="w-25">
        <div class="form-group">
            <x-label value="{{ __('Nom iprimante') }}" />
            <x-input placeholder="Nom de l'imprimante" wire:model.defer='name'/>
            @error('name')
                <span class="error text-danger">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $message }}
                </span>
            @enderror
        </div>
         <div class="d-flex justify-content-start">
            <button wire:click='save' class="btn btn-info" type="button">Sauvegarder</button>
        </div>
    </div>
</div>
