<x-layout>
    <h1 class="title">Register a new account</h1>

    <div class="mx-auto max-w-screen-sm card border shadow p-5">
        <form action="{{route('register')}}" method="post">
@csrf


            {{--username--}}
    <div class="mb-4">
    <label for="username">Username</label>
    <input type="text"
     name="username" 
     value="{{old ('username')}}" 
     class="input @error('username') ring-red-500 @enderror">

    @error('username')
      <p class="error">{{$message}}</p>
    @enderror

    </div>

    {{--email--}}
    <div class="mb-4">
        <label for="email">Email</label>
        <input type="text" name="email" value="{{old ('email')}}" class="input  @error('email') ring-red-500 @enderror">
        @error('email')
        <p class="error">{{$message}}</p>
  
      @enderror
     </div>

       {{--password--}}
         <div class="mb-8">
        <label for="password">Password</label>
          <input type="password" name="password" class="input  @error('password') ring-red-500 @enderror">
          @error('password')
          <p class="error">{{$message}}</p>
    
        @enderror
            </div>

            {{--confirm password--}}
            <div class="mb-4">
             <label for="password_confirmation">Confirm Password</label>
           <input type="password" name="password_confirmation" class="input  @error('password') ring-red-500 @enderror">
           @error('password')
           <p class="error">{{$message}}</p>
     
         @enderror
         </div>

         {{-- submit button--}}
         <button class="btn bg-blue-950 rounded px-4 py-2 text-white">Register</button>

        </form>
    </div>
</x-layout>