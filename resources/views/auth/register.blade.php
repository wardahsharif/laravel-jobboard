<x-layout>
    <h1 class="title">Register a new account</h1>

    <div class="mx-auto max-w-screen-sm card">
        <form action="" method="post">

            {{--username--}}
    <div class="mb-4">
    <label for="username">Username</label>
    <input type="text" name="username" class="input">
    </div>

    {{--email--}}
    <div class="mb-4">
        <label for="email">Email</label>
        <input type="text" name="email" class="input">
     </div>

       {{--password--}}
         <div class="mb-4">
        <label for="password">Password</label>
           < </div>

                 {{--confirm password--}}
            <div class="mb-4">
             <label for="password_confirmation">Confirm Password</label>
           <input type="text" name="password_confirmation" class="input">
         </div>

        </form>
    </div>
</x-layout>