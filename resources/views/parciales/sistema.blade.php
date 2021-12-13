
    @php
        $sistema = App\Models\Sistema::findOrFail(1);
        setlocale(LC_TIME, 'spanish');
    @endphp
    <div class="card bg-primary text-white mb-4 col-6">
        <div class="card-body">Información Del Sistemas</div>
        <div class="card-footer d-flex align-items-center justify-content-between">

            <div class="text-white" style="font-size: 50px">
                    <i class="fab fa-windows"></i>
            </div>
            <div class="text-white text-center" style="font-size: 25px">
                <p class="text-capitalize">{{ strftime("%B - %Y", strtotime($sistema->fechaEvaluada))}}</p>
                @if ($sistema->estado==1)
                    <span class="badge bg-success">ABIERTO</span>
                @else
                    <span class="badge bg-danger">CERRADO</span>
                @endif
            </div> 
        </div>
    </div>
