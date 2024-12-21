<?php
include "./inc/connectDB.php";
include "./actions/dish/create_update.php";
$stm = $conn->prepare("SELECT * FROM dish");
$stm->execute();
$res = $stm->get_result();
if ($res) {
    $dishes = $res->fetch_all(MYSQLI_ASSOC);
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
                        <a href="./dashboard.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
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
                        <a href="./plat.php" class="flex items-center p-2 text-gray-900 rounded-lg bg-gray-100 dark:text-white dark:hover:bg-gray-700 group">
                            <img src="./assets/dish-svgrepo-com.svg" class="w-5 h-5" alt="">
                            <span class="ms-3">Dishes</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <main class="px-5 flex-grow h-full lg:px-10 mt-5">
            <div class="flex items-center justify-between mt-10">
                <h1 class="font-bold text-neutral-700 text-3xl underline">Dishes</h1>
                <button id="btn-modal" class="px-3 py-2 rounded-lg text-white bg-primary hover:bg-primary/90 font-semibold">Create a Dish</button>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Image
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($dishes) && count($dishes) > 0):  ?>
                            <?php foreach ($dishes as $dish) : ?>
                                <tr class="bg-white items-center border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <img src="<?= $dish["image_url"] ?>" class="w-10 rounded-sm" alt="">
                                    </th>
                                    <td class="px-6 py-4">
                                        <?= $dish["name"] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $dish["description"] ?>
                                    </td>
                                    <td class=" py-5 flex items-center gap-x-2">
                                        <button onclick='editDish(<?= json_encode($dish); ?>)' class="text-white bg-green-500 px-3 py-0.5 rounded-lg">Edit</button>
                                        <button class="text-white bg-red-500 px-3 py-0.5 rounded-lg">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <th colspan="100%" class="text-center text-neutral-700 w-full py-4">
                                    No dish available.
                                </th>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

        </main>
        <div id="modal" tabindex="-1" aria-hidden="true" class="hidden flex items-center justify-center fixed inset-0  w-full min-h-screen overflow-auto py-20 z-50 bg-black/30 backdrop-blur-lg">
            <div class="relative p-4 w-full max-w-md">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 id="modal-title" class="text-lg font-semibold text-gray-900 dark:text-white">
                            Create New Dish
                        </h3>
                        <button type="button" id="close-modal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5" id="dishForm" action="" method="post">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type dish name" />
                                <span id="nameError" class="text-red-500 text-sm hidden">Name is required.</span>
                            </div>
                            <div class="col-span-2">
                                <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image</label>
                                <input
                                    type="url"
                                    name="image"
                                    id="image"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type image URL" />
                                <span id="imageError" class="text-red-500 text-sm hidden">Please enter a valid URL.</span>
                            </div>
                            <div class="col-span-2">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dish Description</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Write Dish description here"></textarea>
                                <span id="descriptionError" class="text-red-500 text-sm hidden">Description is required.</span>
                            </div>
                        </div>
                        <input
                            id="modal-btn"
                            type="submit"
                            name="create"
                            class="text-white flex items-center gap-x-1 font-semibold bg-primary hover:bg-primary/90 px-3 py-2 rounded-lg ms-auto"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const modal =  document.getElementById("modal")
    const modalTitle = document.getElementById("modal-title");
    const modalBtn = document.getElementById("modal-btn");
    let name = document.getElementById("name")
    let image = document.getElementById("image")
    let description = document.getElementById("description")


    document.getElementById("btn-modal").addEventListener("click", () => {
        modal.classList.remove("hidden");
        modalTitle.textContent = "Create New Dish"
        modalBtn.name = "create";
    })


    const editDish = (data)=>{
        modal.classList.remove("hidden");
        modalTitle.textContent = "Update Dish"
        modalBtn.name = "edit";
        console.log(data)
        name.value = data.name
        description.value = data.description
        image.value = data.image_url
    }

    document.getElementById("close-modal").addEventListener("click", () => {
        modal.classList.add("hidden");
        name.value = "";
        image.value = "";
        description.value = "";
    })


    document.getElementById("dishForm").addEventListener("submit", function(e) {
        let isValid = true;

        // Get form fields
         name = name.value.trim();
         image = image.value.trim();
         description = description.value.trim();

        // Get error spans
        const nameError = document.getElementById("nameError");
        const imageError = document.getElementById("imageError");
        const descriptionError = document.getElementById("descriptionError");

        // Reset errors
        nameError.classList.add("hidden");
        imageError.classList.add("hidden");
        descriptionError.classList.add("hidden");

        // Validate Name
        if (!name) {
            nameError.classList.remove("hidden");
            isValid = false;
        }

        // Validate Image URL
        const urlPattern = /^(https?:\/\/)?([\w\-]+(\.[\w\-]+)+)(\/[\w\-]*)*\/?$/;
        if (!image || !urlPattern.test(image)) {
            imageError.classList.remove("hidden");
            isValid = false;
        }

        // Validate Description
        if (!description) {
            descriptionError.classList.remove("hidden");
            isValid = false;
        }

        // Prevent submission if invalid
        if (!isValid) {
            e.preventDefault();
        }
    });

</script>





<?php include "./inc/footer.php" ?>