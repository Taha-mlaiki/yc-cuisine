<?php
include "./inc/connectDB.php";
$stm = $conn->prepare("
    SELECT 
        r.*, 
        m.name AS menu_name, 
        u.username AS user_username, 
        u.email AS user_email 
    FROM 
        reservation r
    JOIN 
        menu m 
    ON 
        r.menu_id = m.id
    JOIN 
        user u 
    ON 
        r.user_id = u.id
");


$stm->execute();
$res = $stm->get_result();
if ($res->num_rows > 0) {
    $reservations = $res->fetch_all(MYSQLI_ASSOC);
}


?>
<?php include "./inc/header.php" ?>
<div class="min-h-screen flex flex-col">
    <div class="bg-black">
        <?php include "./inc/navbar.php" ?>
    </div>
    <div class="relative flex-grow flex items-start">
        <aside id="default-sidebar" class="w-64 h-screen flex-shrink-0">
            <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                <ul class="space-y-2 font-medium mt-10">
                    <li>
                        <a href="./dashboard.php" class="flex items-center bg-gray-100 p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="./menus.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                <path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z" />
                            </svg>
                            <span class="ms-3">Menus</span>
                        </a>
                    </li>
                    <li>
                        <a href="./plat.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                            <img src="./assets/dish-svgrepo-com.svg" class="w-5 h-5" alt="">
                            <span class="ms-3">Dishes</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <div class="relative flex-grow flex items-start">
            <main class="px-5 flex-grow h-full lg:px-10 mt-5">
                <h1 class="font-bold text-neutral-700 text-3xl underline">Dashboard</h1>
                <h2 class="font-semibold flex items-center gap-x-2 text-neutral-700 text-lg mt-10">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    Statistiques
                </h2>
                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5 mt-10">
                    <div class=" rounded-md border p-5 py-7 ">
                        <div class="flex items-center gap-x-2">
                            <img src="./assets/date.png" class="w-8 h-8" />
                            <span class="font-bold text-neutral-700 text-2xl">10</span>
                        </div>
                        <p class="text-neutral-700 mt-4 font-medium">
                            Total number of Accepted reservation
                        </p>
                    </div>
                    <div class=" rounded-md border p-5 py-7 ">
                        <div class="flex items-center gap-x-2">
                            <img src="./assets/clipboard.png" class="w-8 h-8" />
                            <span class="font-bold text-neutral-700 text-2xl">10</span>
                        </div>
                        <p class="text-neutral-700 mt-4 font-medium">
                            Total number of Pending reservations
                        </p>
                    </div>
                    <div class=" rounded-md border p-5 py-7 ">
                        <div class="flex items-center gap-x-2">
                            <img src="./assets/calendar.png" class="w-8 h-8" />
                            <span class="font-bold text-neutral-700 text-2xl">10</span>
                        </div>
                        <p class="text-neutral-700 mt-4 font-medium">
                            Total number of Rejected reservations
                        </p>
                    </div>
                </div>
                <h2 class="font-semibold text-neutral-700 flex flex items-center gap-x-2 text-lg mt-10">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                        <path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z" />
                    </svg>
                    Reservations
                </h2>
                <div class="relative overflow-x-auto mt-10 shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    user
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    People
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    menu Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($reservations) || count($reservations) > 0) :  ?>
                                <?php foreach ($reservations as $reserv): ?>
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <?= $reserv["user_username"]  ?>
                                        </th>
                                        <td class="px-6 py-4">
                                            <?= $reserv["date"]  ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?= $reserv["number_of_people"]  ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?= $reserv["status"]  ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?= $reserv["menu_name"]  ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <th colspan="100%" class="text-center text-neutral-700 w-full py-4">
                                        No reservation available.
                                    </th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</div>

<?php include "./inc/footer.php" ?>