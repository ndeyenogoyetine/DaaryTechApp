document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll(".btn-restaurer-user").forEach(function(btnRestaurerUser) {

        btnRestaurerUser.addEventListener("click", function(event) {
            event.preventDefault();

            const userRestaurerId = this.getAttribute('data-confirm-id-user');
            const userRestaurerName = this.getAttribute('data-confirm-nom-user');

            Swal.fire({
                title: `Voulez-vous restaurer l'utilisateur ${userRestaurerName} ?`,
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Oui, restaurer',
            }).then((reponse) => {
                if (reponse.isConfirmed) {
                    window.location.href =`UserMainController?id=${userRestaurerId}&action=restaurer`;
                }
            });
        });
    });
});