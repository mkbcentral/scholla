  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="showStudentInfos" tabindex="-1" role="dialog" aria-labelledby="showStudentInfosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showStudentInfosLabel">
                INFOS DE L'LELVE
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card">
            <div class="card-body">
                @if ($studentToShow !=null)
                    <div><h5><span class="text-bold">Nom:</span> {{$studentToShow->name}}</h5></div>
                    <div><h5><span class="text-bold">Genre:</span> {{$studentToShow->gender}}</h5></div>
                    <div>
                        <h5><span class="text-bold">Ange:</span>
                            @if (date('Y')-$studentToShow->date_of_birth->format('Y')==0)
                                <span class="text-danger">Inconu</span>
                            @elseif(date('Y')-$studentToShow->date_of_birth->format('Y')==1)
                                {{date('Y')-$studentToShow->date_of_birth->format('Y')}} An
                            @else
                                {{date('Y')-$studentToShow->date_of_birth->format('Y')}} Ans
                            @endif
                        </h5>
                    </div>
                    <div><h5><span class="text-bold">Lieu de naissance:</span> {{$studentToShow->place_of_birth}}</h5></div>
                    <div><h5><span class="text-bold">Classe:</span> {{$studentToShow->classe->name.'/'.$studentToShow->classe->option->name}}</h5></div>
                    <hr>
                    @if ($studentToShow->responsable !=null)
                        <div><h5><span class="text-bold">Responsable:</span> {{$studentToShow->responsable->name}}</h5></div>
                        <div><h5><span class="text-bold">Tél:</span> {{$studentToShow->responsable->phone.' | '.$studentToShow->responsable->other_phone}}</h5></div>
                        <div><h5><span class="text-bold">Email:</span> {{$studentToShow->responsable->email}}</h5></div>
                    @endif
                @endif
            </div>
        </div>
      </div>
    </div>
  </div>
