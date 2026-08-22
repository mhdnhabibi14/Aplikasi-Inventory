@extends('layouts.app')

@section('content')
    <div class="login-page">
        <div class="login-card">
            {{-- Bagian kiri --}}
            <div class="login-brand">
                <div class="brand-icon">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <h1>Inventory</h1>
                <p>
                    Sistem Manajemen Inventory
                </p>
                <div class="brand-decoration">
                    <i class="fas fa-chart-line"></i>
                    <i class="fas fa-box"></i>
                    <i class="fas fa-warehouse"></i>
                </div>
            </div>
            {{-- Bagian kanan --}}
            <div class="login-form">
                <div class="form-header">
                    <h2>Selamat Datang 👋</h2>
                    <p>
                        Silakan login untuk melanjutkan
                    </p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    {{-- Email --}}
                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="Masukkan email" required
                                autocomplete="email" autofocus>
                        </div>
                        @error('email')
                            <span class="text-danger small">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    {{-- Password --}}
                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Masukkan password" required autocomplete="current-password">
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-danger small">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    {{-- Remember --}}
                    <div class="remember-row">
                        <label class="remember">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>
                                Ingat saya
                            </span>
                        </label>
                    </div>
                    {{-- Button --}}
                    <button type="submit" class="btn-login">
                        <span>Login</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <div class="login-footer">
                    <small>
                        © {{ date('Y') }} Sistem Inventory
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #f4f7fb;
        }

        .login-page {
            min-height: calc(100vh - 56px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .login-card {
            width: 100%;
            max-width: 950px;
            min-height: 560px;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 45% 55%;
            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.08);
        }

        .login-brand {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 50px;
            color: white;
            background:
                linear-gradient(135deg,
                    #2563eb,
                    #3b82f6,
                    #60a5fa);

            overflow: hidden;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            top: -100px;
            left: -100px;
        }


        .login-brand::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            bottom: -100px;
            right: -80px;
        }

        .brand-icon {
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .18);
            border-radius: 24px;
            font-size: 42px;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }


        .login-brand h1 {
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
        }


        .login-brand p {
            font-size: 16px;
            opacity: .9;
            margin: 0;
            position: relative;
            z-index: 2;
        }

        .brand-decoration {
            display: flex;
            gap: 18px;
            margin-top: 45px;
            position: relative;
            z-index: 2;
        }

        .brand-decoration i {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(255, 255, 255, .12);
            font-size: 20px;
        }

        .login-form {
            padding: 65px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 35px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #64748b;
            margin: 0;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper>i:first-child {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 2;
        }

        .input-wrapper .form-control {
            height: 50px;
            border-radius: 10px;
            border: 1px solid #dbe3ec;
            padding-left: 45px;
            padding-right: 45px;
            box-shadow: none;
            transition: .2s;
        }

        .input-wrapper .form-control:focus {
            border-color: #3b82f6;
            box-shadow:
                0 0 0 3px rgba(59, 130, 246, .12);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            padding: 5px;
        }

        .password-toggle:hover {
            color: #3b82f6;
        }

        .remember-row {
            margin-top: -5px;
            margin-bottom: 25px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: #64748b;
            font-size: 14px;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: #3b82f6;
        }

        .btn-login {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            transition: .2s;
            box-shadow: 0 8px 20px rgba(37, 99, 235, .2);
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, .3);
        }

        .login-footer {
            text-align: center;
            margin-top: 35px;
            color: #94a3b8;
        }

        @media (max-width: 768px) {
            .login-card {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .login-brand {
                min-height: 240px;
                padding: 35px;
            }

            .brand-icon {
                width: 70px;
                height: 70px;
                font-size: 32px;
                margin-bottom: 15px;
            }

            .login-brand h1 {
                font-size: 30px;
            }

            .brand-decoration {
                display: none;
            }

            .login-form {
                padding: 40px 30px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('passwordIcon');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endpush
