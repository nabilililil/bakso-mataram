</div> <!-- #app -->

<!-- ✅ Script Dark Mode -->
<script>
function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
    localStorage.setItem("mode", document.body.classList.contains("dark-mode") ? "dark" : "light");
}

// Aktifkan mode gelap jika sebelumnya dipilih
window.onload = () => {
    if (localStorage.getItem("mode") === "dark") {
        document.body.classList.add("dark-mode");
    }
};
</script>

</body>
</html>
