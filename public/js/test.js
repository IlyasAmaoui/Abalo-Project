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
