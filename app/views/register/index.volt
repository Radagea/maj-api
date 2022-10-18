<div class="auth-form">
    <form action="register/doRegister" method="post">
        <div class="form-group">
            <label for="username">User name</label>
            <input type="text" id="username" name="username" class="form-control" aria-describedby="emailHelp" placeholder="Enter your username">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="email@email.com">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="password-confirmation">Password confirmation</label>
            <input type="password" id="password-confirmation" name="password-confirmation" class="form-control" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>