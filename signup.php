<?php include "./inc/header.php" ?>
<?php include "./inc/connectDB.php" ?>
<?php include "./actions/signup.php" ?>

<main class=" flex items-center justify-center h-screen bg-black/90 text-white">
    <div class="max-w-xl w-full">
        <h1 class="font-bold text-4xl lg:text-5xl text-center mb-16">Sign Up To <span class="text-primary font-extrabold">ChefBytes</span></h1>
        <form action="" method="POST">
            <div class="mb-6">
                <label for="username" class="block mb-2 text-sm font-medium text-white">Username</label>
                <input type="text" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" />
            </div>
            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-white">Email address</label>
                <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@company.com"  />
            </div>
            <div class="mb-3">
                <label for="password" class="block mb-2 text-sm font-medium text-white">Password</label>
                <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••"  />
            </div>
            <div class="mb-4">
                have an account ? <a href="./index.php" class="text-primary">Log in</a>
            </div>
            <input type="submit" value="Submit" name="signup" class="text-white  w-full cursor-pointer hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm   px-5 py-2.5  bg-primary w-full cursor-pointer hover:bg-primary/90">
        </form>
        
    </div>

</main>
<?php include "./inc/footer.php" ?>