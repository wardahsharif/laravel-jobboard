<section>
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="username" class="form-label">Name</label>
            <input type="text" 
                   name="username" 
                   id="username" 
                   class="form-control @error('username') is-invalid @enderror" 
                   value="{{ old('username', Auth::user()->username) }}" 
                   required autofocus autocomplete="username">
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email', Auth::user()->email) }}" 
                   required autocomplete="email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">Save</button>

            @if (session('status') === 'profile-updated')
                <small class="text-success ms-3">Saved.</small>
            @endif
        </div>
    </form>
</section>
