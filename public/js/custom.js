document.addEventListener("DOMContentLoaded", function() {
    const btn = document.getElementById("reserveBtn");
    if (btn) {
        btn.addEventListener("click", function(e) {
            e.preventDefault(); // Sayfanın yukarı kaymasını engelle

            const reservationSection = document.getElementById("reservation");
            if (reservationSection) {
                reservationSection.scrollIntoView({ behavior: "smooth" });
            }
        });
    }
});
