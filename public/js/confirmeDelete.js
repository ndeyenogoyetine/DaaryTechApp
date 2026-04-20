document.addEventListener("DOMContentLoaded", function() {

    // ✅ querySelectorAll + forEach pour cibler tous les boutons
    document.querySelectorAll(".btn-delete").forEach(function(btnDelete) {

        btnDelete.addEventListener("click", function(event) {
            event.preventDefault();

            const serviceReaId = this.getAttribute('data-id');
            const serviceReaName = this.getAttribute('name-servicerea');

            // ✅ Swal avec S majuscule
            Swal.fire({
                title: `Voulez vous supprimez la réalisation ${serviceReaName} ?`,
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer',
            }).then((reponse) => {
                if (reponse.isConfirmed) {
                    window.location.href = `serviceRearMainController?id=${serviceReaId}&action=delete`;
                }
            });
        });
    });
});