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
                <form class="form-signin">
                    <i class="fas fa-lock mb-3" style="font-size: 4rem;"></i>
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" class="form-control" placeholder="Email address" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your email')" required autofocus>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" class="form-control mt-1" placeholder="Password" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Enter your password')" required>
                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>