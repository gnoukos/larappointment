<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="SignupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SignupModalLabel">Sign up</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                @if ($errors->has('register_name') || $errors->has('register_email') || $errors->has('register_password') || $errors->has('register_mobile'))
                    <script>$('#signupModal').modal('show');</script>
                @endif
                <form method="POST" action="{{ route('register') }}" class="form-signin">
                    @csrf
                    <i class="fas fa-user-plus mb-3" style="font-size: 4rem;"></i>
                    <label for="inputEmail" class="sr-only">{{ __('E-Mail Address') }}</label>
                    <input name="register_email" type="email" class="form-control {{ $errors->has('register_email') ? ' is-invalid' : '' }}" value="{{ old('register_email') }}" placeholder="Email address" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your email')" required autofocus>
                    @if ($errors->has('register_email'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                    <label for="inputPassword" class="sr-only">{{ __('Password') }}</label>
                    <input name="register_password" type="password" class="form-control mt-1 {{ $errors->has('register_password') ? ' is-invalid' : '' }}" placeholder="Password" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your password')" required>
                    @if ($errors->has('register_password'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                    <label for="inputPasswordRe-enter" class="sr-only">{{ __('Confirm Password') }}</label>
                    <input name="register_password_confirmation" type="password" class="form-control mt-1" placeholder="Re-enter Password" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Re-enter your password')" required>
                    <label for="inputName" class="sr-only">{{ __('Full Name') }}</label>
                    <input name="register_name" type="text" class="form-control mt-1 {{ $errors->has('register_name') ? ' is-invalid' : '' }}" value="{{ old('register_name') }}" placeholder="Name" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your name')" required autofocus>
                    @if ($errors->has('register_name'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                    <label for="inputPhone" class="sr-only">Phone</label>
                    <input name="register_mobile" type="number" class="form-control mt-1" placeholder="Phone Number" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your phone number')" required autofocus>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('Register') }}</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>