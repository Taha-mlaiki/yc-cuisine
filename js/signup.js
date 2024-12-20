let notification = document.querySelector(".notification");
let notificationMessage = document.querySelector(".notification p");
if (notification && notificationMessage) {
  notification.classList.remove("translate-x-72");
  setTimeout(() => {
    notification.classList.add("translate-x-72");
    window.location.pathname = "/cuisine-brief/";
  }, 2000);
}
