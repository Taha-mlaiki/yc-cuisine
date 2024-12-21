<?php include "./inc/header.php" ?>
<?php include "./inc/connectDB.php" ?>
<?php include "./actions/auth/signup.php" ?>
<?php include "./lib/middleware.php" ?>
<main class=" flex items-center relative justify-center h-screen bg-black/90 text-white">
    <?= isset($toast) ? $toast : $toast ?>
    <div class="max-w-xl w-full">
        <h1 class="font-bold text-4xl lg:text-5xl text-center mb-16">Sign Up To <span class="text-primary font-extrabold">ChefBytes</span></h1>
        <form action="" method="POST">
            <?php if (isset($errors["account"])) : ?>
                <div class="flex items-center gap-x-3 p-3 bg-red-100 text-red-500 mb-4 font-bold rounded-lg">
                    <img src="./assets/warning.png" class="w-7 h-7" alt="">
                    <?= $errors["account"] ?>
                </div>
            <?php endif ?>
            <div class="mb-6">
                <label for="username" class="block mb-2 text-sm font-medium text-white">Username</label>
                <input type="text" id="username" value="<?= $username ?>" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" />
                <?= isset($errors["usernameError"]) ? "<div class='mt-2 text-red-600'>{$errors['usernameError']}</div>" : "" ?>
            </div>
            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-white">Email address</label>
                <input type="email" id="email" name="email" value="<?= $email ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@company.com" />
                <?= isset($errors["emailError"]) ? "<div class='mt-2 text-red-600'>{$errors['emailError']}</div>" : "" ?>
            </div>
            <div class="mb-3">
                <label for="password" class="block mb-2 text-sm font-medium text-white">Password</label>
                <input type="password" id="password" value="<?= $password ?>" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" />
                <?= isset($errors["passwordError"]) ? "<div class='mt-2 text-red-600'>{$errors['passwordError']}</div>" : "" ?>

            </div>
            <div class="mb-4">
                have an account ? <a href="./index.php" class="text-primary">Log in</a>
            </div>
            <input type="submit" value="Submit" name="signup" class="text-white  w-full cursor-pointer hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm   px-5 py-2.5  bg-primary w-full cursor-pointer hover:bg-primary/90">
        </form>

    </div>
                <script src="./js/signup.js"></script>
</main>
<?php include "./inc/footer.php" ?>