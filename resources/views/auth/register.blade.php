@extends('layouts.app')

@section('content')
<style>
    /* =======================
       ESTILOS INSTITUCIONALES (TESVB)
       ========================= */
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

    /* Estilos del contenedor principal (Mismo fondo que Login) */
    .register-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #007F3F 0%, #005020 100%); /* Degradado de fondo con color TESVB */
        padding: 20px;
    }

    /* Estilos de la tarjeta de Registro */
    .register-card {
        max-width: 500px; /* Un poco más ancha que el login para acomodar más campos */
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        border: none;
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
</style>

<div class="register-container">
    <div class="card register-card">
        
        <div class="card-body p-4 p-md-5">

            <div class="logo-container">
                {{-- Placeholder para el logo del TESVB --}}
                <div class="logo-img"><i class="fas fa-user-plus"></i></div>
                <h4 class="mt-3 tesvb-red-text fw-bold">Registro de Usuario</h4>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Campo de Nombre Completo --}}
                <div class="input-group-custom">
                    <label for="name" class="form-label visually-hidden">{{ __('Name') }}</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom" id="name-addon">
                            <i class="fas fa-user"></i>
                        </span>
                        <input id="name" type="text" 
                               class="form-control form-control-custom @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" 
                               placeholder="Nombre Completo" 
                               required autocomplete="name" autofocus>
                        
                        @error('name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Campo de Email --}}
                <div class="input-group-custom">
                    <label for="email" class="form-label visually-hidden">{{ __('Email Address') }}</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom" id="email-addon">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input id="email" type="email" 
                               class="form-control form-control-custom @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" 
                               placeholder="Correo Institucional" 
                               required autocomplete="email">
                        
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
                        <span class="input-group-text input-group-text-custom" id="password-addon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="password" type="password" 
                               class="form-control form-control-custom @error('password') is-invalid @enderror" 
                               name="password" 
                               placeholder="Contraseña (mínimo 8 caracteres)" 
                               required autocomplete="new-password">
                        
                        @error('password')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Campo de Confirmar Contraseña --}}
                <div class="input-group-custom">
                    <label for="password-confirm" class="form-label visually-hidden">{{ __('Confirm Password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom" id="password-confirm-addon">
                            <i class="fas fa-check-double"></i>
                        </span>
                        <input id="password-confirm" type="password" 
                               class="form-control form-control-custom" 
                               name="password_confirmation" 
                               placeholder="Confirmar Contraseña" 
                               required autocomplete="new-password">
                    </div>
                </div>

                {{-- Botón de Registro --}}
                <div class="d-grid mb-3 mt-4">
                    <button type="submit" class="btn tesvb-green-btn btn-lg fw-bold">
                        <i class="fas fa-user-check me-2"></i> {{ __('REGISTRAR CUENTA') }}
                    </button>
                </div>
            </form>
            
            {{-- Enlace de Login --}}
            <div class="text-center mt-3">
                <p class="mb-0">¿Ya tienes cuenta? 
                    <a class="tesvb-red-text" href="{{ route('login') }}">Inicia Sesión aquí</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection