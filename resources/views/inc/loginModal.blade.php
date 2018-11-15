<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="LoginModalLabel">Sign in</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                @if (count($errors)>0)
                    <script>$('#loginModal').modal('show');</script>
                @endif
                <form class="form-signin" action="{{ route('login') }}" method="POST">
                    @csrf
                    <i class="fas fa-lock mb-3" style="font-size: 4rem;"></i>
                    <label for="inputEmail" class="sr-only">{{ __('E-Mail Address') }}</label>
                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" name="email" placeholder="Email address" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your email')" required autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                    <label for="inputPassword" class="sr-only">{{ __('Password') }}</label>
                    <input type="password" class="form-control mt-1 {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your password')" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                    <div class="checkbox mt-1">
                        <label>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </label>
                    </div>
                    <div class="forgot-password mb-2">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('Login') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>