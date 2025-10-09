@extends('admin.auth.app')
@section('title')
    <title>{{ __('Login') }}</title>
@endsection

<style>
    body {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #1e3c72 100%) !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    }
    
    .login-container {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #1e3c72 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
    }
    
    .login-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 20%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                    radial-gradient(circle at 70% 80%, rgba(37, 99, 235, 0.3) 0%, transparent 50%);
        pointer-events: none;
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(30, 60, 114, 0.4), 0 0 0 1px rgba(59, 130, 246, 0.1);
        backdrop-filter: blur(15px);
        border: 2px solid rgba(59, 130, 246, 0.2);
        overflow: hidden;
        max-width: 420px;
        width: 100%;
        position: relative;
        z-index: 1;
    }
    
    .login-brand {
        text-align: center;
        padding: 35px 30px 25px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
        position: relative;
        overflow: hidden;
    }
    
    .login-brand::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    .login-brand img {
        max-width: 180px;
        height: auto;
        filter: brightness(1.2) drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        position: relative;
        z-index: 1;
    }
    
    .card-header {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: none;
        padding: 25px 30px 15px;
        text-align: center;
        border-bottom: 2px solid rgba(59, 130, 246, 0.1);
    }
    
    .card-header h4 {
        color: #1e40af;
        font-weight: 700;
        margin: 0;
        font-size: 26px;
        text-shadow: 0 2px 4px rgba(30, 64, 175, 0.1);
    }
    
    .card-body {
        padding: 25px 30px 35px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group label {
        color: #1e40af;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }
    
    .form-control {
        border-radius: 12px;
        border: 2px solid #bfdbfe;
        padding: 14px 18px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
        color: #1e40af;
    }
    
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        background: #ffffff;
        outline: none;
    }
    
    .form-control::placeholder {
        color: #94a3b8;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
        border: none;
        border-radius: 12px;
        padding: 14px 20px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e3a8a 100%);
    }
    
    .btn-primary:hover::before {
        left: 100%;
    }
    
    .btn-primary:active {
        transform: translateY(-1px);
    }
    
    .form-check-input {
        accent-color: #3b82f6;
    }
    
    .form-check-input:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    
    .form-check-label {
        color: #475569;
        font-size: 14px;
        font-weight: 500;
    }
    
    .text-small {
        color: #3b82f6;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .text-small:hover {
        color: #1d4ed8;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    
    @media (max-width: 768px) {
        .login-card {
            margin: 15px;
            border-radius: 15px;
            max-width: 100%;
        }
        
        .login-brand {
            padding: 25px 20px 20px;
        }
        
        .card-header {
            padding: 20px 20px 12px;
        }
        
        .card-body {
            padding: 20px 20px 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
    }
</style>

@section('content')
    <div class="login-container">
        <div class="login-card">
            <div class="login-brand">
                <a href="{{ route('home') }}">
                    <img src="{{ asset($setting?->logo) }}" alt="{{ $setting?->app_name }}">
                </a>
            </div>
            
            <div class="card-header">
                <h4>{{ __('Admin Login') }}</h4>
            </div>

            <div class="card-body">
                <form novalidate="" id="adminLoginForm" action="{{ route('admin.store-login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        @if (app()->isLocal() && app()->hasDebugModeEnabled())
                            <x-admin.form-input type="email" id="email" name="email"
                                label="{{ __('Email') }}" value="admin@gmail.com" required="true" />
                        @else
                            <x-admin.form-input type="email" id="email" name="email"
                                label="{{ __('Email') }}" value="{{ old('email') }}" required="true" />
                        @endif
                    </div>

                    <div class="form-group">
                        @if (app()->isLocal() && app()->hasDebugModeEnabled())
                            <x-admin.form-input type="password" id="password" label="{{ __('Password') }}"
                                name="password" value="1234" required="true" />
                        @else
                            <x-admin.form-input type="password" id="password" label="{{ __('Password') }}"
                                name="password" required="true" />
                        @endif
                    </div>

                    <div class="form-group d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" tabindex="3"
                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>
                        <a href="{{ route('admin.password.request') }}" class="text-small">
                            {{ __('Forgot Password?') }}
                        </a>
                    </div>

                    <div class="form-group">
                         <x-admin.button type="submit" class="btn-lg btn-block" text="{{ __('Login') }}" />
                     </div>
                 </form>
             </div>
         </div>
     </div>
@endsection
