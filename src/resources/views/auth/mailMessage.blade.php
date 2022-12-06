@include('layouts.padraoLogin')
<div class="container-fluid" style="margin-top: 20vh;">

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Agenda</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ "E-mail para recadastramento de senha enviado com sucesso!" }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
