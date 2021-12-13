@if (session('status'))
    <div class="container mt-4">
            <div class="alert alert-primary alert-dismissible fade show">
                <div class="text-center">
                        {{session('status')}} 
                </div> 
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>          
    </div>
@endif
@if (session('warning'))
    <div class="container mt-4">
            <div class="alert alert-warning alert-dismissible fade show">
                <div class="text-center">
                        {{session('warning')}} 
                </div> 
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>          
    </div>
@endif
@if (session('error'))
    <div class="container mt-4">
            <div class="alert alert-danger alert-dismissible fade show">
                <div class="text-center">
                        {{session('error')}} 
                </div> 
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>      
    </div>
@endif
@if (session('success'))
    <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show">
                <div class="text-center">
                        {{session('success')}} 
                </div> 
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>      
    </div>
@endif
