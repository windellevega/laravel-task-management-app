<template>
  <CDropdown
    inNav
    class="c-header-nav-items"
    placement="bottom-end"
    add-menu-classes="pt-0"
  >
    <template #toggler>
      <CHeaderNavLink>
        <div class="c-avatar">
          <img src="https://picsum.photos/id/1074/200" class="c-avatar-img" />
        </div>
      </CHeaderNavLink>
    </template>
    <CDropdownHeader tag="div" class="text-center" color="light">
      <strong>Account</strong>
    </CDropdownHeader>
    <CDropdownItem> 
      <CIcon name="cil-user" /> Profile 
    </CDropdownItem>
    <CDropdownItem @click="onLogout"> 
      <CIcon name="cil-lock-locked" /> Logout 
    </CDropdownItem>
  </CDropdown>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: "TheHeaderDropdownAccnt",
  data() {
    return {

    }
  },
  methods: {
    ...mapActions({
      logout: 'auth/logout'
    }),

    onLogout() {
      this.logout()
      .then(() => {
        this.$router.push('login')
      });
    }
  },
};
</script>

<style scoped>
.c-icon {
  margin-right: 0.3rem;
}
</style>