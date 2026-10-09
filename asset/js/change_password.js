
        // ---------- 1. GET ELEMENTS ----------
        var toast = document.getElementById("toast");

        var currentPassword = document.getElementById("currentPassword");
        var newPassword = document.getElementById("newPassword");
        var confirmPassword = document.getElementById("confirmPassword");
        var formError = document.getElementById("formError");


        // ---------- 2. TOAST ----------
        function showToast(message) {
            toast.textContent = message;
            toast.classList.add("show");

            setTimeout(function () {
                toast.classList.remove("show");
            }, 2500);
        }


        // ---------- 3. SHOW / HIDE BUTTONS ----------
        var toggleButtons = document.querySelectorAll(".toggle-btn");

        for (var t = 0; t < toggleButtons.length; t++) {
            toggleButtons[t].addEventListener("click", function () {

                var input = document.getElementById(this.getAttribute("data-target"));

                if (input.type === "password") {
                    input.type = "text";
                    this.textContent = "Hide";
                } else {
                    input.type = "password";
                    this.textContent = "Show";
                }
            });
        }


        // ---------- 4. PASSWORD RULES ----------
        // returns true/false for each rule
        function checkRules() {

            var pass = newPassword.value;

            return {
                length: pass.length >= 8,
                upper: /[A-Z]/.test(pass),
                lower: /[a-z]/.test(pass),
                number: /[0-9]/.test(pass),
                match: pass !== "" && pass === confirmPassword.value
            };
        }

        function setRule(id, passed) {
            var item = document.getElementById(id);

            if (passed) {
                item.classList.add("ok");
            } else {
                item.classList.remove("ok");
            }
        }

        function showRules() {
            var rules = checkRules();

            setRule("ruleLength", rules.length);
            setRule("ruleUpper", rules.upper);
            setRule("ruleLower", rules.lower);
            setRule("ruleNumber", rules.number);
            setRule("ruleMatch", rules.match);
        }

        newPassword.addEventListener("input", showRules);
        confirmPassword.addEventListener("input", showRules);


        // ---------- 5. SAVE ----------
        document.getElementById("saveButton").addEventListener("click", function () {

            formError.textContent = "";

            if (currentPassword.value === "" || newPassword.value === "" || confirmPassword.value === "") {
                formError.textContent = "Please fill in all three password boxes.";
                return;
            }

            var rules = checkRules();

            if (!rules.length || !rules.upper || !rules.lower || !rules.number) {
                formError.textContent = "The new password does not meet all of the rules.";
                return;
            }

            if (!rules.match) {
                formError.textContent = "The new passwords do not match.";
                return;
            }

            if (newPassword.value === currentPassword.value) {
                formError.textContent = "The new password must be different from the current one.";
                return;
            }

            // TODO: send currentPassword and newPassword to PHP.
            // PHP must check the current password, then save the new one as a hash
            // (password_hash) in the database.

            currentPassword.value = "";
            newPassword.value = "";
            confirmPassword.value = "";
            showRules();

            showToast("Password updated.");
        });


        // ---------- 6. ACCOUNT MENU (3 dots) ----------
        var accountButton = document.getElementById("accountMenuButton");
        var accountMenu = document.getElementById("accountMenu");

        accountButton.addEventListener("click", function (event) {
            event.stopPropagation();
            accountMenu.classList.toggle("show");
            accountButton.classList.toggle("open");
        });

        // clicking anywhere else (or pressing Esc) closes it
        document.addEventListener("click", function () {
            accountMenu.classList.remove("show");
            accountButton.classList.remove("open");
        });

        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                accountMenu.classList.remove("show");
                accountButton.classList.remove("open");
            }
        });


        // ---------- 7. NOTIFICATION BUTTON ----------
        document.getElementById("notificationButton").addEventListener("click", function () {
            showToast("You have 3 new notifications.");
        });

