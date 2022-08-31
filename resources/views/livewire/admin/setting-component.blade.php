<div>
    <div class="w-50">
        <div class="text-center">
            @if ($setting)
                <img src="{{asset($setting->app_logo==null?'defautl-user.jpg':Storage::url($setting->app_logo)) }}"
                    class="img-circle elevation-2" alt="User Image" width="100">
            @endif
        </div>
        <div class="form-group">
            <x-label value="{{ __('Nom école') }}" />
            <x-input placeholder="Nom ecole" wire:model.defer='app_name'/>
            @error('app_name')
            <span class="error text-danger">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            {{ $message }}
            </span>
        @enderror
        </div>
        <div class="form-group">
            <x-label value="{{ __('Email ecole') }}" />
            <x-input placeholder="Email école" wire:model.defer='email'/>
            @error('email')
            <span class="error text-danger">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            {{ $message }}
            </span>
            @enderror
        </div>
        <div class="form-group">
            <x-label value="{{ __('Tél école') }}" />
            <x-input placeholder="Téléphone" wire:model.defer='phone'/>
            @error('phone')
            <span class="error text-danger">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            {{ $message }}
            </span>
            @enderror
        </div>

        <div>
            @if ($logo)
             <div class="widget-user-image">
                 <img class="img-circle elevation-2" style="width: 100px" src="{{ $logo->temporaryUrl() }}" alt="Logo">
             </div>
            @endif
         </div>
         <div class="form-group mt-2">
             <label for="formFile" class="form-label">Chaoisir un logo</label>
             <input class="form-control" type="file" wire:model.defer='logo'>
           </div>
         @error('logo') <span class="error">{{ $message }}</span> @enderror
         <div class="d-flex justify-content-end">
            <button wire:click='save' class="btn btn-info" type="button">Sauvegarder</button>
        </div>
    </div>
</div>
