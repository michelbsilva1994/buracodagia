@extends('layout.app')

@section('content')
    <div class="container">
        <div class="">
            <a class="my-2 btn btn-success" href="{{ route('role.index') }}">&leftarrow; Voltar</a>
        </div>
        <div class="row justify-content-center">
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
                <h3 class="mt-4">Permissões do Perfil {{ $role->name }}</h3>

                <form action="{{ route('role.permissionsSync', ['role' => $role->id]) }}" method="post" class="mt-4"
                    autocomplete="off">
                    @csrf
                    @method('PUT')

                    @foreach ($permissions as $permission)
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="{{ $permission->id }}"
                                name="{{ $permission->id }}" {{ $permission->can == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $permission->id }}">{{ $permission->name }}</label>
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-block btn-success mt-4">Sincronizar Perfil</button>
                </form>
            </div>

        </div>
    </div>
    </div>
    </div>
@endsection
