document.getElementById("burger").addEventListener("click", function () {
    document.getElementById("nav").classList.toggle("-right-full")
    document.getElementById("nav").classList.toggle("right-0")
    document.getElementById("nav").classList.toggle("bg-cyan-800")
    document.getElementById("burger").classList.toggle("active-burger")
})