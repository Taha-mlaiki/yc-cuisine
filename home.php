<?php
include "./inc/connectDB.php";
$stm = $conn->prepare("SELECT * FROM menu");
$stm->execute();
$res = $stm->get_result();
if ($res->num_rows > 0) {
    $menus = $res->fetch_assoc();
}
?>
<?php include "./inc/header.php" ?>
<header class="h-screen bg-black/90 flex flex-col">
    <?php include "./inc/navbar.php" ?>
    <div class="flex-grow grid gap-x-10 text-white flex items-center md:grid-cols-2 max-w-7xl w-full mx-auto">
        <div>
            <p class="mb-2 text-md font-semibold">Best Dishes & Menus...</p>
            <h1 class="text-xl mg:text-4xl lg:text-6xl font-bold">Always Delivering <span class="text-primary">Amazing</span> Experience</h1>
            <p class="text-md mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, ernterdum nulla,modo diamLorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, ernterdum nulla,modo diam</p>
            <div class="mt-5 flex gap-x-3">
                <button class="font-semibold py-2 px-3 rounded-lg text-white bg-primary">
                    <a href="./reservation">Make a reserveration</a>
                </button>
                <button class="font-semibold py-2 px-3 rounded-lg text-black bg-white">
                    <a href="./reservation">About Us</a>
                </button>
            </div>
        </div>
        <div>
            <img src="./assets/hero-illustration.png" class="w-[70%] mx-auto" alt="">
        </div>
    </div>
</header>
<main class="max-w-7xl w-full mx-auto ">
    <h1 class="font-bold text-6xl mt-10 text-primary text-center">Menus</h1>
    <?php if (!empty($menus) && count($menus) > 0) : ?>
        <div class="grid md:grid-cols-2 gap-10 lg:grid-cols-3 my-20">
            <?php foreach ($menus as $menu): ?>
                <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="w-72 mb-2 mx-auto" src="<?= $menu["image"] ?>" alt="product image" />
                    </a>
                    <div class="px-5 pb-5">
                        <h5 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white"><?= $menu["name"] ?></h5>
                        <p class="my-2 text-neutral-700"><?= $menu["description"] ?></p>
                        <div class="flex items-center justify-end mt-2">
                            <a href="./menuDetails.php?menuId=<?= $menu["id"] ?>" class="text-white  bg-primary hover:bg-primary/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">View Dishes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="text-center text-gray-500 my-20">No menus available at the moment.</p>
    <?php endif; ?>
</main>
<?php include "./inc/footer.php" ?>