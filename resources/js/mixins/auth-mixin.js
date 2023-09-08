export default {
    methods: {
        checkAuthenticated() {
            this.startLoading()
            axios.get('/api/authenticated').then((response) => {
                this.stopLoading()
                this.getUser()
            }).catch(error => {
                this.stopLoading()
                console.error(error)
            })
        },
        getUser() {
            this.startLoading()
            axios.get('/api/user').then((response) => {
                this.stopLoading()
                this.$store.dispatch('auth/updateUser', {user: response.data})
                this.$router.push({name: "Dashboard"});
            }).catch((errors) => {
                this.stopLoading()
                this.handleErrorNotPermission(errors)
                console.log(errors)
            })
        },
        logout() {
            axios.post('/api/logout').then((response) => {
                localStorage.removeItem('token')
                this.$store.dispatch('auth/logout')
                this.$router.push('/login')
            }).catch((errors) => {
                console.log(errors)
            })
        },
    }
}
