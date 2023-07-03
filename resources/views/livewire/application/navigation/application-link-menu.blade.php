<div class="container pt-4 ">
    <div>
        <h3 class="text-bold">School</h3>
    </div>
    <div class="row">
        @foreach ($appLinks as $appLink)
            <div class="col-12 col-sm-6 col-md-3">
                <a href="{{ route($appLink?->link, $appLink) }}" >
                    <div class="info-box">
                        <span class="info-box-icon {{$appLink->color}} elevation-1">
                            <i class="fas {{ $appLink->icon }}"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-number">
                                {{ $appLink->name }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>
            </div>
        @endforeach
    </div>
</div>
