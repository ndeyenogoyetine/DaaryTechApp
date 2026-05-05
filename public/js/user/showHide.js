    // Récupération des éléments 
    const tableListeUser = document.getElementById("table-liste-user");
    const tableCoreilleUser = document.getElementById("table-corbille-user");

    const btnShowListeUser = document.getElementById("btn-show-liste-users");
    const btnShowCoreilleUser = document.getElementById("btn-show-corbeille-users");

    tableCoreilleUser.setAttribute("hidden", "hidden");
    btnShowListeUser.setAttribute("hidden", "hidden");

    btnShowCoreilleUser.addEventListener("click", function (event) {
        this.setAttribute("hidden", "hidden");// c'est pour masquer
        btnShowListeUser.removeAttribute("hidden");// c'est pour afficher

        tableListeUser.setAttribute("hidden", "hidden");
        tableCoreilleUser.removeAttribute("hidden");
    });

    btnShowListeUser.addEventListener("click", function (event) {
        this.setAttribute("hidden", "hidden");
        btnShowCoreilleUser.removeAttribute("hidden");

        tableListeUser.removeAttribute("hidden");
        tableCoreilleUser.setAttribute("hidden", "hidden");

     });