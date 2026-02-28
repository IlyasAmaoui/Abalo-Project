import { createApp } from 'vue';
import SiteHeader from '../components/siteheader.vue';
import SiteFooter from "../components/sitefooter.vue";
import SiteBody from '../components/sitebody.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

import maintenance  from "../components/maintenance.vue";


// Aufgabe 12:M5
const metaUserId = document.querySelector('meta[name="session_id"]');
const currentUserId = metaUserId ? metaUserId.content : null;

const socket = new WebSocket("ws://localhost:4010/chat");

socket.onmessage = function(event) {
    const msg = JSON.parse(event.data);

    if (msg.type === 'sold' && msg.user_id == currentUserId) {
        alert(msg.message);
    }
};







const app = createApp({
    data(){
        return {
            currentView: 'home'
        }
    },
    components: {
        maintenance,
        SiteHeader,
        SiteFooter,
        SiteBody,
    },
    template:`
      <div>
        <maintenance></maintenance>
        <site-header></site-header>
        <site-body :view="currentView"></site-body>
        <site-footer @show="currentView = $event"></site-footer>
      </div>
    
    `
});
app.mount('#app');


