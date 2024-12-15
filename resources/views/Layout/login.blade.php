<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="login-container">
                    <div class="login-card">
                        <!-- Left Section -->
                        <div class="login-left text-center">
                            <h1>Welcome!</h1>
                            <img src="{{asset('assets/images/logo.png')}}" alt="Logo">
                            <p class="mt-4">Not a member yet? 
                                <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Register now</a>
                            </p>
                        </div>
                        <!-- Right Section -->
<div class="login-right">
    <h3 class="mb-4">Log in</h3>
    @if($errors->has('login_error'))
        <div class="alert alert-danger">
            {{ $errors->first('login_error') }}
        </div>
    @endif
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" autofocus placeholder="Example@gmail.com" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-login">Log in now</button>
    </form>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
