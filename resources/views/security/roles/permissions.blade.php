@extends('layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="my-4 text-secondary text-center">Permissões do Perfil {{ $role->name }}</h3>
            <div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger mt-4" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                <div class="col-sm-12 d-md-flex justify-content-md-center col-md-12">
                    <form action="{{ route('role.permissionsSync', ['role' => $role->id]) }}" method="post" class="col-sm-12 col-md-10 col-lg-6" autocomplete="off">
                        @csrf
                        @method('PUT')

                        @foreach ($permissions as $permission)
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="{{ $permission->id }}"
                                    name="{{ $permission->id }}" {{ $permission->can == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center my-5">
                            <button type="submit" class="btn btn-lg btn-success">Sincronizar Perfil</button>
                            <a class="btn btn-lg btn-danger" href="{{ route('role.index') }}">Voltar</a>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
    </div>
    </div>
@endsection
