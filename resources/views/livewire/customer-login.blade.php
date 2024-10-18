<div class="container">
    <form wire:submit.prevent="login">
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" wire:model="username" class="form-control">
            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" wire:model="password" class="form-control">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
