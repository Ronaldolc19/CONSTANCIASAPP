@extends('layouts.app')

@section('content')
<style>
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 70vh; /* Ajustado para que no se pegue al footer */
    }

    .login-card {
        max-width: 400px;
        width: 100%;
        border: none;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .card-accent-top {
        height: 5px;
        background-color: var(--tesvb-green);
        border-radius: 12px 12px 0 0;
    }

    .input-group-text {
        background-color: #f8fafc;
        border-right: none;
        color: #64748b;
    }

    .form-control {
        border-left: none;
        padding: 10px;
    }

    .form-control:focus {
        border-color: #dee2e6;
        box-shadow: none;
    }

    .btn-login {
        background-color: var(--tesvb-green);
        color: white;
        padding: 12px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn-login:hover {
        background-color: var(--tesvb-dark-green);
        color: white;
    }

    .login-header h4 {
        color: #1e293b;
        font-weight: 700;
    }
</style>

<div class="container login-wrapper">
    <div class="card login-card">
        <div class="card-accent-top"></div>
        <div class="card-body p-4 p-md-5">
            
            <div class="login-header text-center mb-4">
                <i class="bi bi-shield-lock text-success" style="font-size: 2.5rem;"></i>
                <h4 class="mt-2">Bienvenido</h4>
                <p class="text-muted small">Ingresa tus credenciales para continuar</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required>
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small text-muted" for="remember">
                        Mantener sesión activa
                    </label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-login">
                        {{ __('INGRESAR') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection