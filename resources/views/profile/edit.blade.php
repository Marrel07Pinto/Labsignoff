<div class="container">
    <h1>Account Settings</h1>

    <!-- Display Status Messages -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Details Form -->
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <hr>
    <!-- Change Password Form -->
    <form action="{{ route('pass_update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>

    <hr>

    <!-- Delete Account Form -->
    <form action="{{ route('profile.destroy') }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="password">Confirm Password to Delete Account</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
    </form>
</div>
