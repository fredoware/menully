document.addEventListener('DOMContentLoaded', function() {
    // Select all collapse toggles
    const collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

    collapseToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const icon = toggle.querySelector('.toggle-icon');
            const targetId = toggle.getAttribute('href');
            const target = document.querySelector(targetId);

            target.addEventListener('shown.bs.collapse', function() {
                icon.classList.replace('fa-angle-right', 'fa-angle-down');
            });

            target.addEventListener('hidden.bs.collapse', function() {
                icon.classList.replace('fa-angle-down', 'fa-angle-right');
            });
        });
    });
});


// Bottom sheet 

// document.addEventListener("DOMContentLoaded", () => {
//     const openSheetBtn = document.getElementById("openSheetBtn");
//     const closeSheetBtn = document.getElementById("closeSheetBtn");
//     const bottomSheet = document.getElementById("bottomSheet");

//     // Open bottom sheet
//     openSheetBtn.addEventListener("click", () => {
//         bottomSheet.style.bottom = "0";
//     });

//     // Close bottom sheet
//     closeSheetBtn.addEventListener("click", () => {
//         bottomSheet.style.bottom = "-100%";
//     });

//     // Close bottom sheet when clicking outside of it
//     window.addEventListener("click", (event) => {
//         if (event.target === bottomSheet) {
//             bottomSheet.style.bottom = "-100%";
//         }
//     });
// });