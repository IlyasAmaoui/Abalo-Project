<template>
  <header>
    <nav>
      <ul class="menu">
        <li
            v-for="item in menuItems"
            :key="item.name"
            :class="['menu__item', { 'menu__item--open': isSubmenuOpen(item.name) }]"
        >
          <a href="#" class="menu__link" @click.prevent="handleMenuClick(item)">
            {{ item.name }}
          </a>

          <ul
              v-if="item.submenu"
              class="menu__submenu"
              :class="{ 'menu__submenu--visible': isSubmenuOpen(item.name) }"
          >
            <li v-for="subItem in item.submenu" :key="subItem.name" class="menu__submenu-item">
              <a :href="subItem.url" class="menu__link">{{ subItem.name }}</a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
</template>



<script>
export default {
  name: 'SiteHeader',
  data() {
    return {
      menuItems: [
        { name: "Home", url: "/articles", submenu: null },
        { name: "Kategorien", url: "/categories", submenu: null },
        { name: "Verkaufen", url: "/sell", submenu: null },
        {
          name: "Unternehmen",
          url: "/unternehmen", // direkt gesetzt!
          submenu: [
            { name: "Philosophie", url: "/philosophy" },
            { name: "Karriere", url: "/careers" }
          ]
        }
      ],
      openSubmenus: []
    };
  },
  methods: {
    handleMenuClick(item) {
      if (item.submenu) {
        const index = this.openSubmenus.indexOf(item.name);
        if (index === -1) {
          this.openSubmenus.push(item.name);
        } else {
          this.openSubmenus.splice(index, 1);
        }
      } else {
        window.location.href = item.url;
      }
    },
    isSubmenuOpen(name) {
      return this.openSubmenus.includes(name);
    }
  }
};
</script>

<style lang="scss" scoped>
// ✅ 1. Variablen
$menu-bg: #f8f8f8;
$submenu-bg: #ffffff;
$hover-color: #e6e6e6;
$primary: #0d6efd;

// ✅ 2. Mixin
@mixin submenu-style {
  background: $submenu-bg;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  list-style: none;
  padding: 0.5rem 0;
}

// ✅ 3. Placeholder
%flex-center {
  display: flex;
  align-items: center;
  justify-content: center;
}

.menu {
  @extend %flex-center;
  gap: 2rem;
  padding: 1rem;
  background: $menu-bg;

  &__item {
    position: relative;

    &--open > .menu__submenu {
      display: block;
    }
  }

  &__link {
    text-decoration: none;
    color: black;
    padding: 0.5rem 1rem;
    display: inline-block;

    &:hover {
      background: $hover-color;
      color: $primary;
    }

    &--active {
      font-weight: bold;
      color: $primary;
    }
  }

  &__submenu {
    display: none;
    position: absolute;
    @include submenu-style;

    &--visible {
      display: block;
    }

    &-item {
      padding: 0.5rem 1rem;

      a {
        text-decoration: none;
        color: black;
      }

      &:hover {
        background: $hover-color;
      }
    }
  }
}
</style>

