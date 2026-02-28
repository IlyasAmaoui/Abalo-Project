import './bootstrap';
import {pi,round} from 'mathjs';
import { createApp } from 'vue';
const app = createApp({
    data() {
        return {
            searchQuery: '',
            results: [],
            isLoading: false,
            xhr: null // Für die XMLHttpRequest-Instanz
        }
    },
    methods: {
        onSearchInput() {
            // Abbrechen laufende Anfrage

            // Suche erst ab 3 Zeichen
            if (this.searchQuery.length >= 3) {
                this.searchArticles();
            } else {
                this.results = [];
            }
        },
        searchArticles() {
            this.$data.isLoading = true;
            this.$data.results = [];

            this.xhr = new XMLHttpRequest();
            const url = `/api/articles?search=${encodeURIComponent(this.searchQuery)}`;

            this.xhr.open('GET', url);
            this.xhr.setRequestHeader('Accept', 'application/json');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            this.xhr.setRequestHeader('X-CSRF-TOKEN', token);

            this.xhr.onload = () => {
                if (this.xhr.status === 200) {
                    const data = JSON.parse(this.xhr.responseText);
                    console.log('API Response:', data);
                    // Nur die ersten 5 Ergebnisse anzeigen
                    this.$data.results = data.articles.slice(0, 5);
                } else {
                    console.error('Fehler bei der Suche');
                }
                this.isLoading = false;
            };

            this.xhr.onerror = () => {
                console.error('Request failed');
                this.isLoading = false;
            };

            this.xhr.send();
        }
    },

}).mount('#search-app');

import newArticle from "../components/newArticle.vue";
const vm=createApp({});
vm.component('newArticle',newArticle);
vm.mount('#new_article_app')









console.log(round(pi,4));

function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
    // path=/ : (standardwert) heißt die Cookie ist für die gesamte Domain gültig (z.B example.com/,example.com/blog).
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


const menuItems = [
    {
        name: "Home",
        url: "/articles",
        submenu: null
    },
    {
        name: "Kategorien",
        url: "/categories",
        submenu: null
    },
    {
        name: "Verkaufen",
        url: "/sell",
        submenu: null
    },
    {
        name: "Unternehmen",
        url: "",
        submenu: [
            { name: "Philosophie", url: "/philosophy" },
            { name: "Karriere", url: "/careers" }
        ]
    }
];
class NavigationsMenu{
    constructor(menuItems,targetElementId) {
        this.menuItems=menuItems;
        this.targetElement=document.getElementById(targetElementId);
    }
    updateMenuItemUrl(name,newUrl){
        const item = this.findMenuItem(name);
        if (item) {
            item.url = newUrl;
            this.render();
            return true;
        }
        return false;

    }
    findMenuItem(name) {
        // Name in Hauptmenü suchen
        const mainItem = this.menuItems.find(item => item.name === name);// wird das erste Treffen zurückgegeben
        if (mainItem) {return mainItem;}

        // Name in SubMenu suchen
        for (const item of this.menuItems) {
            if (item.submenu) {
                const subItem = item.submenu.find(sub => sub.name === name);
                if (subItem) {return subItem;}
            }
        }
        return null;
    }
    render(){
        this.targetElement.innerHTML=this.generateMenu();
        this.bindEvents();
    }
    hasSubmenu(menuItemName){
        const item = this.menuItems.find(item => item.name === menuItemName);
        return item && item.submenu !== null;
    }
    bindEvents() {
        this.targetElement.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                if (this.hasSubmenu(`${link.innerText}`))
                {

                    const submenuElement=document.getElementById(`submenu-${link.innerText}`);
                    if (submenuElement) {

                        submenuElement.style.display = submenuElement.style.display === 'block' ? 'none' : 'block';
                    }
                }
                else {
                    window.location.href = e.target.href;
                }
            });
        });
    }
    generateMenu(){
        return `
        <ul class="menu">
            ${this.menuItems.map(item => `
                <li class="menu-item">
                    <a href="${item.url}" id="${item.name}">${item.name}</a>
                    ${this.hasSubmenu(item.name) ? `
                        <ul class="submenu" id="submenu-${item.name}">
                            ${item.submenu.map(subItem => `
                                <li><a href="${subItem.url}">${subItem.name}</a></li>
                            `).join('')}
                        </ul>
                    ` : ''}
                </li>
            `).join('')}
        </ul>
    `;
    }
}
document.addEventListener('DOMContentLoaded', () => {
    const navContainer = new NavigationsMenu(menuItems,'main-navigation');
    navContainer.render();
    navContainer.updateMenuItemUrl('Unternehmen','/unternehmen');
});



/*
// DOMContentLoaded : sobald das HTML-Dokument vollständig geladen,ohne auf Stylesheets, Bilder oder andere externe Ressourcen zu warten
document.addEventListener('DOMContentLoaded', () => {
        const navContainer = document.getElementById('main-navigation');
        const menuHTML = generateMenu(menuItems);
        navContainer.innerHTML = menuHTML;

        // optional
        const unternehmen =document.getElementById('Unternehmen');
        unternehmen.addEventListener('click',(event) => {
        event.preventDefault(); // verhindert die Navigation
        const submenu_Unternehmen=document.getElementById('submenu-Unternehmen');
        submenu_Unternehmen.style.display=submenu_Unternehmen.style.display==='block' ? 'none':'block';
    });
});

function generateMenu(items) {
    return `
        <ul class="menu">
            ${items.map(item => `
                <li class="menu-item">
                    <a href="${item.url}" id="${item.name}">${item.name}</a>
                    ${item.submenu ? `
                        <ul class="submenu" id="submenu-${item.name}">
                            ${item.submenu.map(subItem => `
                                <li><a href="${subItem.url}">${subItem.name}</a></li>
                            `).join('')}
                        </ul>
                    ` : ''}
                </li>
            `).join('')}
        </ul>
    `;
}
*/
