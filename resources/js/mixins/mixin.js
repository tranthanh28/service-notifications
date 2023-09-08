export default {
    data() {
        return {
            loadingValue: false,
        }
    },
    methods: {
        startLoading() {
            this.loadingValue = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
        },
        stopLoading() {
            this.loadingValue.close();
        },
        handleErrorNotPermission(error) {
            if (error.response.status == 403) {
                this.$notify.error({
                    title: 'Unauthorized',
                    message: 'Bạn không có quyền thực hiện thao tác này. Liên hệ admin để có thêm thông tin!!!'
                });
            } else {
                this.$notify.error({
                    title: 'Error',
                    message: 'Error'
                });
            }
        }
    }
}
