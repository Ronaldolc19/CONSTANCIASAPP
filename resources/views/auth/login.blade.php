@extends('layouts.app')

@section('content')
<style>
    /* Colores del TESVB */
    .tesvb-green-bg {
        background-color: #007F3F !important; /* Verde Oscuro Principal */
        border-color: #007F3F !important;
    }
    .tesvb-green-btn {
        background-color: #007F3F;
        border-color: #007F3F;
        color: white;
        transition: background-color 0.3s;
    }
    .tesvb-green-btn:hover {
        background-color: #005f30;
        border-color: #005f30;
        color: white;
    }
    .tesvb-red-text {
        color: #800020 !important; /* Guinda/Tinto Acento */
    }

    /* Estilos del contenedor principal */
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #007F3F 0%, #005020 100%); /* Degradado de fondo con color TESVB */
        padding: 20px;
    }

    /* Estilos de la tarjeta de Login */
    .login-card {
        max-width: 420px;
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        border: none;
    }
    
    .card-header-custom {
        background-color: #800020; /* Guinda */
        color: white;
        text-align: center;
        padding: 20px;
        font-size: 1.5rem;
        font-weight: 700;
    }

    /* Estilo de los Inputs con Icono */
    .input-group-custom {
        margin-bottom: 20px;
    }
    .input-group-text-custom {
        background-color: #f8f9fa;
        border-right: none;
        color: #800020;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem 0 0 0.375rem;
    }
    .form-control-custom {
        border-left: none;
    }
    .form-control-custom:focus {
        border-color: #007F3F;
        box-shadow: 0 0 0 0.25rem rgba(0, 127, 63, 0.25);
    }
    
    .logo-container {
        text-align: center;
        margin-bottom: 25px;
    }
    .logo-img {
        width: 80px;
        height: 80px;
        background-color: #f0f0f0;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #007F3F;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="login-container">
    <div class="card login-card">
        
        <div class="card-body p-4 p-md-5">

            <div class="logo-container">
                {{-- Placeholder para el logo del TESVB --}}
                <div class="logo-img"><i class="fas fa-university"></i></div>
                <h4 class="mt-3 tesvb-red-text fw-bold">Acceso al Sistema</h4>
                <p class="text-muted small">Gestión de Servicio Social y Constancias</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Campo de Email --}}
                <div class="input-group-custom">
                    <label for="email" class="form-label visually-hidden">{{ __('Email Address') }}</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom" id="basic-addon1">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input id="email" type="email" 
                               class="form-control form-control-custom @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" 
                               placeholder="Correo Institucional" 
                               required autocomplete="email" autofocus>
                        
                        @error('email')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Campo de Contraseña --}}
                <div class="input-group-custom">
                    <label for="password" class="form-label visually-hidden">{{ __('Password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom" id="basic-addon2">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="password" type="password" 
                               class="form-control form-control-custom @error('password') is-invalid @enderror" 
                               name="password" 
                               placeholder="Contraseña" 
                               required autocomplete="current-password">
                        
                        @error('password')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Recordarme y Contraseña Olvidada --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Recordarme
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link tesvb-red-text" href="{{ route('password.request') }}">
                            ¿Olvidaste tu Contraseña?
                        </a>
                    @endif
                </div>

                {{-- Botón de Acceso --}}
                <div class="d-grid mb-3">
                    <button type="submit" class="btn tesvb-green-btn btn-lg fw-bold">
                        <i class="fas fa-sign-in-alt me-2"></i> {{ __('ACCEDER AL SISTEMA') }}
                    </button>
                </div>
            </form>
            
            {{-- Enlace de Registro (si aplica) --}}
            @if (Route::has('register'))
            <div class="text-center mt-3">
                <p class="mb-0">¿No tienes cuenta? 
                    <a class="tesvb-red-text" href="{{ route('register') }}">Regístrate aquí</a>
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection