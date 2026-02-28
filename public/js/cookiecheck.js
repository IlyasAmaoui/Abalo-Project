function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
    // path=/ : ( standardwert) heißt die Cookie ist für die gesamte Domain gültig (z.B example.com/,example.com/blog).
    // immer bei der Setzung einer Cookie mit Werten, die Leerzeichen:
    //Lösung--> die Methode encodeURLComponent (name:Variable) benutzen.
    console.log(document.cookie); // zum Test
}


function getCookie(name) {
    const cookieName = name + "=";
    const ca = document.cookie.split(';');
    console.log(ca);
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i]; //cookieConsent=true
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);// um potenzielle Leerzeichen nach dem Semikolon zu entfernen
        if (c.indexOf(cookieName) === 0) return c.substring(cookieName.length);
    }
    return null;
}


function showCookieConsent() {
    if (!getCookie("cookieConsent")) {
        const banner = document.createElement('div');
        banner.id = 'cookie-banner';
        banner.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            max-width: 600px;
            width: 90%;
            background-color: #1e1e1e;
            color: #fff;
            text-align: center;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            font-family: sans-serif;
            font-size: 16px;
            line-height: 1.4;
            animation: fadeIn 0.5s ease-in-out;
        `;

        banner.innerHTML = `
            <p style="margin: 0 0 10px;">
                🍪 Wir verwenden Cookies, um deine Nutzererfahrung zu verbessern.
            </p>
            <button id="accept-cookies" style="
                color: white;
                background-color: #4CAF50;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                transition: background-color 0.3s ease;
            ">
                Zustimmen
            </button>
        `;
        document.body.appendChild(banner);

        document.getElementById('accept-cookies').addEventListener('click', function() {
            setCookie("cookieConsent", "true", 365);
            document.getElementById('cookie-banner').style.display = 'none';
        });
    }
}


showCookieConsent();
