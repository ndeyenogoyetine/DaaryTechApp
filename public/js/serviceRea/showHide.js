    // Récupération des éléments 
    const tableListe = document.getElementById("table-liste");
    const tableCoreille = document.getElementById("table-corbille");
    const btnShowListe = document.getElementById("btn-show-liste");
    const btnShowCoreille = document.getElementById("btn-show-corbeille");


    tableCoreille.setAttribute("hidden", "hidden");
    btnShowListe.setAttribute("hidden", "hidden");

    btnShowCoreille.addEventListener("click", function (event) {
        this.setAttribute("hidden", "hidden");// c'est pour masquer
        btnShowListe.removeAttribute("hidden");// c'est pour afficher

        tableListe.setAttribute("hidden", "hidden");
        tableCoreille.removeAttribute("hidden");
    });

    btnShowListe.addEventListener("click", function (event) {
        this.setAttribute("hidden", "hidden");
        btnShowCoreille.removeAttribute("hidden");

        tableListe.removeAttribute("hidden");
        tableCoreille.setAttribute("hidden", "hidden");

     });