/* CHECKMATE - notifications (shared by all student pages)
   - new messages: badge on "Messages", toast, sound
   - new answers to your questions: badge on "My Questions", toast, sound
   - total unread count in the browser tab title
   Needs: messages_api.php (action=unread) and notifications_api.php (action=answers)
   in view/student/ */

(() => {
    "use strict";

    if (window.__checkmateNotify) return;
    window.__checkmateNotify = true;

    const MESSAGES_URL = "messages_api.php";
    const ANSWERS_URL = "notifications_api.php";
    const POLL_MS = 4000;
    const BASE_TITLE = document.title;

    let audioCtx = null;
    let unreadMessages = 0;
    let unseenAnswers = 0;

    /* ---------- styles (injected, so no CSS file needs editing) ---------- */

    const style = document.createElement("style");
    style.textContent = `
        .cm-nav-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 18px;
            margin-left: auto;
            padding: 0 5px;
            border-radius: 9px;
            background: #d4a657;
            color: #17130c;
            font-size: 10px;
            font-weight: 700;
            line-height: 1;
        }
        .cm-nav-badge[hidden] { display: none !important; }

        #cmToasts {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 320px;
        }
        .cm-toast {
            display: block;
            padding: 12px 14px;
            border: 1px solid #71582d;
            border-left: 3px solid #d4a657;
            border-radius: 5px;
            background: #181816;
            color: #e7e0d5;
            font-family: Arial, Helvetica, sans-serif;
            text-decoration: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .45);
            animation: cmToastIn .25s ease;
        }
        .cm-toast:hover { background: #292217; }
        .cm-toast strong {
            display: block;
            margin-bottom: 4px;
            color: #d4a657;
            font-size: 12px;
        }
        .cm-toast span {
            display: block;
            overflow: hidden;
            color: #c9c3b9;
            font-size: 11px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        @keyframes cmToastIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);

    /* ---------- helpers ---------- */

    function storeGet(key) {
        try { return sessionStorage.getItem(key); } catch { return null; }
    }

    function storeSet(key, value) {
        try { sessionStorage.setItem(key, String(value)); } catch { /* ignore */ }
    }

    // Small number badge on a sidebar link (for example Messages or My Questions)
    function setBadge(page, count) {
        const text = count > 99 ? "99+" : String(count);

        document.querySelectorAll(`a[href$="${page}"]`).forEach(link => {
            let badge = link.querySelector(".cm-nav-badge");

            if (!badge) {
                badge = document.createElement("span");
                badge.className = "cm-nav-badge";
                link.appendChild(badge);
            }

            badge.textContent = text;
            badge.hidden = count <= 0;
        });
    }

    function updateTitle() {
        const total = unreadMessages + unseenAnswers;
        document.title = total > 0 ? `(${total}) ${BASE_TITLE}` : BASE_TITLE;
    }

    function showToast(href, titleText, previewText) {
        let box = document.getElementById("cmToasts");

        if (!box) {
            box = document.createElement("div");
            box.id = "cmToasts";
            document.body.appendChild(box);
        }

        while (box.children.length >= 3) box.firstChild.remove();

        const toast = document.createElement("a");
        toast.className = "cm-toast";
        toast.href = href;

        const title = document.createElement("strong");
        title.textContent = titleText;

        const preview = document.createElement("span");
        preview.textContent = previewText;

        toast.append(title, preview);
        box.appendChild(toast);

        setTimeout(() => toast.remove(), 7000);
    }

    function beep() {
        try {
            if (!audioCtx) return;
            if (audioCtx.state === "suspended") audioCtx.resume();

            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();

            osc.type = "sine";
            osc.frequency.value = 880;
            gain.gain.setValueAtTime(0.0001, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.15, audioCtx.currentTime + 0.02);
            gain.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + 0.25);

            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.27);
        } catch { /* sound is optional */ }
    }

    // Browsers only allow sound after the user clicked something on the page.
    document.addEventListener("click", () => {
        if (audioCtx) return;
        try {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        } catch { /* ignore */ }
    }, { once: true });

    async function getJson(url) {
        const response = await fetch(url, {
            credentials: "same-origin",
            cache: "no-store",
            headers: { Accept: "application/json" }
        });

        if (!response.ok) return null;

        const data = await response.json();

        return data && data.ok ? data : null;
    }

    /* ---------- messages ---------- */

    async function pollMessages() {
        try {
            const data = await getJson(`${MESSAGES_URL}?action=unread`);

            if (!data) return;

            unreadMessages = Number(data.unread) || 0;
            setBadge("messages.php", unreadMessages);
            updateTitle();

            const key = `cm_last_notified_${data.me}`;
            const stored = storeGet(key);
            const latest = data.latest;

            if (!latest) {
                if (stored === null) storeSet(key, 0);
                return;
            }

            const latestId = Number(latest.message_id);

            // First visit in this tab: remember the current state, don't popup old messages.
            if (stored === null) {
                storeSet(key, latestId);
                return;
            }

            if (latestId > Number(stored)) {
                storeSet(key, latestId);

                const viewing =
                    Number(window.CHECKMATE_ACTIVE_CONVERSATION) ===
                        Number(latest.conversation_id) &&
                    !document.hidden;

                if (!viewing) {
                    showToast(
                        "messages.php?c=" + encodeURIComponent(latest.conversation_id),
                        "New message from " + latest.sender_name,
                        latest.preview
                    );
                    beep();
                }
            }
        } catch {
            /* network hiccup: try again on the next poll */
        }
    }

    /* ---------- answers to my questions ---------- */

    async function pollAnswers() {
        try {
            const data = await getJson(`${ANSWERS_URL}?action=answers`);

            if (!data) return;

            unseenAnswers = Number(data.unseen) || 0;
            setBadge("my_question.php", unseenAnswers);
            updateTitle();

            const latest = data.latest;

            if (!latest) return;

            const key = `cm_last_answer_${data.me}`;
            const stored = Number(storeGet(key)) || 0;
            const latestId = Number(latest.answer_id);

            // Pop up once for each new answer (also right after logging in)
            if (latestId > stored) {
                storeSet(key, latestId);

                showToast(
                    "my_question.php",
                    latest.answerer_name + " answered your question",
                    latest.preview
                );
                beep();
            }
        } catch {
            /* network hiccup: try again on the next poll */
        }
    }

    function pollAll() {
        pollMessages();
        pollAnswers();
    }

    document.addEventListener("visibilitychange", () => {
        if (!document.hidden) pollAll();
    });

    pollAll();
    window.setInterval(pollAll, POLL_MS);
})();