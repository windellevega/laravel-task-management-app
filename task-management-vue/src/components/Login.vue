<template>
  <div class="c-app flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="4">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CForm v-on:keyup.enter="onSubmit">
                  <h1>Login</h1>
                  <p class="text-muted">Sign In to your account</p>
                  <CInput
                    placeholder="Email"
                    autocomplete="email"
                    type="email"
                    prepend="@"
                    v-model="form.email"
                  >
                  </CInput>
                  <CInput
                    placeholder="Password"
                    type="password"
                    autocomplete="curent-password"
                    v-model="form.password"
                  >
                    <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                  </CInput>
                  <CRow>
                    <CCol col="6" class="text-left">
                      <CButton color="primary" class="px-4" @click="onSubmit">Login</CButton>
                    </CCol>
                    <CCol col="6" class="text-right">
                      <!-- <CButton color="link" class="px-0">Forgot password?</CButton> -->
                      <CButton color="link" class="px-0" to="register">Register now!</CButton>
                    </CCol>
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'

  export default {
    name: 'Login',
    data() {
      return {
        form: {
          email: '',
          password: '',
        }
      }
    },
    methods: {
      ...mapActions({
        login: 'auth/login'
      }),

      onSubmit() {
        this.login(this.form)
        .then(() => {
          this.$router.push('/')
        });
      }
    },
  }
</script>
<style scoped>

</style>
