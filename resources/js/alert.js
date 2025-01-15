
window.showLoginAlert = function () {
    Swal.fire({
        title: "Login Diperlukan",
        text: "Silakan login terlebih dahulu untuk mengakses fitur ini",
        icon: "info",
        confirmButtonText: "Login Sekarang",
        confirmButtonColor: "#0D9488",
        showCancelButton: true,
        cancelButtonText: "Nanti",
        showClass: {
            popup: "animate__animated animate__fadeInDown",
        },
        hideClass: {
            popup: "animate__animated animate__fadeOutUp",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            window.dispatchEvent(new CustomEvent("open-login-modal"));
        }
    });
};
