/* CHECKMATE - profile menu (shared by all student pages)
   Clicking the 3 dots next to the profile opens a small menu with "Log out".
   The styles are injected here, so no CSS file needs editing. */

(() => {
    "use strict";

    if (window.__checkmateUserMenu) return;
    window.__checkmateUserMenu = true;

    const DEFAULT_LOGOUT_URL = "../../authentication/Login/logout.php";

    const style = document.createElement("style");
    style.textContent = `
        .cm-user-menu {
            position: fixed;
            z-index: 99998;
            min-width: 170px;
            padding: 6px;
            border: 1px solid #71582d;
            border-radius: 6px;
            background: #181816;
            box-shadow: 0 10px 28px rgba(0, 0, 0, .5);
            font-family: Arial, Helvetica, sans-serif;
        }
        .cm-user-menu[hidden] { display: none; }
        .cm-user-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 4px;
            color: #e7e0d5;
            font-size: 13px;
            text-decoration: none;
        }
        .cm-user-menu a:hover,
        .cm-user-menu a:focus {
            background: #292217;
            color: #d4a657;
            outline: none;
        }
        .cm-user-menu .cm-menu-icon {
            color: #d4a657;
            font-size: 14px;
        }
    `;
    document.head.appendChild(style);

    function init() {
        const button = document.querySelector(".user-more");

        if (!button) return;

        const menu = document.createElement("div");
        menu.className = "cm-user-menu";
        menu.id = "cmUserMenu";
        menu.setAttribute("role", "menu");
        menu.hidden = true;

        const logout = document.createElement("a");
        logout.href = button.dataset.logout || DEFAULT_LOGOUT_URL;
        logout.setAttribute("role", "menuitem");

        const icon = document.createElement("span");
        icon.className = "cm-menu-icon";
        icon.setAttribute("aria-hidden", "true");
        icon.textContent = "→";

        const label = document.createElement("span");
        label.textContent = "Log out";

        logout.append(icon, label);
        menu.appendChild(logout);
        document.body.appendChild(menu);

        button.setAttribute("aria-haspopup", "menu");
        button.setAttribute("aria-expanded", "false");
        button.setAttribute("aria-controls", "cmUserMenu");

        function place() {
            const rect = button.getBoundingClientRect();

            menu.style.visibility = "hidden";
            menu.hidden = false;

            const width = menu.offsetWidth;
            const height = menu.offsetHeight;

            // Open upward (the button sits at the bottom of the sidebar)
            let left = rect.right - width;
            let top = rect.top - height - 8;

            left = Math.max(8, Math.min(left, window.innerWidth - width - 8));

            if (top < 8) {
                top = rect.bottom + 8;
            }

            menu.style.left = left + "px";
            menu.style.top = top + "px";
            menu.style.visibility = "visible";
        }

        function open() {
            place();
            button.setAttribute("aria-expanded", "true");
            logout.focus();
        }

        function close() {
            menu.hidden = true;
            button.setAttribute("aria-expanded", "false");
        }

        button.addEventListener("click", function (event) {
            event.stopPropagation();

            if (menu.hidden) {
                open();
            } else {
                close();
            }
        });

        document.addEventListener("click", function (event) {
            if (!menu.hidden && !menu.contains(event.target)) {
                close();
            }
        });

        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape" && !menu.hidden) {
                close();
                button.focus();
            }
        });

        window.addEventListener("resize", close);
        window.addEventListener("scroll", close, true);
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();