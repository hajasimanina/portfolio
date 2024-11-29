jQuery(document).ready(function ($) {
    $(document).on('submit', '#portfolio-form-data', function (e) {
        e.preventDefault();

        // Cibler le bouton
        let _btn = $('#portfolio-submit-form');
        _btn.addClass('sending');

        let hasError = false;

        // Réinitialiser les erreurs existantes
        $(".error-message").remove();

        // Vérifier chaque champ
        $(this)
            .find("input, textarea")
            .each(function () {
                let $field = $(this);
                let fieldValue = $field.val().trim();
                let fieldId = $field.attr("id");

                // Obtenir un nom lisible pour le champ (depuis 'aria-label', 'placeholder' ou autre)
                let fieldName = $field.attr("aria-label") || $field.attr("placeholder") || "champ";

                // Déterminer le bon article ("Le", "La", ou "L'")
                let article = /^[aeiouy]/i.test(fieldName) ? "L'" : "Le ";

                // Définir le message d'erreur pour le champ
                let errorMessage = "";
                if (fieldValue === "") {
                    errorMessage = `${article}${fieldName.toLowerCase()} est requis.`;
                } else if (fieldId === "email" && !isValidEmail(fieldValue)) {
                    errorMessage = "Veuillez entrer une adresse e-mail valide.";
                }

                // Ajouter l'erreur si nécessaire
                if (errorMessage) {
                    $field.after(
                        `<span class="error-message text-danger">${errorMessage}</span>`
                    );
                    hasError = true;
                }
            });

        // Si une erreur est détectée, stopper la soumission
        if (hasError) {
            _btn.removeClass('sending'); // Supprime la classe si erreur
            return;
        }

        /* Envoyer les données */
        let formData = $(this).serializeArray();

        $.ajax({
            url: object_form.settings.ajaxUrl,
            type: 'POST',
            data: {
                action: 'portfolio_submit_contact',
                formData: formData
            },
            dataType: 'json',
            beforeSend: function () {
                // Changer le texte du bouton
                _btn.html('Sending...');
            },
            success: function (response) {
                if (response && undefined !== response.response) {
                    showAlert(response.response)
                }
            },
            complete: function () {
                // Réinitialiser le bouton
                _btn.removeClass('sending');
                _btn.html('Submit');
            },
            error: function () {
                showAlert("Une erreur est survenue. Veuillez réessayer.");
                _btn.removeClass('sending');
                _btn.html('Submit');
            }
        });
    });


    function showAlert(message) {
        $("#custom-alert p").text(message); // Mettre à jour le message
        $("#custom-alert").fadeIn(); // Afficher l'alerte avec une animation
    }

    // Fonction pour masquer l'alerte
    function closeAlert() {
        $("#custom-alert").fadeOut(); // Masquer l'alerte avec une animation
    }

    // Lorsque l'utilisateur clique sur le bouton OK
    $(document).on("click", ".btn-close-alert", function () {
        closeAlert();
    });

    /**
     * Fonction pour valider une adresse e-mail
     * @param email
     * @returns {boolean}
     */
    function isValidEmail(email) {
        let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
})