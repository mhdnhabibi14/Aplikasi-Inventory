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
                    <h2>Selamat Datang</h2>
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
