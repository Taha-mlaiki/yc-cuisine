<?php
include "./inc/connectDB.php";
include "./actions/reservations/create.php";
if (empty($_GET["menuId"])) {
    echo "No menu is selected";
    exit();
}
$stm = $conn->prepare(
    "SELECT d.*
        FROM menu_dish md
        JOIN dish d ON md.dish_id = d.id
        WHERE md.menu_id = ?;
    "
);
$stm->bind_param("i", $_GET["menuId"]);
$stm->execute();
$res = $stm->get_result();
$data = $res->fetch_all(MYSQLI_ASSOC);
$stm = $conn->prepare(
    "SELECT *
       FROM menu WHERE id = ?
    "
);
$stm->bind_param("i", $_GET["menuId"]);
$stm->execute();
$res = $stm->get_result();
$menu = $res->fetch_assoc();

?>
<?php include "./inc/header.php" ?>
<header class="flex flex-col">
    <?php include "./inc/navbar.php" ?>
    <div class="w-full h-[80vh] relative bg-black flex items-center justify-center">
        <p class="text-white">No Image available!</p>
        <img class="absolute inset-0 w-full z-3 h-full bg-contain" src="<?= $menu["image"] ?>" alt="menu image" />
    </div>
</header>
<main class="px-5 lg:px-10 ">
    <div class="flex items-center justify-between mt-10">
        <h1 class="font-bold text-3xl text-primary text-center">Dishes</h1>
        <button id="btn-modal" class="px-4 py-2 rounded-lg text-lg font-bold bg-primary text-white">
            Reserve this Menu
        </button>
    </div>
    <div class="max-w-7xl w-full mx-auto">
        <?php if (!empty($data) && count($data) > 0) : ?>
            <div class="grid md:grid-cols-2 gap-10 lg:grid-cols-3 my-20">
                <?php foreach ($data as $dish): ?>
                    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="w-full relative h-[350px] bg-black flex items-center justify-center">
                            <span class="text-white text-lg">No Image available</span>
                            <img class="absolute inset-0 w-full z-3 h-full bg-contain" src="<?= $dish["image_url"] ?>" alt="product image" />
                        </div>
                        <div class="py-7 flex flex-col justify-between px-5 pb-5">
                            <h5 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white"><?= $dish["name"] ?></h5>
                            <p class="my-2 text-neutral-700"><?= $dish["description"] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-center text-gray-500 my-20">No Dish available at the moment.</p>
        <?php endif; ?>
    </div>
    <div id="modal" tabindex="-1" aria-hidden="true" class="hidden flex items-center justify-center fixed inset-0  w-full min-h-screen overflow-auto py-20 z-50 bg-black/30 backdrop-blur-lg">
        <div class="relative p-4 w-full max-w-md">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="modal-title" class="text-lg font-semibold text-gray-900 dark:text-white">
                        Reserve <span class="text-primary"><?= $menu["name"] ?></span> Menu
                    </h3>
                    <button type="button" id="close-modal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" id="reservationForm" action="" method="post">
                    <input type="hidden" name="id" value="<?= $_GET["menuId"] ?>">
                    <div class="flex flex-col gap-y-2">
                        <label class="font-semibold text-neutral-700" for="reservation_date">Reservation Date</label>
                        <input class="border py-2 px-3 rounded-md border border-primary" type="date" name="reservation_date" id="reservation_date">
                        <p id="dateError" class="text-red-500 text-sm hidden">Please select a valid reservation date.</p>
                    </div>
                    <div class="flex flex-col gap-y-2 my-3">
                        <label class="font-semibold text-neutral-700" for="reservation_time">Reservation Time</label>
                        <input class="border py-2 px-3 rounded-md border border-primary" type="time" name="reservation_time" id="reservation_time">
                        <p id="timeError" class="text-red-500 text-sm hidden">Please select a valid reservation time.</p>
                    </div>
                    <div class="flex flex-col gap-y-2 my-3">
                        <label class="font-semibold text-neutral-700" for="num_people">Number of people</label>
                        <input class="border py-2 px-3 rounded-md border border-primary" type="number" name="num_people" id="num_people">
                        <p id="peopleError" class="text-red-500 text-sm hidden">Please enter a valid number of people (at least 1).</p>
                    </div>
                    <div class="mt-2">
                        <input
                            id="modal-btn"
                            type="submit"
                            name="create"
                            class="text-white flex items-center gap-x-1 font-semibold bg-primary hover:bg-primary/90 px-3 py-2 cursor-pointer rounded-lg ms-auto" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    document.getElementById("close-modal").addEventListener("click", () => {
        modal.classList.add("hidden");
    })
    const modal = document.getElementById("modal")
    document.getElementById("btn-modal").addEventListener("click", () => {
        modal.classList.remove("hidden");
    })

    document.getElementById("reservationForm").addEventListener("submit", function(e) {
        let isValid = true;

        // Get form fields
        const reservationDate = document.getElementById("reservation_date");
        const reservationTime = document.getElementById("reservation_time");
        const numPeople = document.getElementById("num_people");

        // Get error message elements
        const dateError = document.getElementById("dateError");
        const timeError = document.getElementById("timeError");
        const peopleError = document.getElementById("peopleError");

        // Reset error messages
        dateError.classList.add("hidden");
        timeError.classList.add("hidden");
        peopleError.classList.add("hidden");

        // Validate reservation date
        if (!reservationDate.value) {
            dateError.classList.remove("hidden");
            isValid = false;
        }

        // Validate reservation time
        if (!reservationTime.value) {
            timeError.classList.remove("hidden");
            isValid = false;
        }

        // Validate number of people
        if (!numPeople.value || numPeople.value <= 0) {
            peopleError.classList.remove("hidden");
            isValid = false;
        }

        // Prevent submission if invalid
        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
<?php include "./inc/footer.php" ?>