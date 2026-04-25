document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll(".btn-delete-definitive").forEach(function(btnDeleteDef) {

        btnDeleteDef.addEventListener("click", function(event) {
            event.preventDefault();

            const serviceReaId = this.getAttribute('data-id');
            const serviceReaName = this.getAttribute('name-servicerea');

            Swal.fire({
                title: `Voulez vous bien supprimer définitivement la réalisation ${serviceReaName} ?`,
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Annuler la suppression definitive',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer',
            }).then((reponse) => {
                if (reponse.isConfirmed) {
                    window.location.href = `serviceRearMainController?id=${serviceReaId}&action=deleteDefinitive`;
                }
            });
        });
    });
});