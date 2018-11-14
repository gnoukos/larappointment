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
                <form method="POST" action="{{ route('register') }}" class="form-signin">
                    @csrf
                    <i class="fas fa-user-plus mb-3" style="font-size: 4rem;"></i>
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input name="email" type="email" class="form-control" placeholder="Email address" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your email')" required autofocus>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input name="password" type="password" class="form-control mt-1" placeholder="Password" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your password')" required>
                    <label for="inputPasswordRe-enter" class="sr-only">Re-enter Password</label>
                    <input name="password_confirmation" type="password" class="form-control mt-1" placeholder="Re-enter Password" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Re-enter your password')" required>
                    <label for="inputName" class="sr-only">Name</label>
                    <input name="name" type="text" class="form-control mt-1" placeholder="Name" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your name')" required autofocus>
                    <label for="inputSurname" class="sr-only">Surname</label>
                    <input type="text" class="form-control mt-1" placeholder="Surname" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your surname')" required autofocus>
                    <label for="inputPhone" class="sr-only">Phone</label>
                    <input name="mobile" type="number" class="form-control mt-1" placeholder="Phone Number" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your phone number')" required autofocus>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>